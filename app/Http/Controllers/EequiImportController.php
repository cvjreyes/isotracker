<?php

namespace App\Http\Controllers;


use App\Eequisnew;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class EequiImportController extends Controller
{
   public function importeequi()
    {
     
        DB::table('eequisnews')->truncate();

     Excel::load('estimated\eequis.xlsx', function($reader) {


 
     foreach ($reader->get() as $eequi) {

        /* CONVERTIR A id LOS CATÁLOGOS */

        //$units_id = DB::select("SELECT id FROM units WHERE name="."'".$eequi->unit."'");
        $areas_id = DB::select("SELECT id FROM areas WHERE name="."'".$eequi->area."'");  
        $tequis_id = DB::select("SELECT id FROM tequis WHERE name="."'".$eequi->type."'"); 

        /*FIN DE CONVERSIÓN*/

        

echo $eequi->area;

     Eequisnew::create([
     'areas_id' => $areas_id[0]->id,
     'tequis_id' => $tequis_id[0]->id,
     'qty' => $eequi->qty,
        ]);
    }
   
 });
//return Eequisnew::all();


    }


}
