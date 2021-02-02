<?php

namespace App\Http\Controllers;


use App\Telec;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class TelecImportController extends Controller
{
   public function importtelec()
    {
     
        DB::table('telecs')->truncate();

     Excel::load('catalogos\telecs.xlsx', function($reader) {
 
     foreach ($reader->get() as $telec) {
     telec::create([
     'name' => $telec->name,
     'hours' => $telec->hours,
     'code' => $telec->code,
        ]);
    }

 });
return telec::all();

    }


}
