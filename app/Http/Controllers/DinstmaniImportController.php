<?php

namespace App\Http\Controllers;


use App\Dinst_mani;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DinstmaniImportController extends Controller
{
   public function importdinstmani()
    {
     
        DB::table('dinst_manis')->truncate();

     Excel::load('e3dreports\StatusReport-Inst_mani.csv', function($reader) {
 
     foreach ($reader->get() as $dinstmani) {
     Dinst_mani::create([
     'zone_name' => $dinstmani->zone_name,
     'item_name' =>$dinstmani->item_name,
     'item_type' =>$dinstmani->item_type,
     'status_mani' => $dinstmani->status_mani
        ]);
    }

 });
 return Dinst_mani::all();
    }

}
