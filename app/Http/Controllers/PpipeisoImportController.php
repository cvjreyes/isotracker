<?php

namespace App\Http\Controllers;


use App\Ppipe_iso;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class PpipeisoImportController extends Controller
{
   public function importppipeiso()
    {
     
        DB::table('ppipe_isos')->truncate();

     Excel::load('catalogos\ppipes_iso.csv', function($reader) {
 
     foreach ($reader->get() as $ppipeiso) {
     Ppipe_iso::create([
     'name' => $ppipeiso->name,
     'percentage' =>$ppipeiso->percentage
        ]);
    }

 });
return Ppipe_iso::all();

    }


}
