<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class LaporanNeracaController extends MyController
{
    public $title = 'Laporan Neraca';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Neraca',
        ];

        return view('laporanneraca.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanneraca/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanneraca', compact('data', 'user', 'detailParams'));
    }
}
