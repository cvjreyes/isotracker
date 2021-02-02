<?php

namespace App\Http\Controllers;


use App\Dstation;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DstationImportController extends Controller
{
   public function importdstation()
    {
     
        DB::table('dstations')->truncate();

     Excel::load('e3dreports\StatusReport-Station.csv', function($reader) {
 
     foreach ($reader->get() as $dstation) {
     Dstation::create([
     'zone_name' => $dstation->zone_name,
     'item_name' =>$dstation->item_name,
     'item_type' =>$dstation->item_type,
     'status_station' => $dstation->status_station
        ]);
    }

 });
 return Dstation::all();
    }

}
