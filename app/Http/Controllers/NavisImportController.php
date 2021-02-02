<?php

namespace App\Http\Controllers;


use App\Navis;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class NavisImportController extends Controller
{
   public function importnavis()
    {
     
        DB::table('navis')->truncate();

     Excel::load('..\public\storage\navis\navis.csv', function($reader) {
 
     foreach ($reader->get() as $navi) {
     Navis::create([
     'id' => $navi->id,   
     'object' => $navi->object,
     'value' => $navi->value,
        ]);
    }

 });
return Navis::all();

    }


}
