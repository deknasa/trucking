<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LaporanSupplierBandingStokController extends Controller
{
    public $title = 'Laporan Supplier Banding Stok';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Supplier Banding Stok',
        ];

        return view('laporansupplierbandingstok.index', compact('title'));
    }

    public function report(Request $request)
    {

        $detailParams = [
            'supplier_id' => $request->supplier_id,
            'supplier' => $request->supplier,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporansupplierbandingstok/report', $detailParams);

        $user = Auth::user();
        $data = $header['data'];
        $dataCabang['namacabang'] = $header['namacabang'];
        $detailParams['judul'] = $header['judul'];
        $detailParams['header'] = "Laporan Supplier Banding Stok";

        return view('reports.laporansupplierbandingstok', compact('data','dataCabang', 'user', 'detailParams'));
    }

}
