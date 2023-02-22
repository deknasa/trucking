<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TutupBukuController extends MyController
{
    public $title = 'Tutup Buku';

    public function index(Request $request)
    {
        $title = $this->title;

        return view('tutupbuku.index', compact('title'));
    }
}
