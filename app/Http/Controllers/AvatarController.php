<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AvatarController extends Controller
{
    
    public function index()
    {
        $images = Avatar::all();
        return view('avatars.index', compact('images'));
    }
    
    public function store(Request $request)
    {
        dd($request);
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|max:2048',
        ]);
    
        $avatarPath = $request->file('image')->store('public/images');
        $avatar = new Image([
            'title' => $request->get('title'),
            'image_path' => $avatarPath,
        ]);
        $avatar->save();
    
        return redirect('/images')->with('success', 'Image uploaded successfully');
    }    

}
