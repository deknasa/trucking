<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LookupController extends Controller
{
    public function show($fileName)
    {
        return response()->view("partials.lookups.$fileName");
    }
}
