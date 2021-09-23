<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\AnimeController;
use App\Models\Anime;

class AdminAnimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $animecontroller = new AnimeController;
        return view('admin.Anime.list', ['animes' => $animecontroller->index()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Anime.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $animecontroller = new AnimeController;
        $response = $animecontroller->store($request);
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
        $animecontroller = new AnimeController;
        $response = $animecontroller->show($id);
        if(array_key_exists('success', $response)){
            return view('admin.Anime.showDetails', ['anime' => $response['success']]);
        }elseif(array_key_exists('fail', $response)){
            return back()->with('fail', $response['fail']);
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
        $anime = Anime::find($id);
        if($anime){
            return view('admin.Anime.edit', ['anime' => $anime]);
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
        $animecontroller = new AnimeController;
        $response = $animecontroller->update($request, $id);
        if(array_key_exists('success', $response)){
            return back()->with('success', $response['success']);
        }else{
            return back()->with('fail-arr', $response);
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
        //
    }
}
