<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class RoleController extends MyController
{
    public $title = 'Role';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Role',
            'combostatus' => $this->comboList(),
        ];
        return view('role.index', compact('title', 'data'));
    }

    public function comboList()
    {

        $data = [
            [
                "id" => "0",
                "parameter" => "ALL",
                "param" => "",
            ], [
                "id" => "1",
                "parameter" => "AKTIF",
                "param" => "AKTIF",
            ], [
                "id" => "2",
                "parameter" => "TIDAK AKTIF",
                "param" => "TIDAK AKTIF",
            ]
        ];

        return $data;
    }

    public function aclGrid()
    {
        return view('role.acl._grid');
    }

    /**
     * @ClassName
     */
    public function create()
    {
        $title = $this->title;

        return view('role.add', compact('title'));
    }

    public function store(Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->post(config('app.api_url') . 'role', $request->all());

        return response($response, $response->status());
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
            ->get(config('app.api_url') . "role/$id");

        $role = $response['data'];

        return view('role.edit', compact('title', 'role'));
    }

    /**
     * @ClassName
     */
    public function delete($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "role/$id");

        $role = $response['data'];

        return view('role.delete', compact('title', 'role'));
    }

    /**
     * @ClassName
     */
    public function report(Request $request): View
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'role', $request->all());

        $roles = $response['data'];

        return view('reports.role', compact('roles'));
    }

    /**
     * @ClassName
     */
    public function export(Request $request): void
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
        ];

        $roles = $this->get($params)['rows'];

        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'ID',
                'index' => 'id',
            ],
            [
                'label' => 'Role Name',
                'index' => 'rolename',
            ],
        ];

        $this->toExcel($this->title, $roles, $columns);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'role/field_length');

        return response($response['data'], $response->status());
    }

    public function getroleid(Request $request)
    {

        $status = [
            'rolename' => $request['rolename'],
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'role/getroleid', $status);

        return $response['data'];
    }
}
