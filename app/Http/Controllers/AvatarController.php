<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AvatarController;
// use App\Http\Controllers\Controller;
// use App\Http\Requests;
use Illuminate\Http\Request;


class AvatarController extends Controller
{
    public function add(Request $request)
    {
        
        $request->file('avatar')->store('avatars');
        // dd($request->file('avatar')->store('avatars'));
        // $request->validate([
        //     'title' => 'required',
        //     'image' => 'required|image|max:2048',
        // ]);
    
        // $avatarPath = $request->file('image')->store('public/images');
        // $avatar = new Image([
        //     'title' => $request->get('title'),
        //     'image_path' => $avatarPath,
        // ]);
        // $avatar->save();
    
        return redirect(route('profile.edit'))->with('success', 'Avatar uploaded successfully');
    }    

}
