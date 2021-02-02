<?php

namespace App\Http\Controllers;


use App\Dinst_junct;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DinstjunctImportController extends Controller
{
   public function importdinstjunct()
    {
     
        DB::table('dinst_juncts')->truncate();

     Excel::load('e3dreports\StatusReport-Inst_junct.csv', function($reader) {
 
     foreach ($reader->get() as $dinstjunct) {
     Dinst_junct::create([
     'zone_name' => $dinstjunct->zone_name,
     'item_name' =>$dinstjunct->item_name,
     'item_type' =>$dinstjunct->item_type,
     'status_junct' => $dinstjunct->status_junct
        ]);
    }

 });
 return Dinst_junct::all();
    }

}
