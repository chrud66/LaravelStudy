<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImplicitController extends Controller
{
    /** GET impl/index */
    public function index()
    {
        $collection = collect([1, 'apple', '', 'banana', null, 3])
        ->map(function ($name) {
            return strtoupper($name);
        })
        ->reject(function($name) {
            return is_numeric($name);
        })
        ->reject(function($name) {
            return empty($name);
        });

        return dump($collection);
    }

    public function show(Request $request, $id)
    {
        $col = collect(['fruid' => 'Banana', 'price' => 50]);

        if ($request->ajax()) {
            return $col->toJson();
        }

        return $col->toArray();

        //return 'getShow ID : ' . $id;
    }

    public function post($id)
    {
        return 'getPost ID : ' . $id;
    }
}
