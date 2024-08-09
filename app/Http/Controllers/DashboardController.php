<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Providers\AuthServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DashboardController extends MyController
{
    public function index()
    {
        // $test = Menu::leftJoin('acos', 'menu.aco_id', '=', 'acos.id')
        //     ->where('acos.class', (new Controller)->class)
        //     ->first();
        // dd($test);
        $title = 'Dashboard';
        $data = $this->getData();
        $reminder = $this->remainderFinalAbsensi();
        return view('welcome', compact('title', 'data','reminder'));
    }

    public function getData()
    {
        $aktif = DB::table("parameter")->from(DB::raw("parameter with (readuncommitted)"))->where('grp', 'STATUS AKTIF')->where("text", 'AKTIF')->first();
        $nonAktif = DB::table("parameter")->from(DB::raw("parameter with (readuncommitted)"))->where('grp', 'STATUS AKTIF')->where("text", 'NON AKTIF')->first();

        $tradoAktif = DB::table("trado")->from(DB::raw("trado with (readuncommitted)"))->where('statusaktif', $aktif->id)->count();
        $tradoNonAktif = DB::table("trado")->from(DB::raw("trado with (readuncommitted)"))->where('statusaktif', $nonAktif->id)->count();
        $supirAktif = DB::table("supir")->from(DB::raw("supir with (readuncommitted)"))->where('statusaktif', $aktif->id)->count();
        $supirNonAktif = DB::table("supir")->from(DB::raw("supir with (readuncommitted)"))->where('statusaktif', $nonAktif->id)->count();
        $error = DB::table("error")->from(DB::raw("error with (readuncommitted)"))->where('kodeerror', 'PSB')->first();

        $data = [
            'tradoaktif' => $tradoAktif,
            'tradononaktif' => $tradoNonAktif,
            'supiraktif' => $supirAktif,
            'supirnonaktif' => $supirNonAktif,
            'error' => $error->keterangan,
        ];
        return $data;
    }

    public function remainderFinalAbsensi()
    {
        $user_id =  auth()->user()->id;
        $isUserPusat = auth()->user()->isUserPusat();

        $show = 0;
        $data = '';
        if ($isUserPusat) {
            $show = 1;
            $tigaHariSebelum = date('Y-m-d', strtotime('-3 days'));
            $statusApproval = DB::table("parameter")->from(DB::raw("parameter with (readuncommitted)"))
                ->where('grp', '=', 'STATUS APPROVAL')->where('text', '=', 'APPROVAL')->first();

            $absensisupirheader = DB::table('absensisupirheader')->from(DB::raw("absensisupirheader with (readuncommitted)"))
                ->select(DB::raw("isnull(STRING_AGG(format(tglbukti,'dd-MM-yyyy'), ', '),'') as tglbukti"))
                ->where('tglbukti', '<', $tigaHariSebelum)
                ->whereRaw("isNull(statusapprovalfinalabsensi,0) <> " . $statusApproval->id)
                ->first();
            $data = $absensisupirheader->tglbukti;
            if ($data == '') {
                $show = 0;
            }
        }
        $data = [
            'data' => $data,
            'show' => $show,
        ];

        return $data;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
