<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//   return $request->user();
// });


// Structure d'authentification
Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');
// Route::middleware('auth:api')->group(function () {
  // CRUD operations for users
  Route::get('/users/{id}', '\App\Http\Controllers\UserController@show');
  Route::put('/users/{id}', 'UserController@update');
  Route::delete('/users/{id}', 'UserController@destroy');
// });

// Route::middleware('auth:api')->group(function () {
//   // CRUD operations for cars
//   Route::post('/cars', 'CarController@store');
//   // Route::get('/cars/{id}', 'CarController@show');
//   Route::put('/cars/{id}', 'CarController@update');
//   Route::delete('/cars/{id}', 'CarController@destroy');
// });

// Route::middleware('auth:api')->group(function () {
//     // CRUD operations for documents
//   // Route::post('/documents', 'DocumentController@store');
//   Route::get('/documents/{id}', 'DocumentController@show');
//   Route::put('/documents/{id}', 'DocumentController@update');
//   Route::delete('/documents/{id}', 'DocumentController@destroy');
// });