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


class LapKartuHutangPerVendorDetailController extends MyController
{
    public $title = 'Laporan Kartu Hutang Per Vendor Detail';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Kartu Hutang Per Vendor Detail',
        ];

        return view('laporanhutangpervendordetail.index', compact('title'));
    }

    public function report(Request $request)
    {
      
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'supplierdari' => $request->supplierdari,
            'suppliersampai' => $request->suppliersampai,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'lapkartuhutangpervendordetail/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanhutangpervendordetail', compact('data', 'user', 'detailParams'));
    }

}
