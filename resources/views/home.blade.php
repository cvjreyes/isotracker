@extends('layouts.datatable')

@section('content')

<!-- ACORDEON-->   


<!-- FIN ACORDEON--> 


<!DOCTYPE html>
<html style="background: url('images/refinery2.png') no-repeat center center fixed;
        width:100%;height:100%;
        background-size: cover;
        -moz-background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;">
<div style="background: url('images/refinery2.png') no-repeat center center fixed;
        width:100%;height:100%;
        background-size: cover;
        -moz-background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;">
<br>
<br>
<br>
<br><br>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   
 <table>  
   <tr>
    <td style="width: 10%">
    <div class="row">
        <div class="col-md-4 col-md-offset-4" >
            <div class="panel panel-default" style="border-radius: 20px;">
                <div class="panel-heading" style="background-color: #FAFAFA;border-radius: 20px 20px 0px 0px;text-align: center"><h4><b>3D Progress Control v2</b></h4></div>
                  
                <?php $total_weight=$weight_pipe[0]->weight+$weight_equi[0]->weight+$weight_civil[0]->weight+$weight_inst[0]->weight+$weight_elec[0]->weight;

                $per_pipe=round((($weight_pipe[0]->weight*100)/$total_weight),2)."%";
                $per_equi=round((($weight_equi[0]->weight*100)/$total_weight),2)."%";
                $per_civil=round((($weight_civil[0]->weight*100)/$total_weight),2)."%";
                $per_inst=round((($weight_inst[0]->weight*100)/$total_weight),2)."%";
                $per_elec=round((($weight_elec[0]->weight*100)/$total_weight),2)."%";
                

                 ?>


                <div class="panel-body">
                   @role('Isoctrl')<div id="menu_sel" style="height: 50px;border-radius: 4px;transition:200ms;" onMouseOver="this.style.background='#E0E0E0';" onMouseOut="this.style.background='white';"><a href="hisoctrl" style="color:black;text-decoration:none;"><h4 style="padding-top: 5px" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/file-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;IsoTracker

                                     </h4></div>
                                      <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                          aria-valuemin="0" aria-valuemax="100" style="color:black;font-size: 15px;width:100%; ?>;background-color: #A0AFD9">
                                            <span class="sr-only"></span>Open
                                          </div>
                                        </div></a>
             
                      @endrole

                     <!-- 3D progress curve -->

                   @role('Pipe') <div id="menu_sel" style="height: 50px;border-radius: 4px;transition:200ms;" onMouseOver="this.style.background='#E0E0E0';" onMouseOut="this.style.background='white';"><a href="glineprogresstotal" style="color:black;text-decoration:none;"><h4 style="padding-top: 5px" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/chart-color-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;3D Progress&nbsp;&nbsp;(Weight: <?php echo $weight_total." | 100%";?>)

                                     </h4></a></div>

                                      <?php if(count($dequis)){ ?>

                                          <div align="right" style="font-size: 12px; font-weight: bold"><?php echo "Last Update: ".$updateat_equi[0]->updateat_equi;?></div>

                                     <?php } ?>     

                                      <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                          aria-valuemin="0" aria-valuemax="100" style="color:black;font-size: 15px;width:<?php echo $progresscurve[0]->progress."%"; ?>;background-color: #A0AFD9">
                                            <span class="sr-only"></span><?php echo round($progresscurve[0]->progress,2)."%"; ?>
                                          </div>
                                        </div>

                                     @endrole

                 <!-- FIN 3D progress curve -->                    


                    <!-- PIPING Total Progress -->

                   

                    @role('Pipe')<div id="menu_sel" style="height: 50px;border-radius: 4px;transition:200ms;" onMouseOver="this.style.background='#E0E0E0';" onMouseOut="this.style.background='white';"><a href="epipes" style="color:black;text-decoration:none;"><h4 style="padding-top: 5px" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/pipe-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;Piping&nbsp;&nbsp;(Weight: <?php echo round($weight_pipe[0]->weight,2)." | ".$per_pipe;?>)

                                     </h4></a></div>

                                         

                                      <div class="progress">
                                          <div id="equi" class="progress-bar" role="progressbar" aria-valuenow="70"
                                          aria-valuemin="0" aria-valuemax="100" style="color:black;font-size: 15px;width:<?php echo $sum_per_pipe."%"; ?>;background-color: #A0AFD9">
                                            <span class="sr-only"></span><?php echo round($sum_per_pipe,1)."%"; ?>
                                          </div>
                                        </div>
                      @endrole
                                        
                   

                  <!-- PIPING Total Progress -->

                    <!-- EQUIPMENT Total Progress -->
                    @role('Equi')<div id="menu_sel" style="height: 50px;border-radius: 4px;transition:200ms;" onMouseOver="this.style.background='#E0E0E0';" onMouseOut="this.style.background='white';"><a href="eequis" style="color:black;text-decoration:none;"><h4 style="padding-top: 5px" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/equi-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;Equipment&nbsp;&nbsp;(Weight: <?php echo round($weight_equi[0]->weight,2)." | ".$per_equi;?>)

                                     </h4></a></div>

                                         

                                      <div class="progress">
                                          <div id="equi" class="progress-bar" role="progressbar" aria-valuenow="70"
                                          aria-valuemin="0" aria-valuemax="100" style="color:black;font-size: 15px;width:<?php echo $sum_per_equi[0]->sum_per_equi."%"; ?>;background-color: #A0AFD9">
                                            <span class="sr-only"></span><?php echo round($sum_per_equi[0]->sum_per_equi,1)."%"; ?>
                                          </div>
                                        </div>

                                        
                   

                  <!-- EQUIPMENT Total Progress -->

                  @endrole

                  <style type="text/css">
                    
