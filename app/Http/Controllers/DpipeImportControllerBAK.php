<?php

namespace App\Http\Controllers;


// use App\Dpipe;
use App\Dpipesnew;
// use App\Hdpipe;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DpipeImportController extends Controller
{
   public function importdpipe()
    {


         // HISTORIAL PROGRESO TUBERIAS TOTAL

        //   $start_week = DB::select("SELECT startweek FROM pmanagers WHERE name = 'pipe'");

        // $start_week = $start_week[0]->startweek; // Semana de inicio de la curva, viene de Pmanager

        //   $progress_pipe = DB::select("SELECT total_ppipehours FROM total_ppipes_view"); //para validar si es primera carga

        // $current_date = date('Y-m-d'); // Para echar una semana atrás

        // if (!is_null($progress_pipe[0]->total_ppipehours)){ // valido existencia de progreso, si no hay es que pertenece a la carga inicial por lo que no inserta en historia

        //   $sweek_validate = DB::select("SELECT * FROM hpipes WHERE area='TOTAL'"); 


        //         if(count($sweek_validate)==0){ // Este proceso solo se realiza la primera vez y es para cargar campos dummy en la curva


        //           for ($i = 1; $i <= ($start_week-1); $i++) {
        //               DB::table('hpipes')->insert([
        //                 'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),
        //                 'area' =>'TOTAL',
        //                 'progress' =>0,

        //               ]);
        //           }

        //         } // fin proceso


        //    $sum_per_pipe = DB::select("SELECT * FROM total_ppipes_view"); 
        //  $budget = DB::select("SELECT weight FROM pmanagers WHERE name='pipe'");
        //  $sum_per_epipe = DB::select("SELECT SUM(hours) as ehrspipes FROM pipesview");

        //  $ehrspipes = $sum_per_epipe[0]->ehrspipes;
        //  $total_progress = round((($sum_per_pipe[0]->total_ppipehours)/($sum_per_pipe[0]->total_epipehours))*100,2);

        // $hpipes_total = DB::select("SELECT DISTINCT CURDATE() AS date, 'TOTAL' AS area FROM ppipes_view");

        //           foreach ($hpipes_total as $hpipes_totals) {
        //                DB::table('hpipes')->insert([
        //                 'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),
        //                 'area' =>$hpipes_totals->area,
        //                 'progress' =>$total_progress,

        //               ]);
        //              }


      // HISTORIAL PROGRESO TUBERIAS POR AREA 

        // $units = DB::select("SELECT name FROM units");


        // foreach ($units as $unitss){

        //     $ppipes = DB::select("SELECT SUM(hours) AS epipeshours_area,SUM(ppipehours) as ppipeshours_area FROM ppipes_area WHERE area="."'".$unitss->name."'");

        //     $epipeshours_area= DB::select("SELECT SUM(hours) as hours FROM pipesview WHERE area="."'".$unitss->name."'"); //total de horas por area

        //                     if ($ppipes[0]->epipeshours_area <>0){ 

        //                         $total_progress = (($ppipes[0]->ppipeshours_area)/($epipeshours_area[0]->hours))*100; 

        //                        //$total_progress = (($ppipes[0]->ppipeshours_area)/($ppipes[0]->epipeshours_area))*100;
        //                        $hpipes_total = DB::select("SELECT DISTINCT CURDATE() AS date FROM ppipes_view");  

        //                             DB::table('hpipes')->insert([
        //                         'date' =>date('Y-m-d',strtotime($current_date."- 1 week")),
        //                         'area' =>$unitss->name,
        //                         'progress' =>$total_progress,

        //                       ]); 

        //                     } 

        // }    

      }          

          

     DB::table('dpipesnew')->truncate();

     // Excel::selectSheets('Sheet1')->load('e3dreports\StatusReport-Pipes_template.xlsx', function($reader) {
       Excel::load('e3dreports\StatusReport-Pipes_template.xlsx', function($reader) {


      foreach ($reader->get() as $dpipe) {

        if($dpipe->unit){
         
         $unit = DB::select("SELECT id FROM units WHERE name=".$dpipe->unit);
         $unit = $unit[0]->id; 

         }

        if($dpipe->area){
         
         $area = DB::select("SELECT id FROM areas WHERE name=".$dpipe->area);
         $area = $area[0]->id; 

        }

        $tag = $dpipe->tag;

        if($dpipe->diameter){
         
         $diameter = DB::select("SELECT id FROM diameters WHERE nps=".$dpipe->diameter);
         $diameter = $diameter[0]->id; 

        }

        if($dpipe->calc_notes){
         
         $calc_notes = 1; 

        }


        if($dpipe->pid){
         
         $pid = DB::select("SELECT percentage FROM ppipe_pids WHERE percentage=".$dpipe->pid);
         $pid= $pid[0]->percentage; 

         }else{

          $pid=0;

         }

         if($dpipe->iso){
         
         $iso = DB::select("SELECT percentage FROM ppipe_isos WHERE percentage=".$dpipe->iso);
         $iso= $iso[0]->percentage; 

         }else{

          $iso=0;

         } 

         if($dpipe->stress){
         
         $stress = DB::select("SELECT percentage FROM ppipe_stresses WHERE percentage=".$dpipe->stress);
         $stress= $stress[0]->percentage; 

         }else{

          $stress=0;

         }

         if($dpipe->support){
         
         $support = DB::select("SELECT percentage FROM ppipe_supports WHERE percentage=".$dpipe->support);
         $support= $support[0]->percentage; 

         }else{

          $support=0;

         } 

 

     Dpipesnew::create([
     //'zone_name' => $dpipe->zone_name,
     //'pipe_name' =>$dpipe->pipe_name,
     'pid' =>$pid,
     'iso' => $iso,
     'stress' =>$stress,
     'support' =>$support,
     'pdms_linenumber' => $dpipe->pdms_linenumber
     ]);

     // Dpipe::create([
     // //'zone_name' => $dpipe->zone_name,
     // //'pipe_name' =>$dpipe->pipe_name,
     // 'pid' =>$pid,
     // 'iso' => $iso,
     // 'stress' =>$stress,
     // 'support' =>$support,
     // 'pdms_linenumber' => $dpipe->pdms_linenumber
     // ]);
       
     // Hdpipe::create([
     // 'date' =>date('Y-m-d'), 
     // 'pid' =>$pid,
     // 'iso' => $iso,
     // 'stress' =>$stress,
     // 'support' =>$support,
     // 'pdms_linenumber' => $dpipe->pdms_linenumber
     // ]);
      
    } 
 });
 return Dpipe::all();
    }
}