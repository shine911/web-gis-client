<?php

namespace App\Providers;

use App\Models\LayersModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Use bootstrap paginator
        Paginator::useBootstrap();

        //View share
        $floors = LayersModel::where("layer_type", "=", 0)->orderBy('floor')->get();
        $dormitories = LayersModel::where('layer_type', '=', 1)->orderBy('floor')->get();
        $electricNetwork =  LayersModel::where('layer_type', '=', 2)->get();
        $waterNetwork = LayersModel::where('layer_type', '=', 3)->get();
        View::share('floors', $floors);
        View::share('dormitories', $dormitories);
        View::share('electricNetwork', $electricNetwork);
        View::share('waterNetwork', $waterNetwork);
    }
}