.accordion {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 25%;
    text-align: center;
    border: none;
    outline: none;
    transition: 0.4s;
}
.active, .accordion:hover {
    background-color: #B0BED9;
    color: #fff; 
}



.panela {

    padding: 0 18px;
    background-color: white;
    display: none; /*muestra por defecto*/
    overflow: hidden;
    

}

.accordionarea {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 25%;
    text-align: center;
    border: none;
    outline: none;
    transition: 0.4s;
}
.active, .accordionarea:hover {
    background-color: #B0BED9;
    color: #fff; 
}

.panelaarea {

    padding: 0 18px;
    background-color: white;
    display: none; /*muestra por defecto*/
    overflow: hidden;
    

}


                  </style>

          


              <div class="panela">      
                <br>
                @foreach ($units as $unitss)
                      
                    
  
                    <?php 

                   $feed = DB::select("SELECT DISTINCT feed FROM pmanagers");

                 if (($feed[0]->feed)==1) { 

                    DB::statement(DB::raw("SET @area = "."'".$unitss->name."'"));
                    $total_per_area= DB::select(DB::raw("SELECT DISTINCT `eequis`.`units_id` AS `units_id`,
                    (SELECT DISTINCT `units`.`name` FROM `units` WHERE (`units`.`id` = `eequis`.`units_id`)) AS `area`,
                    `dequis`.`progress` AS `progress`,
                    COUNT(0) AS `modeled`,
                    (SELECT DISTINCT `eequis`.`tequis_id` FROM `eequis` WHERE (`eequis`.`tag` = `dequis`.`tag`)) AS `tequis_id`,
                    (SELECT DISTINCT `tequis_feed`.`name` FROM `tequis_feed` WHERE (`tequis_feed`.`id` = `tequis_id`)) AS `type_equi`,
                    (SELECT DISTINCT IF((eequis.per_feed),((SELECT DISTINCT `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `eequis`.`tequis_id`))*((eequis.per_feed)/100)),((SELECT DISTINCT `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `eequis`.`tequis_id`))*((SELECT DISTINCT per_feed FROM pmanagers WHERE id=1)/100)))) as wfeed,
                    (SELECT DISTINCT `tequis_feed`.`hours` FROM `tequis_feed` WHERE (`tequis_feed`.`id` = `tequis_id`)) AS `hours`,
                    (SELECT DISTINCT `pequis_feed`.`name` FROM `pequis_feed` WHERE (`pequis_feed`.`percentage` = `dequis`.`progress`)) AS `status`,
                    ((((SELECT DISTINCT IF((eequis.per_feed),((SELECT DISTINCT `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `eequis`.`tequis_id`))*((eequis.per_feed)/100)),((SELECT DISTINCT `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `eequis`.`tequis_id`))*((SELECT DISTINCT per_feed FROM pmanagers WHERE id=1)/100)))) * COUNT(0)) * `dequis`.`progress`) / 100) AS `coef_progress`,
                    (SELECT DISTINCT SUM(`equisview_feed`.`est_hours`) AS `mult_estimated` FROM `equisview_feed` WHERE (`equisview_feed`.`units_id`)=(SELECT DISTINCT `id` FROM `units` WHERE `units`.`name`=@area)) AS `coef_estimated`,
                    ((((SELECT DISTINCT IF((eequis.per_feed),((SELECT DISTINCT `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `eequis`.`tequis_id`))*((eequis.per_feed)/100)),((SELECT DISTINCT `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `eequis`.`tequis_id`))*((SELECT DISTINCT per_feed FROM pmanagers WHERE id=1)/100)))) * COUNT(0)) * `dequis`.`progress`) / 
                    (SELECT DISTINCT SUM(`equisview_feed`.`est_hours`) AS `coef_estimated`
                        FROM `equisview_feed` WHERE (`equisview_feed`.`units_id`)=(SELECT DISTINCT `id` FROM `units` WHERE `units`.`name`=@area) )) AS `total_progress`
                FROM
                    `dequis` JOIN `eequis`
                    WHERE (SELECT DISTINCT `units`.`name` FROM `units` WHERE (`units`.`id` = `eequis`.`units_id`)) LIKE CONCAT('%', @area,'%') AND (`eequis`.`tag` = `dequis`.`tag`)
                  GROUP BY `eequis`.`units_id` , `dequis`.`progress`,`eequis`.`tequis_id`,`eequis`.`per_feed`"));


                     $weight_per_area= DB::select("SELECT DISTINCT SUM(est_hours) AS weight FROM equisview_feed WHERE area=@area");


                   }else{

                     DB::statement(DB::raw("SET @area = "."'".$unitss->name."'"));
                    $total_per_area= DB::select(DB::raw("SELECT DISTINCT `eequis`.`units_id` AS `units_id`,
                    (SELECT DISTINCT `units`.`name` FROM `units` WHERE (`units`.`id` = `eequis`.`units_id`)) AS `area`,
                    `dequis`.`progress` AS `progress`,
                    COUNT(0) AS `modeled`,
                    (SELECT DISTINCT `eequis`.`tequis_id` FROM `eequis` WHERE (`eequis`.`tag` = `dequis`.`tag`)) AS `tequis_id`,
                    (SELECT DISTINCT `tequis`.`name` FROM `tequis` WHERE (`tequis`.`id` = `tequis_id`)) AS `type_equi`,
                    (SELECT DISTINCT `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `tequis_id`)) AS `hours`,
                    (SELECT DISTINCT `pequis`.`name` FROM `pequis` WHERE (`pequis`.`percentage` = `dequis`.`progress`)) AS `status`,
                    ((((SELECT DISTINCT `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `tequis_id`)) * COUNT(0)) * `dequis`.`progress`) / 100) AS `coef_progress`,
                    (SELECT DISTINCT SUM(`equisview`.`est_hours`) AS `mult_estimated` FROM `equisview` WHERE (`equisview`.`units_id`)=(SELECT DISTINCT `id` FROM `units` WHERE `units`.`name`=@area)) AS `coef_estimated`,
                    ((((SELECT DISTINCT `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `tequis_id`)) * COUNT(0)) * `dequis`.`progress`) / 
                    (SELECT DISTINCT SUM(`equisview`.`est_hours`) AS `coef_estimated`
                        FROM `equisview` WHERE (`equisview`.`units_id`)=(SELECT DISTINCT `id` FROM `units` WHERE `units`.`name`=@area) )) AS `total_progress`
                FROM
                    `dequis` JOIN `eequis`
                    WHERE (SELECT DISTINCT `units`.`name` FROM `units` WHERE (`units`.`id` = `eequis`.`units_id`)) LIKE CONCAT('%', @area,'%') AND (`eequis`.`tag` = `dequis`.`tag`)
                  GROUP BY `eequis`.`units_id` , `dequis`.`progress`,`eequis`.`tequis_id`"));


                     $weight_per_area= DB::select("SELECT DISTINCT SUM(est_hours) AS weight FROM equisview WHERE area=@area");
                    
                   }

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

                                  $est_area=DB::select("SELECT DISTINCT DISTINCT units.name FROM eequis JOIN units WHERE units.id=eequis.units_id AND units.name="."'".$unitss->name."'");




                                  ?>

                              <?php if ($total_equi<>0 OR count($est_area)) { ?>

                                <center><div id="bar_equi" class="progress" style="width: 80%">
                                          <div style="position:absolute;z-index: 1;left:35%;font-size: 13px"><?php echo "Area ".$unitss->name.": ".round($total_equi,2)."%"." (Weight: ".$weight_per_area[0]->weight.")";?></div>
                                          <div class="progress-bar" role="progressbar" style="width:<?php echo $total_equi."%"; ?>;background-color: #B0BED9">

                                            <span class="sr-only"></span>
                                          </div>

                                        </div>
                              </center>

                                  


                             <?php } ?> 
                  @endforeach                     
               
              </div>

<!--  PROGRESO POR AREAS EQUIPMENT -->

              <!-- <button class="accordion btn btn-lg btn-default" style="padding: 2px 8px;font-size: 14px;">by Areas</button> -->
              <div class="panelaarea">
                <br>


                  @foreach ($areas as $areass)

                  <?php

                    DB::statement(DB::raw("SET @area = "."'".$areass->name."'"));

                    $per_area= DB::select("SELECT SUM((weight*progress)/1600) as sum_per_equi FROM dequisfullview WHERE area=@area");

                    //echo $sum_per_equi[0]->sum_per_equi;?>

                                        <?php echo $areass->name; ?>

                                        <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                          aria-valuemin="0" aria-valuemax="100" style="color:black;font-size: 13px;width:<?php echo $per_area[0]->sum_per_equi."%"; ?>;background-color: #A0AFD9">
                                            <span class="sr-only"></span><?php echo round($per_area[0]->sum_per_equi,2)."%"; ?>
                                          </div>
                                        </div>

                  @endforeach

<!--  FIN PROGRESO POR AREAS EQUIPMENT -->

              </div>    
                  <!-- FIN EQUIPMENTS -->

                  <!-- CIVIL Total Progress -->
                   @role('Civil') <div id="menu_sel" style="height: 50px;border-radius: 4px;transition:200ms;" onMouseOver="this.style.background='#E0E0E0';" onMouseOut="this.style.background='white';"><a href="ecivils" style="color:black;text-decoration:none;"><h4 style="padding-top: 5px" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/stru-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;Civil&nbsp;&nbsp;(Weight: <?php echo round($weight_civil[0]->weight,2)." | ".$per_civil;?>)

                                     </h4></a></div>

                                     <?php if(count($dequis)){ ?>

                                          <div align="right" style="font-size: 12px; font-weight: bold"><?php echo "Last Update: ".$updateat_equi[0]->updateat_equi;?></div>

                                     <?php } ?>     

                                      <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                          aria-valuemin="0" aria-valuemax="100" style="color:black;font-size: 15px;width:<?php echo $sum_per_civil[0]->sum_per_civil."%"; ?>;background-color: #A0AFD9">
                                            <span class="sr-only"></span><?php echo round($sum_per_civil[0]->sum_per_civil,2)."%"; ?>
                                          </div>
                                        </div>

                  <!-- CIVIL Total Progress por Area -->

                  

                  
          <!--  <button class="accordion btn btn-lg btn-default" style="padding: 2px 8px;font-size: 14px;">by Areas</button> -->


              <div class="panela">      
                <br>
                @foreach ($units as $unitss)
                      
                    
  
                    <?php 


                    DB::statement(DB::raw("SET @area = "."'".$unitss->name."'"));
                    $total_per_area= DB::select(DB::raw("SELECT DISTINCT `ecivils`.`units_id` AS `units_id`,
                    (SELECT DISTINCT `units`.`name` FROM `units` WHERE (`units`.`id` = `ecivils`.`units_id`)) AS `area`,
                    `dcivils`.`progress` AS `progress`,
                    COUNT(0) AS `modeled`,
                    (SELECT DISTINCT `ecivils`.`tcivils_id` FROM `ecivils` WHERE (`ecivils`.`tag` = `dcivils`.`tag`)) AS `tcivils_id`,
                    (SELECT DISTINCT `tcivils`.`name` FROM `tcivils` WHERE (`tcivils`.`id` = `tcivils_id`)) AS `type_civil`,
                    (SELECT DISTINCT `tcivils`.`hours` FROM `tcivils` WHERE (`tcivils`.`id` = `tcivils_id`)) AS `hours`,
                    (SELECT DISTINCT `pcivils`.`name` FROM `pcivils` WHERE (`pcivils`.`percentage` = `dcivils`.`progress`)) AS `status`,
                    ((((SELECT DISTINCT `tcivils`.`hours` FROM `tcivils` WHERE (`tcivils`.`id` = `tcivils_id`)) * COUNT(0)) * `dcivils`.`progress`) / 100) AS `coef_progress`,
                    (SELECT DISTINCT SUM(`civilsview`.`est_hours`) AS `mult_estimated` FROM `civilsview` WHERE (`civilsview`.`units_id`)=(SELECT DISTINCT `id` FROM `units` WHERE `units`.`name`=@area)) AS `coef_estimated`,
                    ((((SELECT DISTINCT `tcivils`.`hours` FROM `tcivils` WHERE (`tcivils`.`id` = `tcivils_id`)) * COUNT(0)) * `dcivils`.`progress`) / 
                    (SELECT DISTINCT SUM(`civilsview`.`est_hours`) AS `coef_estimated`
                        FROM `civilsview` WHERE (`civilsview`.`units_id`)=(SELECT DISTINCT `id` FROM `units` WHERE `units`.`name`=@area) )) AS `total_progress`
                FROM
                    `dcivils` JOIN `ecivils`
                    WHERE (SELECT DISTINCT `units`.`name` FROM `units` WHERE (`units`.`id` = `ecivils`.`units_id`)) LIKE CONCAT('%', @area,'%') AND (`ecivils`.`tag` = `dcivils`.`tag`)
                  GROUP BY `ecivils`.`units_id` , `dcivils`.`progress`,`ecivils`.`tcivils_id`"));



                    $weight_per_area= DB::select("SELECT DISTINCT SUM(est_hours) AS weight FROM civilsview WHERE area=@area");

                              $total_civil=0;
                    ?>
                            

                            @foreach ($total_per_area as $total_per_areas)

                              <?php 

                                $suma_civil= $total_per_areas->total_progress; 

                                $total_civil=$total_civil+$suma_civil;


                              ?>

                            @endforeach

                              
                              <!-- Comprobar que el área tiene datos y/o está estimada -->
                             
                              <?php 



                                  $est_area=DB::select("SELECT DISTINCT DISTINCT units.name FROM ecivils JOIN units WHERE units.id=ecivils.units_id AND units.name="."'".$unitss->name."'");




                                  ?>

                              <?php if ($total_civil<>0 OR count($est_area)) { ?>

                                <center><div id="bar_civil" class="progress" style="width: 80%">
                                          <div style="position:absolute;z-index: 1;left:35%;font-size: 13px"><?php echo "Area ".$unitss->name.": ".round($total_civil,2)."%"." (Weight: ".$weight_per_area[0]->weight.")";?></div>
                                          <div class="progress-bar" role="progressbar" style="width:<?php echo $total_civil."%"; ?>;background-color: #B0BED9">

                                            <span class="sr-only"></span>
                                          </div>

                                        </div>
                              </center>

                                  


                             <?php } ?> 
                  @endforeach                     
               
              </div>  @endrole  
                  <!-- FIN CIVIL -->


                  <!-- INSTRUMENTATION Total Progress -->
                   @role('Inst') <div id="menu_sel" style="height: 50px;border-radius: 4px;transition:200ms;" onMouseOver="this.style.background='#E0E0E0';" onMouseOut="this.style.background='white';"><a href="einsts" style="color:black;text-decoration:none;"><h4 style="padding-top: 5px" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/inst-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;Instrumentation&nbsp;&nbsp;(Weight: <?php echo $weight_inst[0]->weight." | ".$per_inst;?>)

                                     </h4></a></div>

                                     <?php if(count($dequis)){ ?>

                                          <div align="right" style="font-size: 12px; font-weight: bold"><?php echo "Last Update: ".$updateat_equi[0]->updateat_equi;?></div>

                                     <?php } ?>     

                                      <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                          aria-valuemin="0" aria-valuemax="100" style="color:black;font-size: 15px;width:<?php echo $sum_per_inst[0]->sum_per_inst."%"; ?>;background-color: #A0AFD9">
                                            <span class="sr-only"></span><?php echo round($sum_per_inst[0]->sum_per_inst,2)."%"; ?>
                                          </div>
                                        </div>

                 
                  <!-- Instrumentation Total Progress por Area -->

                  

                  
          <!--   <button class="accordion btn btn-lg btn-default" style="padding: 2px 8px;font-size: 14px;">by Areas</button> -->


              <div class="panela">      
                <br>
                @foreach ($units as $unitss)
                      
                    
  
                    <?php 


                    DB::statement(DB::raw("SET @area = "."'".$unitss->name."'"));
                    $total_per_area= DB::select(DB::raw("SELECT DISTINCT `einsts`.`units_id` AS `units_id`,
                    (SELECT DISTINCT `units`.`name` FROM `units` WHERE (`units`.`id` = `einsts`.`units_id`)) AS `area`,
                    `dinsts`.`progress` AS `progress`,
                    COUNT(0) AS `modeled`,
                    (SELECT DISTINCT `einsts`.`tinsts_id` FROM `einsts` WHERE (`einsts`.`tag` = `dinsts`.`tag`)) AS `tinsts_id`,
                    (SELECT DISTINCT `tinsts`.`name` FROM `tinsts` WHERE (`tinsts`.`id` = `tinsts_id`)) AS `type_inst`,
                    (SELECT DISTINCT `tinsts`.`hours` FROM `tinsts` WHERE (`tinsts`.`id` = `tinsts_id`)) AS `hours`,
                    (SELECT DISTINCT `pinsts`.`name` FROM `pinsts` WHERE (`pinsts`.`percentage` = `dinsts`.`progress`)) AS `status`,
                    ((((SELECT DISTINCT `tinsts`.`hours` FROM `tinsts` WHERE (`tinsts`.`id` = `tinsts_id`)) * COUNT(0)) * `dinsts`.`progress`) / 100) AS `coef_progress`,
                    (SELECT DISTINCT SUM(`instsview`.`est_hours`) AS `mult_estimated` FROM `instsview` WHERE (`instsview`.`units_id`)=(SELECT DISTINCT `id` FROM `units` WHERE `units`.`name`=@area)) AS `coef_estimated`,
                    ((((SELECT DISTINCT `tinsts`.`hours` FROM `tinsts` WHERE (`tinsts`.`id` = `tinsts_id`)) * COUNT(0)) * `dinsts`.`progress`) / 
                    (SELECT DISTINCT SUM(`instsview`.`est_hours`) AS `coef_estimated`
                        FROM `instsview` WHERE (`instsview`.`units_id`)=(SELECT DISTINCT `id` FROM `units` WHERE `units`.`name`=@area) )) AS `total_progress`
                FROM
                    `dinsts` JOIN `einsts`
                    WHERE (SELECT DISTINCT `units`.`name` FROM `units` WHERE (`units`.`id` = `einsts`.`units_id`)) LIKE CONCAT('%', @area,'%') AND (`einsts`.`tag` = `dinsts`.`tag`)
                  GROUP BY `einsts`.`units_id` , `dinsts`.`progress`,`einsts`.`tinsts_id`"));



                    $weight_per_area= DB::select("SELECT DISTINCT SUM(est_hours) AS weight FROM instsview WHERE area=@area");

                              $total_inst=0;
                    ?>
                            

                            @foreach ($total_per_area as $total_per_areas)

                              <?php 

                                $suma_inst= $total_per_areas->total_progress; 

                                $total_inst=$total_inst+$suma_inst;


                              ?>

                            @endforeach

                              
                              <!-- Comprobar que el área tiene datos y/o está estimada -->
                             
                              <?php 



                                  $est_area=DB::select("SELECT DISTINCT DISTINCT units.name FROM einsts JOIN units WHERE units.id=einsts.units_id AND units.name="."'".$unitss->name."'");




                                  ?>

                              <?php if ($total_inst<>0 OR count($est_area)) { ?>

                                <center><div id="bar_inst" class="progress" style="width: 80%">
                                          <div style="position:absolute;z-index: 1;left:35%;font-size: 13px"><?php echo "Area ".$unitss->name.": ".round($total_inst,2)."%"." (Weight: ".$weight_per_area[0]->weight.")";?></div>
                                          <div class="progress-bar" role="progressbar" style="width:<?php echo $total_inst."%"; ?>;background-color: #B0BED9">

                                            <span class="sr-only"></span>
                                          </div>

                                        </div>
                              </center>

                                  


                             <?php } ?> 
                  @endforeach                     
               
              </div>  @endrole  
                  <!-- FIN instrumentation --> 



                  <!-- ELECTRICAL Total Progress -->
                   @role('Elec') <div id="menu_sel" style="height: 50px;border-radius: 4px;transition:200ms;" onMouseOver="this.style.background='#E0E0E0';" onMouseOut="this.style.background='white';"><a href="eelecs" style="color:black;text-decoration:none;"><h4 style="padding-top: 5px" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/elec-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;Electrical&nbsp;&nbsp;(Weight: <?php echo $weight_elec[0]->weight." | ".$per_elec;?>)

                                     </h4></a></div>

                                     <?php if(count($dequis)){ ?>

                                          <div align="right" style="font-size: 12px; font-weight: bold"><?php echo "Last Update: ".$updateat_equi[0]->updateat_equi;?></div>

                                     <?php } ?>     

                                      <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                          aria-valuemin="0" aria-valuemax="100" style="color:black;font-size: 15px;width:<?php echo $sum_per_elec[0]->sum_per_elec."%"; ?>;background-color: #A0AFD9">
                                            <span class="sr-only"></span><?php echo round($sum_per_elec[0]->sum_per_elec,2)."%"; ?>
                                          </div>
                                        </div>

                 
                  <!-- ELECTRICAL Total Progress por Area -->

                  

                  
            <!-- <button class="accordion btn btn-lg btn-default" style="padding: 2px 8px;font-size: 14px;">by Areas</button> -->


              <div class="panela">      
                <br>
                @foreach ($units as $unitss)
                      
                    
  
                    <?php 


                    DB::statement(DB::raw("SET @area = "."'".$unitss->name."'"));
                    $total_per_area= DB::select(DB::raw("SELECT DISTINCT `eelecs`.`units_id` AS `units_id`,
                    (SELECT DISTINCT `units`.`name` FROM `units` WHERE (`units`.`id` = `eelecs`.`units_id`)) AS `area`,
                    `delecs`.`progress` AS `progress`,
                    COUNT(0) AS `modeled`,
                    (SELECT DISTINCT `eelecs`.`telecs_id` FROM `eelecs` WHERE (`eelecs`.`tag` = `delecs`.`tag`)) AS `telecs_id`,
                    (SELECT DISTINCT `telecs`.`name` FROM `telecs` WHERE (`telecs`.`id` = `telecs_id`)) AS `type_elec`,
                    (SELECT DISTINCT `telecs`.`hours` FROM `telecs` WHERE (`telecs`.`id` = `telecs_id`)) AS `hours`,
                    (SELECT DISTINCT `pelecs`.`name` FROM `pelecs` WHERE (`pelecs`.`percentage` = `delecs`.`progress`)) AS `status`,
                    ((((SELECT DISTINCT `telecs`.`hours` FROM `telecs` WHERE (`telecs`.`id` = `telecs_id`)) * COUNT(0)) * `delecs`.`progress`) / 100) AS `coef_progress`,
                    (SELECT DISTINCT SUM(`elecsview`.`est_hours`) AS `mult_estimated` FROM `elecsview` WHERE (`elecsview`.`units_id`)=(SELECT DISTINCT `id` FROM `units` WHERE `units`.`name`=@area)) AS `coef_estimated`,
                    ((((SELECT DISTINCT `telecs`.`hours` FROM `telecs` WHERE (`telecs`.`id` = `telecs_id`)) * COUNT(0)) * `delecs`.`progress`) / 
                    (SELECT DISTINCT SUM(`elecsview`.`est_hours`) AS `coef_estimated`
                        FROM `elecsview` WHERE (`elecsview`.`units_id`)=(SELECT DISTINCT `id` FROM `units` WHERE `units`.`name`=@area) )) AS `total_progress`
                FROM
                    `delecs` JOIN `eelecs`
                    WHERE (SELECT DISTINCT `units`.`name` FROM `units` WHERE (`units`.`id` = `eelecs`.`units_id`)) LIKE CONCAT('%', @area,'%') AND (`eelecs`.`tag` = `delecs`.`tag`)
                  GROUP BY `eelecs`.`units_id` , `delecs`.`progress`,`eelecs`.`telecs_id`"));



                    $weight_per_area= DB::select("SELECT DISTINCT SUM(est_hours) AS weight FROM elecsview WHERE area=@area");

                              $total_elec=0;
                    ?>
                            

                            @foreach ($total_per_area as $total_per_areas)

                              <?php 

                                $suma_elec= $total_per_areas->total_progress; 

                                $total_elec=$total_elec+$suma_elec;


                              ?>

                            @endforeach

                              
                              <!-- Comprobar que el área tiene datos y/o está estimada -->
                             
                              <?php 



                                  $est_area=DB::select("SELECT DISTINCT DISTINCT units.name FROM eelecs JOIN units WHERE units.id=eelecs.units_id AND units.name="."'".$unitss->name."'");




                                  ?>

                              <?php if ($total_elec<>0 OR count($est_area)) { ?>

                                <center><div id="bar_elec" class="progress" style="width: 80%">
                                          <div style="position:absolute;z-index: 1;left:35%;font-size: 13px"><?php echo "Area ".$unitss->name.": ".round($total_elec,2)."%"." (Weight: ".$weight_per_area[0]->weight.")";?></div>
                                          <div class="progress-bar" role="progressbar" style="width:<?php echo $total_elec."%"; ?>;background-color: #B0BED9">

                                            <span class="sr-only"></span>
                                          </div>

                                        </div>
                              </center>

                                  


                             <?php } ?> 
                  @endforeach                     
               
              </div>  @endrole  
   <!--                <!-- FIN ELECTRICAL -->    

              
              <?php $est_area=DB::select("SELECT DISTINCT COUNT(id) AS count FROM epipesnews"); 

                if (($est_area[0]->count)!=0){ //VALIDACIÓN SI NO HAY DATA DE ESTIMACIÓN


                 

                        ?>



                      <!-- Proceso para totalizar progreso PIPING -->

                                    <!--   Se comprueba el peso deseado (BUDGET/AREAS) -->

                                                <?php $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='pipe'");?>


                                            <?php if ($weight_total[0]->weight_total==0) :?>    

                                                <?php $total_weight= DB::select("SELECT SUM(weight*qty) AS weight FROM epipesfullview;");?> 

                                            <?php else: ?>

                                                 <?php $total_weight= DB::select("SELECT weight FROM pmanagers WHERE name='pipe'");?>   

                                            <?php endif ?>

                                     <!--   FIN DE LA COMPROBACIÓN (BUDGET/AREAS) --> 

                                            
                                                <?php if ($total_weight[0]->weight!=0) :?>

                                               <!--      <h3>Estimated Weight: <?php //echo $total_weight[0]->weight; ?> -->
                                                    <?php $sub_total_progress = DB::select("SELECT (SUM((pid*w_pid)+(iso*w_iso)+(stress*w_stress)+(support*w_support))) as  sub_total_progress 
                                                            FROM dpipesfullview");

                                                    $total_progress = (($sub_total_progress[0]->sub_total_progress)/$total_weight[0]->weight);
                                                    ?>

                                                <!-- <br>Total Progress: <?php //echo round($total_progress,1)."%";?></h3> -->


                                                <?php else: ?>

                                                   <!--  <h3>Estimated Weight: <?php //echo "0"; ?>
                                                    <br>Total Progress: <?php //echo "0%";?></h3> -->

                                                <?php endif ?> 


              


                    


                                        <?php 

                                        //FILTER PIPE QUERYS (HOURS)
                            $filterpipe = DB::select("SELECT DISTINCT * FROM filterpipes");
                            $countfilterpipe = DB::select("SELECT DISTINCT COUNT(*) as count FROM filterpipes");
                            $count=$countfilterpipe[0]->count;
                            $sum_per_epipe_1 = "SELECT DISTINCT SUM(`pipesview`.`hours`) as ehrspipes FROM `pipesview` ";
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

                                $sum_per_pipe_1 = "SELECT DISTINCT SUM(((`ppipes_view_bak`.`total_progress` * `ppipes_view_bak`.`hours`) / 100)) AS `total_ppipehours` FROM `ppipes_view_bak` "; 
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


                                          //$sum_per_pipe = DB::select("SELECT DISTINCT * FROM total_ppipes_view"); 
                                          //$sum_per_epipe = DB::select("SELECT DISTINCT SUM(hours) as ehrspipes FROM pipesview");

                                         ?>

                                    <!-- FILTER VALIDATE  -->

                                    <?php if($filter==1){ ?>

                                      <?php if(count($dequis)){ ?>

                                            <div align="right" style="font-size: 12px; font-weight: bold"><?php echo "<div style='background-color: #FEE173'>*** WARNING: FILTER APPLIED ! ***&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last Update: ".$updateat_equi[0]->updateat_equi;?></div></div>
                                            <?php } ?>
                                
                                          <?php }else{ ?>     

                                       

                                       <?php } ?>

                                    <!-- END FILTER VALIDATE  -->   

                                      <!-- <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="50"
                                          aria-valuemin="0" aria-valuemax="100" style="color:black;font-size: 15px;width:<?php //echo round($total_progress,1)."%"; ?>; ?>;background-color: #A0AFD9">
                                            <span class="sr-only"></span><?php //echo round($total_progress,1)."%"; ?>
                                          </div>
                                        </div> -->

              <!-- <button class="accordion btn btn-lg btn-default" style="padding: 2px 8px;font-size: 14px;">by Areas</button> -->
             <!--  <div class="panela">      
                <br>
 -->
                            
                            <!-- por Areas PIPING -->
         

                            <!--   @foreach ($homeload as $homeloads)

                               

                            
                              @endforeach

                        
                </div>

                       <!--  <?php }//else{ ?>

                            


                           
                        


                       <!-- FIN PIPING -->

                </div>




          </div>
        </div>
       </div>
     </td>

   </tr>
     </table>
     </div>
</html>
 <script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}
</script>


@endsection
