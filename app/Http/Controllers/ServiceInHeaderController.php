<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ServiceInHeaderController extends MyController
{
    public $title = 'Service in';
    // /**
    //  * Fungsi index
    //  * @ClassName index
    //  */
    public function index(Request $request)
    {
        $title = $this->title;
        return view('serviceinheader.index', compact('title'));
    }

    // /**
    //  * Fungsi store
    //  * @ClassName store
    //  */
    public function store(Request $request)
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'serviceinheader', $request->all());


            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    // /**
    //  * Fungsi get
    //  * @ClassName get
    //  */
    public function get($params = [])
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
            'withRelations' => $params['withRelations'] ?? request()->withRelations ?? false,
        ];

        $response = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'serviceinheader', $params);

            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? [],
                'params' => $response['params'] ?? [],
            ];

        return $data;
    }

    // /**
    //  * Fungsi create
    //  * @ClassName create
    //  */
    public function create()
    {
        $title = $this->title;

        $combo = $this->combo();

        return view('serviceinheader.add', compact('title', 'combo'));
    }

    // /**
    //  * Fungsi edit
    //  * @ClassName edit
    //  */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "serviceinheader/$id");

        $servicein = $response['data'];
        $kode = $response['kode'];
        $serviceNoBukti = $this->getNoBukti('SERVICEIN', 'SERVICEIN', 'serviceinheader');

        $combo = $this->combo();

        return view('serviceinheader.edit', compact('title', 'serviceinheader', 'combo', 'serviceNoBukti'));
    }

    // /**
    //  * Fungsi update
    //  * @ClassName update
    //  */
    public function update(Request $request, $id)
    {
        // /* Unformat nominal */
        // $request->nominal = array_map(function ($nominal) {
        //     $nominal = str_replace('.', '', $nominal);
        //     $nominal = str_replace(',', '', $nominal);

        //     return $nominal;
        // }, $request->nominal);

        // $request->merge([
        //     'nominal' => $request->nominal
        // ]);

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "serviceinheader/$id", $request->all());

        return response($response);
    }

    // /**
    //  * Fungsi delete
    //  * @ClassName delete
    //  */
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "serviceinheader/$id");

            $servicein = $response['data'];
            $combo = $this->combo();

            return view('serviceinheader.delete', compact('title', 'combo', 'serviceinheader'));
        } catch (\Throwable $th) {
            return redirect()->route('serviceinheader.index');
        }
    }

    // /**
    //  * Fungsi destroy
    //  * @ClassName destroy
    //  */
    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "serviceinheader/$id");

        return response($response);
    }

    // /**
    //  * Fungsi getNoBukti
    //  * @ClassName getNoBukti
    //  */
    public function getNoBukti($group, $subgroup, $table)
    {
        $params = [
            'group' => $group,
            'subgroup' => $subgroup,
            'table' => $table
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "running_number", $params);

        $noBukti = $response['data'] ?? 'No bukti tidak ditemukan';

        return $noBukti;
    }

    // /**
    //  * Fungsi combo
    //  * @ClassName combo
    //  */
    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'serviceinheader/combo');

        return $response['data'];
    }
}
