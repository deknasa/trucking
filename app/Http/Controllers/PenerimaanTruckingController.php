<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PenerimaanTruckingController extends MyController
{
    public $title = 'Penerimaan Trucking';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;

        return view('penerimaan_trucking.index', compact('title'));
    }
    
    /**
     * @ClassName
     */
    public function create()
    {
        $title = $this->title;

        return view('penerimaan_trucking.add', compact('title'));
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
            ->get(config('app.api_url') . "penerimaan_trucking/$id");

        $penerimaanTrucking = $response['data'];

        return view('penerimaan_trucking.edit', compact('title', 'penerimaanTrucking'));
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
                ->get(config('app.api_url') . "penerimaan_trucking/$id");

            $penerimaanTrucking = $response['data'];

            return view('penerimaan_trucking.delete', compact('title', 'penerimaanTrucking'));
        } catch (\Throwable $th) {
            return redirect()->route('penerimaan_trucking.index');
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
            ->get(config('app.api_url') . 'penerimaan_trucking', $request->all());

        $penerimaanTruckings = $response['data'];

        return view('reports.penerimaan_trucking', compact('penerimaanTr$penerimaanTruckings'));
    }
}
