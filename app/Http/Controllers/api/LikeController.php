<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Anime;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function index(){
        return Like::all();
    } 

    public function getAnimeLike($id){
        return Like::where('anime_id', $id)->get();
    }
    public function getEpisodeLike($id){
        return Like::where('episode_id', $id)->get();
    }
    public function createAnimeLike(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string'],
        ]);
        if($validator->fails()){
            return ($validator->errors()->toArray());
        }
        $user_id = null;
        if(Auth::user()){
            $user_id = Auth::id();
        }
        if($request->user){
            $user_id = $request->user;
        }
        $checkLike = Like::where(['anime_id'=> $id, 'author' => $user_id])->first();
        if($checkLike){
            //if it's like
            if($checkLike->type == 'like'){
                // and requested like type is "like"
                if($request->type == 'like'){
                    Like::destroy($checkLike->id);
                    $this->calculateRating($user_id);
                    $this->CalculateAnimeRating($id);
                    return ['success' => 'Like removed successfully!'];
                }
                // and requested like type is "dislike"
                else{
                    $checkLike->update(['type' => 'dislike']);
                    $this->calculateRating($user_id);
                    $this->CalculateAnimeRating($id);
                    return ['success' => 'Disliked anime successfully!'];
                }            
            }
            //if it's dislike
            elseif($checkLike->type == 'dislike'){
                // and requested like type is "like"
                if($request->type == 'like'){
                    $checkLike->update(['type' => 'like']);
                    $this->calculateRating($user_id);
                    $this->CalculateAnimeRating($id);
                    return ['success' => 'Liked anime successfully!'];
                }
                // and requested like type is "dislike"
                else{
                    Like::destroy($checkLike->id);
                    $this->calculateRating($user_id);
                    $this->CalculateAnimeRating($id);
                    return ['success' => 'Dislike removed successfully!'];
                } 
            }
        }else{
            $like = Like::create([
                'author' => $user_id,
                'anime_id' => $id,
                'type' => $request->type,
            ]);
            if($like){
                $this->calculateRating($user_id);
                $this->CalculateAnimeRating($id);
                return ['success' => $request->type. ' anime successfully!'];
            }else{
                return ['fail' => 'Something went wrong!'];
            }
        }
    }

    public function createEpisodeLike(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string'],
        ]);
        if($validator->fails()){
            return ($validator->errors()->toArray());
        }
        $user_id = null;
        if(Auth::user()){
            $user_id = Auth::id();
        }
        if($request->user){
            $user_id = $request->user;
        }
        $checkLike = Like::where(['episode_id'=> $id, 'author' => $user_id])->first();
        if($checkLike){
            //if it's like
            if($checkLike->type == 'like'){
                // and requested like type is "like"
                if($request->type == 'like'){
                    Like::destroy($checkLike->id);
                    $this->calculateRating($user_id);
                    $this->CalculateEpisodeRating($id);
                    return ['success' => 'Like removed successfully!'];
                }
                // and requested like type is "dislike"
                else{
                    $checkLike->update(['type' => 'dislike']);
                    $this->calculateRating($user_id);
                    $this->CalculateEpisodeRating($id);
                    return ['success' => 'Disliked episode successfully!'];
                }            
            }
            //if it's dislike
            elseif($checkLike->type == 'dislike'){
                // and requested like type is "like"
                if($request->type == 'like'){
                    $checkLike->update(['type' => 'like']);
                    $this->calculateRating($user_id);
                    $this->CalculateEpisodeRating($id);
                    return ['success' => 'Liked episode successfully!'];
                }
                // and requested like type is "dislike"
                else{
                    Like::destroy($checkLike->id);
                    $this->calculateRating($user_id);
                    $this->CalculateEpisodeRating($id);
                    return ['success' => 'Dislike removed successfully!'];
                } 
            }
        }else{
            $like = Like::create([
                'author' => $user_id,
                'episode_id' => $id,
                'type' => $request->type,
            ]);
            if($like){
                $this->calculateRating($user_id);
                $this->CalculateEpisodeRating($id);
                return ['success' => $request->type. ' episode successfully!'];
            }else{
                return ['fail' => 'Something went wrong!'];
            }
        }
    }

    public function deleteAnimeLike($id){
        $like = Like::where(['anime_id'=> $id, 'author' => Auth::id()])->first();
        if($like){
            Like::destroy($like->id);
            $this->calculateRating(Auth::id());
            $this->CalculateAnimeRating($id);
            return ['success' => 'Like deleted successfully!'];
        }
        else{
            return ['fail' => 'Like not exist under this anime!'];
        }
    }

    public function getCommentLike($id){
        return Like::where('comment_id', $id)->get();
    }

    public function destroy($id){
        if(Like::find($id)){
            Like::destroy($id);
            $this->calculateRating(Auth::user());
            return ['success' => 'Like deleted successfully!'];
        }else{
            return ['fail' => 'Like requested not found!'];
        }
    }
    public function createCommentLike(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string'],
        ]);
        if($validator->fails()){
            return json_decode($validator->errors()->toJson());
        }
        if(Auth::user()){
            $user_id = Auth::id();
        }
        if($request->user){
            $user_id = $request->user;
        }
        if(!Comment::find($id)){
            return ['fail' => 'Comment Requested not exist!'];
        }
        $checkLike = Like::where(['comment_id'=> $id, 'author' => $user_id])->first();
        if($checkLike){
            //if it's like
            if($checkLike->type == 'like'){
                // and requested like type is "like"
                if($request->type == 'like'){
                    Like::destroy($checkLike->id);
                    $this->calculateRating($user_id);
                    $this->CalculateCommentRating($id);
                    return ['success' => 'Like removed successfully!'];
                }
                // and requested like type is "dislike"
                else{
                    $checkLike->update(['type' => 'dislike']);
                    $this->calculateRating($user_id);
                    $this->CalculateCommentRating($id);
                    return ['success' => 'Disliked comment successfully!'];
                }            
            }
            //if it's dislike
            elseif($checkLike->type == 'dislike'){
                // and requested like type is "like"
                if($request->type == 'like'){
                    $checkLike->update(['type' => 'like']);
                    $this->calculateRating($user_id);
                    $this->CalculateCommentRating($id);
                    return ['success' => 'Liked comment successfully!'];
                }
                // and requested like type is "dislike"
                else{
                    Like::destroy($checkLike->id);
                    $this->calculateRating($user_id);
                    $this->CalculateCommentRating($id);
                    return ['success' => 'Dislike removed successfully!'];
                } 
            }
        }else{
            $like = Like::create([
                'author' => $user_id,
                'comment_id' => $id,
                'type' => $request->type,
            ]);
            if($like){
                $this->calculateRating($user_id);
                $this->CalculateCommentRating($id);
                return ['success' => $request->type. ' comment successfully!'];
            }else{
                return ['fail' => 'Something went wrong!'];
            }
        }
    }

    public function deleteCommentLike($id){
        $like = Like::where(['comment_id'=> $id, 'author' => Auth::id()])->first();
        if($like){
            Like::destroy($like->id);
            $this->calculateRating(Auth::id());
            $this->CalculateCommentRating($id);
            return ['success' => 'Like deleted successfully!'];
        }
        else{
            return ['fail' => 'Like not exist under this comment!'];
        }
    }

    public function calculateRating($user_id){
        $user = User::find($user_id);
        $likes = Like::where('author', $user_id)->get();
        $rating = 0;
        foreach($likes as $like){
            if($like->type == 'like'){
                $rating++;
            }else{
                $rating--;
            }
        }
        $user->update(['rating' => $rating]);
    }
    public function CalculateCommentRating($comment_id){
        $comment = Comment::find($comment_id);
        $likes = Like::where('comment_id', $comment_id)->get();
        $rating = 0;
        foreach($likes as $like){
            if($like->type == 'like'){
                $rating++;
            }else{
                $rating--;
            }
        }
        $comment->update(['rating' => $rating]);
    }
    public function CalculateAnimeRating($anime_id){
        $anime = Anime::find($anime_id);
        $likes = $this->getAnimeLike($anime_id);
        $rating = 0;
        foreach($likes as $like){
            if($like->type == 'like'){
                $rating++;
            }else{
                $rating--;
            }
        }
        $anime->update(['rating' => $rating]);
    }
    public function CalculateEpisodeRating($episode_id){
        $episode = Episode::find($episode_id);
        $likes = $this->getEpisodeLike($episode_id);
        $rating = 0;
        foreach($likes as $like){
            if($like->type == 'like'){
                $rating++;
            }else{
                $rating--;
            }
        }
        $episode->update(['rating' => $rating]);
    }
}
