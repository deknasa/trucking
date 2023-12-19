<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OtobonController extends MyController
{
    public $title = 'Otobon';
    public function index(Request $request)
    {
        $title = $this->title;
        return view('otobon.index', compact('title'));
    }

    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'otobon', $request->all());

        $otobons = $response['data'];

        return view('reports.otobon', compact('otobons'));
    }
    public function export()
    {

    }
}
