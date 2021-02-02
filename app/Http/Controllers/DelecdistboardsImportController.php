<?php

namespace App\Http\Controllers;


use App\Delec_dist_boards;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DelecdistboardsImportController extends Controller
{
   public function importdelecdistboards()
    {
     
    DB::table('Delec_dist_boards')->truncate();

     Excel::load('e3dreports\StatusReport-Elec_dist_boards.csv', function($reader) {
 
     foreach ($reader->get() as $delecdistboards) {
     Delec_dist_boards::create([
     'zone_name' => $delecdistboards->zone_name,
     'item_name' =>$delecdistboards->item_name,
     'item_type' =>$delecdistboards->item_type,
     'status_boards' => $delecdistboards->status_boards
        ]);
    }

 });
 return Delec_dist_boards::all();
    }

}
