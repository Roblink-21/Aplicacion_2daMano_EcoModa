<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function index()
    {
        return Category::all();
    }

    public function indexFree()
    {
        return Category::all();
    }

    
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:35'],
            'slug' => ['required', 'string', 'min:3', 'max:35', 'unique:categories']
        ]);

        return Category::create($request->all());
        
    }

    
    public function show($id)
    {
        return Category::find($id);
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:35'],
            'slug' => ['required', 'string', 'min:3', 'max:35', 'unique:categories']
        ]);

        $category = Category::find($id);

        $category -> update($request->all());

        return $category;
    }

    
    public function destroy($id)
    {
        $category = Category::find($id);

        try {
            
            $category -> delete();
            return response() -> json([
                'message' => 'delete success'
            ]);

        } catch (\Exception $e){

            return $e -> getMessage();

        }
    }
}
