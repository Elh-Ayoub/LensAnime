<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\CommentController;

class AdminCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store4anime(Request $request, $id)
    {
        $commentController = new CommentController;
        $response = $commentController->store4anime($request, $id);
        if(array_key_exists('success', $response)){
            return back()->with('success', $response['success']);
        }elseif(array_key_exists('fail', $response)){
            return back()->with('fail', $response['fail']);
        }else{
            return back()->with('fail-arr', $response);
        }
    }
    public function store4episode(Request $request, $id)
    {
        $commentController = new CommentController;
        $response = $commentController->store4episode($request, $id);
        if(array_key_exists('success', $response)){
            return back()->with('success', $response['success']);
        }elseif(array_key_exists('fail', $response)){
            return back()->with('fail', $response['fail']);
        }else{
            return back()->with('fail-arr', $response);
        }
    }
    public function store4comment(Request $request, $id)
    {
        $commentController = new CommentController;
        $response = $commentController->store4comment($request, $id);
        if(array_key_exists('success', $response)){
            return back()->with('success', $response['success']);
        }elseif(array_key_exists('fail', $response)){
            return back()->with('fail', $response['fail']);
        }else{
            return back()->with('fail-arr', $response);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $commentController = new CommentController;
        $response = $commentController->update($request, $id);
        if(array_key_exists('success', $response)){
            return back()->with('success', $response['success']);
        }elseif(array_key_exists('fail', $response)){
            return back()->with('fail', $response['fail']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $commentController = new CommentController;
        $response = $commentController->destroy($id);
        if(array_key_exists('success', $response)){
            return back()->with('success', $response['success']);
        }elseif(array_key_exists('fail', $response)){
            return back()->with('fail', $response['fail']);
        }
    }
}
