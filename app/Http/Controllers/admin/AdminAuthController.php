<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\AuthController;

class AdminAuthController extends Controller
{
    public function login(Request $request){
        $authcontroller = new AuthController;
        $res = $authcontroller->login($request, "admin");
        if(array_key_exists('success', $res)){
            return redirect('/');
        }elseif(array_key_exists('error', $res)){
            return back()->with('fail', $res['error']);
        }else{
            return back()->with('fail', 'All fields are required!');
        }
    }
    public function register(Request $request){
        $authcontroller = new AuthController;
        $res = $authcontroller->register($request);
        if(array_key_exists('success', $res)){
            return back()->with('success', 'Registred successfully! and an email has been sent to your mailbox');
        }elseif(array_key_exists('error', $res)){
            return back()->with('fail', $res['error']);
        }else{
            return back()->with('fail', $res);
        }
    }
    public function logout(Request $request){
        $authcontroller = new AuthController;
        $res = $authcontroller->logout($request);
        if(array_key_exists('success', $res)){
            return redirect('admin/auth/login')->with('success', 'Logeed out successfully!');
        }elseif(array_key_exists('error', $res)){
            return back()->with('fail', 'something went wrong!');
        }
    }
    function sendResetLink(Request $request){
        $authcontroller = new AuthController;
        $res = $authcontroller->sendResetLink($request);
        if(array_key_exists('success', $res)){
            return redirect('admin/auth/login')->with('success', $res['success']);
        }elseif(array_key_exists('fail', $res)){
            return back()->with('fail', $res['fail']);
        }
    }
    function resetPassword(Request $request){
        $authcontroller = new AuthController;
        $res = $authcontroller->resetPassword($request, $request->token);
        if(array_key_exists('success', $res)){
            return redirect('admin/auth/login')->with('success', $res['success']);
        }elseif(array_key_exists('fail', $res)){
            return back()->with('fail', $res['fail']);
        }
    }
}
