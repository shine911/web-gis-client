<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/login', function(){
    return view('login');
});



Route::group(['middleware' => 'localization'], function () {
    Route::get('/home', 'DashboardController@index');
    Route::get('/room', 'Web\RoomViewController@index');
    Route::get('/room/detail', 'Web\RoomViewController@detail')->name('room_detail');
    Route::get('/mapeditor', 'WebMapEditorController@index');
    Route::get('/tang1_tret', 'Web\Tang1_TretController@index');
});
//i18n Settings
Route::get('settings/lang/{locale}', function ($locale) {
    $lang = $locale;
    $language = config('app.locale');
    if ($lang == 'en') {
        $language = 'en';
    }
    if ($lang == 'vi') {
        $language = 'vi';
    }
    session()->put('language', $language);
    return redirect()->back();
})->name('change-laguage');
