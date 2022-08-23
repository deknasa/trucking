<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PengeluaranDetailController extends Controller
{
    public $title = 'Pengeluaran Detail';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $params = [
            'pengeluaran_id' => $request->pengeluaran_id,
            'whereIn' => $request->whereIn
        ];
        $response = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->get(config('app.api_url') .'pengeluarandetail', $params);
        
        //  dd($response->getBody()->getContents());
        $data = [
            'rows' => $response['data'] ?? []
        ];
        return response($data);
    }
}
