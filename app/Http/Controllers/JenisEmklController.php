<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class JenisEmklController extends MyController
{
    public $title = 'JENISEMKL';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;

        return view('jenisemkl.index', compact('title'));
    }

    /**
     * @ClassName
     */
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
            ->get(config('app.api_url') . 'jenisemkl', $params);

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

    /**
     * @ClassName
     */
    public function create(): View
    {
        $title = $this->title;

        return view('jenisemkl.add', compact('title'));
    }

    /**
     * @ClassName
     */
    public function store(Request $request): Response
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'jenisemkl', $request->all());

            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    /**
     * @ClassName
     */
    public function edit($id): View
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "jenisemkl/$id");

        $jenisemkl = $response['data'];

        return view('jenisemkl.edit', compact('title', 'jenisemkl'));
    }

    /**
     * @ClassName
     */
    public function update(Request $request, $id): Response
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "jenisemkl/$id", $request->all());

        return response($response);
    }

    /**
     * @ClassName
     */
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "jenisemkl/$id");

            $jenisemkl = $response['data'];

            return view('jenisemkl.delete', compact('title', 'jenisemkl'));
        } catch (\Throwable $th) {
            return redirect()->route('jenisemkl.index');
        }
    }

    /**
     * @ClassName
     */
    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "jenisemkl/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'jenisemkl/field_length');

        return response($response['data']);
    }

}
