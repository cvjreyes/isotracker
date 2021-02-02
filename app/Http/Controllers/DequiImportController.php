<?php
namespace App\Http\Controllers;


use App\Dequi;
use App\Dequisnew;
use App\Hequi;
use App\Hdequi;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DequiImportController extends Controller
{
   


   public function importdequi()
    {
        
     

      // // HISTORIAL PROGRESO EQUIPOS TOTAL

      //   $start_week = DB::select("SELECT startweek FROM pmanagers WHERE name = 'equi'");

      //   $start_week = $start_week[0]->startweek; // Semana de inicio de la curva, viene de Pmanager

      //   $hequis_total = DB::select("SELECT CURDATE() AS date, 'TOTAL' AS area, SUM(total_progress) AS progress FROM pequis_view");
      //   $progress_equi = DB::select("SELECT DISTINCT total_pequihours FROM total_pequis_view"); 

      //   $current_date = date('Y-m-d'); // Para echar una semana atrás

      //   if (!is_null($progress_equi[0]->total_pequihours)){ // valido existencia de progreso, si no hay es que pertenece a la carga inicial por lo que no inserta en historia


      //       $sweek_validate = DB::select("SELECT * FROM hequis WHERE area='TOTAL'"); 


      //           if(count($sweek_validate)==0){ // Este proceso solo se realiza la primera vez y es para cargar campos dummy en la curva


      //             for ($i = 1; $i <= ($start_week-1); $i++) {
      //                 DB::table('hequis')->insert([
      //                   'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),// Para echar una semana atrás
      //                   'area' =>'TOTAL',
      //                   'progress' =>0,

      //                 ]);
      //             }

      //           } // fin proceso


                


      //             foreach ($hequis_total as $hequis_totals) {
      //                  DB::table('hequis')->insert([
      //                   'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),// Para echar una semana atrás
      //                   'area' =>$hequis_totals->area,
      //                   'progress' =>$hequis_totals->progress,

      //                 ]);
      //                }


      // // HISTORIAL PROGRESO EQUIPOS POR AREA               

      //         $units=DB::select("SELECT DISTINCT units_id FROM pequis_view");
      //          foreach ($units as $unitss) {

      //            DB::statement(DB::raw("SET @area_id=".$unitss->units_id));

      //            $hequis_area = DB::select("SELECT DISTINCT CURDATE() AS date, (SELECT units.name FROM units WHERE units.id=@area_id) as area, ((SELECT SUM(total_progress_area) FROM pequis_view WHERE units_id=@area_id)*100) as progress  FROM pequis_view;");


      //                  foreach ($hequis_area as $hequis_areas) {
      //                  DB::table('hequis')->insert([
      //                   'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),// Para echar una semana atrás
      //                   'area' =>$hequis_areas->area,
      //                   'progress' =>$hequis_areas->progress,

      //                 ]);
      //                }
      //         }

      //       }

      //   //}


       
        
         DB::table('dequisnews')->truncate();

      Excel::load('e3dreports\StatusReport-Equi.csv', function($reader) {
      

        

 
      foreach ($reader->get() as $dequi) {

        if($dequi->progress){
         
         $progress = DB::select("SELECT * FROM pequis WHERE percentage=".$dequi->progress);
         $progress= $progress[0]->percentage; 
         $progress_id= $progress[0]->id; 

         }else{

          $progress=0;

         }

         if($dequi->unit){
         
         $units_id = DB::select("SELECT id FROM units WHERE name="."'".$dequi->unit."'");
         $units_id = $units_id[0]->id;

         }else{


         $units_id=0;   

         }

         // CUSTOM PARA IQOXE
         // $areas_id = DB::select("SELECT id FROM areas WHERE name="."'".$dequi->area."'");
         // $areas_id = $areas_id[0]->id; 

        if ((strlen(strstr($dequi->area,'30'))>0) OR (strlen(strstr($dequi->area,'63'))>0)) { 

          $areas_id=0;  

        }else{

          $areas_id=1;

        }

         // FIN CUSTOM  

         $tequis_id = DB::select("SELECT id FROM tequis WHERE code="."'".$dequi->type."'");
         

         if(count($tequis_id)==0) {

          $tequis_id=999;

         }else{

          $tequis_id = $tequis_id[0]->id;

         }

         $pequis_id = DB::select("SELECT id FROM pequis WHERE percentage=".$dequi->progress);
         $pequis_id = $pequis_id[0]->id;

         echo $dequi->area."-";

      
      Dequisnew::create([
        'units_id' =>$units_id,
        'areas_id' =>$areas_id,
        'tequis_id' =>$tequis_id,
        'tag' =>$dequi->tag,
        'pequis_id' =>$pequis_id,
         ]);
     
	 
      

     }


     // Gráfica de progreso

      //  Se comprueba el peso deseado (BUDGET/AREAS)
                $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='equi'");

                    if ($weight_total[0]->weight_total==0){

                        $total_weight= DB::select("SELECT SUM(weight*qty) AS weight FROM eequisfullview;");

                    }else{

                        $total_weight= DB::select("SELECT weight FROM pmanagers WHERE name='equi'");

                    }
                // FIN DE LA COMPROBACIÓN (BUDGET/AREAS) 

      if ($total_weight[0]->weight!=0) {

         $total_progress = DB::select("SELECT SUM((weight*progress)/".$total_weight[0]->weight.") as total_progress FROM dequisfullview;");
         $total_progress=$total_progress[0]->total_progress;

      }else{

         $total_progress = 0;

      }

     $week = DB::select("SELECT COUNT(*)+1 AS week FROM hequis");
     $week = $week[0]->week; 
     
     Hequi::create([
      
           'week' =>$week,
           'date' =>date('Y-m-d'),
           'area' => 'TOTAL', 
           'progress' =>$total_progress,

           ]);

 });
             
 return Dequisnew::all();
    }

}
