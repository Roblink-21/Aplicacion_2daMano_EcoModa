<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function indexFree()
    {
        $categories = Category::all();
        
        return view('welcome', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.categories.create');
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
            'name' => ['required', 'string', 'min:3', 'max:35'],
            'slug' => ['required', 'string', 'min:3', 'max:35', 'unique:categories']
        ]);

        $category = Category::create($request->all());

        return redirect()->route('admin.categories.edit', $category)-> with('status', 'Category create successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:35'],
            'slug' => ['required', 'string', 'min:3', 'max:35', 'unique:categories']
        ]);

        $category ->update($request->all());

        return redirect()->route('admin.categories.edit', $category)->with('status', 'Category update successfully');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
       
        $category -> delete();

        return redirect()->route('admin.categories.index')->with('status', "Category delete successfully");
    }
}
