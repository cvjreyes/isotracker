<?php

namespace App\Http\Controllers;


use App\Pinst;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class PinstImportController extends Controller
{
   public function importpinst()
    {
     
        DB::table('pinsts')->truncate();

     Excel::load('catalogos\pinsts.csv', function($reader) {
 
     foreach ($reader->get() as $pinst) {
     Pinst::create([
     'name' => $pinst->name,
     'percentage' =>$pinst->percentage
        ]);
    }

 });
return Pinst::all();

    }


}
