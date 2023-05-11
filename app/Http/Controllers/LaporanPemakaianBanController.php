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


class LaporanPemakaianBanController extends MyController
{
    public $title = 'Laporan Pemakaian Ban';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Pemakaian Ban',
        ];

        return view('laporanpemakaianban.index', compact('title'));
    }

    public function report(Request $request)
    {
        if ($request->posisiakhirtrado != null) {

            $parameter = $request->posisiakhirtrado;
        }else{
            $parameter = $request->posisiakhirgandengan;
        }
      
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'posisiakhir' => $parameter,
            'jenislaporan' =>$request->jenislaporan
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpemakaianban/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanpemakaianban', compact('data', 'user', 'detailParams'));
    }

}
