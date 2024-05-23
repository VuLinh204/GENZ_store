<?php

namespace App\Providers;

use App\Models\Favorite;
use App\Observers\FavoriteObserver;
use Illuminate\Support\ServiceProvider;

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
        Favorite::observe(FavoriteObserver::class);
    }
}
