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
            'whereIn' => $request->whereIn,
            'offset' => $request->rows ?? (($request->page - 1) * $request->limit),
            'page' =>$request->page, 
            'limit' =>  $request->limit ?? 0,
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pengeluarantruckingdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? [],
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
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
        return view('pengeluarantruckingheader._detail');
    }
}


