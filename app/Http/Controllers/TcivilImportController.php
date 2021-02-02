<?php

namespace App\Http\Controllers;


use App\Tcivil;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class TcivilImportController extends Controller
{
   public function importtcivil()
    {
     
        DB::table('tcivils')->truncate();

     Excel::load('catalogos\tcivils.xlsx', function($reader) {
 
     foreach ($reader->get() as $tcivil) {
     tcivil::create([
     'name' => $tcivil->name,
     'hours' => $tcivil->hours,
     'code' => $tcivil->code,
        ]);
    }

 });
return tcivil::all();

    }


}
