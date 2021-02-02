<?php

namespace App\Http\Controllers;


use App\Ecivilsnew;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class EcivilImportController extends Controller
{
   public function importecivil()
    {
     
        DB::table('ecivilsnews')->truncate();

     Excel::load('estimated\ecivils.xlsx', function($reader) {


 
     foreach ($reader->get() as $ecivil) {

        /* CONVERTIR A id LOS CATÁLOGOS */

        //$units_id = DB::select("SELECT id FROM units WHERE name="."'".$ecivil->unit."'");
        $areas_id = DB::select("SELECT id FROM areas WHERE name="."'".$ecivil->area."'");  
        $tcivils_id = DB::select("SELECT id FROM tcivils WHERE name="."'".$ecivil->type."'"); 

        /*FIN DE CONVERSIÓN*/

        

echo $ecivil->type;

     Ecivilsnew::create([
     'areas_id' => $areas_id[0]->id,
     'tcivils_id' => $tcivils_id[0]->id,
     'qty' => $ecivil->qty,
        ]);
    }
   
 });
//return Ecivilsnew::all();


    }


}
