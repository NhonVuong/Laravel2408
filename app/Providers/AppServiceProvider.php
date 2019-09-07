<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Categories;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['layout.menu-left','pages.update-product','pages.add-product'],function($view){
            $menu = Categories::all();
            $view->with('menu', $menu);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
