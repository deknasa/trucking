<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public $title = 'Role';
    public $httpHeader = [
        // 'Accept' => 'application/json',
        // 'Content-Type' => 'application/json'
    ];

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {

        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Role'
        ];

        return view('role.index', compact('title', 'data'));
    }

    public function get($params = []): array
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
        ];

        // dd($params);

        // $response = Http::get('http://localhost/trucking-laravel/public/role', $params);
        $response = Http::withHeaders(request()->header())
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'role', $params);



        $data = [
            'total' => $response['attributes']['totalPages'],
            'records' => $response['attributes']['totalRows'],
            'rows' => $response['data']
        ];


        return $data;
    }


    /**
     * Fungsi create
     * @ClassName create
     */
    public function create()
    {
        $title = $this->title;


        return view('role.add', compact('title'));
    }

    public function store(Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->post(config('app.api_url') . 'role', $request->all());

        return response($response);
    }

    /**
     * Fungsi edit
     * @ClassName edit
     */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "role/$id");

        $role = $response['data'];
        return view('role.edit', compact('title', 'role'));
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "role/$id", $request->all());

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
            ])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "role/$id");

            $role = $response['data'];


            return view('role.delete', compact('title', 'role'));
        } catch (\Throwable $th) {
            return redirect()->route('role.index');
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
            ->delete(config('app.api_url') . "role/$id", $request->all());

        return response($response);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeader)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'role/field_length');

        return response($response['data']);
    }

    public function getroleid(Request $request)
    {

        $status = [
            'rolename' => $request['rolename'],
        ];
        $response = Http::withHeaders($this->httpHeader)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'role/getroleid', $status);

        // dd($response['data']);
        return $response['data'];
    }
}
