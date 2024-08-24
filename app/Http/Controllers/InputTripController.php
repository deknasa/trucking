<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InputTripController extends MyController
{
    public $title = 'input Trip ( mandor )';

    /**
     * @ClassName
     */
    public function index()
    {
        $title = $this->title;

        $data = $this->getData();
        $jobmanual = DB::table("parameter")->from(DB::raw("parameter with (readuncommitted)"))
        ->where('grp','JOB TRUCKING MANUAL')->first()->text ?? 'TIDAK';
        return view('inputtrip.index', compact('title','data','jobmanual'));
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
