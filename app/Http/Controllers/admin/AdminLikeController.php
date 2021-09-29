<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\LikeController;

class AdminLikeController extends Controller
{
    public function store4anime(Request $request, $id){
        $likecontroller = new LikeController;
        $response = $likecontroller->createAnimeLike($request, $id);
        if(array_key_exists('success', $response)){
            return back()->with('success', $response['success']);
        }elseif(array_key_exists('fail', $response)){
            return back()->with('fail', $response['fail']);
        }else{
            return back()->with('fail-arr', $response);
        }
    }
    public function store4comment(Request $request, $id){
        $likecontroller = new LikeController;
        $response = $likecontroller->createCommentLike($request, $id);
        if(array_key_exists('success', $response)){
            return back()->with('success', $response['success']);
        }elseif(array_key_exists('fail', $response)){
            return back()->with('fail', $response['fail']);
        }else{
            return back()->with('fail-arr', $response);
        }
    }
    public function store4episode(Request $request, $id){
        $likecontroller = new LikeController;
        $response = $likecontroller->createEpisodeLike($request, $id);
        if(array_key_exists('success', $response)){
            return back()->with('success', $response['success']);
        }elseif(array_key_exists('fail', $response)){
            return back()->with('fail', $response['fail']);
        }else{
            return back()->with('fail-arr', $response);
        }
    }
}
