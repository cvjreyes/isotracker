<?php

namespace App\Http\Controllers;


use App\Einstsnew;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class EinstImportController extends Controller
{
   public function importeinst()
    {
     
        DB::table('einstsnews')->truncate();

     Excel::load('estimated\einsts.xlsx', function($reader) {


 
     foreach ($reader->get() as $einst) {

        /* CONVERTIR A id LOS CATÁLOGOS */

        //$units_id = DB::select("SELECT id FROM units WHERE name="."'".$einst->unit."'");
        $areas_id = DB::select("SELECT id FROM areas WHERE name="."'".$einst->area."'");  
        $tinsts_id = DB::select("SELECT id FROM tinsts WHERE name="."'".$einst->type."'"); 

        /*FIN DE CONVERSIÓN*/

      

echo $einst->type;

     Einstsnew::create([
     'areas_id' => $areas_id[0]->id,
     'tinsts_id' => $tinsts_id[0]->id,
     'qty' => $einst->qty,
        ]);
    }
   
 });


//return Einstsnew::all();


    }


}
