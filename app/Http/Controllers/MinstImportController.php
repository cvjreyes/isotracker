<?php

namespace App\Http\Controllers;


use App\Minst;
use App\Hinst;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class MinstImportController extends Controller
{
   public function importminst()
    {

            /*UPDATE al campo milestone de la tabla 'hinsts' según sea hito o no (1 ó 0)*/

             $date_progress = DB::select("SELECT * from hinsts");

                 foreach ($date_progress as $date_progressss) {

                    $milestone_date = DB::select("SELECT date from minsts where date='".$date_progressss->date."'");

                        if (count($milestone_date)>0) {

                            DB::table('hinsts')->where('id', $date_progressss->id)->update(array('milestone' => 1));

                        }else{

                            DB::table('hinsts')->where('id', $date_progressss->id)->update(array('milestone' => 0));    

                        }

                    
                    } 


     
        DB::table('minsts')->truncate();

     Excel::load('estimated\minsts.csv', function($reader) {
 
     foreach ($reader->get() as $minst) {
     Minst::create([
     'id' => $minst->id,
     'date' => $minst->date,
     'quantity' => $minst->quantity,
        ]);
    }

 });
return Minst::all();

    }


}
