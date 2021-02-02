<?php

namespace App\Http\Controllers;


use App\Flu_pha;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class FluPhaImportController extends Controller
{
   public function importflupha()
    {
     
        DB::table('flu_phas')->truncate();

     Excel::load('catalogos\flu_pha.csv', function($reader) {
 
     foreach ($reader->get() as $flu_pha) {
     Flu_pha::create([
     'id' => $flu_pha->id,   
     'name' => $flu_pha->name,
        ]);
    }

 });
return Flu_pha::all();

    }


}
