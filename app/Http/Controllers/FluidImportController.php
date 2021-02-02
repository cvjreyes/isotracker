<?php

namespace App\Http\Controllers;


use App\Fluid;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class FluidImportController extends Controller
{
   public function importfluid()
    {
     
        DB::table('fluids')->truncate();

     Excel::load('catalogos\fluids.xlsx', function($reader) {
 
     foreach ($reader->get() as $fluid) {
     Fluid::create([
     'id' => $fluid->id,   
     'name' => $fluid->name,
     'code' => $fluid->code,
        ]);
    }

 });
return Fluid::all();

    }


}
