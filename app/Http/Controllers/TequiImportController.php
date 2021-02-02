<?php

namespace App\Http\Controllers;


use App\Tequi;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class TequiImportController extends Controller
{
   public function importtequi()
    {
     
        DB::table('tequis')->truncate();

     Excel::load('catalogos\tequis.xlsx', function($reader) {
 
     foreach ($reader->get() as $tequi) {
     tequi::create([
     'id' => $tequi->id,   
     'name' => $tequi->name,
     'hours' => $tequi->hours,
     'code' => $tequi->code,
        ]);
    }

 });
return tequi::all();

    }


}
