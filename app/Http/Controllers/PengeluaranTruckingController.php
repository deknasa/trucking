<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PengeluaranTruckingController extends MyController
{
    public $title = 'Pengeluaran Trucking';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;

        return view('pengeluaran_trucking.index', compact('title'));
    }
    
    /**
     * @ClassName
     */
    public function create()
    {
        $title = $this->title;

        return view('pengeluaran_trucking.add', compact('title'));
    }

    /**
     * @ClassName
     */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "pengeluaran_trucking/$id");

        $pengeluaranTrucking = $response['data'];

        return view('pengeluaran_trucking.edit', compact('title', 'pengeluaranTrucking'));
    }

    /**
     * @ClassName
     */
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "pengeluaran_trucking/$id");

            $pengeluaranTrucking = $response['data'];

            return view('pengeluaran_trucking.delete', compact('title', 'pengeluaranTrucking'));
        } catch (\Throwable $th) {
            return redirect()->route('pengeluaran_trucking.index');
        }
    }
    
    /**
     * @ClassName
     */
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pengeluaran_trucking', $request->all());

        $pengeluaranTruckings = $response['data'];

        return view('reports.pengeluaran_trucking', compact('pengeluaranTr$pengeluaranTruckings'));
    }
}
