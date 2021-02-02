<?php
namespace App\Http\Controllers;


use App\Delec;
use App\Delecsnew;
use App\Helec;
use App\Hdelec;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DelecImportController extends Controller
{
   


   public function importdelec()
    {
        
     

      // // HISTORIAL PROGRESO elecPOS TOTAL

      //   $start_week = DB::select("SELECT startweek FROM pmanagers WHERE name = 'elec'");

      //   $start_week = $start_week[0]->startweek; // Semana de inicio de la curva, viene de Pmanager

      //   $helecs_total = DB::select("SELECT CURDATE() AS date, 'TOTAL' AS area, SUM(total_progress) AS progress FROM pelecs_view");
      //   $progress_elec = DB::select("SELECT DISTINCT total_pelechours FROM total_pelecs_view"); 

      //   $current_date = date('Y-m-d'); // Para echar una semana atrás

      //   if (!is_null($progress_elec[0]->total_pelechours)){ // valido existencia de progreso, si no hay es que pertenece a la carga inicial por lo que no inserta en historia


      //       $sweek_validate = DB::select("SELECT * FROM helecs WHERE area='TOTAL'"); 


      //           if(count($sweek_validate)==0){ // Este proceso solo se realiza la primera vez y es para cargar campos dummy en la curva


      //             for ($i = 1; $i <= ($start_week-1); $i++) {
      //                 DB::table('helecs')->insert([
      //                   'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),// Para echar una semana atrás
      //                   'area' =>'TOTAL',
      //                   'progress' =>0,

      //                 ]);
      //             }

      //           } // fin proceso


                


      //             foreach ($helecs_total as $helecs_totals) {
      //                  DB::table('helecs')->insert([
      //                   'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),// Para echar una semana atrás
      //                   'area' =>$helecs_totals->area,
      //                   'progress' =>$helecs_totals->progress,

      //                 ]);
      //                }


      // // HISTORIAL PROGRESO elecPOS POR AREA               

      //         $units=DB::select("SELECT DISTINCT units_id FROM pelecs_view");
      //          foreach ($units as $unitss) {

      //            DB::statement(DB::raw("SET @area_id=".$unitss->units_id));

      //            $helecs_area = DB::select("SELECT DISTINCT CURDATE() AS date, (SELECT units.name FROM units WHERE units.id=@area_id) as area, ((SELECT SUM(total_progress_area) FROM pelecs_view WHERE units_id=@area_id)*100) as progress  FROM pelecs_view;");


      //                  foreach ($helecs_area as $helecs_areas) {
      //                  DB::table('helecs')->insert([
      //                   'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),// Para echar una semana atrás
      //                   'area' =>$helecs_areas->area,
      //                   'progress' =>$helecs_areas->progress,

      //                 ]);
      //                }
      //         }

      //       }

      //   //}


       
        
         DB::table('delecsnews')->truncate();

      Excel::load('e3dreports\StatusReport-Elec.csv', function($reader) {
      

        

 
      foreach ($reader->get() as $delec) {

        if($delec->progress){
         
         $progress = DB::select("SELECT * FROM pelecs WHERE percentage=".$delec->progress);
         $progress= $progress[0]->percentage; 
         $progress_id= $progress[0]->id; 

         }else{

          $progress=0;

         }

         if($delec->unit){
         
         $units_id = DB::select("SELECT id FROM units WHERE name="."'".$delec->unit."'");
         $units_id = $units_id[0]->id;

         }else{


         $units_id=0;   

         }

         // CUSTOM PARA IQOXE
         // $areas_id = DB::select("SELECT id FROM areas WHERE name="."'".$delec->area."'");
         // $areas_id = $areas_id[0]->id; 

        if ((strlen(strstr($delec->area,'30'))>0) OR (strlen(strstr($delec->area,'63'))>0)) { 

          $areas_id=0;  

        }else{

          $areas_id=1;

        }

         // FIN CUSTOM  

         $telecs_id = DB::select("SELECT id FROM telecs WHERE code="."'".$delec->type."'");
         

         if(count($telecs_id)==0) {

          $telecs_id=999;

         }else{

          $telecs_id = $telecs_id[0]->id;

         }

         $pelecs_id = DB::select("SELECT id FROM pelecs WHERE percentage=".$delec->progress);
         $pelecs_id = $pelecs_id[0]->id;

         echo $delec->area."-";
      
      Delecsnew::create([
        'units_id' =>$units_id,
        'areas_id' =>$areas_id,
        'telecs_id' =>$telecs_id,
        'tag' =>$delec->tag,
        'pelecs_id' =>$pelecs_id,
         ]);
     
   
      

     }


     // Gráfica de progreso

      //  Se comprueba el peso deseado (BUDGET/AREAS)
                $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='elec'");

                    if ($weight_total[0]->weight_total==0){

                        $total_weight= DB::select("SELECT SUM(weight*qty) AS weight FROM eelecsfullview;");

                    }else{

                        $total_weight= DB::select("SELECT weight FROM pmanagers WHERE name='elec'");

                    }
                // FIN DE LA COMPROBACIÓN (BUDGET/AREAS) 

      if ($total_weight[0]->weight!=0) {

         $total_progress = DB::select("SELECT SUM((weight*progress)/".$total_weight[0]->weight.") as total_progress FROM delecsfullview;");
         $total_progress=$total_progress[0]->total_progress;

      }else{

         $total_progress = 0;

      }

    $week = DB::select("SELECT COUNT(*)+1 AS week FROM helecs");
     $week = $week[0]->week; 

     Helec::create([
      
           'week' =>$week,
           'date' =>date('Y-m-d'),
           'area' => 'TOTAL', 
           'progress' =>$total_progress,

           ]);

 });
             
 return Delecsnew::all();
    }

}
