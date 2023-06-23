<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class SocialLoginController extends Controller
{
// Login with github
    public function githubLogin()
    { 
        return Socialite::driver('github')->redirect();
    } 
    public function githubCallback()
    {            
        $user = Socialite::driver('github')->user();
        $user = User::firstOrCreate(
            ['email' => $user->email],
            ['name' => $user->nickname,'password' => 'password']
        );
        Auth::login($user);
        return redirect('/dashboard');
    } 

// Login with facebook
    public function facebookLogin()
    { 
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {   
        $user = Socialite::driver('facebook')->user();
        $user = User::firstOrCreate(
            ['email' => $user->email],
            ['name' => $user->name,'password' => 'password']
        );
        Auth::login($user);
        return redirect('/dashboard');
    } 
    
    // Login with google
    public function googleLogin()
    { 
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {   
        $user = Socialite::driver('google')->user();
        $user = User::firstOrCreate(
            ['email' => $user->email],
            ['name' => $user->name,'password' => 'password'],
            ['email' => $user->avatar]
        );
        Auth::login($user);
        return redirect('/dashboard');
    } 
}
