<?php

namespace App\Http\Controllers;


use App\Diameter;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DiamImportController extends Controller
{
   public function importdiam()
    {
     
        DB::table('diameters')->truncate();

     Excel::load('catalogos\diameters.csv', function($reader) {
 
     foreach ($reader->get() as $diam) {
     Diameter::create([
     'id' => $diam->id,   
     'nps' => $diam->nps,
     'dn' => $diam->dn,
        ]);
    }

 });
return Diameter::all();

    }


}
