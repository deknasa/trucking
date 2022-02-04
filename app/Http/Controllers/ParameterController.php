<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ParameterController extends Controller
{
    public $title = 'Parameter';
    public $httpHeader = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            parent::__construct();
            
            return $next($request);
        });
    }
    
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
                ->get(config('app.api_url') . 'parameter', $params);

            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? [],
            ];

            return response($data);
        }

        $title = $this->title;

        return view('parameter.index', compact('title'));
    }

    public function create()
    {
        $title = $this->title;

        return view('parameter.add', compact('title'));
    }

    public function store(Request $request)
    {
        $request['modifiedby']=Auth::user()->name;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(config('app.api_url') . 'parameter', $request->all());

        return response($response);
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get(config('app.api_url') . "parameter/$id");

        $parameter = $response['data'];

        return view('parameter.edit', compact('title', 'parameter'));
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby']=Auth::user()->name;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch(config('app.api_url') . "parameter/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->get(config('app.api_url') . "parameter/$id");

            $parameter = $response['data'];

            return view('parameter.delete', compact('title', 'parameter'));
        } catch (\Throwable $th) {
            return redirect()->route('parameter.index');
        }
    }

    public function destroy($id)
    {
        $request['modifiedby']=Auth::user()->name;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->delete(config('app.api_url') . "parameter/$id");

        return response($response);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeader)->get(config('app.api_url') . 'parameter/field_length');

        return response($response['data']);
    }
}
