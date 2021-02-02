<?php

namespace App\Http\Controllers;


use App\Dinst_inst;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DinstinstImportController extends Controller
{
   public function importdinstinst()
    {
     
     DB::table('dinst_insts')->truncate();

     Excel::load('e3dreports\StatusReport-Inst_inst.csv', function($reader) {
 
     foreach ($reader->get() as $dinstinst) {
     Dinst_inst::create([
     'zone_name' => $dinstinst->zone_name,
     'item_name' =>$dinstinst->item_name,
     'item_type' =>$dinstinst->item_type,
     'status_inst' => $dinstinst->status_inst
        ]);
    }

 });
 return Dinst_inst::all();
    }

}
