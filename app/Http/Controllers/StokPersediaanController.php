<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StokPersediaanController extends MyController
{
    public $title = 'Stok Persediaan';
    
    public function index(Request $request)
    {
        $title = $this->title;
        return view('stokpersediaan.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'filter' => $request->filter,
            'datafilter' => $request->datafilter,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'stokpersediaan/report', $detailParams);

        $data = $header['data'];
        $dataHeader = $header['dataheader'];

        return view('reports.stokpersediaan', compact('data','dataHeader'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'filter' => $request->filter,
            'datafilter' => $request->datafilter,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'stokpersediaan/export', $detailParams);

        $data = $header['data'];
        $dataHeader = $header['dataheader'];
    }
}
?>