<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PenerimaanStokDetailController extends MyController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'penerimaanstokheader_id' => $request->penerimaanstokheader_id,
            'whereIn' => $request->whereIn,
            'offset' => $request->rows ?? (($request->page - 1) * $request->limit),
            'page' =>$request->page, 
            'limit' =>  $request->limit ?? 0,
        ];

         $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'penerimaanstokdetail', $params);
        
            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? [],
            ];
        

        return response($data);
    }

    
    public function jurnalGrid()
    {
        return view('jurnalumum._jurnal');
    }
    public function hutangGrid()
    {
        return view('penerimaanstokheader._hutang');
    }
    public function detailGrid()
    {
        return view('penerimaanstokheader._detail');
    }
}
