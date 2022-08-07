<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileAvatarController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:512']
        ]);

        $user = auth()->user();

        $user->updateImage($request['image'], 'avatars');
        
        return [
            'message' => 'Avatar update successfully!'
        ];
    }
}
