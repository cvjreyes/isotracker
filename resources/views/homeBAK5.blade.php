@extends('layouts.datatable')

@section('content')

   


<br>
<br>
<br>
<br><br>
  
 <table>  
   <tr>
    <td style="width: 10%">
    <div class="row" style="margin-left: center">
        <div class="col-md-4 col-md-offset-4" >
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #ffffff;"><h4>Real 3D Progress</h4></div>
                 




                <div class="panel-body">


                    <!-- EQUIPMENTS Total Progress -->
                    <div id="menu_sel" style="height: 60px;border-radius: 4px;transition:200ms;" onMouseOver="this.style.background='#B0BED9';" onMouseOut="this.style.background='white';"><a href="equipments" style="color:black;text-decoration:none;"><h4 style="padding-top: 10px" onMouseOver="this.style.color='white'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/equi-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;Equipments&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                     </h4></a></div>
                                      <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                          aria-valuemin="0" aria-valuemax="100" style="font-size: 16px;width:<?php echo $sum_per_equi[0]->sum_per_equi."%"; ?>;background-color: #533D7A">
                                            <span class="sr-only"></span><?php echo round($sum_per_equi[0]->sum_per_equi,2)."%"; ?>
                                          </div>
                                        </div>

                  <!-- EQUIPMENTS Total Progress por Area -->
                @foreach ($units as $unitss)
                      
                    
  
                    <?php 


                    DB::statement(DB::raw("SET @area = "."'".$unitss->name."'"));
                    $total_per_area= DB::select(DB::raw("SELECT `eequis`.`units_id` AS `units_id`,
                    (SELECT `units`.`name` FROM `units` WHERE (`units`.`id` = `eequis`.`units_id`)) AS `area`,
                    `dequis`.`progress` AS `progress`,
                    COUNT(0) AS `modeled`,
                    (SELECT `eequis`.`tequis_id` FROM `eequis` WHERE (`eequis`.`tag` = `dequis`.`tag`)) AS `tequis_id`,
                    (SELECT `tequis`.`name` FROM `tequis` WHERE (`tequis`.`id` = `tequis_id`)) AS `type_equi`,
                    (SELECT `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `tequis_id`)) AS `hours`,
                    (SELECT `pequis`.`name` FROM `pequis` WHERE (`pequis`.`percentage` = `dequis`.`progress`)) AS `status`,
                    ((((SELECT `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `tequis_id`)) * COUNT(0)) * `dequis`.`progress`) / 100) AS `coef_progress`,
                    (SELECT SUM(`equisview`.`est_hours`) AS `mult_estimated` FROM `equisview` WHERE (`equisview`.`units_id`)=(SELECT `id` FROM `units` WHERE `units`.`name`=@area)) AS `coef_estimated`,
                    ((((SELECT `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `tequis_id`)) * COUNT(0)) * `dequis`.`progress`) / 
                    (SELECT SUM(`equisview`.`est_hours`) AS `coef_estimated`
                        FROM `equisview` WHERE (`equisview`.`units_id`)=(SELECT `id` FROM `units` WHERE `units`.`name`=@area) )) AS `total_progress`
                FROM
                    `dequis` JOIN `eequis`
                    WHERE (SELECT `units`.`name` FROM `units` WHERE (`units`.`id` = `eequis`.`units_id`)) LIKE CONCAT('%', @area,'%') AND (`eequis`.`tag` = `dequis`.`tag`)
                  GROUP BY `eequis`.`units_id` , `dequis`.`progress`"));


                              $total_equi=0;
                    ?>
                            

                            @foreach ($total_per_area as $total_per_areas)

                              <?php 

                                $suma_equi= $total_per_areas->total_progress; 
                                $total_equi=$total_equi+$suma_equi;


                              ?>

                            @endforeach

                              
                              <!-- Comprobar que el área tiene datos y/o está estimada -->
                             
                              <?php 

                                  $est_area=DB::select("SELECT DISTINCT units.name FROM eequis JOIN units WHERE units.id=eequis.units_id AND units.name="."'".$unitss->name."'");




                                  ?>

                              <?php if ($total_equi<>0 OR count($est_area)) { ?>

                                <center><div id="bar_equi" class="progress" style="width: 80%">
                                          <div style="position:absolute;z-index: 1;left:40%;font-size: 13px"><?php echo "Área ".$unitss->name.": ".round($total_equi,2)."%";?></div>
                                          <div class="progress-bar" role="progressbar" style="width:<?php echo $total_equi."%"; ?>;background-color: #B0BED9">

                                            <span class="sr-only"></span>
                                          </div>

                                        </div>
                              </center>

                                  


                             <?php } ?> 
                  @endforeach                     
               

                  <!-- FIN EQUIPMENTS -->

              <?php $est_area=DB::select("SELECT COUNT(id) AS count FROM epipes"); 

                if (($est_area[0]->count)!=0){ //VALIDACIÓN SI NO HAY DATA DE ESTIMACIÓN


                 

                        ?>



                      <!-- Proceso para totalizar progreso PIPING --> 


                    <div id="menu_sel" style="height: 60px;border-radius: 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9'" onMouseOut="this.style.background='white';"><a href="pipes" style="color:black;text-decoration:none;"><h4 style="padding-top: 10px"  onMouseOver="this.style.color='white'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/pipe-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;Piping</h4></a></div>


                                        <?php 

                                        //FILTER PIPE QUERYS (HOURS)
                            $filterpipe = DB::select("SELECT * FROM filterpipes");
                            $countfilterpipe = DB::select("SELECT COUNT(*) as count FROM filterpipes");
                            $count=$countfilterpipe[0]->count;
                            $sum_per_epipe_1 = "SELECT SUM(`pipesview`.`hours`) as ehrspipes FROM `pipesview` ";
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


                            $sum_per_epipe = DB::select($sum_per_epipe); 

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

                                $sum_per_pipe = DB::select($sum_per_pipe); 


                      

                            //END FILTER PIPE QUERYS (PROGRESS)


                                          //$sum_per_pipe = DB::select("SELECT * FROM total_ppipes_view"); 
                                          //$sum_per_epipe = DB::select("SELECT SUM(hours) as ehrspipes FROM pipesview");

                                         ?>

                                        <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="50"
                                          aria-valuemin="0" aria-valuemax="100" style="font-size: 16px;width:<?php echo round((($sum_per_pipe[0]->total_ppipehours)/($sum_per_epipe[0]->ehrspipes))*100,2)."%"; ?>; ?>;background-color: #533D7A">
                                            <span class="sr-only"></span><?php echo round((($sum_per_pipe[0]->total_ppipehours)/($sum_per_epipe[0]->ehrspipes))*100,2)."%"; ?>
                                          </div>
                                        </div>


                            
                            <!-- por Areas PIPING -->
         

                              @foreach ($units as $unitss)

                            <?php 

                             
                               $ppipes = DB::select("SELECT COUNT(hours) as count, SUM(hours) AS epipeshours_area,SUM(ppipehours) as ppipeshours_area FROM ppipes_area WHERE area="."'".$unitss->name."'");

                               if (($ppipes[0]->count)==0){

                           

                                    $epipes = DB::select("SELECT COUNT(units_id) as count FROM epipes WHERE units_id=".$unitss->id); // Validar si el área está estimada 

                                    if (($epipes[0]->count)<>0){?>


                                  
                                    <center><div id="bar_equi" class="progress" style="width: 80%">
                                          <div style="position:absolute;z-index: 1;left:40%;font-size: 13px"><?php echo "Área ".$unitss->name.": ".round(0,2)."%";?></div>
                                          <div class="progress-bar" role="progressbar" style="width:"0%"; ?>;background-color: #B0BED9">

                                            <span class="sr-only"></span>
                                          </div>

                                        </div>
                              </center>    


                                    <?php }


                                  } 

                            if ($ppipes[0]->epipeshours_area <>0){  

                               $total_pipe = (($ppipes[0]->ppipeshours_area)/($ppipes[0]->epipeshours_area))*100


                            ?>

                            <center><div id="bar_equi" class="progress" style="width: 80%">
                                          <div style="position:absolute;z-index: 1;left:40%;font-size: 13px"><?php echo "Área ".$unitss->name.": ".round($total_pipe,2)."%";?></div>
                                          <div class="progress-bar" role="progressbar" style="width:<?php echo $total_pipe."%"; ?>;background-color: #B0BED9">

                                            <span class="sr-only"></span>
                                          </div>

                                        </div>
                              </center>              

                             <?php } ?> 

                              @endforeach

                        <!-- FIN PIPING -->

                        <?php }else{ ?>


                           <div id="menu_sel" style="height: 60px;border-radius: 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9'" onMouseOut="this.style.background='white';"><a href="pipes" style="color:black;text-decoration:none;"><h4 style="padding-top: 10px"  onMouseOver="this.style.color='white'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/pipe-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;Piping</h4></a></div>


                                        <?php 

                                          $sum_per_pipe = DB::select("SELECT * FROM total_ppipes_view"); 
                                          $sum_per_epipe = DB::select("SELECT SUM(hours) as ehrspipes FROM pipesview");

                                         ?>

                                        <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="50"
                                          aria-valuemin="0" aria-valuemax="100" style="font-size: 16px;width:0%; ?>; ?>;background-color: #533D7A">
                                            <span class="sr-only"></span><?php echo "0%"; ?>
                                          </div>
                                        </div>



                       <?php } ?>

                </div>




          </div>
        </div>
       </div>
     </td>

   </tr>
     </table>
  
 



@include('common.footer')
@endsection
