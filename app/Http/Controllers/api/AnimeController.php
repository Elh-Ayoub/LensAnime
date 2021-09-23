<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Anime;

class AnimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Anime::all();
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:500'],
            'categories' => ['required', 'max:255'],
            'image' => ['required'],
        ]);
        if($validator->fails()){
            return ($validator->errors()->toArray());
        }
                        ///---later---
        // $categories = explode(" ", $request->categories);
        // foreach($categories as $category){
        //     $cat = Category::where('title', $category)->first();
        //     if(!$cat){
        //         Category::create([
        //             'title' => trim($category),
        //         ]);
        //     }
        // }
        $image = $this->uploadImage($request);
        $anime = Anime::create(array_merge($request->all(), ['image' => $image, 'created_by' => Auth::id()]));
        if($anime){
            return ['success' => 'anime created successfully!'];
        }else{
            return ['fail' => 'Something went wrong!'];
        }
    }
    function uploadImage($request){
        $image = $request->file('image');
        if($image){
            $filename = str_replace(' ', '-', $request->input('title')). '.png';
            $image = $request->file('image')->store('public');
            $image1 = $request->file('image')->move(public_path('/anime-images'), $filename);
            return url('/anime-images/' . $filename);
        }
    }
    
    public function show($id)
    {
        $anime = Anime::find($id);
        if($anime){
            return ['success' => $anime];
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
