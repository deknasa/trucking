<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KasGantungDetailController extends MyController
{
    public $title = 'Kas Gantung Detail';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $params = [
            'kasgantung_id' => $request->kasgantung_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'kasgantung_detail', $params);
            
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
        return view('kasgantung._detail');
    }
}
