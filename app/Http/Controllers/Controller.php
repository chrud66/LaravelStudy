<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->setSharedVariables();
    }

    protected function setSharedVariables()
    {
        view()->share('currentLocale', app()->getLocale());
        view()->share('currentUser', auth()->user());
        view()->share('currentRouteName', \Route::currentRouteName());
        view()->share('currentUrl', \Request::fullUrl());
        /*View::share('currentLocale', app()->getLocale());
        View::share('currentUser', auth()->user());
        View::share('currentRouteName', \Route::currentRouteName());
        View::share('currentUrl', \Request::fullUrl());*/
    }
}
