<?php

namespace App\Http\Controllers;


use App\Mcivil;
use App\Hcivil;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class McivilImportController extends Controller
{
   public function importmcivil()
    {

            /*UPDATE al campo milestone de la tabla 'hcivils' según sea hito o no (1 ó 0)*/

             $date_progress = DB::select("SELECT * from hcivils");

                 foreach ($date_progress as $date_progressss) {

                    $milestone_date = DB::select("SELECT date from mcivils where date='".$date_progressss->date."'");

                        if (count($milestone_date)>0) {

                            DB::table('hcivils')->where('id', $date_progressss->id)->update(array('milestone' => 1));

                        }else{

                            DB::table('hcivils')->where('id', $date_progressss->id)->update(array('milestone' => 0));    

                        }

                    
                    } 


     
        DB::table('mcivils')->truncate();

     Excel::load('estimated\mcivils.csv', function($reader) {
 
     foreach ($reader->get() as $mcivil) {
     Mcivil::create([
     'id' => $mcivil->id,
     'date' => $mcivil->date,
     'quantity' => $mcivil->quantity,
        ]);
    }

 });
return Mcivil::all();

    }


}
