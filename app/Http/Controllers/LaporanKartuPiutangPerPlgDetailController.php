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

class LaporanKartuPiutangPerPlgDetailController extends MyController
{
    public $title = 'Laporan Kartu Piutang Per Pelanggan Detail';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Kartu Piutang Per Pelanggan Detail',
        ];

        return view('laporankartupiutangperplgdetail.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai,
            'dari' => $request->dari,
            'pelanggandari' => $request->pelanggandari,
            'pelanggansampai' => $request->pelanggansampai,
            'pelanggandari_id' => $request->pelanggandari_id,
            'pelanggansampai_id' => $request->pelanggansampai_id,
            'text_id' => $request -> text_id,
            'text' => $request -> text
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankartupiutangperplgdetail/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporankartupiutangperplgdetail', compact('data', 'user', 'detailParams'));
    }
}
