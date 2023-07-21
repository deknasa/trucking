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


class LaporanKartuHutangPrediksiController extends MyController
{
    public $title = 'Laporan Kartu Hutang Prediksi (EBS)';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Kartu Hutang Prediksi (EBS)',
        ];

        return view('laporankartuhutangprediksi.index', compact('title'));
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
            ->get(config('app.api_url') . 'laporankartuhutangprediksi/report', $detailParams);


            if ($header->successful()) {
                $data = $header['data'];
                $user = Auth::user();
                return view('reports.laporankartuhutangprediksi', compact('data', 'user', 'detailParams'));
            } else {
                return response()->json($header->json(), $header->status());
            }

    }

}
