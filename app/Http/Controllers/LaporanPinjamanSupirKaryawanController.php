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


class LaporanPinjamanSupirKaryawanController extends MyController
{
    public $title = 'Laporan Pinjaman Supir/Karyawan';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Pinjaman Supir/Karyawan',
        ];

        return view('laporanpinjamansupirkaryawan.index', compact('title'));
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
            ->get(config('app.api_url') . 'laporanpinjamansupirkaryawan/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanpinjamansupirkaryawan', compact('data', 'user', 'detailParams'));
    }

}
