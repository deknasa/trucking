<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TradoTambahanAbsensiController extends MyController
{
    public $title = 'Trado Tambahan Absensi';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combo' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
        ];

        return view('tradotambahanabsensi.index', compact('title', 'data'));
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
