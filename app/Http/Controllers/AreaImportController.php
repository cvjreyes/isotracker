<?php

namespace App\Http\Controllers;


use App\Area;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class AreaImportController extends Controller
{
   public function importarea()
    {
     
        DB::table('areas')->truncate();




        //config(['excel.import.startRow' => 10 ]);
        //config(['excel.import.heading' => 'slugged' ]);

     Excel::load('catalogos\areas.xlsx', function($reader) {

        //$reader->noHeading = true;
 
     foreach ($reader->get() as $area) {
     area::create([
     'id' => $area->id,   
     'name' => $area->name,
     'ngf' => $area->ngf,
     'e3d' => $area->e3d,
        ]);
    }

 });
return area::all();

    }


}
