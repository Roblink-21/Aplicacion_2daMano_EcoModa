<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Product::class, 'post');
    }

    public function index()
    {
        $posts = Product::where('user_id', auth()->user()-> id)-> latest('id')->paginate(4);

        return view('custom.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
      
        return view('custom.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        
        return back()->with('status', 'Product created successfully');
    }


    public function show(Product $product)
    {
        return view('custom.show', compact('product'));
    }

    public function edit(Product $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('custom.edit', compact('post', 'categories', 'tags'));
    }

    
    public function update(Request $request, Product $post)
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

        

        return back()->with('status', 'Product updated successfully');
    }

    public function change(Product $post)
    {
        $value = $post -> id;
        $state = $post->status;
        if($state == 0){
            Product::where('id', $value) ->update(['status' => '3' ]);
            $message = "removed from product list";
        }
        elseif ($state == 3){
            Product::where('id', $value) ->update(['status' => '0' ]);
            $message = "activated again";

        }
        return back()->with('status', "Product $message successfully");
    }
}
