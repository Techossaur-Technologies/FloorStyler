<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\model\organization;
class organizationController extends Controller
{
    public function index()
    {
        $live = array('menu'=>'20','parent'=>'3');
        if (Auth::user()->user_type == 'ADMIN') {
        	$organization = organization::all();
        	
        }
    	return view('organization', compact('live', 'organization'));
    	
    }
}
