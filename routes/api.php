<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WebsiteController;
use App\Jobs\SendEmail;
use App\Jobs\SendMail;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('posts',PostController::class);
Route::apiResource('users',UserController::class);
Route::apiResource('websites',WebsiteController::class);

Route::get('users/website_id/{website}', [UserController::class, 'getUsersByWebsite']);
Route::get('posts/website_id/{website}', [PostController::class, 'getPostsByWebsite']);

