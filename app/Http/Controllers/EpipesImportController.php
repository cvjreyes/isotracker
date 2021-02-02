<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Epipesnew;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class EpipesImportController extends Controller
{
    public function importepipe()
    {
     
        DB::table('epipesnews')->truncate();

     Excel::load('estimated\epipes.xlsx', function($reader) {


 
     foreach ($reader->get() as $epipe) {

        /* CONVERTIR A id LOS CATÁLOGOS */

        //$units_id = DB::select("SELECT id FROM units WHERE name="."'".$eequi->unit."'");
        $areas_id = DB::select("SELECT id FROM areas WHERE name="."'".$epipe->area."'");  
        $tpipes_id = DB::select("SELECT id FROM tpipes WHERE code="."'".$epipe->type."'"); 

        /*FIN DE CONVERSIÓN*/

        

echo $epipe->type;

     Epipesnew::create([
     'areas_id' => $areas_id[0]->id,
     'tpipes_id' => $tpipes_id[0]->id,
     'qty' => $epipe->qty,
        ]);
    }
   
 });
//return Eequisnew::all();


    }

}
