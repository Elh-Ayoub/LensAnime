<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\EpisodeController;
use App\Models\Episode;
use App\Models\Anime;

class AdminEpisodeController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $episodecontroller = new EpisodeController;
        $response = $episodecontroller->store($request);
        if(array_key_exists('success', $response)){
            return back()->with('success', $response['success']);
        }elseif(array_key_exists('fail', $response)){
            return back()->with('fail', $response['fail']);
        }else{
            return back()->with('fail-arr', $response);
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
        $episodecontroller = new EpisodeController;
        $response = $episodecontroller->show($id);
        if(array_key_exists('success', $response)){
            $all_episodes = Episode::where('anime_id', $response['success']->anime_id)->get();
            $all_episodes = $all_episodes->sortBy('number');
            return view('admin.Episodes.index', [
                'episode' => $response['success'],
                'all_episodes' => $all_episodes,
                'servers' => explode(',', $response['success']->videos),
                'anime' => Anime::find($response['success']->anime_id),
            ]);
        }elseif(array_key_exists('fail', $response)){
            return back()->with('fail', $response['fail']);
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
        $episodecontroller = new EpisodeController;
        $anime_id = Episode::find($id)->anime_id;
        $response = $episodecontroller->update($request, $id);
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
        $episodecontroller = new EpisodeController;
        $anime_id = Episode::find($id)->anime_id;
        $response = $episodecontroller->destroy($id);
        if(array_key_exists('success', $response)){
            return redirect('admin/animes/' . $anime_id)->with('success', $response['success']);
        }elseif(array_key_exists('fail', $response)){
            return back()->with('fail', $response['fail']);
        }
    }
}
