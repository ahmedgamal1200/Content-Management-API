<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return response()->json([
            'message' => 'Tags retrieved successfully.',
            'tags' => $tags,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:tags,name',
        ]);
        $tag = Tag::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Tag created successfully!',
            'tag' => $tag,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|unique:tags,name, ' . $id,
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()], 400);
        }

        $tag = Tag::find($id);

        if(!$tag){
            return response()->json(['message' => 'Tag not found'], 404);
        }

        $tag->name = $request->name;
        $tag->save();

        return response()->json(['message' => 'Tag updated successfully', 'tag' => $tag]);
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json([
                'message' => 'Tag not found.'
            ], 404);
        }

        $tag->delete();

        return response()->json([
            'message' => 'Tag deleted successfully.'
        ], 200);
    }


}
