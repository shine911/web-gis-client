<?php

use App\Http\Controllers\Web\DormitoryController;
use App\Http\Controllers\Web\LayersController;
use App\Models\LayersModel;
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
    $urlFloors = LayersModel::where("layer_type", "=", 0)->orderBy('floor')->get();
    $urlDormitys = LayersModel::where("layer_type", "=", 1)->orderBy('floor')->get();
    $data = ['url' => $urlFloors, 'urlDormitys' => $urlDormitys ];
    return view('index', $data);
})->name('index');

Route::get('/login', function(){
    return view('login');
});



Route::group(['middleware' => 'localization'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/floors/{layerId}.{floor}', 'Web\RoomsController@index')->name('floor.show');
    Route::get('/floors/{layerId}.{floor}/id/{id}', 'Web\RoomsController@detail')->name('room.show');

    //Dormitories
    Route::get('/dormitories/{layerId}.{floor}', [DormitoryController::class, 'index'])->name('dormitory.show');
    Route::get('/dormitories/{layerId}.{floor}/detail/{id}', [DormitoryController::class, 'detail'])->name('dormitory.detail');

    //Layer Settings
    Route::get('/layers', [LayersController::class, 'index'])->name('layers.index');
    Route::get('/layers/detail/{id}', [LayersController::class, 'detail']);
    Route::post('/layers/detail/{id}', [LayersController::class, 'detailPost']);
    Route::get('/layers/create', [LayersController::class, 'create'])->name('layers.create');
    Route::post('/layers/create', [LayersController::class, 'createPost']);

    //Index
    //SportGrounds
    Route::get("/sport-grounds", function(){
       return view('sportview');
    })->name('sport-view');

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
