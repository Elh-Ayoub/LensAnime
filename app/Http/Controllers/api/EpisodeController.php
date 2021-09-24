<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
            'title' => ['required', 'string', 'max:100'],
            'description' => ['max:500'],
            'video' => ['required'],
        ]);
        if($validator->fails()){
            return ($validator->errors()->toArray());
        }
        
        if($request->file('video')){
            $video = $this->uploadVideo($request);
        }
                //later using link
        // else{
        //     $video = $request->video;
        // }
        $episode = Episode::create([
            'title' => $request->title,
            'description' => $request->description,
            'video' => $video,
            'created_by' => Auth::id(),
            'anime_id' => $request->anime_id,
        ]);
        if($episode){
            return ['success' => 'episode created successfully!'];
        }else{
            return ['fail' => 'Something went wrong!'];
        }
    }
    // public function uploadVideo($request)
    // {
    //     $file = $request->file('video');
    //     $filename = $file->getClientOriginalName();
    //     $path = public_path().'/episodes/';
    //     return $file->move($path, $filename);
    // }
    public function uploadVideo($request){
        $video = $request->file('video');
        if($video){
            $filename = $video->getClientOriginalName();
            $video = $request->file('video')->store('public');
            $video1 = $request->file('video')->move(public_path('/episodes'), $filename);
            return url('/episodes/' . $filename);
        }
    }
    public function getAnimesEpisodes($anime_id){
       return Episode::where('anime_id', $anime_id)->get();
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
