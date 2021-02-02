<?php

namespace App\Http\Controllers;


use App\Eelecsnew;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class EelecImportController extends Controller
{
   public function importeelec()
    {
     
        DB::table('eelecsnews')->truncate();

     Excel::load('estimated\eelecs.xlsx', function($reader) {


 
     foreach ($reader->get() as $eelec) {

        /* CONVERTIR A id LOS CATÁLOGOS */

        //$units_id = DB::select("SELECT id FROM units WHERE name="."'".$eelec->unit."'");
        $areas_id = DB::select("SELECT id FROM areas WHERE name="."'".$eelec->area."'");  
        $telecs_id = DB::select("SELECT id FROM telecs WHERE name="."'".$eelec->type."'"); 

        /*FIN DE CONVERSIÓN*/

        

echo $eelec->type;

     Eelecsnew::create([
     'areas_id' => $areas_id[0]->id,
     'telecs_id' => $telecs_id[0]->id,
     'qty' => $eelec->qty,
        ]);
    }
   
 });
//return Eelecsnew::all();


    }


}
