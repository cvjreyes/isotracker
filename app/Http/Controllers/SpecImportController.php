<?php

namespace App\Http\Controllers;


use App\Spec;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class SpecImportController extends Controller
{
   public function importspec()
    {
     
        DB::table('specs')->truncate();

     Excel::load('catalogos\specs.csv', function($reader) {
 
     foreach ($reader->get() as $spec) {
     Spec::create([
     'id' => $spec->id,   
     'name' => $spec->name,
        ]);
    }

 });
return Spec::all();

    }


}
