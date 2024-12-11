<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\TagsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');



Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/tags', [TagsController::class, 'index']);
    Route::post('/tags', [TagsController::class, 'store']);
    Route::PUT('/tags/{id}', [TagsController::class, 'update']);
    Route::DELETE('/tags/{id}', [TagsController::class, 'destroy']);
});


Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::post('/posts/{id}', [PostController::class, 'show']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'softDelete']);
    Route::get('/posts/deleted', [PostController::class, 'deletedPosts']);
    Route::patch('/posts/{id}/restore', [PostController::class, 'restore']);
});

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/stats', [StatsController::class, 'index']);
});