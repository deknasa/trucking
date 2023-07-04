<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ApprovalSupirKeteranganController extends MyController
{
    public $title = 'Approval Supir Keterangan';
    
    public function index(Request $request)
    {
        $title = $this->title;
        $combo = [            
            'statusapproval' => $this->getParameter('STATUS APPROVAL', 'STATUS APPROVAL'),
        ];
        return view('approvalsupirketerangan.index', compact('title','combo'));
    }

    
}
