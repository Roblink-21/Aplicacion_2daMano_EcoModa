<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileProductResource;
use App\Http\Resources\ProfileResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class ProfileController extends Controller
{

    private string $ui_avatar_api = "https://ui-avatars.com/api/?name=*+*&size=128";

    public function show($id)
    {
        $user = User::find($id);

        return response([
            'user' => new ProfileResource($user),
            'your Products' => new ProfileProductResource($user)
        ], 201);

    }


    public function notice(){

        $user = Auth::user();

        $index = $user->id;

        $products_reserve =  Product::where('user_id', $index) ->where('status', 2)->get()->toArray(); 
        $products_bought = Product::where('user_id', $index) ->where('status', 3)->get()->toArray();

        if(empty($products_reserve) && empty($products_bought)){

            return [
                'message' => 'There are no records of Reserved or Sold Products!'
            ];
        }elseif (!empty($products_reserve) && empty($products_bought)){
            return [
                'My reserved Products' => $products_reserve,
                'My purchased Products' => 'There are no records of Sold Products!'
            ];
        }elseif (empty($products_reserve) && !empty($products_bought)){
            return [
                'My reserved Products' => 'There are no records of Reserved Products!',
                'My purchased Products' => $products_bought
            ];
        }else{

            return response([
                'My reserved Products' => $products_reserve,
                'My purchased Products' => $products_bought
            ], 201);

        }
    }

    //Actualizacion de datos del Usuario
    //Actualizar Username

    public function updateUsername(Request $request)
    {

        $request->validate([      
            'username' => ['required', 'string', 'min:3', 'max:20', 'unique:users'],
        ]);


        $user = auth()->user();

        $user->username = $request['username'];

        $user->save();

        return [
            'message' => 'Username update successfully!'
        ];
    }

    //Actualizar datos

    public function update(Request $request)
    {

        $request->validate([
            'first_name' => ['required', 'string', 'alpha','min:3', 'max:35'],
            'last_name' => ['required', 'string', 'min:3', 'max:35'],
            'birthdate' => ['nullable', 'string', 'date_format:d/m/Y',
            'after_or_equal:' . date('Y-m-d', strtotime('-70 years')),
            'before_or_equal:' . date('Y-m-d', strtotime('-18 years'))],
            'personal_phone' => ['required', 'numeric', 'digits:10'],
            'home_phone' => ['required', 'numeric', 'digits:9'],
            'address' => ['required', 'string', 'min:5', 'max:50'],
        ]);

        $user = auth()->user();

        /*Update the model using Eloquent*/
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->birthdate = $this->verifyDateFormat($request['birthdate']);
        $user->personal_phone = $request['personal_phone'];
        $user->home_phone = $request['home_phone'];
        $user->address = $request['address'];
        $user->save();

        $this->updateUIAvatar($user);

        return [
            'message' => 'Profile update successfully!'
        ];
    }

    private function updateUIAvatar(User $user): void
    {
        $user_image = $user->image;
        $image_path = $user_image->path;
        if (Str::startsWith($image_path, 'https://')) {
            $user_image->path = Str::replaceArray(
                '*',
                [
                    $user->first_name,
                    $user->last_name
                ],
                $this->ui_avatar_api
            );
            $user_image->save();
        }
    }

    private function verifyDateFormat(?string $date): ?string
    {
        return isset($date)
            ? $this->changeDateFormat($date, 'd/m/Y')
            : null;
    }


    public static function changeDateFormat(
        string $date,
        string $date_format,
        string $expected_format = 'Y-m-d'
    ): string
    {
        return Carbon::createFromFormat($date_format, $date)->format($expected_format);
    }


}
