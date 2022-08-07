<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    
    public function index()
    {
        return Tag::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:35'],
            'slug' => ['required', 'string', 'min:3', 'max:35', 'unique:tags']
        ]);

        return Tag::create($request->all());
    }

    public function show($id)
    {
        return Tag::find($id);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:35'],
            'slug' => ['required', 'string', 'min:3', 'max:35', 'unique:tags']
        ]);


        $tag -> update($request->all());

        return $tag;
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);

        try {
            
            $tag -> delete();
            return response() -> json([
                'message' => 'delete success'
            ]);

        } catch (\Exception $e){

            return $e -> getMessage();

        }
    }
}
