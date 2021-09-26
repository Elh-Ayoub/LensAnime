<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:categories|between:1,100',
        ]);
        if($validator->fails()){
            return ($validator->errors()->toArray());
        }
        $category = Category::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        if($category){
            return ['success' => 'Category ' . $category->title . ' created successfully!'];
        }else{
            return ['fail' => 'Something went wrong!'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $category = Category::find($id);
        if($category){
            return ['success' => $category];
        }else{
            return ['fail' => 'Noting found!'];
        }
    }
    public function getAnimesByCategory($id){
        $animes = Anime::all();
        $category = Category::find($id);
        if($category){
            $res = [];
            foreach($animes as $anime){
                if(str_contains(strtoupper($anime->categories), strtoupper($category->title))){
                    array_push($res, $anime);
                }
            }
            return $res;
        }else{
            return ['fail' => 'Category requested not found!'];
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if($category){
            $validator = Validator::make($request->all(), [
                'title' => 'string|between:1,100',
                'description' => 'string|between:1,100',
            ]);
            if($validator->fails()){
                return json_decode($validator->errors()->toJson());
            }
            if($category->title != $request->title && Category::where('title', $request->title)->first()){
                return ['fail' => 'This category title has already been taken.'];
            }else{
                $category->update([
                    'title' => $request->title,
                    'description' => $request->description,
                ]);
                return ['success' => 'Category updated successfully!'];
            }            
        }else{
            return ['fail' => 'Category requested not found!'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id){
        if(Category::find($id)){
            Category::destroy($id);
            return ['success' => 'Category deleted successfully!'];
        }
        else{
            return ['fail' => 'Category requested not found!'];
        }
    }
}
