<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PenerimaanTruckingController extends Controller
{
   
        public $title = 'Penerimaan Trucking';
    
        /**
         * @ClassName
         */
        public function index(Request $request)
        {
            $title = $this->title;
    
            return view('penerimaantrucking.index', compact('title'));
        }
        
        /**
         * @ClassName
         */
        public function create()
        {
            $title = $this->title;
    
            return view('penerimaantrucking.add', compact('title'));
        }
    
        /**
         * @ClassName
         */
        public function edit($id)
        {
            $title = $this->title;
    
            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "penerimaantrucking/$id");
    
            $penerimaanTrucking = $response['data'];
    
            return view('penerimaantrucking.edit', compact('title', 'penerimaanTrucking'));
        }
    
        /**
         * @ClassName
         */
        public function delete($id)
        {
            try {
                $title = $this->title;
    
                $response = Http::withHeaders($this->httpHeaders)
                    ->withOptions(['verify' => false])
                    ->withToken(session('access_token'))
                    ->get(config('app.api_url') . "penerimaantrucking/$id");
    
                $penerimaanTrucking = $response['data'];
    
                return view('penerimaantrucking.delete', compact('title', 'penerimaanTrucking'));
            } catch (\Throwable $th) {
                return redirect()->route('penerimaantrucking.index');
            }
        }
        
        /**
         * @ClassName
         */
        public function report(Request $request)
        {
            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . 'penerimaantrucking', $request->all());
    
            $penerimaanTruckings = $response['data'];
    
            return view('reports.penerimaantrucking', compact('penerimaanTr$penerimaanTruckings'));
        }
   
    
}
