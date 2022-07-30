<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsernameController extends Controller
{
    public function edit()
    {
        return view('profile.show', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {

        $request->validate([      
            'username' => ['required', 'string', 'min:3', 'max:20', 'unique:users'],
        ]);


        $user = $request->user();

        $user->username = $request['username'];

        $user->save();


        return back()->with('status', 'Username update successfully');
    }
}
