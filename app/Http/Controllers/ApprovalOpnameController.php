<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApprovalOpnameController extends MyController
{
    public $title = 'Approval Opname';

    public function index(Request $request)
    {
        $title = $this->title;
        return view('approvalopname.index', compact('title'));
    }
}
