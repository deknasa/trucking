<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ParameterController extends Controller
{
    public $title = 'Parameter';

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $params = [
                'offset' => (($request->page - 1) * $request->rows),
                'limit' => $request->rows,
                'sortIndex' => $request->sidx,
                'sortOrder' => $request->sord,
                'search' => json_decode($request->filters, 1) ?? [],
            ];

            $response = Http::withHeaders($request->header())
                ->get('http://localhost/trucking-laravel/public/api/parameter', $params);

            $data = [
                'total' => $response['attributes']['totalPages'],
                'records' => $response['attributes']['totalRows'],
                'rows' => $response['data']
            ];

            return response($data);
        }

        $title = 'Parameter';

        return view('parameter.index', compact('title'));
    }

    public function create()
    {
        $title = $this->title;

        return view('parameter.add', compact('title'));
    }

    public function store(Request $request)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('http://localhost/trucking-laravel/public/api/parameter', $request->all());

        return response($response);
    }

    public function edit($id) {
        $title = $this->title;
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get("http://localhost/trucking-laravel/public/api/parameter/$id");
        
        $parameter = $response['data'];

        return view('parameter.edit', compact('title', 'parameter'));
    }

    public function update(Request $request, $id) {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->patch("http://localhost/trucking-laravel/public/api/parameter/$id", $request->all());

        return response($response);
    }

    public function delete($id) {
        try {
            $title = $this->title;
            
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->get("http://localhost/trucking-laravel/public/api/parameter/$id");
            
            $parameter = $response['data'];
    
            return view('parameter.delete', compact('title', 'parameter'));
        } catch (\Throwable $th) {
            return redirect()->route('parameter.index');
        }
    }

    public function destroy($id) {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->delete("http://localhost/trucking-laravel/public/api/parameter/$id");

        return response($response);
    }
}
