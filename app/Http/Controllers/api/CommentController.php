<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Anime;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *  @param  int  $id (anime id)
     * @return \Illuminate\Http\Response
     */
    public function getAnimeComments($id)
    {
        return Comment::where('anime_id', $id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return array response 
     */
    public function store4anime(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|between:1,500',
        ]);
        if($validator->fails()){
            return ($validator->errors()->toArray());
        }
        $comment = Comment::create([
            'author' => Auth::id(),
            'content' => $request->content,
            'anime_id' => $id,
        ]);
        if($comment){
            return ['success' => 'Commented under anime successfully!'];
        }else{
            return ['fail' => 'Somrthing went wrong! Try again please.'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
