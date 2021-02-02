<?php

namespace App\Http\Controllers;


use App\Delec_junts;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DelecjuntImportController extends Controller
{
   public function importdelecjunt()
    {

        DB::table('delec_junts')->truncate();

     Excel::load('e3dreports\StatusReport-Elec_junt.csv', function($reader) {
 
     foreach ($reader->get() as $delecjunt) {
     Delec_junts::create([
     'zone_name' => $delecjunt->zone_name,
     'item_name' =>$delecjunt->item_name,
     'item_type' =>$delecjunt->item_type,
     'status_junct' => $delecjunt->status_junct
        ]);
    }

 });
 return Delec_junts::all();
    }

}
