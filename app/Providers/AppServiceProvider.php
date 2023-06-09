<?php

namespace App\Providers;

use App\Http\Resources\UsuariResource;
use Illuminate\Support\ServiceProvider;
use App\Http\Resources\ExpedientResource;

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
        ExpedientResource::withoutWrapping();
        UsuariResource::withoutWrapping();
    }
}
