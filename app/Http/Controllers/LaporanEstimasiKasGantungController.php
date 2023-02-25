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


class LaporanEstimasiKasGantungController extends MyController
{
    public $title = 'Laporan Estimasi Kas Gantung';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Estimasi Kas Gantung',
        ];

        return view('laporanestimasikasgantung.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai,
            'jenis' => $request->jenis,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanestimasikasgantung/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanestimasikasgantung', compact('data', 'user', 'detailParams'));
    }

}
