<?php

namespace App\Http\Controllers;


use App\Flu_desc;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class FluDescImportController extends Controller
{
   public function importfludesc()
    {
     
        DB::table('flu_descs')->truncate();

     Excel::load('catalogos\flu_desc.csv', function($reader) {
 
     foreach ($reader->get() as $flu_desc) {
     Flu_desc::create([
     'id' => $flu_desc->id,   
     'name' => $flu_desc->name,
        ]);
    }

 });
return Flu_desc::all();

    }


}
