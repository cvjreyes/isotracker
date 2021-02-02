<?php
namespace App\Http\Controllers;


use App\Dinst;
use App\Dinstsnew;
use App\Hinst;
use App\Hdinst;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DinstImportController extends Controller
{
   


   public function importdinst()
    {
        
     

      // // HISTORIAL PROGRESO instPOS TOTAL

      //   $start_week = DB::select("SELECT startweek FROM pmanagers WHERE name = 'inst'");

      //   $start_week = $start_week[0]->startweek; // Semana de inicio de la curva, viene de Pmanager

      //   $hinsts_total = DB::select("SELECT CURDATE() AS date, 'TOTAL' AS area, SUM(total_progress) AS progress FROM pinsts_view");
      //   $progress_inst = DB::select("SELECT DISTINCT total_pinsthours FROM total_pinsts_view"); 

      //   $current_date = date('Y-m-d'); // Para echar una semana atrás

      //   if (!is_null($progress_inst[0]->total_pinsthours)){ // valido existencia de progreso, si no hay es que pertenece a la carga inicial por lo que no inserta en historia


      //       $sweek_validate = DB::select("SELECT * FROM hinsts WHERE area='TOTAL'"); 


      //           if(count($sweek_validate)==0){ // Este proceso solo se realiza la primera vez y es para cargar campos dummy en la curva


      //             for ($i = 1; $i <= ($start_week-1); $i++) {
      //                 DB::table('hinsts')->insert([
      //                   'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),// Para echar una semana atrás
      //                   'area' =>'TOTAL',
      //                   'progress' =>0,

      //                 ]);
      //             }

      //           } // fin proceso


                


      //             foreach ($hinsts_total as $hinsts_totals) {
      //                  DB::table('hinsts')->insert([
      //                   'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),// Para echar una semana atrás
      //                   'area' =>$hinsts_totals->area,
      //                   'progress' =>$hinsts_totals->progress,

      //                 ]);
      //                }


      // // HISTORIAL PROGRESO instPOS POR AREA               

      //         $units=DB::select("SELECT DISTINCT units_id FROM pinsts_view");
      //          foreach ($units as $unitss) {

      //            DB::statement(DB::raw("SET @area_id=".$unitss->units_id));

      //            $hinsts_area = DB::select("SELECT DISTINCT CURDATE() AS date, (SELECT units.name FROM units WHERE units.id=@area_id) as area, ((SELECT SUM(total_progress_area) FROM pinsts_view WHERE units_id=@area_id)*100) as progress  FROM pinsts_view;");


      //                  foreach ($hinsts_area as $hinsts_areas) {
      //                  DB::table('hinsts')->insert([
      //                   'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),// Para echar una semana atrás
      //                   'area' =>$hinsts_areas->area,
      //                   'progress' =>$hinsts_areas->progress,

      //                 ]);
      //                }
      //         }

      //       }

      //   //}


       
        
         DB::table('dinstsnews')->truncate();

      Excel::load('e3dreports\StatusReport-Inst.csv', function($reader) {
      

        

 
      foreach ($reader->get() as $dinst) {

        if($dinst->progress){
         
         $progress = DB::select("SELECT * FROM pinsts WHERE percentage=".$dinst->progress);
         $progress= $progress[0]->percentage; 
         $progress_id= $progress[0]->id; 

         }else{

          $progress=0;

         }

         if($dinst->unit){
         
         $units_id = DB::select("SELECT id FROM units WHERE name="."'".$dinst->unit."'");
         $units_id = $units_id[0]->id;

         }else{


         $units_id=0;   

         }

          // CUSTOM PARA IQOXE
         // $areas_id = DB::select("SELECT id FROM areas WHERE name="."'".$dinst->area."'");
         // $areas_id = $areas_id[0]->id; 

        if ((strlen(strstr($dinst->area,'30'))>0) OR (strlen(strstr($dinst->area,'63'))>0)) { 

          $areas_id=0;  

        }else{

          $areas_id=1;

        }

         // FIN CUSTOM  

         $tinsts_id = DB::select("SELECT id FROM tinsts WHERE code="."'".$dinst->type."'");
         

         if(count($tinsts_id)==0) {

          $tinsts_id=999;

         }else{

          $tinsts_id = $tinsts_id[0]->id;

         }

         $pinsts_id = DB::select("SELECT id FROM pinsts WHERE percentage=".$dinst->progress);
         $pinsts_id = $pinsts_id[0]->id;

         echo $dinst->area."-";

      
      Dinstsnew::create([
        'units_id' =>$units_id,
        'areas_id' =>$areas_id,
        'tinsts_id' =>$tinsts_id,
        'tag' =>$dinst->tag,
        'pinsts_id' =>$pinsts_id,
         ]);
     
   
      

     }


     // Gráfica de progreso

      //  Se comprueba el peso deseado (BUDGET/AREAS)
                $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='inst'");

                    if ($weight_total[0]->weight_total==0){

                        $total_weight= DB::select("SELECT SUM(weight*qty) AS weight FROM einstsfullview;");

                    }else{

                        $total_weight= DB::select("SELECT weight FROM pmanagers WHERE name='inst'");

                    }
                // FIN DE LA COMPROBACIÓN (BUDGET/AREAS) 

      if ($total_weight[0]->weight!=0) {

         $total_progress = DB::select("SELECT SUM((weight*progress)/".$total_weight[0]->weight.") as total_progress FROM dinstsfullview;");
         $total_progress=$total_progress[0]->total_progress;

      }else{

         $total_progress = 0;

      }

     $week = DB::select("SELECT COUNT(*)+1 AS week FROM hinsts");
     $week = $week[0]->week; 

     Hinst::create([
      
           'week' =>$week,
           'date' =>date('Y-m-d'),
           'area' => 'TOTAL', 
           'progress' =>$total_progress,

           ]);

 });
             
 return Dinstsnew::all();
    }

}
