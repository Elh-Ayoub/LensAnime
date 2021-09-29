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
    public function store4episode(Request $request, $id)
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
            'episode_id' => $id,
        ]);
        if($comment){
            return ['success' => 'Commented under episode successfully!'];
        }else{
            return ['fail' => 'Somrthing went wrong! Try again please.'];
        }
    }
    public function store4comment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|between:1,500',
        ]);
        if($validator->fails()){
            return ($validator->errors()->toArray());
        }
        $reply = Comment::create([
            'author' => Auth::id(),
            'content' => $request->content,
            'comment_id' => $id,
        ]);
        if($reply){
            return ['success' => 'Replied to comment successfully!'];
        }else{
            return ['fail' => 'Somrthing went wrong! Try again please.'];
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return array response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        if($comment){
            if($comment->author === Auth::id() && !$request->content){
                $comment->delete();
            }
            $comment->update($request->all());
            return ['success' => 'Comment status updated successfully!']; 
        }
        return ['fail'=> 'Nothing updated!'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        if(Comment::find($id)){
            Comment::destroy($id);
            return ['success' => 'Comment deleted successfully!'];
        }else{
            return ['fail' => 'Comment requested not found!'];
        }
    }
}
