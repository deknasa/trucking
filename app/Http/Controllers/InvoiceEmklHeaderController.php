<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class InvoiceEmklHeaderController extends MyController
{
    public $title = 'Invoice EMKL';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Invoice EMKL',
            'comboapproval' => $this->comboList('STATUS APPROVAL', 'STATUS APPROVAL'),
            'combocetak' => $this->comboList('STATUSCETAK', 'STATUSCETAK'),
            'comboinvoice' => $this->comboList('STATUS INVOICE', 'STATUS INVOICE'),
            'combopajak' => $this->comboList('STATUS PAJAK', 'STATUS PAJAK'),
            'comboppn' => $this->comboList('STATUS PPN', 'STATUS PPN'),
            'listbtn' => $this->getListBtn()
        ];
        $data = array_merge(
            compact('title', 'data'),
            ["request" => $request->all()]
        );
        return view('invoiceemklheader.index', $data);
    }
    public function comboList($grp, $subgrp)
    {

        $status = [
            'status' => 'list',
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/combolist', $status);

        return $response['data'];
    }
    public function report(Request $request)
    {
         //FETCH HEADER
         $id = $request->id;
         $invoices = Http::withHeaders($request->header())
             ->withOptions(['verify' => false])
             ->withToken(session('access_token'))
             ->get(config('app.api_url') . 'invoiceemklheader/'.$id.'/export')['data'];
             
        $detailParams = [
            'forReport' => true,
            'invoiceemkl_id' => $request->id
        ];
        $invoice_detail = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'invoiceemkldetail', $detailParams)['data'];
          
        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $invoices["combo"] =  $combo[$key];
        return view('reports.invoiceemkl', compact('invoice_detail', 'invoices'));
    }

    public function combo($aksi)
    {
        $status = [
            'status' => $aksi,
            'grp' => 'STATUSCETAK',
            'subgrp' => 'STATUSCETAK',
        ]; 
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus',$status);
        return $response['data'];
    }

    // public function combolist($grp, $subgrp)
    // {
    //     $params = [
    //         'grp' => $grp ?? '',
    //         'subgrp' => $subgrp ?? '',
    //     ];
    //     $temp = '##temp' . rand(1, getrandmax()) . str_replace('.', '', microtime(true));

    //     Schema::create($temp, function ($table) {
    //         $table->integer('id')->length(11)->nullable();
    //         $table->string('parameter', 50)->nullable();
    //         $table->string('param', 50)->nullable();
    //     });


    //     DB::table($temp)->insert(
    //         [
    //             'id' => '0',
    //             'parameter' => 'ALL',
    //             'param' => '',
    //         ]
    //     );

    //     $queryall = db::table('parameter')->from(db::raw("parameter with (readuncommitted)"))
    //         ->select('id', 'text as parameter', 'text as param')
    //         ->where('grp', "=", $params['grp'])
    //         ->where('subgrp', "=", $params['subgrp']);

    //     $query = DB::table($temp)
    //         ->unionAll($queryall);

    //     $data = $query->get();

    //     // $datajson[$index]['updated_at']
        
    //         return json_decode($data);
    // }
}
