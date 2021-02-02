<?php

namespace App\Http\Controllers;


use App\Epipe;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class EpipeImportController extends Controller
{

   public function importepipe()
    {

        /* DUPLICAR TABLA epipes PARA RESPALDAR calc_notes*/

        // DB::statement(DB::raw("CREATE TABLE epipes_temp SELECT * FROM epipes;"));
 
         /* LIMPIAR TABLA epipes*/
          DB::table('epipes')->truncate();



          /* INSERTAR NUEVA LISTA DE LINEAS EN epipes*/
     Excel::load('estimated\epipes2.xlsx', function($reader) {

     $flag=0;
     $err=0;
     $numline=0;
          
     foreach ($reader->get() as $epipe) {

        /* CONVERTIR A id LOS CATÁLOGOS */

        $units_id = DB::select("SELECT id FROM units WHERE name="."'".$epipe->unit."'");
        $areas_id = DB::select("SELECT id FROM areas WHERE name="."'".$epipe->area."'"); 
        /*$diameters_id = DB::select("SELECT id FROM diameters WHERE dn=".$epipe->diameter);*/ // milimeters
        $diameters_id = DB::select("SELECT id FROM diameters WHERE nps=".$epipe->diameter); // inches
        /*$fluids_id = DB::select("SELECT id FROM fluids WHERE code="."'".$epipe->fluid."'");*/
        /*$specs_id = DB::select("SELECT id FROM specs WHERE name="."'".$epipe->spec."'");*/

        /*FIN DE CONVERSIÓN*/

        /* VALIDAR QUE EXISTE DATO DE ENTRADA EN EL CATÁLOGO A TRAVÉS DE COUNT */

        $units_count = DB::select("SELECT COUNT(id) units_count FROM units WHERE name="."'".$epipe->unit."'");
        $areas_count = DB::select("SELECT COUNT(id) areas_count FROM areas  WHERE name="."'".$epipe->area."'");  
        /*$diameters_count = DB::select("SELECT COUNT(id) diameters_count FROM diameters WHERE dn=".$epipe->diameter);*/ // milimeters
        $diameters_count = DB::select("SELECT COUNT(id) diameters_count FROM diameters WHERE nps=".$epipe->diameter); // inches
        $fluids_count = DB::select("SELECT COUNT(id) fluids_count FROM fluids WHERE code="."'".$epipe->fluid."'");
        $specs_count = DB::select("SELECT COUNT(id) specs_count FROM specs WHERE name="."'".$epipe->spec."'");

         //echo "b ";


    //if (($units_count[0]->units_count != 0) AND ($diameters_count[0]->diameters_count != 0) AND ($fluids_count[0]->fluids_count != 0) AND ($specs_count[0]->specs_count != 0)){ // OJO NO BORRAR + PARA LISTA DE LÍNEAS COMPLETA***************


        if (($diameters_count[0]->diameters_count != 0) AND ($units_count[0]->units_count != 0) AND ($areas_count[0]->areas_count != 0)){


        /* FIN VALIDACIÓN EXISTENCIA */
        //echo "a ";
        $flag=$flag+1;

            if (is_null($epipe->pdms_linenumber)){

                $numline=$numline+1;
                $epipe->line_number = $numline;
                $epipe->pdms_linenumber = "Line-".$numline;

            }

                 Epipe::create([  
                 //'pdestination' => $epipe->pdestination,   
                 'units_id' => $units_id[0]->id, // NO BORRAR + PARA LISTA DE LÍNEAS COMPLETA***************
                 'areas_id' => $areas_id[0]->id,
                 //'section' => $epipe->section,
                 'diameters_id' => $diameters_id[0]->id,
                 //'fluids_id' => $fluids_id[0]->id,// NO BORRAR + PARA LISTA DE LÍNEAS COMPLETA***************
                 'line_number' => $epipe->line_number,
                 //'sec_number' => $epipe->sec_number,
                 //'specs_id' => $specs_id[0]->id,// NO BORRAR + PARA LISTA DE LÍNEAS COMPLETA***************
                 // 'loc_from' => $epipe->loc_from,
                 // 'loc_to' => $epipe->loc_to,
                 // 'flu_name' => $epipe->flu_name,
                 // 'flu_pha' => $epipe->flu_pha,
                 // 'density' => $epipe->density,
                 // 'oco_pressbar' => $epipe->oco_pressbar,
                 // 'oco_tempc' => $epipe->oco_tempc,
                 // 'dco_pressbar' => $epipe->dco_pressbar,
                 // 'dco_tempc' => $epipe->dco_tempc,
                 // 'oocoa_pressbar' => $epipe->oocoa_pressbar,
                 // 'oocoa_tempc' => $epipe->oocoa_tempc,
                 // 'oocob_pressbar' => $epipe->oocob_pressbar,
                 // 'oocob_tempc' => $epipe->oocob_tempc,
                 // 'dco_tflexc' => $epipe->dco_tflexc,
                 // 'wth_sch' => $epipe->wth_sch,
                 // 'wth_cormm' => $epipe->wth_cormm,
                 // 'ins_com' => $epipe->ins_lim,
                 // 'ins_thkmm' => $epipe->ins_thkmm,
                 // 'tra_size' => $epipe->tra_size,
                 // 'tra_num' => $epipe->tra_num,
                 // 'tmainc' => $epipe->tmainc,
                 // 'pca_tpset' => $epipe->pca_tpset,
                 // 'pca_altfg' => $epipe->pca_altfg,
                 // 'pca_man' => $epipe->pca_man,
                 // 'paint_a' => $epipe->paint_a,
                 // 'paint_b' => $epipe->paint_b,
                 // 'trp_typ' => $epipe->trp_typ,
                 // 'trp_minbarg' => $epipe->trp_minbarg,
                 // 'trp_maxbarg' => $epipe->trp_maxbarg,
                 // 'aut_pha' => $epipe->aut_pha,
                 // 'aut_grp' => $epipe->aut_grp,
                 // 'aut_cat' => $epipe->aut_cat,
                 // 'cancelled' => $epipe->cancelled,
                 // 'rev' => $epipe->rev,
                 // 'pid' => $epipe->pid,
                 // 'notes' => $epipe->notes,
                 'pdms_linenumber' => $epipe->pdms_linenumber,
                 // 'soumis' => $epipe->soumis,
                 // 'modification' => $epipe->modification,
                 // 'pwht' => $epipe->pwht,
                 // 'nacerequir' => $epipe->nacerequir,
                 // 'constcate' => $epipe->constcate,
                 // 'priority' => $epipe->priority,
                 // 'sftyacces' => $epipe->sftyacces,
                 // 'source' => $epipe->source,

        ]);



     }else{


         //Recupera las lineas con errores;
         $err=$err+1;
         $flag=$flag+1;
         echo $epipe->pdms_linenumber."-> "." unit: ".$units_count[0]->units_count." area: ".$areas_count[0]->areas_count." diameter: ".$diameters_count[0]->diameters_count." fluid: ".$fluids_count[0]->fluids_count." spec: ".$specs_count[0]->specs_count."<br>";

       


     }

    }

    //SI TODO ESTÁ CORRECTO, QUEDARÁ EN BLANCO

 });


    }


}
