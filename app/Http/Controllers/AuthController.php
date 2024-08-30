<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\Plan;
use App\Models\User;
use App\Models\seeker;
use App\Models\employer;
use App\Models\JobApply;
use Illuminate\Http\Request;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // direct login page
    public function loginPage(){
        return view('user/login');
    }

    public function registerPage(){
        return view('user/register');
    }

    public function dashboard(){
        if(Auth::user()->role == 'admin'){
            $employer = User::where('role','employer')->get();
            $seeker = User::where('role','seeker')->get();
            $applyList = JobApply::get();
            $transaction = TransactionHistory::get();
            return redirect()->route('admin#dashboard',compact('employer','seeker','applyList','transaction'));
        }
        
        if(Auth::user()->role == 'seeker' && Auth::user()->is_activated == 0){
            return redirect()->route('seeker#verify');
        }elseif(Auth::user()->role == 'seeker' && Auth::user()->is_activated == 1){
            return redirect()->route('seeker#home');
        }
        

        if(Auth::user()->role == 'employer' && Auth::user()->is_activated == 0){
            return redirect()->route('employer#verify');
        }elseif(Auth::user()->role == 'employer' && Auth::user()->is_activated == 1){
            $data = Plan::get();
            $image = User::where('id',Auth::user()->id)->first();
            return redirect()->route('employer#home',compact('data','image'));
        }
    }
}
