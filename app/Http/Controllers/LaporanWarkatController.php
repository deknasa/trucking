<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanWarkatController extends MyController
{
    public $title = 'Laporan Warkat';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Warkat',
        ];

        return view('laporanwarkat.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai,
            'dari' => $request->dari
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanwarkat/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanwarkat', compact('data', 'user', 'detailParams'));
    }
}
