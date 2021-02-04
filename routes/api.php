<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BlogController;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/register', 'RegisterController@register')->name('register');



// Route::get('/register', function(){
//     return 'Hello World';
// });

Route::post('/login',[RegisterController::class, 'login']);
Route::post('/register',[RegisterController::class, 'register']);




Route::middleware('auth:api')->group( function () {
    Route::get('/blogs',[BlogController::class, 'index']);
    Route::post('/storeBlog',[BlogController::class, 'store']);
    Route::put('/updateBlog/{id}',[BlogController::class, 'update']);
    Route::get('/showBlog/{id}', [BlogController::class, 'show']);
    Route::delete('/deleteBlog/{id}', [BlogController::class, 'destroy']);
});

