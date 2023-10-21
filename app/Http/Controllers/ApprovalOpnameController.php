<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApprovalOpnameController extends MyController
{
    public $title = 'Approval Opname';

    public function index(Request $request)
    {
        $title = $this->title;
        $status = $this->comboList('STATUS APPROVAL','STATUS APPROVAL');
        return view('approvalopname.index', compact('title', 'status'));
    }
    public function comboList($grp, $subgrp)
    {

        $status = [
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/combo', $status);

        return $response['data'];
    }
}
