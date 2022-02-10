<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsensiSupirDetailController extends Controller
{
    public $title = 'Absensi';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $params = [
            'absensi_id' => $request->absensi_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->get('http://localhost/trucking-laravel/public/api/absensi_detail', $params);

        $data = [
            'rows' => $response['data']
        ];

        return response($data);
    }
}
