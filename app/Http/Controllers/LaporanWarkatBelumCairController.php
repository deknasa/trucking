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


class LaporanWarkatBelumCairController extends MyController
{
    public $title = 'Laporan Warkat Belum Cair';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Warkat Belum Cair',
        ];

        return view('laporanwarkatbelumcair.index', compact('title'));
    }

    public function report(Request $request)
    {
      
        $detailParams = [
            'periode' => $request->periode,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanwarkatbelumcair/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanwarkatbelumcair', compact('data', 'user', 'detailParams'));
    }

}
