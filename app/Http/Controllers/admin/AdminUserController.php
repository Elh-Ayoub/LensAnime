<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\UserController;

class AdminUserController extends Controller
{
    public function UpdateAdmin(Request $request, $id){
        $usercontroller = new UserController;
        $res = $usercontroller->update($request, $id);
        if(array_key_exists('success', $res)){
            return back()->with('success', $res['success']);
        }elseif(array_key_exists('fail', $res)){
            return back()->with('fail', $res['fail']);
        }
    }
    public function UpdateAvatar(Request $request){
        $usercontroller = new UserController;
        $res = $usercontroller->updateAvatar($request);
        if(array_key_exists('success', $res)){
            return back()->with('success', $res['success']);
        }else{
            return back()->with('fail-arr', $res);
        }
    }
    function destroy($id){
        $usercontroller = new UserController;
        $res = $usercontroller->destroy($id);
        if(array_key_exists('success', $res)){
            return redirect('admin/auth/login')->with('success', $res['success']);
        }elseif(array_key_exists('fail', $res)){
            return back()->with('fail', $res['fail']);
        }
    }
    function create(Request $request){
        $usercontroller = new UserController;
        $res = $usercontroller->create($request);
        if(array_key_exists('success', $res)){
            return back()->with('success', $res['success']);
        }elseif(array_key_exists('fail', $res)){
            return back()->with('fail', $res['fail']);
        }else{
            return back()->with('fail-arr', $res);
        }
    }
}
