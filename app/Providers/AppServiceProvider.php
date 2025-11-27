<?php

namespace App\Providers;
use App\Http\ViewComposers\MahasiswaNavbarComposer;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        view()->composer('landing.header-mhs', MahasiswaNavbarComposer::class);
    }
}
