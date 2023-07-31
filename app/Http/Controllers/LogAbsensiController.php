<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogAbsensiController extends MyController
{
    public $title = 'Log Absensi';
  
   public function index()
   {
       $title = $this->title;
       
       return view('logabsensi.index', compact('title'));
   }

   public function export(){

   }
   public function report(){
    
   }
}
