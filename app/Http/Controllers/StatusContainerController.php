<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;


class StatusContainerController extends MyController
{
    public $title = 'Status Container';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            'listbtn' => $this->getListBtn()
        ];
        return view('statuscontainer.index', compact('title', 'combo'));
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

        return view('statuscontainer.add', compact('title', 'combo'));
    }

    /**
     * @ClassName
     */
    public function edit($id)
    {
        $title = $this->title;
        $combo = $this->combo();

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "statuscontainer/$id");

        $statuscontainer = $response['data'];

        return view('statuscontainer.edit', compact('title', 'statuscontainer', 'combo'));
    }

    /**
     * @ClassName
     */
    public function delete($id)
    {
        try {
            $title = $this->title;
            $combo = $this->combo();

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "statuscontainer/$id");

            $statuscontainer = $response['data'];

            return view('statuscontainer.delete', compact('title', 'statuscontainer', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('statuscontainer.index');
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
        ])->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "statuscontainer/$id", $request->all());

        return response($response);
    }


    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'statuscontainer', $request->all());

        $statusContainers = $response['data'];

        $i = 0;
        foreach ($statusContainers as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];


            $statusContainers[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }


        return view('reports.statuscontainer', compact('statusContainers'));
    }
}
