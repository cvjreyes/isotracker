<?php

namespace App\Http\Controllers;


use App\Delec_tray;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DelectrayImportController extends Controller
{
   public function importdelectray()
    {

        DB::table('delec_trays')->truncate();

     Excel::load('e3dreports\StatusReport-Elec_tray.csv', function($reader) {
 
     foreach ($reader->get() as $delectray) {
     Delec_tray::create([
     'zone_name' => $delectray->zone_name,
     'item_name' =>$delectray->item_name,
     'item_type' =>$delectray->item_type,
     'status_trays' => $delectray->status_trays
        ]);
    }

 });
 return Delec_tray::all();
    }

}
