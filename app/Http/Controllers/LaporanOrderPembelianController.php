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

class LaporanOrderPembelianController extends MyController
{
    public $title = 'Laporan Order Pembelian';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Order Pembelian',
        ];

        return view('laporanorderpembelian.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai,
            'dari' => $request->dari,
            'supplierdari' => $request->supplierdari,
            'suppliersampai' => $request->suppliersampai,
            'supplierdari_id' => $request->supplierdari_id,
            'suppliersampai_id' => $request->suppliersampai_id,
            'text_id' => $request -> text_id,
            'text' => $request -> text
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanorderpembelian/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanorderpembelian', compact('data', 'user', 'detailParams'));
    }
}
