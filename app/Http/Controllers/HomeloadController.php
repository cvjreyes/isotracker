<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Charts;


class HomeloadController extends Controller
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
    
    }

    public function homeload()
    {
        
    DB::statement(DB::raw("DROP TABLE IF EXISTS `homeload`"));
    DB::statement(DB::raw("CREATE TABLE `homeload` (`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, `area` varchar(191), `weight` int(11), `progress` decimal(44,2),PRIMARY KEY (`id`))"));

    $units = DB::select("SELECT * FROM units");

    foreach ($units as $unitss) {

            $total_pipe=0;
        
            $ppipes = DB::select("SELECT DISTINCT COUNT(hours) as count, SUM(hours) AS epipeshours_area, SUM(ppipehours) as ppipeshours_area FROM ppipes_area WHERE area="."'".$unitss->name."'");


             $weight_per_area = DB::select("SELECT DISTINCT SUM(hours) AS weight FROM pipesview WHERE area="."'".$unitss->name."'");

                               if (($ppipes[0]->count)==0){

                                 $epipes = DB::select("SELECT DISTINCT COUNT(units_id) as count FROM epipes WHERE units_id=".$unitss->id); // Validar si el área está estimada 

                                    if (($epipes[0]->count)<>0){



                                    }

                           }


                 $epipe = DB::select("SELECT DISTINCT * FROM pipesview");
                            $nodpipes=0;
                            
                            
                            $epipeshours_area= DB::select("SELECT DISTINCT SUM(hours) as hours FROM pipesview WHERE area="."'".$unitss->name."'"); //total de horas por area


                 if ($ppipes[0]->epipeshours_area <>0) {  

                     
                               $total_pipe = (($ppipes[0]->ppipeshours_area)/($epipeshours_area[0]->hours))*100;
                               
                                
                       }

                     DB::table('homeload')->insert([
                                'area' =>$unitss->name,
                                'weight' =>$weight_per_area[0]->weight,
                                'progress' =>round($total_pipe,2),

                      ]);      


                    }

                    DB::statement(DB::raw("DELETE FROM `homeload` WHERE `weight` IS NULL"));

        return "successful!";

    }

   

}
