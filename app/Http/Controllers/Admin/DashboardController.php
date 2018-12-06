<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

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
        $min = 1;
        $max = 999;

        $data = [$this->getRandNum($min, $max), $this->getRandNum($min, $max)];

        return response()->json($data);
    }

    public function getSiteData()
    {
        $min = 1000;
        $max = 9999;

        $data = [$this->getRandNum($min, $max), $this->getRandNum($min, $max)];

        return response()->json($data);
    }

    public function getConnectorData(Request $request)
    {
        $min = 1000;
        $max = 9999;

        $dates = [];
        $values = [];

        $chartOption = strtolower($request->input('chartOption'));

        switch($chartOption) {
            case 'year':
                $baseDate = Carbon::now()->subYear(5);
                for ($i = 1; $i <= 5; $i++) {
                    $dates[] = $baseDate->copy()->addYears($i)->format('Y');
                    $values[] = $this->getRandNum($min, $max);
                };
                break;

            case 'month':
                $baseDate = Carbon::now()->subMonth(7);
                for ($i = 1; $i <= 7; $i++) {
                    $dates[] = $baseDate->copy()->addMonths($i)->format('Y-m');
                    $values[] = $this->getRandNum($min, $max);
                };
                break;

            default:
                $baseDate = Carbon::now()->subDays(7);
                for ($i = 1; $i <= 7; $i++) {
                    $dates[] = $baseDate->copy()->addDays($i)->toDateString();
                    $values[] = $this->getRandNum($min, $max);
                };
                break;
        };

        $data = [
            "labels"=> $dates,
            "datas" => $values
        ];

        return response()->json($data);
    }

    private function getRandNum($min, $max)
    {
        return mt_rand($min, $max);
    }

    private function storageExchange($bytes)
    {
        $prefix = array('B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB');
        $base = 1024;
        $class = min((int)log($bytes, $base), count($prefix) - 1);

        return sprintf('%1.2f', $bytes / pow($base, $class)) . ' ' . $prefix[$class];
    }
}
