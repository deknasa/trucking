<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PenerimaanDetailController extends Controller
{
    public $title = 'Penerimaan Detail';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $params = [
            'penerimaan_id' => $request->penerimaan_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') .'penerimaandetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}
