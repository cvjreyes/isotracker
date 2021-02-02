<?php
namespace App\Http\Controllers;


use App\Dcivil;
use App\Dcivilsnew;
use App\Hcivil;
use App\Hdcivil;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DcivilImportController extends Controller
{
   


   public function importdcivil()
    {
        
     

      // // HISTORIAL PROGRESO civilPOS TOTAL

      //   $start_week = DB::select("SELECT startweek FROM pmanagers WHERE name = 'civil'");

      //   $start_week = $start_week[0]->startweek; // Semana de inicio de la curva, viene de Pmanager

      //   $hcivils_total = DB::select("SELECT CURDATE() AS date, 'TOTAL' AS area, SUM(total_progress) AS progress FROM pcivils_view");
      //   $progress_civil = DB::select("SELECT DISTINCT total_pcivilhours FROM total_pcivils_view"); 

      //   $current_date = date('Y-m-d'); // Para echar una semana atrás

      //   if (!is_null($progress_civil[0]->total_pcivilhours)){ // valido existencia de progreso, si no hay es que pertenece a la carga inicial por lo que no inserta en historia


      //       $sweek_validate = DB::select("SELECT * FROM hcivils WHERE area='TOTAL'"); 


      //           if(count($sweek_validate)==0){ // Este proceso solo se realiza la primera vez y es para cargar campos dummy en la curva


      //             for ($i = 1; $i <= ($start_week-1); $i++) {
      //                 DB::table('hcivils')->insert([
      //                   'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),// Para echar una semana atrás
      //                   'area' =>'TOTAL',
      //                   'progress' =>0,

      //                 ]);
      //             }

      //           } // fin proceso


                


      //             foreach ($hcivils_total as $hcivils_totals) {
      //                  DB::table('hcivils')->insert([
      //                   'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),// Para echar una semana atrás
      //                   'area' =>$hcivils_totals->area,
      //                   'progress' =>$hcivils_totals->progress,

      //                 ]);
      //                }


      // // HISTORIAL PROGRESO civilPOS POR AREA               

      //         $units=DB::select("SELECT DISTINCT units_id FROM pcivils_view");
      //          foreach ($units as $unitss) {

      //            DB::statement(DB::raw("SET @area_id=".$unitss->units_id));

      //            $hcivils_area = DB::select("SELECT DISTINCT CURDATE() AS date, (SELECT units.name FROM units WHERE units.id=@area_id) as area, ((SELECT SUM(total_progress_area) FROM pcivils_view WHERE units_id=@area_id)*100) as progress  FROM pcivils_view;");


      //                  foreach ($hcivils_area as $hcivils_areas) {
      //                  DB::table('hcivils')->insert([
      //                   'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),// Para echar una semana atrás
      //                   'area' =>$hcivils_areas->area,
      //                   'progress' =>$hcivils_areas->progress,

      //                 ]);
      //                }
      //         }

      //       }

      //   //}


       
        
         DB::table('dcivilsnews')->truncate();

      Excel::load('e3dreports\StatusReport-Civil.csv', function($reader) {
      

        

 
      foreach ($reader->get() as $dcivil) {

        if($dcivil->progress){
         
         $progress = DB::select("SELECT * FROM pcivils WHERE percentage=".$dcivil->progress);
         $progress= $progress[0]->percentage; 
         $progress_id= $progress[0]->id; 

         }else{

          $progress=0;

         }

         if($dcivil->unit){
         
         $units_id = DB::select("SELECT id FROM units WHERE name="."'".$dcivil->unit."'");
         $units_id = $units_id[0]->id;

         }else{


         $units_id=0;   

         }

         // CUSTOM PARA IQOXE
         // $areas_id = DB::select("SELECT id FROM areas WHERE name="."'".$dcivil->area."'");
         // $areas_id = $areas_id[0]->id; 

        if ((strlen(strstr($dcivil->area,'30'))>0) OR (strlen(strstr($dcivil->area,'63'))>0)) { 

          $areas_id=0;  

        }else{

          $areas_id=1;

        }

         // FIN CUSTOM  

         $tcivils_id = DB::select("SELECT id FROM tcivils WHERE code="."'".$dcivil->type."'");
         

         if(count($tcivils_id)==0) {

          $tcivils_id=999;

         }else{

          $tcivils_id = $tcivils_id[0]->id;

         }

         $pcivils_id = DB::select("SELECT id FROM pcivils WHERE percentage=".$dcivil->progress);
         $pcivils_id = $pcivils_id[0]->id;

         echo $dcivil->area."-";
      
      Dcivilsnew::create([
        'units_id' =>$units_id,
        'areas_id' =>$areas_id,
        'tcivils_id' =>$tcivils_id,
        'tag' =>$dcivil->tag,
        'pcivils_id' =>$pcivils_id,
         ]);
     
   
      

     }


     // Gráfica de progreso

      //  Se comprueba el peso deseado (BUDGET/AREAS)
                $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='civil'");

                    if ($weight_total[0]->weight_total==0){

                        $total_weight= DB::select("SELECT SUM(weight*qty) AS weight FROM ecivilsfullview;");

                    }else{

                        $total_weight= DB::select("SELECT weight FROM pmanagers WHERE name='civil'");

                    }
                // FIN DE LA COMPROBACIÓN (BUDGET/AREAS) 

      if ($total_weight[0]->weight!=0) {

         $total_progress = DB::select("SELECT SUM((weight*progress)/".$total_weight[0]->weight.") as total_progress FROM dcivilsfullview;");
         $total_progress=$total_progress[0]->total_progress;

      }else{

         $total_progress = 0;

      }

    $week = DB::select("SELECT COUNT(*)+1 AS week FROM hcivils");
     $week = $week[0]->week; 

     Hcivil::create([
      
           'week' =>$week,
           'date' =>date('Y-m-d'),
           'area' => 'TOTAL', 
           'progress' =>$total_progress,

           ]);

 });
             
 return Dcivilsnew::all();
    }

}
