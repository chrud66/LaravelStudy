<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImplicitController extends Controller
{
    /** GET impl/index */
    public function index()
    {
        return 'getIndex';
    }

    public function show($id)
    {
        return 'getShow ID : ' . $id;
    }

    public function post($id)
    {
        return 'getPost ID : ' . $id;
    }
}
