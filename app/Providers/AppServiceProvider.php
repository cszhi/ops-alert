<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //\DB::listen(function($query) { \Log::info($query); });
        //$menus = Menu::where('pid', '0')->orderBy('sort')->get();
        //view()->share('menus', $menus);
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
