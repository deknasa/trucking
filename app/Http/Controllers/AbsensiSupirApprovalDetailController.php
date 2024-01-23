<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsensiSupirApprovalDetailController extends MyController
{
    public $title = 'Absensi Supir Approval';

    public function index(Request $request)
    {
        $params = [
            'absensisupirapproval_id' => $request->absensisupirapproval_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'hutangbayardetail', $params);

        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
    public function jurnalGrid()
    {
        return view('jurnalumum._jurnal');
    }
    public function pengeluaranGrid()
    {
        return view('pengeluaran._pengeluaran');
    }
    public function detailGrid()
    {
        return view('absensisupirapprovalheader._detail');
    }
}
