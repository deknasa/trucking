<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class LaporanKartuStokController extends MyController
{
    public $title = 'Laporan Kartu Stok';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Kartu Stok',
        ];

        return view('laporankartustok.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai,
            'dari' => $request->dari,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankartustok/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporankartustok', compact('data', 'user', 'detailParams'));
    }
}
