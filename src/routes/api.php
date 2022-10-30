<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostCommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/posts/image/upload', [PostController::class, 'upload']);

Route::apiResource('authors', AuthorController::class)->only([
    'index', 'store', 'show'
]);

Route::apiResource('posts', PostController::class);

Route::apiResource('posts.comments', PostCommentController::class)->shallow()->except([
    'show', 'update'
]);
