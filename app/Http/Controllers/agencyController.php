<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

use Auth;
use App\model\agency;
use Crypt;
use Session;
use Validator;
use File;

class agencyController extends Controller
{
    public function index()
    {
        $live = array('menu'=>'20','parent'=>'3');
        if (Auth::user()->user_type == 'ADMIN') {
        	$agencies = agency::where('status', '!=', 'DEAD')
                        ->get();
        } else {
            $organization_id = Auth::user()->organization_id;
            $agencies = agency::where('organization_id', $organization_id)
                    ->where('status', '!=', 'DEAD')
                    ->get();
        }
    	return view('agency', compact('live', 'agencies'));
    }
    public function add()
    {
        $live = array('menu'=>'20','parent'=>'3');
        return view('agency_add', compact('live'));
    }
    public function edit($name, $id)
    {
        $live = array('menu'=>'20','parent'=>'3');
        $data_id = Crypt::decrypt($id);
        $agencies = agency::find($data_id);
        return view('agency_edit', compact('live', 'agencies'));
    }
    public function update(Request $request)
    {
        $data_id    = Crypt::decrypt($request->agency_id);
        if($agency = agency::find($data_id)) {
            Agency::where('id', $data_id)->update([
                'name'=>$request->agency_name,
            ]);
            if (Input::hasfile('images')) {
                File::Delete($agency->logo_path);
                $files   = Input::file('images');
                $prefix = "LA-".$data_id;
                $this->file_upload($files, $prefix, $data_id);
            }

            Session::flash('message', "Agency Id#".$data_id." updated Successfully");
            return redirect('agency/edit/'.$agency->name.'/'.Crypt::encrypt($agency->id));
        }
    }
    public function destroy($id)
    {
        $data_id = Crypt::decrypt($id);
        if(agency::where('id', $data_id)->update(['status' => 'DEAD'])){
            Session::flash('message', "Agency Id#".$data_id." deleted Successfully");
            return back();
        } else {
            Session::flash('message', "Agency Id#".$data_id." not found!!!");
            return back();
        }
    }
    public function status($id)
    {
        $data_id = Crypt::decrypt($id);
        if(agency::where('id', $data_id)->where('status', 'ALIVE')->update(['status' => 'IDLE'])){
            Session::flash('message', "Agency Id#".$data_id." inactivated Successfully");
            return back();
        } else if(agency::where('id', $data_id)->where('status', 'IDLE')->update(['status' => 'ALIVE'])){
            Session::flash('message', "Agency Id#".$data_id." activated Successfully");
            return back();
        } else {
            Session::flash('message', "Agency Id#".$data_id." not found!!!");
            return back();
        }
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agency_name' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $agency = new agency;
            $agency->organization_id = Auth::user()->organization_id;
            $agency->name = $request->agency_name;
            $agency->save();
            $data_id = $agency->id;
            if (Input::hasfile('images')) {
                $files   = Input::file('images');
                $prefix = "LA-".$data_id;
                $this->file_upload($files, $prefix, $data_id);
            }
            Session::flash('message', "Agency Id#".$data_id." updated Successfully");
            return back();
        }
    }

    public function file_upload($files, $prefix, $data_id) {
        // File Path 
        $target = "storage/logo/";
        // Files Upload with insert into database
        foreach($files as $file) {
            // $files_extension         = $file->getClientOriginalExtension();
            $filename          = $prefix."-".rand().".jpg";
            $upload_success    = $file->move($target, $filename);
            // Update database
            Agency::where('id', $data_id)->update([
                'logo'      =>$filename,
                'logo_path' =>$target.$filename,
            ]);
        }
    }
}
