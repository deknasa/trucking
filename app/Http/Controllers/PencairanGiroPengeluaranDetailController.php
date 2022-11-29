<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PencairanGiroPengeluaranDetailController extends Controller
{
    public $title = 'Pencairan Giro Pengeluaran Detail';

    public function index(Request $request)
    {
        $params = [
            'pengeluaran_id' => $request->pengeluaran_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pencairangiropengeluarandetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}


