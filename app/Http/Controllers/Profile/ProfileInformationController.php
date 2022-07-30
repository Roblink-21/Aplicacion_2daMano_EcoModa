<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileInformationController extends Controller
{
    private string $ui_avatar_api = "https://ui-avatars.com/api/?name=*+*&size=128";

    public function edit()
    {
        return view('profile.show', [
            'user' => Auth::user(),
        ]);
    }

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

        $user = $request->user();

        /*Update the model using Eloquent*/
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->birthdate = $this->verifyDateFormat($request['birthdate']);
        $user->personal_phone = $request['personal_phone'];
        $user->home_phone = $request['home_phone'];
        $user->address = $request['address'];
        $user->save();

        $this->updateUIAvatar($user);

        return back()->with('status', 'Profile update successfully');
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

    public function show(User $user)
    {
        //dd($product);
        //$user = $product -> user;
        //dd($user);
        $similar = User::where('id', $user->id) ->first();

        $yours_products = $user -> products() -> where('user_id', $user->id) ->where('status', 1)->latest('id')->paginate(4); 

        return view('profile.info', compact('similar', 'yours_products'));
    }

    public function notice(){

        $user = Auth::user();

        $index = $user->id;

        $products_reserve =  Product::where('user_id', $index) ->where('status', 2)->latest('id')->paginate(4); 
        $products_bought = Product::where('user_id', $index) ->where('status', 3)->latest('id')->paginate(4);
        //35:0,59:0,;57:1,13:1,56:1,;55:2,58:2,3:2,

        return view('profile.notice', compact('products_reserve', 'products_bought'));

    }
}