<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Str;

class AuthController extends Controller
{
    public function login(Request $request, $requiredRole = null){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->role == $requiredRole || !$requiredRole){
                return ['success' => Auth::user()];
            }else{
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return ['error' => 'Only Admins can log in.'];
            }
        }else{
            return ['error' => 'Not matching our credentials!'];
        }
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users|between:5,30',
            'full_name' => 'required|string|between:5,30',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);
        if($validator->fails()){
            return ($validator->errors()->toArray());
        }
        $name = substr($request->input('username'), 0, 2);
        $role = 'user';
        if(($request->path() == 'admin/auth/register')){
            $role = 'admin';
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password),
            'profile_photo' => 'https://ui-avatars.com//api//?name='.$name.'&color=7F9CF5&background=EBF4FF',
            'role' => $role]
        ));
        event(new Registered($user));
        if($user){
            return ['success' => 'Account created successfully. Please check mailbox to verify email.'];
        }else{
            return ['error' => 'Somthing went wrong! Try again.'];
        }
    }
    
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if(!Auth::user()){
            return ['success' => 'logged out suucceessfully!'];
        }else{
            return ['error' => 'Something went wrong!'];
        }
    }

    function sendResetLink(Request $request){
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? (['success' => __($status)])
                    : (['fail' => __($status)]);
    }
    function resetPassword(Request $request, $token){
        $request->validate([
            'token' => 'required',
            'email' => 'email',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $status = Password::reset(
            array_merge($request->only('email', 'password', 'password_confirmation'), ['token' => $token]),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET
                    ? (['success' => __($status)])
                    : (['fail' => [__($status)]]);
    }
}
