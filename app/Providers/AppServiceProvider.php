<?php

namespace App\Providers;

use App\Services\IceAndFire\IceAndFireContract;
use App\Services\IceAndFire\IceAndFireService;
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
        $this->registerIceAndFireServiceRegister();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerIceAndFireServiceRegister()
    {
        $this->app->singleton(IceAndFireContract::class, function () {
            return new IceAndFireService();
        });
    }
}
