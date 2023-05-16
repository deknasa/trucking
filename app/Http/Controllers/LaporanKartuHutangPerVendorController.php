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

class LaporanKartuHutangPerVendorController extends MyController
{
    public $title = 'Laporan Kartu Hutang Per Vendor';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Kartu Hutang Per Vendor',
        ];

        return view('laporankartuhutangpervendor.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'suppdari_id' => $request->suppdari_id,
            'suppsampai_id' => $request->suppsampai_id,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankartuhutangpervendor/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporankartuhutangpervendor', compact('data', 'user', 'detailParams'));
    }
}
