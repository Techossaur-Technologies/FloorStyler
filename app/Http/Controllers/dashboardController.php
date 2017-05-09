<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\assignment;
use App\User;
use App\Http\Requests;
use DB;
use Auth;

class dashboardController extends Controller
{
    public function index()
    {
	    $live = array('menu'=>'11','parent'=>'1');
	    $user_type = Auth::user()->user_type;
	    $date_array = array();
	    for ($i = 0 ; $i < 15 ; $i++) {
		  $date_array[] = date("d-M", strtotime('-'.$i.' days'));
		}
		
		if($user_type == 'ADMIN') {
			
			$users = User::where('user_type','!=','ADMIN')->get();
			$dailyChartofUser = $this->dailyChartofUser($users);
			$yearlyChartofUser = $this->yearlyChartofUser($users);

	    } else if($user_type == 'SUPERUSER') {
	    	$users = User::where('organization_id', Auth::user()->organization_id)->get();
			$yearlyChartofUser = $this->yearlyChartofUser($users);
			$dailyChartofUser = $this->dailyChartofUser($users);

	    } else if($user_type == 'USER') {
	    	$users = User::where('id', Auth::user()->id)->get();
			$yearlyChartofUser = $this->yearlyChartofUser($users);
			$dailyChartofUser = $this->dailyChartofUser($users);

	    } else {
	    	$users = User::where('id', Auth::user()->id)->get();
			$yearlyChartofUser = $this->yearlyChartofUser($users);
			$dailyChartofUser = $this->dailyChartofUser($users);

	    }
	    // echo $dailyChartofUser;		
		// echo $yearlyChartofUser;
		return view('dashboard', compact('live', 'dailyChartofUser', 'yearlyChartofUser', 'date_array'));

    }

    public function dailyChartofUser($users) {
    	$stacks = array('Projects', 'Blueprints');
    	$dailyChart = array();
		$j = 0;
		foreach ($users as $user) {
			foreach ($stacks as $stack) {

				$dailyChart[$j]['name'] = $user->fname.' '.$user->lname;
				$dataArray = array();
				for ($i = 0 ; $i < 15 ; $i++) {
					$curr_date = date("Y-m-d", strtotime('-'.$i.' days'));
					if ($stack == 'Projects') {
						$assignments = DB::select("SELECT *, COUNT(id) AS assignment FROM `assignments` WHERE DATE( created_at ) = '".$curr_date."' AND user_id ='".$user->id."'");
						foreach ($assignments as $assignment) {
							array_push($dataArray, $assignment->assignment);
						}
					} else if($stack == 'Blueprints'){
						$plans = DB::select("SELECT *,COUNT( raw_plans.id ) AS plans FROM `raw_plans` INNER JOIN assignments ass ON raw_plans.assignment_id = ass.id WHERE user_id ='".$user->id."' AND DATE( raw_plans.created_at ) = '".$curr_date."' AND TYPE = 'SKETCH'");
						foreach ($plans as $plan) {
							array_push($dataArray, $plan->plans);
						}
					}
					
				}
				$dailyChart[$j]['data'] = $dataArray;
				$dailyChart[$j]['stack'] = $stack;
				$j++;
			}
		}
		$dailyCharts = json_encode($dailyChart);
		return $dailyCharts;
    }

    public function yearlyChartofUser($users){
    	$yearlyChart = array();
    	$stacks = array('Projects', 'Blueprints');
    	$year = date('Y');
		$j = 0;
    	foreach ($stacks as $stack) {
    		$dataArray = array();
    		for($i = 1; $i<=12;$i++){
    			$data = 0;
    			foreach ($users as $user) {
    				if ($stack == 'Projects') {
    					$assignments = DB::select("SELECT * , COUNT( id ) AS assignment FROM `assignments` WHERE `user_id` ='".$user->id."' AND MONTH(created_at) = '".$i."' AND YEAR(created_at) = '".$year."'");
    					foreach ($assignments as $assignment) {
							$data = $data + $assignment->assignment;
						}
    				} elseif ($stack == 'Blueprints') {
    					$plans = DB::select("SELECT *,COUNT(raw_plans.id) AS plans FROM `raw_plans` INNER JOIN assignments ass ON raw_plans.assignment_id = ass.id WHERE user_id ='".$user->id."' AND MONTH(raw_plans.created_at) = '".$i."' AND YEAR(raw_plans.created_at) = '".$year."' AND TYPE = 'SKETCH'");
						foreach ($plans as $plan) {
							$data = $data + $plan->plans;
						}
    				}
    			}
    			array_push($dataArray, $data);
    		}
    		$yearlyChart[$j]['name'] = $stack;
    		$yearlyChart[$j]['data'] = $dataArray;
    		$j++;
    	}
    	$yearlyCharts = json_encode($yearlyChart);
    	return $yearlyCharts;
    }
}
