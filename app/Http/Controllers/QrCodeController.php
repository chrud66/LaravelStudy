<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests\QrCodeRequest;

class QrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('qrCode.index');
    }

    public function generator(QrCodeRequest $request)
    {
        dd($request->input());
    }

    public function getForm($name)
    {
        return view('qrCode.partial.'.$name);
    }
}
