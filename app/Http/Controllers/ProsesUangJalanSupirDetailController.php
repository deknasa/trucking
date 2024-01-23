<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ProsesUangJalanSupirDetailController extends MyController
{
    public $title = 'Proses Uang Jalan Supir';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $params = [
            'prosesuangjalansupir_id' => $request->prosesuangjalansupir_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') .'prosesuangjalansupirdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
    public function transferGrid()
    {
        return view('prosesuangjalansupir._transfer');
    }
    public function detailGrid()
    {
        return view('prosesuangjalansupir._detail');
    }
}
