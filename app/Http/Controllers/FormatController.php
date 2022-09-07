<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFormatRequest;

class FormatController extends Controller
{
    public function update(UpdateFormatRequest $request)
    {
        $path = 'formats/global.json';
        
        $formats = json_decode(file_get_contents($path), true);

        if (isset($formats[$request->key])) {
            $formats[$request->key] = $request->value;
        }

        $jsonFormats = json_encode($formats);

        file_put_contents($path, $jsonFormats);

        return response([
            'message' => 'Formats updated'
        ]);
    }
}
