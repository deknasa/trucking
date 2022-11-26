<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ReportAllController extends MyController
{
    public $title = 'Report';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Report'
        ];

        return view('reportall.index', compact('title','data'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'tanggal' => $request->tgl,
            'data' => $request->data
        ];
  
        $report = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get('http://localhost/trucking-laravel/public/api/reportall/report', $detailParams);
           

        $reports = $report['data']['original']['data'];
        $user = $report['data']['original']['user'];
        return view('reports.reportall', compact('reports','user'));

    }
}