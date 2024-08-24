<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ListTripController extends MyController
{
    public $title = 'Data Trip ( mandor )';
     /**
     * @ClassName 
     */
    public function index()
    {
        $title = $this->title;
        
        $status = $this->getData();
        $jobmanual = DB::table("parameter")->from(DB::raw("parameter with (readuncommitted)"))
        ->where('grp','JOB TRUCKING MANUAL')->first()->text ?? 'TIDAK';
        $data = [
            'combolongtrip' => $this->comboList('list','STATUS LONGTRIP','STATUS LONGTRIP'),
            'combogudangsama' => $this->comboList('list', 'STATUS GUDANG SAMA', 'STATUS GUDANG SAMA')
        ];
        return view('listtrip.index', compact('title','data','status','jobmanual'));
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
    
    public function getData()
    {
        $dataJenisKendaraan = DB::table("parameter")->from(DB::raw("parameter with (readuncommitted)"))
            ->select('id', 'text')
            ->where('grp', 'STATUS JENIS KENDARAAN')
            ->get()->toArray();
        $dataLongtrip = DB::table("parameter")->from(DB::raw("parameter with (readuncommitted)"))
            ->select('id', 'text')
            ->where('grp', 'STATUS LONGTRIP')
            ->get()->toArray();
        $dataGudangSama = DB::table("parameter")->from(DB::raw("parameter with (readuncommitted)"))
            ->select('id', 'text')
            ->where('grp', 'STATUS GUDANG SAMA')
            ->get()->toArray();
        $dataLangsir = DB::table("parameter")->from(DB::raw("parameter with (readuncommitted)"))
            ->select('id', 'text')
            ->where('grp', 'STATUS LANGSIR')
            ->get()->toArray();
        $dataGandengan = DB::table("parameter")->from(DB::raw("parameter with (readuncommitted)"))
            ->select('id', 'text')
            ->where('grp', 'STATUS GANDENGAN')
            ->get()->toArray();
        $dataPenyesuaian = DB::table("parameter")->from(DB::raw("parameter with (readuncommitted)"))
            ->select('id', 'text')
            ->where('grp', 'STATUS PENYESUAIAN')
            ->get()->toArray();

        $data = [
            'jeniskendaraan' => $dataJenisKendaraan,
            'longtrip' => $dataLongtrip,
            'gudangsama' => $dataGudangSama,
            'langsir' => $dataLangsir,
            'gandengan' => $dataGandengan,
            'penyesuaian' => $dataPenyesuaian,
        ];

        return $data;
    }
}
