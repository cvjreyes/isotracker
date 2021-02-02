<?php

namespace App\Http\Controllers;


use App\Unit;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class UnitImportController extends Controller
{
   public function importunit()
    {
     
        DB::table('units')->truncate();




        //config(['excel.import.startRow' => 10 ]);
        //config(['excel.import.heading' => 'slugged' ]);

     Excel::load('catalogos\units.xlsx', function($reader) {

        //$reader->noHeading = true;
 
     foreach ($reader->get() as $unit) {
     Unit::create([
     'id' => $unit->id,   
     'name' => $unit->name,
     'ngf' => $unit->ngf,
     'e3d' => $unit->e3d,
        ]);
    }

 });
return Unit::all();

    }


}
