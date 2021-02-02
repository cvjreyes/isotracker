<?php

namespace App\Http\Controllers;


use App\Melec;
use App\Helec;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class MelecImportController extends Controller
{
   public function importmelec()
    {

            /*UPDATE al campo milestone de la tabla 'helecs' según sea hito o no (1 ó 0)*/

             $date_progress = DB::select("SELECT * from helecs");

                 foreach ($date_progress as $date_progressss) {

                    $milestone_date = DB::select("SELECT date from melecs where date='".$date_progressss->date."'");

                        if (count($milestone_date)>0) {

                            DB::table('helecs')->where('id', $date_progressss->id)->update(array('milestone' => 1));

                        }else{

                            DB::table('helecs')->where('id', $date_progressss->id)->update(array('milestone' => 0));    

                        }

                    
                    } 


     
        DB::table('melecs')->truncate();

     Excel::load('estimated\melecs.csv', function($reader) {
 
     foreach ($reader->get() as $melec) {
     Melec::create([
     'id' => $melec->id,
     'date' => $melec->date,
     'quantity' => $melec->quantity,
        ]);
    }

 });
return Melec::all();

    }


}
