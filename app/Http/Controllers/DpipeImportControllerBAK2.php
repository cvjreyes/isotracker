<?php

namespace App\Http\Controllers;


// use App\Dpipe;
use App\Dpipesnew;
use App\Hpipe;
// use App\Hdpipe;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DpipeImportController extends Controller
{
   public function importdpipe()
    {

     DB::table('dpipesnews')->truncate();

     // Excel::selectSheets('Sheet1')->load('e3dreports\StatusReport-Pipes_template.xlsx', function($reader) {
       Excel::load('e3dreports\StatusReport-Pipes.csv', function($reader) {


      foreach ($reader->get() as $dpipe) {

        if($dpipe->unit){
         
         $unit = DB::select("SELECT id FROM units WHERE name="."'".$dpipe->unit."'");
         $unit = $unit[0]->id; 

         }else{

          $unit = 0;
            
         }

          // CUSTOM PARA IQOXE
        //   if($dpipe->area){
         
        //  $area = DB::select("SELECT id FROM areas WHERE name="."'".$dpipe->area."'");
        //  $area = $area[0]->id; 

        // }

        if ((strlen(strstr($dpipe->area,'30'))>0) OR (strlen(strstr($dpipe->area,'63'))>0)) { 

          $area=0;  

        }else{

          $area=1;

        }

         // FIN CUSTOM  

       

        $tag = $dpipe->tag;

        if($dpipe->diameter){
         
         $diameter = DB::select("SELECT id FROM diameters WHERE dn=".$dpipe->diameter);
         $diameter = $diameter[0]->id; 

        }

        if($dpipe->calc_notes=='unset'){
         
         $calc_notes = 0; 

        }else{

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

        echo $dpipe->area."-";

     Dpipesnew::create([
     //'zone_name' => $dpipe->zone_name,
     //'pipe_name' =>$dpipe->pipe_name,
     'units_id' =>$unit,
     'areas_id' => $area,
     'tag' => $dpipe->tag,
     'diameters_id' =>$diameter,
     'calc_notes' =>$calc_notes,
     'ppipe_pids_id' =>$pid,
     'ppipe_isos_id' =>$iso,
     'ppipe_stresses_id' =>$stress,
     'ppipe_supports_id' =>$support
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

     //  Se comprueba el peso deseado (BUDGET/AREAS)
                $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='pipe'");

                    if ($weight_total[0]->weight_total==0){

                        $total_weight= DB::select("SELECT SUM(weight*qty) AS weight FROM epipesfullview;");

                    }else{

                        $total_weight= DB::select("SELECT weight FROM pmanagers WHERE name='pipe'");

                    }
                // FIN DE LA COMPROBACIÓN (BUDGET/AREAS)    

  $sub_total_progress = DB::select("SELECT (SUM((pid*w_pid)+(iso*w_iso)+(stress*w_stress)+(support*w_support))) as  sub_total_progress 
                                                            FROM dpipesfullview");

  $total_progress = ceil(($sub_total_progress[0]->sub_total_progress)/$total_weight[0]->weight);
                                                

    $week = DB::select("SELECT COUNT(*)+1 AS week FROM hpipes");
    $week = $week[0]->week;                            

     Hpipe::create([
      
     'week' =>$week,
     'date' =>date('Y-m-d'),
     'area' => 'TOTAL', 
     'progress' =>$total_progress,

     ]);
 });
 return Dpipesnew::all();
    }
}