<?php

namespace App\Http\Controllers;


use App\Dinst_tray;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;


class DinsttrayImportController extends Controller
{
   public function importdinsttray()
    {
     
        DB::table('dinst_trays')->truncate();

     Excel::load('e3dreports\StatusReport-Inst_tray.csv', function($reader) {
 
     foreach ($reader->get() as $dinsttray) {
     Dinst_tray::create([
     'zone_name' => $dinsttray->zone_name,
     'item_name' =>$dinsttray->item_name,
     'item_type' =>$dinsttray->item_type,
     'status_tray' => $dinsttray->status_tray
        ]);
    }

 });
 return Dinst_tray::all();
    }

}
