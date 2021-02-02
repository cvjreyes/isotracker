<?php

namespace App\Http\Controllers;


use App\Ppipe_support;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class PpipesupportImportController extends Controller
{
   public function importppipesupport()
    {
     
        DB::table('ppipe_supports')->truncate();

     Excel::load('catalogos\ppipes_support.csv', function($reader) {
 
     foreach ($reader->get() as $ppipesupport) {
     Ppipe_support::create([
     'name' => $ppipesupport->name,
     'percentage' =>$ppipesupport->percentage
        ]);
    }

 });
return Ppipe_support::all();

    }


}
