<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Charts;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        // Weight de PIPING por filtro


           //FILTER PIPE QUERYS (HOURS)
                            $filterpipe = DB::select("SELECT * FROM filterpipes");
                            $countfilterpipe = DB::select("SELECT COUNT(*) as count FROM filterpipes");
                            $count=$countfilterpipe[0]->count;
                            $sum_per_epipe_1 = "SELECT SUM(`pipesview`.`hours`) as weight FROM `pipesview` ";
                            $sum_per_epipe_2 = "WHERE ";

                            for ($i = 0; $i < $count; $i++){

                                if($i < $count-1){

                                  if ($filterpipe[$i+1]->field=='area'){  

                                    $sum_per_epipe_2 = $sum_per_epipe_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."' OR ";
                                  }else{

                                    $sum_per_epipe_2 = $sum_per_epipe_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."' AND ";

                                  }  
    
                                }else{

                                    $sum_per_epipe_2 = $sum_per_epipe_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."'";

                                }

                            }

                            if ($count>0){
                                $sum_per_epipe=$sum_per_epipe_1.$sum_per_epipe_2;
                            }else{
                                $sum_per_epipe=$sum_per_epipe_1;
                            }


                            //$sum_per_epipe = DB::select($sum_per_epipe); 

                            //END FILTER PIPE QUERYS (HOURS)

                            //FILTER PIPE QUERYS (PROGRESS)

                                $sum_per_pipe_1 = "SELECT SUM(((`ppipes_view_bak`.`total_progress` * `ppipes_view_bak`.`hours`) / 100)) AS `total_ppipehours` FROM `ppipes_view_bak` "; 
                                $sum_per_pipe_2 = "WHERE ";

                                for ($i = 0; $i < $count; $i++){

                                if($i < $count-1){

                                    $sum_per_pipe_2 = $sum_per_pipe_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."' OR ";
    
                                }else{

                                    $sum_per_pipe_2 = $sum_per_pipe_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."'";

                                }

                                }

                                if ($count>0){
                                    $sum_per_pipe=$sum_per_pipe_1.$sum_per_pipe_2;
                                }else{
                                    $sum_per_pipe=$sum_per_pipe_1;
                                }

                                $weightpipe_wf = DB::select($sum_per_epipe); 
                                $weightpipe = DB::select($sum_per_epipe_1);


        // FIN Weight de PIPING por filtro

       //$sum_per_civil = DB::select("SELECT SUM(total_progress) as sum_per_civil FROM pcivils_view");
        
        //PIPING
            //  Se comprueba el peso deseado (BUDGET/AREAS)
                $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='pipe'");

                    if ($weight_total[0]->weight_total==0){

                        $weight_pipe= DB::select("SELECT SUM(weight*qty) AS weight FROM epipesfullview;");

                    }else{

                        $weight_pipe= DB::select("SELECT weight FROM pmanagers WHERE name='pipe'");

                    }
                // FIN DE LA COMPROBACIÓN (BUDGET/AREAS) 

         //FIN PIPING

        //EQUIPMENT
            //  Se comprueba el peso deseado (BUDGET/AREAS)
                $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='equi'");

                    if ($weight_total[0]->weight_total==0){

                        $weight_equi= DB::select("SELECT SUM(weight*qty) AS weight FROM eequisfullview;");

                    }else{

                        $weight_equi= DB::select("SELECT weight FROM pmanagers WHERE name='equi'");

                    }
                // FIN DE LA COMPROBACIÓN (BUDGET/AREAS) 

         //FIN EQUIPMENT 

         //CIVIL
            //  Se comprueba el peso deseado (BUDGET/AREAS)
                $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='civil'");

                    if ($weight_total[0]->weight_total==0){

                        $weight_civil= DB::select("SELECT SUM(weight*qty) AS weight FROM ecivilsfullview;");

                    }else{

                        $weight_civil= DB::select("SELECT weight FROM pmanagers WHERE name='civil'");

                    }
                // FIN DE LA COMPROBACIÓN (BUDGET/AREAS) 

         //FIN CIVIL

         //INSTRUMENT
            //  Se comprueba el peso deseado (BUDGET/AREAS)
                $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='inst'");

                    if ($weight_total[0]->weight_total==0){

                        $weight_inst= DB::select("SELECT SUM(weight*qty) AS weight FROM einstsfullview;");

                    }else{

                        $weight_inst= DB::select("SELECT weight FROM pmanagers WHERE name='inst'");

                    }
                // FIN DE LA COMPROBACIÓN (BUDGET/AREAS) 

         //FIN INSTRUMENTS 

         //ELECTRICAL
            //  Se comprueba el peso deseado (BUDGET/AREAS)
                $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='elect'");

                    if ($weight_total[0]->weight_total==0){

                        $weight_elec= DB::select("SELECT SUM(weight*qty) AS weight FROM eelecsfullview;");

                    }else{

                        $weight_elec= DB::select("SELECT weight FROM pmanagers WHERE name='elect'");

                    }
                // FIN DE LA COMPROBACIÓN (BUDGET/AREAS) 

         //FIN ELECTRICAL        

        if ($weight_equi[0]->weight==0){

            $weight_equi[0]->weight=1;

        }

        if ($weight_civil[0]->weight==0){

            $weight_civil[0]->weight=1;

        }

        if ($weight_inst[0]->weight==0){

            $weight_inst[0]->weight=1;

        }

        if (is_null($weight_elec[0]->weight)){

            $weight_elec[0]->weight=1;

        }

        if (is_null($weight_pipe[0]->weight)){

            $weight_pipe[0]->weight=1;

        }

        
        $weight_total = $weight_pipe[0]->weight + $weight_equi[0]->weight + $weight_civil[0]->weight + $weight_inst[0]->weight + $weight_elec[0]->weight;

        $sub_total_progress = DB::select("SELECT (SUM((pid*w_pid)+(iso*w_iso)+(stress*w_stress)+(support*w_support))) as  sub_total_progress FROM dpipesfullview");


        $sum_per_pipe = (($sub_total_progress[0]->sub_total_progress)/$weight_pipe[0]->weight);      

        $sum_per_equi = DB::select("SELECT SUM((weight*progress)/".$weight_equi[0]->weight.") as sum_per_equi FROM dequisfullview;");

        $sum_per_civil = DB::select("SELECT SUM((weight*progress)/".$weight_civil[0]->weight.") as sum_per_civil FROM dcivilsfullview;");

        $sum_per_inst = DB::select("SELECT SUM((weight*progress)/".$weight_inst[0]->weight.") as sum_per_inst FROM dinstsfullview;");

        $sum_per_elec = DB::select("SELECT SUM((weight*progress)/".$weight_elec[0]->weight.") as sum_per_elec FROM delecsfullview;");


        
        // Validación de tener progreso sin peso:

        if ($sum_per_pipe>100){

            $sum_per_pipe = 0;

        } 

        if (($sum_per_equi[0]->sum_per_equi)>100){

            $sum_per_equi[0]->sum_per_equi = 0;

        }

        if (($sum_per_civil[0]->sum_per_civil)>100){

            $sum_per_civil[0]->sum_per_civil = 0;

        }

        if (($sum_per_inst[0]->sum_per_inst)>100){

            $sum_per_inst[0]->sum_per_inst = 0;

        }

        if (($sum_per_elec[0]->sum_per_elec)>100){

            $sum_per_elec[0]->sum_per_elec = 0;

        }

        //Validación de tener progreso sin peso: 




        // SE COMPARA PARA VALIDAR LA EXISTENCIA DE FILTROS


        if (count(DB::select("SELECT * FROM filterpipes"))){

            $filter=1;

        }else{ 

            $filter=0;

        }

        // VALORES DE CURVA TOTAL DE PROGRESO
        DB::statement(DB::raw("SET @wpipe=(SELECT SUM(weight*qty) FROM epipesfullview);
                                    SET @wequi=(SELECT SUM(weight*qty) FROM eequisfullview);
                                    SET @wcivil=(SELECT SUM(weight*qty) FROM ecivilsfullview);
                                    SET @winst=(SELECT SUM(weight*qty) FROM einstsfullview);
                                    SET @welec=(SELECT SUM(weight*qty) FROM eelecsfullview);
                                    SET @wtotal=@wpipe+@wequi+@wcivil+@winst+@welec;
                                    SET @fpipe=@wpipe/@wtotal;
                                    SET @fequi=@wequi/@wtotal;
                                    SET @fcivil=@wcivil/@wtotal;
                                    SET @finst=@winst/@wtotal;
                                    SET @felec=@welec/@wtotal;"));



        //$milestone = DB::select("SELECT * FROM milestones");
        $progresscurve = DB::select("SELECT hpipes.week,
                                    IFNULL(hpipes.progress,0) AS ppipe,
                                    IFNULL(hequis.progress,0) AS pequi,
                                    IFNULL(hcivils.progress,0) AS pcivil,
                                    IFNULL(hinsts.progress,0) AS pinst,
                                    IFNULL(helecs.progress,0) AS pelec,
                                    IFNULL(milestones.estimated,0) AS estimated,
                                    TRUNCATE(((IFNULL(hpipes.progress,0)*@fpipe)+(IFNULL(hequis.progress,0)*@fequi)+(IFNULL(hcivils.progress,0)*@fcivil)+
                                    (IFNULL(hinsts.progress,0)*@finst)+(IFNULL(helecs.progress,0)*@felec)),2) as progress
                                    FROM hpipes 
                                    LEFT JOIN hequis ON hequis.week=hpipes.week
                                    LEFT JOIN hcivils ON hcivils.week=hpipes.week
                                    LEFT JOIN hinsts ON hinsts.week=hpipes.week
                                    LEFT JOIN helecs ON helecs.week=hpipes.week
                                    LEFT JOIN milestones ON milestones.week=hpipes.week
                                    ORDER BY hpipes.id DESC LIMIT 1");

         // FIN DE CURVA TOTAL DE PROGRESO

        //$weight_pipe = DB::select($sum_per_epipe);
        //$weight_pipe= DB::select("SELECT SUM(`pipesview`.`hours`) as weight FROM `pipesview` ");

        $updateat_equi= DB::select("SELECT DISTINCT updated_at as updateat_equi FROM dequis");
        //$count_by_area = DB::select("SELECT count(equi_name) as count_by_area FROM dequis WHERE zone_name LIKE '%".$unitss->name."%'");

        $units = DB::select("SELECT * FROM units");
        $areas = DB::select("SELECT * FROM areas");
        $homeload = DB::select("SELECT * FROM homeload");

                       

         

        return view('home')->with('units', $units)->with('areas', $areas)->with('homeload', $homeload)->with('sum_per_equi', $sum_per_equi)->with('sum_per_civil', $sum_per_civil)->with('sum_per_inst', $sum_per_inst)->with('sum_per_elec', $sum_per_elec)->with('sum_per_pipe', $sum_per_pipe)->with('weight_pipe', $weight_pipe)->with('weight_equi', $weight_equi)->with('weight_civil', $weight_civil)->with('weight_inst', $weight_inst)->with('weight_elec', $weight_elec)->with('weight_total', $weight_total)->with('progresscurve', $progresscurve)->with('updateat_equi', $updateat_equi)->with('filter', $filter);
    }

    public function glineprogresstotal()
        {


         DB::statement(DB::raw("SET @wpipe=(SELECT SUM(weight*qty) FROM epipesfullview);
                                    SET @wequi=(SELECT SUM(weight*qty) FROM eequisfullview);
                                    SET @wcivil=(SELECT SUM(weight*qty) FROM ecivilsfullview);
                                    SET @winst=(SELECT SUM(weight*qty) FROM einstsfullview);
                                    SET @welec=(SELECT SUM(weight*qty) FROM eelecsfullview);
                                    SET @wtotal=@wpipe+@wequi+@wcivil+@winst+@welec;
                                    SET @fpipe=@wpipe/@wtotal;
                                    SET @fequi=@wequi/@wtotal;
                                    SET @fcivil=@wcivil/@wtotal;
                                    SET @finst=@winst/@wtotal;
                                    SET @felec=@welec/@wtotal;"));



        $milestone = DB::select("SELECT * FROM milestones");
        $progresscurve = DB::select("SELECT hpipes.week,
                                    IFNULL(hpipes.progress,0) AS ppipe,
                                    IFNULL(hequis.progress,0) AS pequi,
                                    IFNULL(hcivils.progress,0) AS pcivil,
                                    IFNULL(hinsts.progress,0) AS pinst,
                                    IFNULL(helecs.progress,0) AS pelec,
                                    IFNULL(milestones.estimated,0) AS estimated,
                                    TRUNCATE(((IFNULL(hpipes.progress,0)*@fpipe)+(IFNULL(hequis.progress,0)*@fequi)+(IFNULL(hcivils.progress,0)*@fcivil)+
                                    (IFNULL(hinsts.progress,0)*@finst)+(IFNULL(helecs.progress,0)*@felec)),2) as progress
                                    FROM hpipes 
                                    LEFT JOIN hequis ON hequis.week=hpipes.week
                                    LEFT JOIN hcivils ON hcivils.week=hpipes.week
                                    LEFT JOIN hinsts ON hinsts.week=hpipes.week
                                    LEFT JOIN helecs ON helecs.week=hpipes.week
                                    LEFT JOIN milestones ON milestones.week=hpipes.week");
 

                //return view('glineprogresstotal',['progresscurve'=>$progresscurve]);
            return view('glineprogresstotal')->with('progresscurve', $progresscurve)->with('milestone', $milestone);
        }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        
        return view('dashboard');
    }

   

}
