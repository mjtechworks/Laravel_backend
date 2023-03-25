<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
    	$contentHeader = [
    		'title' => 'Dashboard',
    		'bcs' => [
    			[
    				'title' => 'Home',
    				'link' => route('backend.dashboard'),
    			],
    			[
    				'title' => 'Dashboard',
    				'active' => true
    			]
    		]
    	];

        $countUser = \App\Model\User::count();

    	return view(
            'backend.dashboard.index', 
            compact('contentHeader', 'countUser'
        ));
    }
}
