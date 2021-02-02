<?php

namespace App\Http\Controllers;


use App\Tinst;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class TinstImportController extends Controller
{
   public function importtinst()
    {
     
        DB::table('tinsts')->truncate();

     Excel::load('catalogos\tinsts.xlsx', function($reader) {
 
     foreach ($reader->get() as $tinst) {
     tinst::create([
     'name' => $tinst->name,
     'hours' => $tinst->hours,
     'code' => $tinst->code,
        ]);
    }

 });
return tinst::all();

    }


}
