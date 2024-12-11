<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        $totalPosts = Post::count();

        $UsersWithZeroPosts = User::doesntHave('posts')->count();

        return response()->json([
            'total_users' => $totalUsers,
            'total_posts' => $totalPosts,
            'users_with_zero_posts' => $UsersWithZeroPosts,

    ]);
    
}

}
