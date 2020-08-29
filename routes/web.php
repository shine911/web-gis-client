<?php

use App\FeaturesConfigUrl;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
Auth::routes([
    'reset' => false,
    'verify' => false,
    'register' => false,
 ]);
 
Route::get('/', function () {
    $data = ['url' => FeaturesConfigUrl::all() ];
    return view('index', $data);
});
Route::get('/login', function(){
    return view('login');
});



Route::group(['middleware' => 'localization'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/room', 'Web\RoomViewController@index');
    Route::get('/room/detail', 'Web\RoomViewController@detail')->name('room_detail');
    Route::get('/mapeditor', 'WebMapEditorController@index');
    Route::get('/tang1_tret', 'Web\Tang1_TretController@index');
    Route::get('/tang1_tret/detail/{id}', 'Web\Tang1_TretController@detail');
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
