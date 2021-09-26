<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Anime;
use App\Models\Category;

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

        foreach($request->categories as $category){
            $cat = Category::where('title', $category)->first();
            if(!$cat){
                Category::create([
                    'title' => $category
                ]);
            }
        }
        $categories = implode(", ", $request->categories);
        $image = $this->uploadImage($request);
        $anime = Anime::create(array_merge($request->all(), [
            'image' => $image,
             'created_by' => Auth::id(),
              'categories' => $categories
        ]));
        if($anime){
            return ['success' => 'Anime created successfully!'];
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:500'],
            'categories' => ['max:255'],
        ]);
        if($validator->fails()){
            return ($validator->errors()->toArray());
        }
        $anime = Anime::find($id);
        $image = $anime->image;
        $categories = $anime->categories;

        if($request->file('image')){
            $image = $this->uploadImage($request);
        }
        if($request->categories){
            foreach($request->categories as $category){
                $cat = Category::where('title', $category)->first();
                if(!$cat){
                    Category::create([
                        'title' => $category
                    ]);
                }
            }
            $categories = implode(", ", $request->categories);
        }
        $anime->update(array_merge($request->all(), [
            'image' => $image,
            'categories' => $categories,
        ]));
        return ['success' => 'Anime Updated successfully!'];
    }

    public function destroy($id)
    {
        if(Anime::find($id)){
            Anime::destroy($id);
            return ['success' => "Anime deleted successfully!"];
        }else{
            return ['fail' => 'Not found!'];
        }
    }
}
