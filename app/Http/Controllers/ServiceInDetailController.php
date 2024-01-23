<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ServiceInDetailController extends MyController
{
    public $title = 'Service In Detail';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $params = [
            'servicein_id' => $request->servicein_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'serviceindetail', $params);

        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}
