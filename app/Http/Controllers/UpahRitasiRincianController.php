<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UpahRitasiRincianController extends MyController
{
    public $title = 'Upah Ritasi Rincian';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $params = [
            'upahritasi_id' => $request->upahritasi_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') .'upahritasirincian', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}
