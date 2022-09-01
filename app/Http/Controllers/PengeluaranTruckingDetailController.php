<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PengeluaranTruckingDetailController extends Controller
{
    public $title = 'Pengeluaran Trucking Detail';

    public function index(Request $request)
    {
        $params = [
            'pengeluarantruckingheader_id' => $request->pengeluarantruckingheader_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pengeluarantruckingdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}


