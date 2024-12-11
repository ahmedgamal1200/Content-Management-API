<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())
        ->orderBy('pinned', 'desc')
        ->latest()->with('tags')->get();

        return response()->json(['posts' => $posts]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'cover_image' => 'required|image|max:2048',
            'pinned' => 'required|boolean',
            'tags' => 'required|string',
            'tags.*' => 'exists:tags,id'
        ]);

        //store the cover image
        $coverImagePath = $request->file('cover_image')->store('cover_images', 'public');

        // create the post
        $post = Post::create([
            'title' =>$request->title,
            'body' => $request->body,
            'cover_image' => $coverImagePath,
            'pinned' => $request->pinned,
            'user_id' => Auth::id(),
        ]);

        //to ensures that tags are linked to the post
        $post->tags()->attach($request->tags);

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post->load('tags'),
        ], 201);
    
    }

    public function show($id)
    {
        $post = Post::where('user_id', Auth::id())->where('id', $id)->first();

        if($post)
        {
            return response()->json(['post' => $post], 200);
        }else{
            return response()->json(['message' => 'Post not found or you do not have access'], 404);
        }
    }

    public function update(Request $request, $post_id)
{
    
    $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'pinned' => 'required|boolean',
        'tags' => 'string', 
        'cover_image' => 'nullable|image',
    ]);

    $post = Post::where('user_id', Auth::id())->find($post_id);

    if (!$post) {
        return response()->json(['message' => 'Post not found'], 404);
    }

    $post->update([
        'title' => $request->title,
        'body' => $request->body,
        'pinned' => $request->pinned,

        'cover_image' => $request->hasFile('cover_image') ? $request->file('cover_image')->store('images') : $post->cover_image,
    ]);

    if ($request->has('tags')) {
        $post->tags()->sync($request->tags);
    }

    return response()->json([
        'message' => 'Post updated successfully',
        'post' => $post
    ]);
}

    public function softDelete($id)
    {
        $post = Post::where('id', $id)->where('user_id', Auth::id())->first();

        if(!$post)
        {
            return response()->json([
            'message' => 'Post not found or not authorized to delete.'
            ],404);
        }

        $post->delete();
        return response()->json([
            'message' => 'Post deleted successfully.'
        ], 200);
    }

    public function deletedPosts()
    {
        $userId = Auth::id();

        $deletedPosts = Post::onlyTrashed()->where('user_id', $userId)->with('tags')->orderBy('updated_at', 'desc')->get();

        return response()->json([
            'message' => 'Deleted posts retrieved successfully.',
            'deleted_posts' => $deletedPosts
        ], 200);
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $post->restore();

        return response()->json([
            'message' => 'Post restored successfully.',
            'post' => $post
        ],200);
    }

}
