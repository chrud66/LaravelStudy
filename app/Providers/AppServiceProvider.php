<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //기본 스트링 길이 지정
        Schema::defaultStringLength(191);

        if ($locale = request()->cookie('locale__Laravel')) {
            app()->setLocale(\Crypt::decrypt($locale));
        }


        if (! is_api_request()) {
            view()->composer('*', function ($view) {
                $view->with('currentLocale', app()->getLocale());
                $view->with('currentUser', auth()->user());
                $view->with('currentRouteName', \Route::currentRouteName());
                $view->with('currentUrl', \Request::fullUrl());
            });
        }
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
