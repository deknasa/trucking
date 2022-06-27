<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SupplierController extends MyController
{
    public $title = 'Supplier';

    public function index(Request $request)
    {
        $title = $this->title;

        return view('supplier.index', compact('title'));
    }

    public function create()
    {
        $title = $this->title;

        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
        ];

        return view('supplier.add', compact('title', 'combo'));
    }


    public function edit($id)
    {
        $title = $this->title;

        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "supplier/$id");


        $supplier = $response['data'];

        return view('supplier.edit', compact('title', 'supplier'));
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "supplier/$id");

            $supplier = $response['data'];

            return view('supplier.delete', compact('title', 'supplier'));
        } catch (\Throwable $th) {
            return redirect()->route('supplier.index');
        }
    }
}
