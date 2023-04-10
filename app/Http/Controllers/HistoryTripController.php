<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HistoryTripController extends MyController
{
    public $title = 'History Trip';
     /**
     * @ClassName 
     */
    public function index()
    {
        $title = $this->title;
        $data = [
            'combolongtrip' => $this->comboList('list','STATUS LONGTRIP','STATUS LONGTRIP'),
        ];
        return view('historytrip.index', compact('title','data'));
    }    
    public function comboList($aksi, $grp, $subgrp)
    {

        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/combolist', $status);

        return $response['data'];
    }
}
