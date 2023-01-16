<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function __construct()
    {
        
    }

    public function homePage(){
        if(session()->get('user_data') == null){
            return view('home');
        }else{
            return redirect('/request-token');
        }
    }

    public function loginPage(){
        if(session()->get('user_data') == null){
            return view('login');
        }else{
            return redirect('/request-token');
        }
    }

    public function registerPage(){
        if(session()->get('user_data') == null){
            return view('register');
        }else{
            return redirect('/request-token');
        }
    }

    public function otpPage(){
        if(session()->get('user_data') == null){
            return view('otp');
        }else{
            return redirect('/request-token');
        }
    }

    public function fuelStation(){
        if(session()->get('station_data') == null){
            return view('station.home');
        }else{
            return redirect('/fuel-issue');
        }
    }

    public function fuelStationLogin(){
        if(session()->get('station_data') == null){
            return view('station.login');
        }else{
            return redirect('/fuel-issue');
        }
    }

    public function fuelIssue(){
        if(session()->get('station_data')){

            return view('station.issue');
        }else{
            return redirect('/station-login');
        }
    }

    public function fuelOrder(){
        if(session()->get('station_data')){

            return view('station.order');
        }else{
            return redirect('/station-login');
        }
    }


    public function adminLoginPage(){
        if(Auth::check()){
            return redirect('/admin-console');
        }else{
            return view('admin.login');
        }
    }

    public function adminHomePage(){
        if(Auth::check()){
            return view('admin.home');
        }else{
            return redirect('/admin-login');
        }
    }
    

}
