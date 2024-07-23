<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SupirController extends MyController
{
    public $title = 'Supir';

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
                ->get(config('app.api_url') . 'supir', $params);
            
            $rows = $response['data'];

            foreach($response['data'] as $key => $item) {
                $arrSupir       = json_decode($item['photosupir']);
                $arrKtp         = json_decode($item['photoktp']);
                $arrSim         = json_decode($item['photosim']);
                $arrKk          = json_decode($item['photokk']);
                $arrSkck        = json_decode($item['photoskck']);
                $arrDomisili    = json_decode($item['photodomisili']);

                $imgSupir='';
                if (!empty($arrSupir)) {
                    $count = count($arrSupir);
                    if ($count > 0) {
                        $total = $count / 3;
                        $idx=2;
                        for ($i=0; $i < $total; $i++) {
                            if ($i>0){
                                $idx+=3;
                            }

                            $imgSupir .= "<img src='".config('app.api_url').'../uploads/supir/'.$arrSupir[$idx]."' class='mr-2'>";
                        }
                    }
                }

                $imgKtp='';
                if (!empty($arrKtp)) {
                    $count = count($arrKtp);
                    if ($count > 0) {
                        $total = $count / 3;
                        $idx=2;
                        for ($i=0; $i < $total; $i++) {
                            if ($i>0){
                                $idx+=3;
                            }

                            $imgKtp .= "<img src='".config('app.api_url').'../uploads/ktp/'.$arrKtp[$idx]."' class='mr-2'>";
                        }
                    }
                }

                $imgsim='';
                if (!empty($arrSim)) {
                    $count = count($arrSim);
                    if ($count > 0) {
                        $total = $count / 3;
                        $idx=2;
                        for ($i=0; $i < $total; $i++) {
                            if ($i>0){
                                $idx+=3;
                            }

                            $imgsim .= "<img src='".config('app.api_url').'../uploads/sim/'.$arrSim[$idx]."' class='mr-2'>";
                        }
                    }
                }

                $imgkk='';
                if (!empty($arrKk)) {
                    $count = count($arrKk);
                    if ($count > 0) {
                        $total = $count / 3;
                        $idx=2;
                        for ($i=0; $i < $total; $i++) {
                            if ($i>0){
                                $idx+=3;
                            }

                            $imgkk .= "<img src='".config('app.api_url').'../uploads/kk/'.$arrKk[$idx]."' class='mr-2'>";
                        }
                    }
                }

                $imgskck='';
                if (!empty($arrSkck)) {
                    $count = count($arrSkck);
                    if ($count > 0) {
                        $total = $count / 3;
                        $idx=2;
                        for ($i=0; $i < $total; $i++) {
                            if ($i>0){
                                $idx+=3;
                            }

                            $imgskck .= "<img src='".config('app.api_url').'../uploads/skck/'.$arrSkck[$idx]."' class='mr-2'>";
                        }
                    }
                }

                $imgdomisili='';
                if (!empty($arrDomisili)) {
                    $count = count($arrDomisili);
                    if ($count > 0) {
                        $total = $count / 3;
                        $idx=2;
                        for ($i=0; $i < $total; $i++) {
                            if ($i>0){
                                $idx+=3;
                            }

                            $imgdomisili .= "<img src='".config('app.api_url').'../uploads/domisili/'.$arrDomisili[$idx]."' class='mr-2'>";
                        }
                    }
                }
            
                $rows[$key]['photosupir']       = $imgSupir;
                $rows[$key]['photoktp']         = $imgKtp;
                $rows[$key]['photosim']         = $imgsim;
                $rows[$key]['photokk']          = $imgkk;
                $rows[$key]['photoskck']        = $imgskck;
                $rows[$key]['photodomisili']    = $imgdomisili;
            }
            
                $data = [
                    'total' => $response['attributes']['totalPages'],
                    'records' => $response['attributes']['totalRows'],
                    'rows' => $rows
                ];

                return response($data);

             }

        $title = $this->title;

        $data = [
            'statusaktif' => $this->comboStatusAktif('list','STATUS AKTIF','STATUS AKTIF'),
            'statusadaupdategambar' => $this->comboStatusAktif('list','STATUS ADA UPDATE GAMBAR','STATUS ADA UPDATE GAMBAR'),
            'statusluarkota' => $this->comboStatusAktif('list','STATUS LUAR KOTA','STATUS LUAR KOTA'),
            'statuszonatertentu' => $this->comboStatusAktif('list','ZONA TERTENTU','ZONA TERTENTU'),
            'statusblacklist' => $this->comboStatusAktif('list','BLACKLIST SUPIR','BLACKLIST SUPIR'),
            'combopostingtnl' => $this->comboStatusAktif('list', 'STATUS POSTING TNL', 'STATUS POSTING TNL'),
            'statusapprovalhistorysupirmilikmandor' => $this->comboStatusAktif('list','STATUS APPROVAL','STATUS APPROVAL'),
            'listbtn' => $this->getListBtn()
        ];

        return view('supir.index', compact('title','data'));
    }

    public function create()
    {
        $title = $this->title;
        $combo = $this->combo();
        
        return view('supir.add', compact('title','combo'));
    }

    public function store(Request $request)
    {
        // $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false]);

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
        ->post(config('app.api_url') . 'supir', $request->all());

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
                $res = $res->post(config('app.api_url') . 'supir/upload_image/'.$id);
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

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))->get(config('app.api_url') . "supir/$id");

        $supir = $response['data'];

        $combo = $this->combo();

        return view('supir.edit', compact('title', 'supir', 'combo'));
    }

    public function update(Request $request, $id)
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))->patch(config('app.api_url') . "supir/$id", $request->all());

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
                $res = $res->post(config('app.api_url') . 'supir/upload_image/'.$id,[
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

            $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "supir/$id");

            $supir = $response['data'];

            $combo = $this->combo();

            return view('supir.delete', compact('title', 'supir', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('supir.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
        ->delete(config('app.api_url') . "supir/$id", $request->all());

        return response($response);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))->get(config('app.api_url') . 'supir/field_length');

        return response($response['data']);
    }

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'supir/combo');
        
        return $response['data'];
    }

    public function comboStatusAktif($aksi, $grp, $subgrp)
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
            ->get(config('app.api_url') . 'supir', $request->all());

        $supirs = $response['data'];

        $i = 0;
        foreach ($supirs as $index => $params) {

            $statusaktif = $params['statusaktif'];
            $statusLuarKota = $params['statusluarkota'];
            $statusZonaTertentu = $params['statuszonatertentu'];
            $statusBlacklist = $params['statusblacklist'];
            $statusUpdateGambar = $params['statusadaupdategambar'];
            $statusApprovalHistorySupirMilikMandor= $params['statusapprovalhistorysupirmilikmandor'];

            $result = json_decode($statusaktif, true);
            $resultLuarKota = json_decode($statusLuarKota, true);
            $resultZonaTertentu = json_decode($statusZonaTertentu, true);
            $resultBlacklist = json_decode($statusBlacklist, true);
            $resultUpdateGambar = json_decode($statusUpdateGambar, true);
            $resultApprovalHistorySupirMilikMandor = json_decode($statusApprovalHistorySupirMilikMandor, true);


            $statusaktif = $result['MEMO'];
            $statusLuarKota = $resultLuarKota['MEMO'];
            $statusZonaTertentu = $resultZonaTertentu['MEMO'];
            $statusBlacklist = $resultBlacklist['MEMO'];
            $statusUpdateGambar = $resultUpdateGambar['MEMO'];
            $statusApprovalHistorySupirMilikMandor = $resultApprovalHistorySupirMilikMandor['MEMO'];



            $supirs[$i]['statusaktif'] = $statusaktif;
            $supirs[$i]['statusluarkota'] = $statusLuarKota;
            $supirs[$i]['statuszonatertentu'] = $statusZonaTertentu;
            $supirs[$i]['statusblacklist'] = $statusBlacklist;
            $supirs[$i]['statusadaupdategambar'] = $statusUpdateGambar;
            $trados[$i]['statusapprovalhistorysupirmilikmandor'] = $statusApprovalHistorySupirMilikMandor;


        
            $i++;


        }

        return view('reports.supir', compact('supirs'));
    }
}