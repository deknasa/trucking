<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "statuscontainer/$id");

        $statusContainer = $response['data'];
        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
        ];

        return view('statuscontainer.edit', compact('title', 'statusContainer', 'combo'));
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
                ->get(config('app.api_url') . "statuscontainer/$id");

            $statusContainer = $response['data'];
            $combo = [
                'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            ];

            return view('statuscontainer.delete', compact('title', 'statusContainer', 'combo'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    /**
     * @ClassName
     */
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'statuscontainer', $request->all());

        $statusContainers = $response['data'];

        return view('reports.statuscontainer', compact('statusContainers'));
    }
}
