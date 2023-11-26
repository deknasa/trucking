<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StokPusatController extends MyController
{
    public $title = 'Stok Pusat';

    public function index(Request $request)
    {
        $title = $this->title;

        return view('stokpusat.index', compact('title'));
    }

    public function tokenJkt(Request $request)
    {
        session(['access_token_jkt' => $request->token]);
        $token = session('access_token_jkt');
        return response([
            'data' => $token
        ]);
    }
    public function tokenJktTnl(Request $request)
    {
        session(['access_token_jkttnl' => $request->token]);
        $token = session('access_token_jkttnl');
        return response([
            'data' => $token
        ]);
    }
}
