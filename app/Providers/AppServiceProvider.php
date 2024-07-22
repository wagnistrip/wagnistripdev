<?php

namespace App\Providers;

use App\Services\AmadeusService;
use App\Services\GalileoService;
use App\Services\EasebuzzService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AmadeusService::class, function ($app) {
            return new AmadeusService(
                config('services.amadeus.client_id'),
                config('services.amadeus.client_secret')
            );
        });
        $this->app->singleton(GalileoService::class, function ($app) {
            return new GalileoService(
                config('services.galileo.user_name'),
                config('services.galileo.password'),
            );
        });
        $this->app->singleton(EasebuzzService::class, function ($app) {
            return new EasebuzzService(
                config('services.easebuzz.api_key'),
                config('services.easebuzz.api_secret'),
                config('services.easebuzz.merchant_id')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
