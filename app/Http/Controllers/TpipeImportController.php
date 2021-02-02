<?php

namespace App\Http\Controllers;


use App\Tpipe;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class TpipeImportController extends Controller
{
   public function importtpipe()
    {
     
        DB::table('tpipes')->truncate();

     Excel::load('catalogos\tpipes.xlsx', function($reader) {
 
     foreach ($reader->get() as $tpipe) {
     tpipe::create([
     'id' => $tpipe->id,   
     'name' => $tpipe->name,
     'hours' => $tpipe->hours,
     'code' => $tpipe->code,
     'pid' => $tpipe->pid,
     'iso' => $tpipe->iso,
     'stress' => $tpipe->stress,
     'support' => $tpipe->support,
        ]);
    }

 });
return tpipe::all();

    }


}
