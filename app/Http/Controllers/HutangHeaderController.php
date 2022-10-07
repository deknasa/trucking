<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class HutangHeaderController extends MyController
{

    public $title = 'Hutang';

    /**
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        return view('hutang.index', compact('title'));
    }

    /**
     * @ClassName create
     */
    public function create()
    {
        $title = $this->title;

        return view('hutang.add', compact('title'));
    }

    /**
     * @ClassName store
     */
    public function store(Request $request)
    {
        try {


            $request->total = array_map(function ($total) {
                $total = str_replace('.', '', $total);

                return $total;
            }, $request->total);

            $request->cicilan = array_map(function ($cicilan) {
                $cicilan = str_replace('.', '', $cicilan);

                return $cicilan;
            }, $request->cicilan);

            $request->totalbayar = array_map(function ($totalbayar) {
                $totalbayar = str_replace('.', '', $totalbayar);

                return $totalbayar;
            }, $request->totalbayar);
            

            $request->merge([
               // 'nominal' => $request->nominal,
                'total' => $request->total,
                'cicilan' => $request->cicilan,
                'totalbayar' => $request->totalbayar,

            ]);

            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'hutangheader', $request->all());


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
            ->get(config('app.api_url') . 'hutangheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }


    /**
     * Fungsi edit
     * @ClassName edit
     */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "hutangheader/$id");
            // dd($response->getBody()->getContents());

        $hutang = $response['data'];
        $hutangNoBukti = $this->getNoBukti('HUTANG', 'HUTANG', 'hutangheader');


        return view('hutang.edit', compact('title', 'hutang', 'hutangNoBukti'));
    }

   // /**
    //  * Fungsi update
    //  * @ClassName update
    //  */
    public function update(Request $request, $id)
    {

        $request->total = array_map(function ($total) {
            $total = str_replace('.', '', $total);

            return $total;
        }, $request->total);

        $request->cicilan = array_map(function ($cicilan) {
            $cicilan = str_replace('.', '', $cicilan);

            return $cicilan;
        }, $request->cicilan);

        $request->totalbayar = array_map(function ($totalbayar) {
            $totalbayar = str_replace('.', '', $totalbayar);

            return $totalbayar;
        }, $request->totalbayar);
        

        $request->merge([
           // 'nominal' => $request->nominal,
            'total' => $request->total,
            'cicilan' => $request->cicilan,
            'totalbayar' => $request->totalbayar,

        ]);

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "hutangheader/$id", $request->all());

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
                ->get(config('app.api_url') . "hutangheader/$id");

            $hutangHeader = $response['data'];
            $combo = $this->combo();

            return view('hutangheader.delete', compact('title', 'combo', 'hutangheader'));
        } catch (\Throwable $th) {
            return redirect()->route('hutangheader.index');
        }
    }

     /**
     * @ClassName
     */
    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "hutangheader/$id");

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

}
