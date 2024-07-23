<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TradoController extends MyController
{
    public $title = 'Trado';

    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    public function image()
    {
        return response()->download(public_path('image.jpg'));
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $params = [
                'offset' => (($request->page - 1) * $request->rows),
                'limit' => $request->rows,
                'sortIndex' => $request->sidx,
                'sortOrder' => $request->sord,
                'search' => json_decode($request->filters, 1) ?? [],
            ];
            
            $response = Http::withHeaders($request->header())->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . 'trado', $params);

            $rows = $response['data'];

            foreach($response['data'] as $key => $item) {
                $arrtrado   = json_decode($item['phototrado']);
                $arrstnk    = json_decode($item['photostnk']);
                $arrbpkb    = json_decode($item['photobpkb']);

                $imgtrado='';
                if (!empty($arrtrado)) {
                    $count = count($arrtrado);
                    if ($count > 0) {
                        $total = $count / 3;
                        $idx=2;
                        for ($i=0; $i < $total; $i++) {
                            if ($i>0){
                                $idx+=3;
                            }

                            $imgtrado .= "<img src='".config('app.api_url').'../uploads/trado/'.$arrtrado[$idx]."' class='mr-2'>";
                        }
                    }
                }

                $imgbpkb='';
                if (!empty($arrbpkb)) {
                    $count = count($arrbpkb);
                    if ($count > 0) {
                        $total = $count / 3;
                        $idx=2;
                        for ($i=0; $i < $total; $i++) {
                            if ($i>0){
                                $idx+=3;
                            }

                            $imgbpkb .= "<img src='".config('app.api_url').'../uploads/bpkb/'.$arrbpkb[$idx]."' class='mr-2'>";
                        }
                    }
                }

                $imgstnk='';
                if (!empty($arrstnk)) {
                    $count = count($arrstnk);
                    if ($count > 0) {
                        $total = $count / 3;
                        $idx=2;
                        for ($i=0; $i < $total; $i++) {
                            if ($i>0){
                                $idx+=3;
                            }

                            $imgstnk .= "<img src='".config('app.api_url').'../uploads/stnk/'.$arrstnk[$idx]."' class='mr-2'>";
                        }
                    }
                }

                $rows[$key]['phototrado']   = $imgtrado;
                $rows[$key]['photobpkb']    = $imgbpkb;
                $rows[$key]['photostnk']    = $imgstnk;
            }

            $data = [
                'total' => $response['attributes']['totalPages'],
                'records' => $response['attributes']['totalRows'],
                'rows' => $rows,
            ];

            return response($data);
        }

        $title = $this->title;
        $data = [
            'statusaktif' => $this->comboStatusAktif('list','STATUS AKTIF','STATUS AKTIF'),
            'statusstandarisasi' => $this->comboStatusAktif('list','STATUS STANDARISASI','STATUS STANDARISASI'),
            'statusjenisplat' => $this->comboStatusAktif('list','JENIS PLAT','JENIS PLAT'),
            'statusmutasi' => $this->comboStatusAktif('list','STATUS MUTASI','STATUS MUTASI'),
            'statusvalidasikendaraan' => $this->comboStatusAktif('list','STATUS VALIDASI KENDARAAN','STATUS VALIDASI KENDARAAN'),
            'statusmobilstoring' => $this->comboStatusAktif('list','STATUS MOBIL STORING','STATUS MOBIL STORING'),
            'statusappeditban' => $this->comboStatusAktif('list','STATUS APPROVAL EDIT BAN','STATUS APPROVAL EDIT BAN'),
            'statuslewatvalidasi' => $this->comboStatusAktif('list','STATUS LEWAT VALIDASI','STATUS LEWAT VALIDASI'),
            'statusabsensisupir' => $this->comboStatusAktif('list','STATUS ABSENSI SUPIR','STATUS ABSENSI SUPIR'),
            'statusapprovalhistorytradomilikmandor' => $this->comboStatusAktif('list','STATUS APPROVAL','STATUS APPROVAL'),
            'statusapprovalhistorytradomiliksupir' => $this->comboStatusAktif('list','STATUS APPROVAL','STATUS APPROVAL'),
            'listbtn' => $this->getListBtn(),
        ];

   
        return view('trado.index', compact('title','data'));
    }


    public function create()
    {
        $title = $this->title;
        $combo = $this->combo();
        
        return view('trado.add', compact('title','combo'));
    }

    public function store(Request $request)
    {
        // $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false]);

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
        ->post(config('app.api_url') . 'trado', $request->all());

        if ($response->ok()) {
            $id = $response['data']['id'];
            $res = Http::withToken(ENV('API_KEY'));
            if($request->files) {
                foreach ($request->files as $key=> $files) {
                    if ($request->hasFile($key)) {
                        foreach($files as $k => $file) {
                            $fileName = $file->getClientOriginalName();
                            $res = $res->attach($key.'[]', file_get_contents($file),$fileName);
                        }
                    }
                }
                $res = $res->post(config('app.api_url') . 'trado/upload_image/'.$id);
            }
            return response($res);
        } else {
            return response($response);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))->get(config('app.api_url') . "trado/$id");
        
        $trado = $response['data'];

        $combo = $this->combo();

        return view('trado.edit', compact('title', 'trado', 'combo'));
    }

    public function update(Request $request, $id)
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))->patch(config('app.api_url') . "trado/$id", $request->all());

        if ($response->ok()) {
            $id = $response['data']['id'];
            $res = Http::withToken(ENV('API_KEY'));
            if($request->files) {
                foreach ($request->files as $key=> $files) {
                    if ($request->hasFile($key)) {
                        foreach($files as $k => $file) {
                            $fileName = $file->getClientOriginalName();
                            $res = $res->attach($key.'[]', file_get_contents($file),$fileName);
                        }
                    }
                }
                $res = $res->post(config('app.api_url') . 'trado/upload_image/'.$id,[
                    'name' => 'g_all',
                    'contents' => $request['g_all']
                ]);
            }
            return response($res);
        } else {
            return response($response);
        }
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))
            ->get(config('app.api_url') . "trado/$id");

            $trado = $response['data'];

            $combo = $this->combo();

            return view('trado.delete', compact('title', 'trado', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('trado.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))
        ->delete(config('app.api_url') . "trado/$id", $request->all());

        return response($response);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))->get(config('app.api_url') . 'trado/field_length');

        return response($response['data']);
    }


    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'trado/combo');
        
        return $response['data'];
    }

    public function comboStatusAktif($aksi,$grp,$subgrp)
    {

        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }

    public function report(Request $request)
    {

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'trado', $request->all());

        $trados = $response['data'];

       

        $i = 0;
        foreach ($trados as $index => $params) {


            $statusaktif = $params['statusaktif'];
            $statusStandarisasi = $params['statusstandarisasi'];
            $statusJenisPlat = $params['statusjenisplat'];
            $statusMutasi = $params['statusmutasi'];
            $statusValidasiKendaraan = $params['statusvalidasikendaraan'];
            $statusMobilStoring= $params['statusmobilstoring'];
            $statusAppEditBan= $params['statusappeditban'];
            $statusLewatValidasi= $params['statuslewatvalidasi'];
            $statusAbsensiSupir= $params['statusabsensisupir'];
            $statusApprovalHistoryTradoMilikMandor= $params['statusapprovalhistorytradomilikmandor'];
            $statusApprovalHistoryTradoMilikSupir= $params['statusapprovalhistorytradomiliksupir'];


            $result = json_decode($statusaktif, true);
            $resultStandarisasi = json_decode($statusStandarisasi, true);
            $resultJenisPlat = json_decode($statusJenisPlat, true);
            $resultMutasi = json_decode($statusMutasi, true);
            $resultValidasiKendaraan = json_decode($statusValidasiKendaraan, true);
            $resultMobilStoring = json_decode($statusMobilStoring, true);
            $resultAppEditBan = json_decode($statusAppEditBan, true);
            $resultLewatValidasi = json_decode($statusLewatValidasi, true);
            $resultAbsensiSupir = json_decode($statusAbsensiSupir, true);
            $resultApprovalHistoryTradoMilikMandor = json_decode($statusApprovalHistoryTradoMilikMandor, true);
            $resultApprovalHistoryTradoMilikSupir = json_decode($statusApprovalHistoryTradoMilikSupir, true);

            $statusaktif = $result['MEMO'];
            $statusStandarisasi = $resultStandarisasi['MEMO'];
            $statusJenisPlat = $resultJenisPlat['MEMO'];
            $statusMutasi = $resultMutasi['MEMO'];
            $statusValidasiKendaraan = $resultValidasiKendaraan['MEMO'];
            $statusMobilStoring = $resultMobilStoring['MEMO'];
            $statusAppEditBan = $resultAppEditBan['MEMO'];
            $statusLewatValidasi = $resultLewatValidasi['MEMO'];
            $statusAbsensiSupir = $resultAbsensiSupir['MEMO'];
            $statusApprovalHistoryTradoMilikMandor = $resultApprovalHistoryTradoMilikMandor['MEMO'];
            $statusApprovalHistoryTradoMilikSupir = $resultApprovalHistoryTradoMilikSupir['MEMO'];


            $trados[$i]['statusaktif'] = $statusaktif;
            $trados[$i]['statusstandarisasi'] = $statusStandarisasi;
            $trados[$i]['statusjenisplat'] = $statusJenisPlat;
            $trados[$i]['statusmutasi'] = $statusMutasi;
            $trados[$i]['statusvalidasikendaraan'] = $statusValidasiKendaraan;
            $trados[$i]['statusmobilstoring'] = $statusMobilStoring;
            $trados[$i]['statusappeditban'] = $statusAppEditBan;
            $trados[$i]['statuslewatvalidasi'] = $statusLewatValidasi;
            $trados[$i]['statusabsensisupir'] = $statusAbsensiSupir;
            $trados[$i]['statusapprovalhistorytradomilikmandor'] = $statusApprovalHistoryTradoMilikMandor;
            $trados[$i]['statusapprovalhistorytradomiliksupir'] = $statusApprovalHistoryTradoMilikSupir;

            $i++;
        }

        // dd($trados);


        return view('reports.trado', compact('trados'));
    }
}
