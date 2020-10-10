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
        $floors = LayersModel::where("layer_type", "=", 0)->get();

        View::share('floors', $floors);
    }
}
