<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Crypt;
use Mail;
use App\Http\Requests;
use Auth;
use App\assignment;
use App\model\raw_plan;
use App\model\organization;
use App\User;
use App\model\agency;
use App\Libraries\imageGrid;
use Illuminate\Support\Facades\Input;
use Validator;
use Session;
use File;
use DB;
class assignmentController extends Controller
{
    public function __construct() {

        $this->live = array('menu'=>'12','parent'=>'3');
    }
    public function index() {
        $live = $this->live;

        if (Auth::user()->user_type == 'ADMIN') {
        	$assignment = assignment::all();
        } else if (Auth::user()->user_type == 'SUPERUSER') {
            $org_id     = Auth::user()->organization_id;
            $assignment = assignment::where('organization_id', $org_id)->get();

        } else if (Auth::user()->user_type == 'USER') {
            $user_id    = Auth::user()->id;
            $assignment = assignment::where('user_id', $user_id)->get();

        }
    	return view('assignment', compact('live', 'assignment'));

    }
    public function add() {
        $live = $this->live;

        if (Auth::user()->user_type == 'ADMIN') {
            $user = User::where('status', '=', 'ALIVE')
                ->where('user_type','!=','ADMIN')->get();
        } else if(Auth::user()->user_type == 'SUPERUSER') {
            $user = Auth::user()->organization->users;

        } else if(Auth::user()->user_type == 'USER') {
            $user_id = Auth::user()->id;
            $user    = User::where('id', $user_id)->get();

        } 
        return view('assignment_add', compact('live', 'user'));

    }
    public function postagency(Request $request) {
        $user= User::find($request->user_id);
        $agencies = $user->organization->agencies;
        return response()->json($agencies);
    }
    public function create(Request $request) {
        
        // Insert Assignment in Database
        $assignment_name = $request->assignment_name;
        $user            = $request->user;
        $agency          = $request->agency;
        $comment    =  "";
        $rules = array(
            // 'file'            => 'required|mimes:png,gif,jpeg,jpg',
            'assignment_name' => 'required',
            'user'            => 'required',
            'agency'          => 'required',
        );
        $validator = Validator::make(array(
            'assignment_name' => $assignment_name,
            'user'            => $user,
            'agency'          => $agency
            ), $rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else{
            $assignment                  = new assignment;
            $assignment->name            = $assignment_name;
            $assignment->user_id         = $user;
            $assignment->organization_id = User::find($user)->organization_id;
            $assignment->agency_id       = $agency;
            $assignment->save();
            $last_id                     = $assignment->id;
            
            // Files Upload with insert into database
            if (Input::hasfile('images')) {
                $files   = Input::file('images');
                $type = "SKETCH";
                $prefix = "BP-ID".$last_id;
                $fileArray = $this->file_upload($files, $last_id, $type, $prefix, $comment);
            }

            // Send Mail

            $data = [
               'assignment_id' => $last_id,
               'address' => $assignment_name,
               'company' => Auth::user()->fname.' '.Auth::user()->lname,
               'client' => agency::find($agency),
               'fileArray' => $fileArray,
               'view' => 'emails.rawblueprintuploadmail',
               'to' => config('global.email'),
               'name' => config('global.siteTitle'),
               'subject' => 'New Blueprint of Assignment Id# '.$last_id.', Address: '.$assignment_name.' has been added'
            ];

            $this->sendMail($data);
            
            return redirect('assignment');
        }
    }

    public function sendMail($data){
        Mail::send($data['view'], $data, function($message) use ($data){
            $message->to($data['to'], $data['name'])->subject($data['subject']);
            if ($data['fileArray'] != '') {
                foreach ($data['fileArray'] as $file) {
                    $message->attach($file);
                }
            }
        });
    }

    public function delete(Request $request) {
        $data_id    = Crypt::decrypt($request->id);
        $assignment = assignment::find($data_id);
        $raw_plans = $assignment->raw_plan;
        foreach ($raw_plans as $raw_plan) {
            File::delete($raw_plan->path);
        }
        $assignment->raw_plan()->delete();
        $assignment->delete();
        // Session::flash('message', "Assignment Id#".$data_id." deleted Successfully");
        if (assignment::where('id', $data_id)->exists()) {
            return response()->json(array('status'=>'error', 'message'=>"<p style='color:green;'>Assignment Id#".$data_id." not deleted!!!</p>"));
        } else {
            return response()->json(array('status'=>'success', 'message'=>"<p style='color:green;'>Assignment Id#".$data_id." deleted Successfully</p>"));

        }
        // return back();
    }

    public function getEdit( $name, $id ) {
        $data_id    = Crypt::decrypt($id);
        $assignment = assignment::find($data_id);
        $live       = $this->live;


        if (Auth::user()->user_type == 'ADMIN') {
            $user = User::all();
        } else if(Auth::user()->user_type == 'SUPERUSER') {
            $user = Auth::user()->organization->users;

        } else if(Auth::user()->user_type == 'USER') {
            $user_id = Auth::user()->id;
            $user    = User::where('id', $user_id)->get();
        }

        return view('assignment_edit', compact('live', 'user', 'assignment'));
    }

    public function update(Request $request) {
        $data_id    = Crypt::decrypt($request->assignment_id);
        $comment = "";
        if(assignment::find($data_id)) {
            assignment::where('id', $data_id)->update([
                'name'            =>$request->assignment_name,
                'user_id'         => $request->user,
                'organization_id' => User::find($request->user)->organization_id,
                'agency_id'       => $request->agency,
                'status'       	  => 'PENDING',
            ]);
            if (Input::hasfile('images')) {
                $files   = Input::file('images');
                $last_id = $data_id;
                $type = "SKETCH";
                $prefix = "BP-ID".$last_id;
                $fileArray = $this->file_upload($files, $last_id, $type, $prefix, $comment);
            } else {
                $fileArray = '';
            }

            $data = [
               'assignment_id' => $data_id,
               'address' => $request->assignment_name,
               'company' => Auth::user()->fname.' '.Auth::user()->lname,
               'client' => agency::find($request->agency),
               'fileArray' => $fileArray,
               'view' => 'emails.updateassignment',
               'to' => config('global.email'),
               'name' => config('global.siteTitle'),
               'subject' => 'Assignment Id# '.$data_id.', Address: '.$request->assignment_name.' has been updated'
            ];

            $this->sendMail($data);

            Session::flash('message', "Assignment Id#".$data_id." updated Successfully");
            return redirect('assignment');
        }
    }

    public function file_upload($files, $last_id, $type, $prefix, $comment) {
        $fileArray = array();
        // File Path 
        $path      = date('Y').'/'.date('m').'/';
        if (!file_exists('storage/uploads/'.$path)) {
            mkdir(('storage/uploads/'.$path), 0777, true);
            $target = 'storage/uploads/'.$path;
        } else {
            $target = 'storage/uploads/'.$path;
        }
        // Files Upload with insert into database
        if (raw_plan::where('assignment_id', $last_id)->first()) {
            $last_flag = raw_plan::where('assignment_id', $last_id)->max('flag');
        } else {
            $last_flag = 0;
        }
        $files_count                 = count($files);
        foreach($files as $file) {
            // $files_extension         = $file->getClientOriginalExtension();
            $filename                = $prefix."-".rand().".jpg";
            $upload_success          = $file->move($target, $filename);
            // Insert into database
            $raw_plan                = new raw_plan;
            $raw_plan->name          = $filename;
            $raw_plan->assignment_id = $last_id;
            $raw_plan->path          = $target.$filename;
            $raw_plan->type          = $type;
            $raw_plan->flag          = $last_flag+1;
            $raw_plan->commentBy     = Auth::user()->id;
            $raw_plan->comment       = $comment;
            $raw_plan->save();
            $fileArray[]             = $target.$filename;
        }
        return $fileArray;
    }

    public function view( $name, $id ) {
        $live               = $this->live;
        $assignment         = assignment::find(Crypt::decrypt($id));
        // $flags              = $assignment->raw_plan()->groupBy('flag')->get();
        $assignment_details = $assignment->raw_plan()
                                ->select('raw_plans.*', DB::raw('group_concat(path) as paths'))
                                ->where('assignment_id', Crypt::decrypt($id))
                                ->groupBy('flag')
                                ->orderBy('flag', 'desc')
                                ->get();
        return view('assignment_view', compact('name', 'id', 'live', 'assignment', 'assignment_details'));
    }

    public function add_fp( $name, $id ) {
        $live               = $this->live;
        $assignment         = assignment::find(Crypt::decrypt($id));
        return view('assignment_addfp', compact('name', 'id', 'live', 'assignment'));
    }

    public function update_fp( Request $request) {
        $data_id = Crypt::decrypt($request->assignment_id);
        $comment = $request->comment;
        if (Input::hasfile('images')) {
            $files      = Input::file('images');
            $last_id    = $data_id;
            $type       = "DRAWING";
            $prefix     = "FP-ID".$last_id;
            $fileUploads = $this->file_upload($files, $last_id, $type, $prefix, $comment);
            $assignment = assignment::find($data_id);
            $logos = $assignment->agency()->pluck('agencies.logo_path');
            $logoAttach = $this->add_logo($fileUploads, $logos);
            Session::flash('message', "Add floorplan for Assignment Id#".$data_id." upload Successfull");

            // Send Mail
            $user = User::find($assignment->user_id);
            $data = [
               'assignment_id' => $last_id,
               'address' => $assignment->name,
               'company' => agency::find($assignment->agency_id),
               'fileArray' => $fileUploads,
               'view' => 'emails.assignmentdeliveryconfirmationtoclient',
               'to' => $user->email,
               'name' => $user->fname.' '.$user->lname,
               'subject' => 'Assignment Id# '.$last_id.', Address: '.$assignment->name.' is ready to download'
            ];

            $this->sendMail($data);
        } else {
            Session::flash('message', "Please add floorplan");
        }
        return redirect('assignment/view/'.$request->assignment_name.'/'.$request->assignment_id);

    }

    public function add_logo($files, $logos) {
        foreach ($logos as $logo) {
            foreach ($files as $img) {
                header('Content-Type: image/jpeg');

                $imageGrid = new imageGrid(3000, 2000, 300, 200);
                $img1 = imagecreatefromjpeg($img);
                $imageGrid->putImage($img1, 210, 157, 40, 0);
                $img2 = imagecreatefromjpeg($logo);
                $imageGrid->putImage($img2, 300, 40, 0, 158);
                $collageFlag = $imageGrid->display($img);
                imagedestroy($img1);
                imagedestroy($img2);
            }
        }
        
    }

    public function addcomment($name, $id) {
        $live               = $this->live;
        $assignment         = assignment::find(Crypt::decrypt($id));
        return view('assignment_addcomment', compact('name', 'id', 'live', 'assignment'));

    }

    public function update_addcomment(Request $request) {
        $data_id = Crypt::decrypt($request->assignment_id);
        $assignment = assignment::find($data_id);
        $fileUploads = '';
        $comment = $request->comment;
        if (Input::hasfile('images')) {
            $files      = Input::file('images');
            $last_id    = $data_id;
            $type       = "COMMENT";
            $prefix     = "CM-ID".$last_id;
            $fileUploads = $this->file_upload($files, $last_id, $type, $prefix, $comment);
            Session::flash('message', "Add Comment for Assignment Id#".$data_id." upload Successfull");
        } else {
            $last_flag = raw_plan::where('assignment_id', $data_id)->max('flag');

            $raw_plan                = new raw_plan;
            $raw_plan->assignment_id = $data_id;
            $raw_plan->type          = "COMMENT";
            $raw_plan->flag          = $last_flag+1;
            $raw_plan->comment       = $comment;
            $raw_plan->commentBy     = Auth::user()->id;
            $raw_plan->save();
            Session::flash('message', "Comment added to assignment ID#".$data_id);
        }

        if (Auth::user()->user_type == 'ADMIN') {
        	$sendTo = $assignment->user->email;
        	$sendToName = $assignment->user->fname;
        } else {
        	$sendTo = config('global.email');
        	$sendToName = config('global.siteTitle');
        }

        $data = [
           'assignment' => $assignment,
           'comment' => $comment,
           'user' => Auth::user(),

           'fileArray' => $fileUploads,
           'view' => 'emails.addcomment',
           'to' => $sendTo,
           'name' => $sendToName,
           'subject' => 'New Comment to Assignment Id# '.$data_id.', Address: '.$assignment->name.''
        ];

        $this->sendMail($data);
        return redirect('assignment/view/'.$request->assignment_name.'/'.$request->assignment_id);
    }

    public function addBoligAppID(Request $request)
    {
        $id             = Crypt::decrypt($request->id);
        $app_id         = $request->app_id;
        $operation_type = $request->operation_type;
        $baseURL        = config('global.baseURL');

        $rules = array(
            'id'             => 'required',
            'app_id'         => 'required',
            'operation_type' => 'required',
        );
        $validator = Validator::make(array(
            'id'             => $id,
            'app_id'         => $app_id,
            'operation_type' => $operation_type
            ), $rules);
        if ($validator->fails()) {
            echo json_encode(array("status" => "error", "message" => 'Error in Processing!!!'));
        } else{
            $file_array = array();
            $raw_plans = raw_plan::where('assignment_id', $id)
                            ->where('type', 'DRAWING')
                            ->get();
            foreach ($raw_plans as $raw_plan) {
                array_push($file_array, $baseURL.'/'.$raw_plan['path']);
            }
            $file_string = implode(",", $file_array);
            if (is_numeric($app_id)) {
                $post = array('bolig_app_id' => $app_id, 'operation_type' => $operation_type, 'bolig_file_array' => $file_string);

                // CURL function
                $result = $this->postCURL($post);

                if ($result == 'success') {
                    if ($operation_type == "REMOVE") {
                        assignment::where('id', $id)->update([
                            'boligAppID' => 0
                        ]);

                    }else {
                        assignment::where('id', $id)->update([
                            'boligAppID' => $app_id
                        ]);
                    }
                    echo json_encode(array("status" => "success", "message" => 'Floorpan succesfully updated to Bolig application!'));
                }
            }
        }
    }
    public function postCURL($post)
    {
        $target_url = 'http://boligfotograf.net/admin_test/accept_floorplanner_assignment.php';
        $ch         = curl_init();
        curl_setopt($ch, CURLOPT_URL,$target_url);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result     = curl_exec ($ch);
        curl_close ($ch);
        return $result;
    }

    public function list(Request $request) {
        $requestData = $request;
        $sql         = '';
        $data        = array();
        if (Auth::user()->user_type == 'ADMIN') {
            $sql .= "SELECT * FROM `assignments` WHERE 1";
        } else if (Auth::user()->user_type == 'SUPERUSER') {
            $org_id     = Auth::user()->organization_id;
            $sql .= "SELECT * FROM `assignments` WHERE `organization_id` = '".$org_id."'";
        } else if (Auth::user()->user_type == 'USER') {
            $user_id    = Auth::user()->id;
            $sql .= "SELECT * FROM `assignments` WHERE `user_id` = '".$user_id."'";
        }
        $qry = DB::select($sql);
        $totalData = count($qry);
        $totalFiltered = $totalData;
        if( !empty($requestData['search']['value']) ) {
            $sql .= " AND ( id LIKE '".$requestData['search']['value']."%' ";
            $sql .= " OR name LIKE '".$requestData['search']['value']."%' ";
            $sql .= " OR boligAppID LIKE '".$requestData['search']['value']."%' ";
            $sql .= " OR status LIKE '".$requestData['search']['value']."%' ) ";
        }
        $qry = DB::select($sql);
        $totalFiltered = count($qry);

        $sql .= " ORDER BY CASE WHEN status= 'PENDING' THEN 1 WHEN status = 'PROCESSING' THEN 2 WHEN status = 'COMPLETED' THEN 3 END ASC, id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."";
        $qry = DB::select($sql);
        
        foreach ($qry as $row) {
            $actionsItem = '';
            $user = User::find($row->user_id);
            $agency = agency::find($row->agency_id);
            $organization = organization::find($row->organization_id);
            $raw_plan = count(raw_plan::where('assignment_id', $row->id)->where('type','SKETCH')->get());
            $nestedData   = array();
            $nestedData[] = $row->id;
            $nestedData[] = '<a title="View Details" href="assignment/view/'.$row->name.'/'.Crypt::encrypt($row->id).'">'.$row->name.'</a>';
            if (Auth::user()->user_type != 'USER') {
            	$nestedData[] = $user->fname.' '.$user->lname;
            }
            $nestedData[] = $agency->name;
            if (Auth::user()->user_type == 'ADMIN'){
            	$nestedData[] = $organization->name;
            }
            $nestedData[] = $raw_plan;
            if($row->status == 'PENDING'){
            	$nestedData[] = '<p style="color:red;">'.$row->status.'</p>';
            } else if ($row->status == 'PROCESSING') {
            	$nestedData[] = '<p style="color:blue;">'.$row->status.'</p>';
            } else{
            	$nestedData[] = '<p style="color:green;">'.$row->status.'</p>';
            }
            $nestedData[] = $row->boligAppID;
            $nestedData[] = $row->updated_at;
            $nestedData[] = $row->created_at;
            if($row->status == 'PENDING'){
            	$actionsItem .= '<a style="font-size: medium;" class="fa fa-check-square-o" title="Complete" id="'.Crypt::encrypt($row->id).'"></a>&nbsp';
            	$actionsItem .= '<a style="font-size: medium; opacity: 0.5;" class="fa fa-upload" title="Bolig Link" id="'.Crypt::encrypt($row->id).'"></a>&nbsp';
            } else {
            	$actionsItem .= '<a style="font-size: medium;" class="fa fa-recycle" title="Pending" id="'.Crypt::encrypt($row->id).'"></a>&nbsp';
            	$actionsItem .= '<a style="font-size: medium;" class="fa fa-upload linktobolig" title="Bolig Link" id="'.Crypt::encrypt($row->id).'"></a>&nbsp';
            }

            $actionsItem .= '<a style="font-size: medium;" class="fa fa-pencil" title="Edit" id="'.Crypt::encrypt($row->id).'" href="assignment/edit/'.$row->name.'/'.Crypt::encrypt($row->id).'"></a>&nbsp';
            $actionsItem .= '<a style="font-size: medium;" class="fa fa-trash" title="Delete" id="'.Crypt::encrypt($row->id).'"></a>&nbsp';


            $nestedData[] = $actionsItem;
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
        );
        // echo json_encode($json_data);
        return response()->json($json_data);

    }

    public function status(Request $request){
        $id = Crypt::decrypt($request->id);
        $assignment = assignment::find($id);
        if ($assignment->status == 'PENDING') {
            assignment::where('id', $id)->update([
                'status' => 'COMPLETED'
                ]);
            echo json_encode(array("status" => "success", "message" => '<p style="color:green;">Assignment ID#'.$id.' updated as COMPLETED...</p>'));

        } else if ($assignment->status == 'COMPLETED') {
            assignment::where('id', $id)->update([
                'status' => 'PENDING'
                ]);
            echo json_encode(array("status" => "success", "message" => '<p style="color:green;">Assignment ID#'.$id.' updated as PENDING...</p>'));
        } else{
            echo json_encode(array("status" => "error", "message" => '<p style="color:red;">Assignment ID#'.$id.' NOT FOUND</p>'));
        }
    }

}
