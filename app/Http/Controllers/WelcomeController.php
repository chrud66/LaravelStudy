<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['only' => ['home']]);
    }

    public function index()
    {
        //return view('welcome');
        return view('index');
    }

    public function locale()
    {
        $cookie = cookie()->forever('locale__Laravel', request('locale'));

        cookie()->queue($cookie);

        return ($return = request('return'))
        ? redirect(urldecode($return))->withCookie($cookie)
        : redirect(urldecode('home'))->withCookie($cookie);
    }
}
