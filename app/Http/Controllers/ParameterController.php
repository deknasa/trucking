<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    /**
     * Fungsi index
     * @ClassName index
     */     
    public function index(Request $request)
    {
        $title = $this->title;

        return view('parameter.index', compact('title'));
    }

    public function get(Request $request): Array
    {
        $params = [
            'offset' => $request->offset ?? (($request->page - 1) * $request->rows),
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
            'params' => $params
        ];

        return $data;
    }

    /**
     * Fungsi create
     * @ClassName create
     */     
    public function create(): View
    {
        $title = $this->title;

        return view('parameter.add', compact('title'));
    }

    public function store(Request $request): Response
    {
        $request['modifiedby']=Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(config('app.api_url') . 'parameter', $request->all());

        return response($response);
    }

    /**
     * Fungsi edit
     * @ClassName edit
     */     
    public function edit($id): View
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get(config('app.api_url') . "parameter/$id");

        $parameter = $response['data'];

        return view('parameter.edit', compact('title', 'parameter'));
    }

    public function update(Request $request, $id): Response
    {
        $request['modifiedby']=Auth::user()->name;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch(config('app.api_url') . "parameter/$id", $request->all());

        return response($response);
    }

    /**
     * Fungsi delete
     * @ClassName delete
     */     
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

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->delete(config('app.api_url') . "parameter/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeader)->get(config('app.api_url') . 'parameter/field_length');

        return response($response['data']);
    }

    public function report(Request $request): View
    {
        $request->offset = $request->dari - 1;
        $request->rows = $request->sampai + 1;

        $parameters = $this->get($request)['rows'];

        return view('reports.parameter', compact('parameters'));
    }
}