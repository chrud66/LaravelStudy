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
}
