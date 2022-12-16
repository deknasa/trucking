<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LookupController extends Controller
{
    public function show(Request $request, $fileName)
    {
        return response()->view("partials.lookups.$fileName", $request->all());
    }
}
