<?php

namespace App\Http\Controllers;


use App\Dstru;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DstruImportController extends Controller
{
   public function importdstru()
    {
     
        DB::table('dstrus')->truncate();

     Excel::load('e3dreports\StatusReport-Stru.csv', function($reader) {
 
     foreach ($reader->get() as $dstru) {
     Dstru::create([
     'zone_name' => $dstru->zone_name,
     'item_name' =>$dstru->item_name,
     'item_type' =>$dstru->item_type,
     'status_str' => $dstru->status_str
        ]);
    }

 });
 //return Dstru::all();
     return 'Successful';
    }

}