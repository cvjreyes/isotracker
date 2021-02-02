<?php

namespace App\Http\Controllers;


use App\Mequi;
use App\Hequi;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class MequiImportController extends Controller
{
   public function importmequi()
    {

        DB::table('mequis')->truncate();

     Excel::load('estimated\mequis.xlsx', function($reader) {
 
     foreach ($reader->get() as $mequi) {
     Mequi::create([
     'week' => $mequi->week,
     'area' => $mequi->area,
     'estimated' => $mequi->estimated,
        ]);
    }

 });
return Mequi::all();

    }


}
