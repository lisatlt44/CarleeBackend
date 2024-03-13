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

// Les routes définies ici sont préfixées par défaut par /api

// Structure d'authentification
Route::post('/register', '\App\Http\Controllers\UserController@register');
Route::post('/login', '\App\Http\Controllers\UserController@login');
// Route::middleware('auth:api')->group(function () {
  // CRUD operations for users
  Route::get('/users/{id}', '\App\Http\Controllers\UserController@show');
  Route::put('/users/{id}', '\App\Http\Controllers\UserController@update');
  Route::delete('/users/{id}', '\App\Http\Controllers\UserController@destroy');
// });

// Route::middleware('auth:api')->group(function () {
  // CRUD operations for cars
  Route::get('/cars/{id}', '\App\Http\Controllers\CarController@show');
  Route::post('/cars', '\App\Http\Controllers\CarController@store');
  Route::put('/cars/{id}', '\App\Http\Controllers\CarController@update');
  Route::delete('/cars/{id}', '\App\Http\Controllers\CarController@destroy');
// });

// Route::middleware('auth:api')->group(function () {
    // CRUD operations for documents
  Route::get('/documents/{id}', '\App\Http\Controllers\DocumentController@show');
  Route::post('/documents', '\App\Http\Controllers\DocumentController@store');
  Route::put('/documents/{id}', '\App\Http\Controllers\DocumentController@update');
  Route::delete('/documents/{id}', '\App\Http\Controllers\DocumentController@destroy');
// });

// Route::middleware('auth:api')->group(function () {
    // CRUD operations for car_pictures
    Route::get('/car-pictures/car/{carId}', '\App\Http\Controllers\CarPictureController@index');
    Route::get('/car-pictures/{id}', '\App\Http\Controllers\CarPictureController@show');
    Route::post('/car-pictures', '\App\Http\Controllers\CarPictureController@store');
    Route::delete('/car-pictures/{id}', '\App\Http\Controllers\CarPictureController@destroy');
  // });