<?php

namespace App\Http\Controllers;

use App\Libraries\Myauth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ApprovalBukaCetakController  extends MyController
{
    public $title = 'Approval Buka Cetak';
    
    public function index(Request $request)
    {
        $title = $this->title;
        $paramTable = $this->comboTable('list');
        $comboTable =[];
        $myAuth = new Myauth;
        foreach ($paramTable as $index => $table) {
            if($myAuth->hasPermission($table['text'], 'approvalbukacetak')) {
                $comboTable[$index]['id'] = $table['id'];
                $comboTable[$index]['text'] = json_decode($table['memo'])->MEMO;
            }
        }

        $data = [            
            'comboTable' => $comboTable
        ];
        return view('approvalbukacetak.index', compact('title','data'));
    }

    public function comboTable()
    {

        $status = [
            'grp' => 'CETAKULANG',
            'subgrp' => 'CETAKULANG',
        ];

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/combo',$status);

        return $response['data'];
    }
}
