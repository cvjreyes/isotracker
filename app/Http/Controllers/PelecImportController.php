<?php

namespace App\Http\Controllers;


use App\Pelec;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class PelecImportController extends Controller
{
   public function importpelec()
    {
     
        DB::table('pelecs')->truncate();

     Excel::load('catalogos\pelecs.csv', function($reader) {
 
     foreach ($reader->get() as $pelec) {
     Pelec::create([
     'name' => $pelec->name,
     'percentage' =>$pelec->percentage
        ]);
    }

 });
return Pelec::all();

    }


}
