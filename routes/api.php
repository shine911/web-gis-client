<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('utf-8')->resource('room', 'Api\RoomController');
//TODO: Fix here
Route::middleware('utf-8')->resource('room', 'Api\RoomController');
Route::middleware('utf-8')->resource('map', 'Api\MapController');
Route::middleware('utf-8')->resource('dormitory', 'Api\DormitoryController');