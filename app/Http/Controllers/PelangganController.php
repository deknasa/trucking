<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PelangganController extends MyController
{
    public $title = 'Pelanggan';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;

        return view('pelanggan.index', compact('title'));
    }
    
    /**
     * @ClassName
     */
    public function create()
    {
        $title = $this->title;

        return view('pelanggan.add', compact('title'));
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
            ->get(config('app.api_url') . "pelanggan/$id");

        $pelanggan = $response['data'];

        return view('pelanggan.edit', compact('title', 'pelanggan'));
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
                ->get(config('app.api_url') . "pelanggan/$id");

            $pelanggan = $response['data'];

            return view('pelanggan.delete', compact('title', 'pelanggan'));
        } catch (\Throwable $th) {
            return redirect()->route('pelanggan.index');
        }
    }
}
