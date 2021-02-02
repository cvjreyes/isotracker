<?php

namespace App\Http\Controllers;


use App\Delec_light;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DeleclightImportController extends Controller
{
   public function importdeleclight()
    {
        
     DB::table('delec_lights')->truncate();   

     Excel::load('e3dreports\StatusReport-Elec_light.csv', function($reader) {
 
     foreach ($reader->get() as $deleclight) {
     Delec_light::create([
     'zone_name' => $deleclight->zone_name,
     'item_name' =>$deleclight->item_name,
     'item_type' =>$deleclight->item_type,
     'status_lighting' => $deleclight->status_lighting
        ]);
    }

 });
 return Delec_light::all();
    }

}
