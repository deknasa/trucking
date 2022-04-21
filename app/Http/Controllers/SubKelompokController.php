<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SubKelompokController extends MyController
{
    public $title = 'Sub Kelompok';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;

        return view('sub_kelompok.index', compact('title'));
    }
    
    /**
     * @ClassName
     */
    public function create()
    {
        $title = $this->title;
        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
        ];

        return view('sub_kelompok.add', compact('title', 'combo'));
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
            ->get(config('app.api_url') . "sub_kelompok/$id");

        $subKelompok = $response['data'];
        
        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
        ];

        return view('sub_kelompok.edit', compact('title', 'subKelompok', 'combo'));
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
                ->get(config('app.api_url') . "sub_kelompok/$id");

            $subKelompok = $response['data'];
            
            $combo = [
                'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            ];

            return view('sub_kelompok.delete', compact('title', 'subKelompok', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('sub_kelompok.index');
        }
    }
}
