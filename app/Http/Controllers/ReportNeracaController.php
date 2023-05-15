<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ReportNeracaController extends MyController
{
    public $title = 'Report';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Report Neraca'
        ];

        return view('reportneraca.index', compact('title','data'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'tgldr' => $request->tgldr,
            'tglsd' => $request->tglsd,
            'coadr' => $request->coadr,
            'coasd' => $request->coasd,
        ];

        $report = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get('http://localhost/trucking-laravel/public/api/reportneraca/report', $detailParams);
           

        $reports = $report['data']['original']['data'];
        $user = $report['data']['original']['user'];
        return view('reports.reportneraca', compact('reports','user'));

    }
}
