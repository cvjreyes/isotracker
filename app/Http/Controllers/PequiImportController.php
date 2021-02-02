<?php

namespace App\Http\Controllers;


use App\Pequi;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class PequiImportController extends Controller
{
   public function importpequi()
    {
     
        DB::table('pequis')->truncate();

     Excel::load('catalogos\pequis.csv', function($reader) {
 
     foreach ($reader->get() as $pequi) {
     Pequi::create([
     'name' => $pequi->name,
     'percentage' =>$pequi->percentage
        ]);
    }

 });
return Pequi::all();

    }


}
