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


class LaporanArusKasController extends MyController
{
    public $title = 'Laporan Arus Kas / Bank';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Arus Kas / Bank',
        ];
        return view('laporanaruskas.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'periode' => $request->periode,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanaruskas/report', $detailParams);
          
        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanaruskas', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {

    }
}
