<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //funcion pr registro 
    public function register(Request $request){
        $rules = [

            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'personal_phone' => ['required', 'string', 'max:10'],
            'home_phone' => ['required', 'string', 'max:9'],
            'address' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required']
        ];


        $input = $request->only('first_name', 'last_name', 'username', 'personal_phone', 'home_phone', 'address', 'email', 'password', 'password_confirmation');

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'personal_phone' => $request->personal_phone,
            'home_phone' => $request->home_phone,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->image()->create([
            'path' => $user->generateAvatarUrl(),
        ]);

        return [
            'message' => 'Register succesfull'
        ];

    }
    
    //Funcion para realizar login
    public function login(LoginRequest $request)
    {
        //Ejecuta el metodo de la clase LoginRequest
        $request->authenticate();
        //Toma el usuario del request
        $user = $request->user();
        //Se crea un token
        $token = $user->createToken('token-name')->plainTextToken;
        //Se procede a realizar la respuesta
        return response([
            'user' => new UserResource($user),
            'token' => $token
        ], 201);
    }

    public function index()
    {
        return User::all();
    }

    public function logout(Request $request): array
    {
        // https://laravel.com/docs/8.x/queries#delete-statements
        $request->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}