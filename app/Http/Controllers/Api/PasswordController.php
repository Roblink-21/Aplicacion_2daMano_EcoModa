<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;


class PasswordController extends Controller
{
    public function update(Request $request)
    {
        $rules =[
            'current_password' => ['required', 'string', 'max:255'],
            'password' => [
                'required',
                'string',
                Password::min(6)->mixedCase()->numbers()->symbols(),
                'confirmed',
                'max:255'
            ],
            'password_confirmation' => ['required']
        ];

        $user = auth()->user();

        $input = $request->only('current_password', 'password', 'password_confirmation');

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        //Se debe verificar si la pass coincide con la del usuario
        if(!$this->checkPassword($request->input('current_password'), $user->password)){

            throw ValidationException::withMessages([
                'current_password' => 'No es su password actual',
            ]);
        }


        $user->password = Hash::make($request->password);
        $user->save();

        return [
            'message' => 'Password update successfully!'
        ];
    }


    public function checkPassword(string $current_password, string $user_password): bool
    {
        return Hash::check($current_password, $user_password);

    }
}
