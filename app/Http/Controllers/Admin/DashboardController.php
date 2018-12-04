<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalByte = disk_total_space($_SERVER["DOCUMENT_ROOT"]);
        $freeByte = disk_free_space($_SERVER["DOCUMENT_ROOT"]);

        $storageData['total'] = $this->storageExchange($totalByte);
        $storageData['free'] = $this->storageExchange($freeByte);
        $storageData['use'] = $this->storageExchange($totalByte - $freeByte);
        $storageData['percentFree'] = round(($freeByte / $totalByte * 100), 2) . "%";
        $storageData['percentUse'] = 100 - round(($freeByte / $totalByte * 100), 2) . "%";

        return view('Admin.dashboard.index', compact('storageData'));
    }

    public function getUserData()
    {
        $data = [100, 233];

        return response()->json($data);
    }

    private function storageExchange($bytes)
    {
        $prefix = array('B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB');
        $base = 1024;
        $class = min((int)log($bytes, $base), count($prefix) - 1);

        return sprintf('%1.2f', $bytes / pow($base, $class)) . ' ' . $prefix[$class];
    }
}
