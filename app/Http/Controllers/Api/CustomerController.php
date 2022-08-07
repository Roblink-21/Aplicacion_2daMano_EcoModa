<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        return Product::where('user_id', auth()->user()-> id)-> latest('id')->get()->toArray();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:45'],
            'slug' => ['required', 'string', 'min:3', 'max:35', 'unique:products'],
            'details' => ['required', 'string', 'min:5', 'max:45'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string', 'min:5', 'max:255'],
            'category_id' => 'required',
            'tags' => 'required',
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:512'], //max image size is 512 kb
        ]);


        $guard = Auth::user();

        //dd($guard);

        $product = new Product();

        $product -> name = $request['name'];
        $product -> slug = $request['slug'];
        $product -> details = $request['details'];
        $product -> price = $request['price'];
        $product -> description = $request['description'];
        $product -> category_id = $request['category_id'];

        $guard -> products() -> save($product);

        $product -> tags() -> attach($request->tags);

        if ($request->has('image'))
        {
            $product->storeImage($request['image'], 'products', 'images');
        }
        
        return [
            'message' => 'created the product'
        ];;

    }

    public function show($id)
    {

        $userA = auth()->user()-> id;
        $userP = Product::find($id) -> user_id;

        if($userA === $userP){
            return Product::find($id);
        } else {

            return [
                'message' => 'is not your product'
            ];

        }
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:45'],
            'slug' => ['required', 'string', 'min:3', 'max:35', 'unique:products'],
            'details' => ['required', 'string', 'min:5', 'max:45'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string', 'min:5', 'max:255'],
            'category_id' => 'required',
            'tags' => 'required',
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:512'], //max image size is 512 kb
        ]);

        $post = Product::find($id);

        $post -> name = $request['name'];
        $post -> slug = $request['slug'];
        $post -> details = $request['details'];
        $post -> price = $request['price'];
        $post -> description = $request['description'];
        $post -> category_id = $request['category_id'];

        $post -> tags() -> sync($request->tags);


        $post->save();
        

        if ($request->has('image'))
        {
            $post->updateImage($request['image'], 'products', 'images');
        }

        return [
            'message' => 'product update'
        ];
    }

    
    public function destroy($id)
    {
        $post = Product::find($id);
        $value = $post -> id;
        $state = $post->status;
        if($state == 0){
            
            Product::where('id', $value) ->update(['status' => '3' ]);

            return [
                'message' => 'product delete'
            ];
            
        }
        elseif ($state == 3){
           
            Product::where('id', $value) ->update(['status' => '0' ]);

            return [
                'message' => 'product activated'
            ];
        }
    }

}
