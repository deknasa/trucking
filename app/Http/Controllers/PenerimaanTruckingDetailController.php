<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PenerimaanTruckingDetailController extends Controller
{
    public $title = 'Penerimaan Trucking Detail';

    public function index(Request $request)
    {
        $params = [
            'penerimaantruckingheader_id' => $request->penerimaantruckingheader_id,
            'whereIn' => $request->whereIn,
            'offset' => $request->rows ?? (($request->page - 1) * $request->limit),
            'page' =>$request->page, 
            'limit' =>  $request->limit ?? 0,
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'penerimaantruckingdetail', $params);
            
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
    public function penerimaanGrid()
    {
        return view('penerimaan._penerimaan');
    }
    public function detailGrid()
    {
        return view('penerimaantruckingheader._detail');
    }
}


