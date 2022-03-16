<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    public $title = 'Bank';
    public $access_token = 'tes';
    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         parent::__construct();

    //         return $next($request);
    //     });
    // }

    public function index(Request $request)
    {
        $title = $this->title;
        $breadcrumb = $this->breadcrumb;

        return view('bank.index', compact('title', 'breadcrumb'));
    }

    public function get($params = [])
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
        ];

        $response = Http::withHeaders(request()->header())
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'bank', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $params ?? [],
            'message' => $response['message'] ?? ''
        ];

        if (request()->ajax()) {
            return response($data, $response->status());
        }
        
        return $data;
    }

    public function create()
    {
        $title = $this->title;
        $breadcrumb = $this->breadcrumb;
        $combo = $this->combo();

        return view('bank.add', compact('title', 'breadcrumb','combo'));
    }

    public function store(Request $request): Response
    {
        try {
            $request['modifiedby'] = Auth::user()->name;
            
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'bank', $request->all());
    
            return response($response, $response->status());
        } catch (\Throwable $th) {
            dd($th->getMessage());
            throw $th->getMessage();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "bank/$id");

        $bank = $response['data'];
        $combo = $this->combo();

        return view('bank.edit', compact('title', 'bank','combo'));
    }

    public function update(Request $request, $id): Response
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "bank/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "bank/$id");

            $bank = $response['data'];
            $combo = $this->combo();

            return view('bank.delete', compact('title', 'bank','combo'));
        } catch (\Throwable $th) {
            return redirect()->route('bank.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "bank/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'bank/field_length');

        return response($response['data']);
    }

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->get(config('app.api_url') . 'bank/combo');
        
        return $response['data'];
    }
}
