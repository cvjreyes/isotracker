<?php

namespace App\Http\Controllers;


use App\Ins_code;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class InsCodImportController extends Controller
{
   public function importinscod()
    {
     
        DB::table('ins_codes')->truncate();

     Excel::load('catalogos\ins_codes.csv', function($reader) {
 
     foreach ($reader->get() as $ins_code) {
     Ins_code::create([
     'id' => $ins_code->id,   
     'name' => $ins_code->name,
     'code' => $ins_code->code,
        ]);
    }

 });
return Ins_code::all();

    }


}
