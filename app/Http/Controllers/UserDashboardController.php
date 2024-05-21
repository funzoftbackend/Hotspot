<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Business;
use App\Models\Driver;
class UserDashboardController extends Controller
{
    public function index()
    {
   
    $user = Auth::user();
    $totalbusinesses = Business::all()->count();
    $totalusers = User::all()->count();
    $totaldrivers = Driver::all()->count();
    return view('dashboard.index',compact('user','totalusers','totalbusinesses','totaldrivers'));
    }  
}
