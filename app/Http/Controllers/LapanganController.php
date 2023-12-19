<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LapanganController extends MyController
{
    public $title = 'Lapangan';
    public function index(Request $request)
    {
        $title = $this->title;
        return view('lapangan.index', compact('title'));
    }
    
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'lapangan', $request->all());

        $lapangans = $response['data'];

        return view('reports.lapangan', compact('lapangans'));
    }
}
