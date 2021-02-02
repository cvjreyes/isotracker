<?php

namespace App\Http\Controllers;


use App\Dinst_fg;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DinstfgImportController extends Controller
{
   public function importdinstfg()
    {
     
        DB::table('dinst_fgs')->truncate();

     Excel::load('e3dreports\StatusReport-Inst_fg.csv', function($reader) {
 
     foreach ($reader->get() as $dinstfg) {
     Dinst_fg::create([
     'zone_name' => $dinstfg->zone_name,
     'item_name' =>$dinstfg->item_name,
     'item_type' =>$dinstfg->item_type,
     'status_fg' => $dinstfg->status_fg
        ]);
    }

 });
 return Dinst_fg::all();
    }

}
