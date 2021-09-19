<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }
    public function show($id){
        $user =  User::find($id);
        if($user){
            return $user;
        }else{
            return ['fail' => 'User not found!!'];
        }
    }
    public function update(Request $request, $id){
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'username' => 'string|between:5,30',
            'full_name' => 'string|between:5,30',
            'email' => 'string|email|max:100',
        ]);
        if($validator->fails()){
            return json_decode($validator->errors()->toJson());
        }
        $profile_photo = $user->profile_photo;
        if($user->username != $request->username && User::where('username', $request->username)->first()){
            return ['fail' => 'username already exist!'];
        }
        if($user->email != $request->email && User::where('email', $request->email)->first()){
            return ['fail' => 'Email already exist!'];
        }
        if($request->username && $user->username !== $request->username ){
            if(str_contains(parse_url($user->profile_photo, PHP_URL_PATH), '.png')){
                $filename = str_replace(' ', '-', $request->input('username')) . '.png';
                Storage::move(parse_url($user->profile_photo, PHP_URL_PATH),
                '/profile-pictures/' . $filename);
                $profile_photo = url('profile-pictures/'. $filename);
            }else{
                $profile_photo = 'https://ui-avatars.com//api//?name='.substr($request->username, 0, 2).'&color=7F9CF5&background=EBF4FF';
            }
        }
        $user->update(array_merge($request->all(), ['profile_photo' => $profile_photo]));
        return ['success' => 'Account Updated successfully!'];
    }
    public function updateAvatar(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpg,png|max:20000',
        ]);
        if($validator->fails()){
            return ($validator->errors()->toArray());
        }
        if(Auth::user()){
          $user = Auth::user();  
        }
        if($request->user){
            $user = $this->show($request->user);
        }
        $image = $request->file('image');
        if($image){
            $fileName = str_replace(' ', '-', $user->username) . '.png';
            $image = $request->file('image')->store('public');
            $image1 = $request->file('image')->move(public_path('/profile-pictures'), $fileName);
            $user->profile_photo  = url('/profile-pictures/' . $fileName);
            DB::update('update users set profile_photo = ? where id = ?', [url('/profile-pictures/' . $fileName), $user->id]);
            return ['success' => 'Profile picture updated successfully!'];
        }
        return response()->json('error', 404);
    }
    public function destroy($id)
    {
        if(User::find($id)){
            User::destroy($id);
            return ['success' => 'Account deleted successfully!'];
        }else{
            return ['fail' => 'User account not found!'];
        }
    }
}
