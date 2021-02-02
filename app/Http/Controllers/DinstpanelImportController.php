<?php

namespace App\Http\Controllers;


use App\Dinst_panel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DinstpanelImportController extends Controller
{
   public function importdinstpanel()
    {
     
        DB::table('dinst_panels')->truncate();

     Excel::load('e3dreports\StatusReport-Inst_panel.csv', function($reader) {
 
     foreach ($reader->get() as $dinstpanel) {
     Dinst_panel::create([
     'zone_name' => $dinstpanel->zone_name,
     'item_name' =>$dinstpanel->item_name,
     'item_type' =>$dinstpanel->item_type,
     'status_panel' => $dinstpanel->status_panel
        ]);
    }

 });
 return Dinst_panel::all();
    }

}
