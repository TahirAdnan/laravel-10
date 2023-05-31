<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AvatarController;
// use App\Http\Controllers\Controller;
// use App\Http\Requests;
use Illuminate\Http\Request;


class AvatarController extends Controller
{
    public function add(Request $request)
    {
        $path = $request->file('avatar')->store('avatars','public');
        auth()->user()->update(['avatar' => $path]);    
        return redirect(route('profile.edit'))->with('success', 'Avatar-uploaded');
    }    

}
