<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class GajiSupirDetailController extends Controller
{
    public $title = 'Gaji Supir Detail';

    public function index(Request $request)
    {
        
        $params = [
            'gajisupir_id' => $request->gajisupir_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'gajisupirdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
    
    public function jurnalGrid()
    {
        return view('gajisupirheader._jurnal');
    }
    public function potsemuaGrid()
    {
        return view('gajisupirheader._potsemua');
    }
    public function potpribadiGrid()
    {
        return view('gajisupirheader._potpribadi');
    }
    public function depositoGrid()
    {
        return view('gajisupirheader._deposito');
    }
    public function absensiGrid()
    {
        return view('gajisupirheader._absensi');
    }
    public function detailGrid()
    {
        return view('gajisupirheader._detail');
    }
}


