<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use Illuminate\Http\Request;
use App\Models\Episode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => ['required', 'string', 'max:100'],
            'description' => ['max:500'],
            'server_name' => ['required'],
            'src' => ['required'],
        ]);
        if($validator->fails()){
            return ($validator->errors()->toArray());
        }
        // if($request->file('video')){
        //     $video = $this->uploadVideo($request);
        // }
        //         // later using link
        // // else{
        // //     $video = $request->video;
        // // }
        $videos = [];
        for($i=0; $i < count($request->src); $i++){
            array_push($videos, $request->server_name[$i] . " | " . $request->src[$i]);
        }
        $episode = Episode::create([
            'number' => $request->number,
            'description' => $request->description,
            'videos' => implode(",", $videos),
            'created_by' => Auth::id(),
            'anime_id' => $request->anime_id,
        ]);
        if($episode){
            return ['success' => 'episode created successfully!'];
        }else{
            return ['fail' => 'Something went wrong!'];
        }
    }

    public function uploadVideo($request){
        $video = $request->file('video');
        if($video){
            $filename = $video->getClientOriginalName();
            $anime_name = Anime::find($request->anime_id)->title;
            $video = $request->file('video')->store('public');
            $video1 = $request->file('video')->move(public_path('/episodes/' . $anime_name), $filename);
            return url('/episodes/' . $filename);
        }
    }
    public function getAnimesEpisodes($anime_id){
       return Episode::where('anime_id', $anime_id)->get();
    }
    
    public function show($id)
    {
        $ep = Episode::find($id);
        if($ep){
            return ['success' => $ep];
        }else{
            return ['fail' => 'Not found!'];
        }
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
