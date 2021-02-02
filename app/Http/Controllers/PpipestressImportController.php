<?php

namespace App\Http\Controllers;


use App\Ppipe_stress;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class PpipestressImportController extends Controller
{
   public function importppipestress()
    {
     
     DB::table('ppipe_stresses')->truncate();

     Excel::load('catalogos\ppipes_stress.csv', function($reader) {
 
     foreach ($reader->get() as $ppipestress) {
     Ppipe_stress::create([
     'name' => $ppipestress->name,
     'percentage' =>$ppipestress->percentage
        ]);
    }

 });
return Ppipe_stress::all();

    }


}
