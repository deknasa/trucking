<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HutangDetailController extends Controller
{
    public $title = 'Hutang Detail';

    public function index(Request $request)
    {
        $params = [
            'hutang_id' => $request->hutang_id,
            'whereIn' => $request->whereIn,
            'offset' => $request->offset ?? (($request->page - 1) * $request->limit),
            'page' => $request->page, 
            'limit' =>  $request->limit ?? 0,
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'hutangdetail', $params);
            
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
    public function historyGrid()
    {
        return view('hutang._history');
    }
    public function detailGrid()
    {
        return view('hutang._details');
    }
}
