<?php
namespace App\Http\Controllers;


use App\Dequi;
use App\Hdequi;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DequiImportController extends Controller
{
   


   public function importdequi()
    {
        
     

      // HISTORIAL PROGRESO EQUIPOS TOTAL

        $start_week = DB::select("SELECT startweek FROM pmanagers WHERE name = 'equi'");

        $start_week = $start_week[0]->startweek; // Semana de inicio de la curva, viene de Pmanager

        $hequis_total = DB::select("SELECT CURDATE() AS date, 'TOTAL' AS area, SUM(total_progress) AS progress FROM pequis_view");
        $progress_equi = DB::select("SELECT total_pequihours FROM total_pequis_view"); 

        if (!is_null($progress_equi[0]->total_pequihours)){ // valido existencia de progreso, si no hay es que pertenece a la carga inicial por lo que no inserta en historia


            $sweek_validate = DB::select("SELECT * FROM hequis WHERE area='TOTAL'"); 


                if(count($sweek_validate)==0){ // Este proceso solo se realiza la primera vez y es para cargar campos dummy en la curva


                  for ($i = 1; $i <= ($start_week-1); $i++) {
                      DB::table('hequis')->insert([
                        'date' =>date('Y-m-d'),
                        'area' =>'TOTAL',
                        'progress' =>0,

                      ]);
                  }

                } // fin proceso

                  foreach ($hequis_total as $hequis_totals) {
                       DB::table('hequis')->insert([
                        'date' =>$hequis_totals->date,
                        'area' =>$hequis_totals->area,
                        'progress' =>$hequis_totals->progress,

                      ]);
                     }


      // HISTORIAL PROGRESO EQUIPOS POR AREA               

              $units=DB::select("SELECT DISTINCT units_id FROM pequis_view");
               foreach ($units as $unitss) {

                 DB::statement(DB::raw("SET @area_id=".$unitss->units_id));

                 $hequis_area = DB::select("SELECT DISTINCT CURDATE() AS date, (SELECT units.name FROM units WHERE units.id=@area_id) as area, ((SELECT SUM(total_progress_area) FROM pequis_view WHERE units_id=@area_id)*100) as progress  FROM pequis_view;");


                       foreach ($hequis_area as $hequis_areas) {
                       DB::table('hequis')->insert([
                        'date' =>$hequis_areas->date,
                        'area' =>$hequis_areas->area,
                        'progress' =>$hequis_areas->progress,

                      ]);
                     }
              }

            }

        //}


       
        
         DB::table('dequis')->truncate();

      Excel::selectSheets('Sheet1')->load('e3dreports\StatusReport-Equi.xls', function($reader) {
      

        

 
      foreach ($reader->get() as $dequi) {

        if($dequi->progress){
         
         $progress = DB::select("SELECT percentage FROM pequis WHERE name="."'".$dequi->progress."'");
         $progress= $progress[0]->percentage; 

         }else{

          $progress=0;

         } 


      Dequi::create([
      'tag' =>$dequi->tag,
      'progress' =>$progress
         ]);
     }
	 
	 foreach ($reader->get() as $hdequi) {
      Hdequi::create([
      'date' =>date('Y-m-d'),  
      'tag' =>$hdequi->tag,
      'progress' =>$progress
         ]);
     }

 });
             
 return Dequi::all();
    }

}
