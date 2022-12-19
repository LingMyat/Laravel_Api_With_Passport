<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Authcontroller;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfileController;

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

Route::get('test',function(){
    return 'this is test url';
});
Route::controller(Authcontroller::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
    Route::post('logout','logout')->middleware('auth:api');
});

Route::middleware('auth:api')->group(function(){
    Route::controller(UserController::class)->group(function(){
        Route::get('profile','profile');
        Route::get('profile/posts','posts');
        Route::get('categories','categories');
    });

    Route::controller(PostController::class)->group(function(){
        Route::get('post','index');
        Route::post('post','create');
        Route::get('post/{id}','show');
    });
});



