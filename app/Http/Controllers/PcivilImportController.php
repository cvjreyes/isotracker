<?php

namespace App\Http\Controllers;


use App\Pcivil;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class PcivilImportController extends Controller
{
   public function importpcivil()
    {
     
        DB::table('pcivils')->truncate();

     Excel::load('catalogos\pcivils.csv', function($reader) {
 
     foreach ($reader->get() as $pcivil) {
     Pcivil::create([
     'name' => $pcivil->name,
     'percentage' =>$pcivil->percentage
        ]);
    }

 });
return Pcivil::all();

    }


}
