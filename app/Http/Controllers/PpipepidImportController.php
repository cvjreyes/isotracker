<?php

namespace App\Http\Controllers;


use App\Ppipe_pid;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class PpipepidImportController extends Controller
{
   public function importppipepid()
    {
     
     DB::table('ppipe_pids')->truncate();

     Excel::load('catalogos\ppipes_pid.csv', function($reader) {
 
     foreach ($reader->get() as $ppipepid) {
     Ppipe_pid::create([
     'name' => $ppipepid->name,
     'percentage' =>$ppipepid->percentage
        ]);
    }

 });
return Ppipe_pid::all();

    }


}
