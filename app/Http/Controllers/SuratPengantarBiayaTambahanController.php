<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SuratPengantarBiayaTambahanController extends MyController
{
    public $title = 'Surat Pengantar Biaya Tambahan';

    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combolongtrip' => $this->comboList('list', 'STATUS LONGTRIP', 'STATUS LONGTRIP'),
            'comboeditsp' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combotitipan' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'comboperalihan' => $this->comboList('list', 'STATUS PERALIHAN', 'STATUS PERALIHAN'),
            'comboritasiomset' => $this->comboList('list', 'STATUS RITASI OMSET', 'STATUS RITASI OMSET'),
            'combogudangsama' => $this->comboList('list', 'STATUS GUDANG SAMA', 'STATUS GUDANG SAMA'),
            'combobatalmuat' => $this->comboList('list', 'STATUS BATAL MUAT', 'STATUS BATAL MUAT'),
            'combogajisupir' => $this->comboList('list', 'STATUS SUDAH BUKA', 'STATUS SUDAH BUKA'),
            'comboinvoice' => $this->comboList('list', 'STATUS SUDAH BUKA', 'STATUS SUDAH BUKA'),
        ];

        $data = array_merge(
            compact('title', 'data'),
            ["request" => $request->all()]
        );
        return view('biayatambahan.index', $data);
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
