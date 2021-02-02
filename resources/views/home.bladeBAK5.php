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

 <table>  
   <tr>
    <td style="width: 10%">
    <div class="row">
        <div class="col-md-4 col-md-offset-4" >
            <div class="panel panel-default" style="border-radius: 20px;">
                <div class="panel-heading" style="background-color: #FAFAFA;border-radius: 20px 20px 0px 0px;text-align: center"><h4><b>3D Progress Control v1.1</b></h4></div>
                  



                <div class="panel-body">


                    <!-- EQUIPMENTS Total Progress -->
                    <div id="menu_sel" style="height: 50px;border-radius: 4px;transition:200ms;" onMouseOver="this.style.background='#E0E0E0';" onMouseOut="this.style.background='white';"><a href="equipments" style="color:black;text-decoration:none;"><h4 style="padding-top: 5px" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/equi-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;Equipment&nbsp;&nbsp;(Weight: <?php echo $weight_equi[0]->weight;?>)

                                     </h4></a></div>

                                         <!--  <div align="right" style="font-size: 12px; font-weight: bold"><?php //echo "Last Update: ".$updateat_equi[0]->updateat_equi;?></div> -->

                                      <div class="progress">
                                          <div id="equi" class="progress-bar" role="progressbar" aria-valuenow="70"
                                          aria-valuemin="0" aria-valuemax="100" style="color:black;font-size: 15px;width:<?php echo $sum_per_equi[0]->sum_per_equi."%"; ?>;background-color: #A0AFD9">
                                            <span class="sr-only"></span><?php echo round($sum_per_equi[0]->sum_per_equi,2)."%"; ?>
                                          </div>
                                        </div>

                                        
                   

                  <!-- EQUIPMENTS Total Progress por Area -->

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


                  </style>

                  
            <button class="accordion btn btn-lg btn-default" style="padding: 2px 8px;font-size: 14px;">by Areas</button>


              <div class="panela">      
                <br>
                @foreach ($units as $unitss)
                      
                    
  
                    <?php 


                    DB::statement(DB::raw("SET @area = "."'".$unitss->name."'"));
                    $total_per_area= DB::select(DB::raw("SELECT DISTINCT  `eequis`.`units_id` AS `units_id`,
                    (SELECT DISTINCT  `units`.`name` FROM `units` WHERE (`units`.`id` = `eequis`.`units_id`)) AS `area`,
                    `dequis`.`progress` AS `progress`,
                    COUNT(0) AS `modeled`,
                    (SELECT DISTINCT  `eequis`.`tequis_id` FROM `eequis` WHERE (`eequis`.`tag` = `dequis`.`tag`)) AS `tequis_id`,
                    (SELECT DISTINCT  `tequis`.`name` FROM `tequis` WHERE (`tequis`.`id` = `tequis_id`)) AS `type_equi`,
                    (SELECT DISTINCT  `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `tequis_id`)) AS `hours`,
                    (SELECT DISTINCT  `pequis`.`name` FROM `pequis` WHERE (`pequis`.`percentage` = `dequis`.`progress`)) AS `status`,
                    ((((SELECT DISTINCT  `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `tequis_id`)) * COUNT(0)) * `dequis`.`progress`) / 100) AS `coef_progress`,
                    (SELECT DISTINCT  SUM(`equisview`.`est_hours`) AS `mult_estimated` FROM `equisview` WHERE (`equisview`.`units_id`)=(SELECT DISTINCT  `id` FROM `units` WHERE `units`.`name`=@area)) AS `coef_estimated`,
                    ((((SELECT DISTINCT  `tequis`.`hours` FROM `tequis` WHERE (`tequis`.`id` = `tequis_id`)) * COUNT(0)) * `dequis`.`progress`) / 
                    (SELECT DISTINCT  SUM(`equisview`.`est_hours`) AS `coef_estimated`
                        FROM `equisview` WHERE (`equisview`.`units_id`)=(SELECT DISTINCT  `id` FROM `units` WHERE `units`.`name`=@area) )) AS `total_progress`
                FROM
                    `dequis` JOIN `eequis`
                    WHERE (SELECT DISTINCT  `units`.`name` FROM `units` WHERE (`units`.`id` = `eequis`.`units_id`)) LIKE CONCAT('%', @area,'%') AND (`eequis`.`tag` = `dequis`.`tag`)
                  GROUP BY `eequis`.`units_id` , `dequis`.`progress`,`eequis`.`tequis_id`"));


                     $weight_per_area= DB::select("SELECT SUM(est_hours) AS weight FROM equisview WHERE area=@area");

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
                                          <div style="position:absolute;z-index: 1;left:35%;font-size: 13px"><?php echo "Area ".$unitss->name.": ".round($total_equi,2)."%"." (Weight: ".$weight_per_area[0]->weight.")";?></div>
                                          <div class="progress-bar" role="progressbar" style="width:<?php echo $total_equi."%"; ?>;background-color: #B0BED9">

                                            <span class="sr-only"></span>
                                          </div>

                                        </div>
                              </center>

                                  


                             <?php } ?> 
                  @endforeach                     
               
              </div>    
                  <!-- FIN EQUIPMENTS -->

                  <!-- CIVIL Total Progress -->
                   @role('Civil') <div id="menu_sel" style="height: 50px;border-radius: 4px;transition:200ms;" onMouseOver="this.style.background='#E0E0E0';" onMouseOut="this.style.background='white';"><a href="civils" style="color:black;text-decoration:none;"><h4 style="padding-top: 5px" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/stru-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;Civil&nbsp;&nbsp;(Weight: <?php echo $weight_civil[0]->weight;?>)

                                     </h4></a></div>

                                     <div align="right" style="font-size: 12px; font-weight: bold"><?php echo "Last Update: ".$updateat_equi[0]->updateat_equi;?></div>

                                      <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                          aria-valuemin="0" aria-valuemax="100" style="color:black;font-size: 15px;width:<?php echo $sum_per_civil[0]->sum_per_civil."%"; ?>;background-color: #A0AFD9">
                                            <span class="sr-only"></span><?php echo round($sum_per_civil[0]->sum_per_civil,2)."%"; ?>
                                          </div>
                                        </div>

                  <!-- CIVIL Total Progress por Area -->

                  

                  
            <button class="accordion btn btn-lg btn-default" style="padding: 2px 8px;font-size: 14px;">by Areas</button>


              <div class="panela">      
                <br>
                @foreach ($units as $unitss)
                      
                    
  
                    <?php 


                    DB::statement(DB::raw("SET @area = "."'".$unitss->name."'"));
                    $total_per_area= DB::select(DB::raw("SELECT `ecivils`.`units_id` AS `units_id`,
                    (SELECT `units`.`name` FROM `units` WHERE (`units`.`id` = `ecivils`.`units_id`)) AS `area`,
                    `dcivils`.`progress` AS `progress`,
                    COUNT(0) AS `modeled`,
                    (SELECT `ecivils`.`tcivils_id` FROM `ecivils` WHERE (`ecivils`.`tag` = `dcivils`.`tag`)) AS `tcivils_id`,
                    (SELECT `tcivils`.`name` FROM `tcivils` WHERE (`tcivils`.`id` = `tcivils_id`)) AS `type_civil`,
                    (SELECT `tcivils`.`hours` FROM `tcivils` WHERE (`tcivils`.`id` = `tcivils_id`)) AS `hours`,
                    (SELECT `pcivils`.`name` FROM `pcivils` WHERE (`pcivils`.`percentage` = `dcivils`.`progress`)) AS `status`,
                    ((((SELECT `tcivils`.`hours` FROM `tcivils` WHERE (`tcivils`.`id` = `tcivils_id`)) * COUNT(0)) * `dcivils`.`progress`) / 100) AS `coef_progress`,
                    (SELECT SUM(`civilsview`.`est_hours`) AS `mult_estimated` FROM `civilsview` WHERE (`civilsview`.`units_id`)=(SELECT `id` FROM `units` WHERE `units`.`name`=@area)) AS `coef_estimated`,
                    ((((SELECT `tcivils`.`hours` FROM `tcivils` WHERE (`tcivils`.`id` = `tcivils_id`)) * COUNT(0)) * `dcivils`.`progress`) / 
                    (SELECT SUM(`civilsview`.`est_hours`) AS `coef_estimated`
                        FROM `civilsview` WHERE (`civilsview`.`units_id`)=(SELECT `id` FROM `units` WHERE `units`.`name`=@area) )) AS `total_progress`
                FROM
                    `dcivils` JOIN `ecivils`
                    WHERE (SELECT `units`.`name` FROM `units` WHERE (`units`.`id` = `ecivils`.`units_id`)) LIKE CONCAT('%', @area,'%') AND (`ecivils`.`tag` = `dcivils`.`tag`)
                  GROUP BY `ecivils`.`units_id` , `dcivils`.`progress`,`ecivils`.`tcivils_id`"));



                    $weight_per_area= DB::select("SELECT SUM(est_hours) AS weight FROM civilsview WHERE area=@area");

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



                                  $est_area=DB::select("SELECT DISTINCT units.name FROM ecivils JOIN units WHERE units.id=ecivils.units_id AND units.name="."'".$unitss->name."'");




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

      @role('Civil')
              <?php $est_area=DB::select("SELECT COUNT(id) AS count FROM epipes"); 

                if (($est_area[0]->count)!=0){ //VALIDACIÓN SI NO HAY DATA DE ESTIMACIÓN


                 

                        ?>



                      <!-- Proceso para totalizar progreso PIPING --> 


                    <div id="menu_sel" style="height: 50px;border-radius: 4px;transition:200ms" onMouseOver="this.style.background='#E0E0E0'" onMouseOut="this.style.background='white';"><a href="pipes" style="color:black;text-decoration:none;"><h4 style="padding-top: 5px"  onMouseOver="this.style.color='black'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/pipe-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;Piping&nbsp;&nbsp;(Weight: <?php echo $weight_pipe[0]->weight;?>)</h4></a></div>


                    


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

                                    <!-- FILTER VALIDATE  -->

                                    <?php if($filter==1){ ?>

                                            <div align="right" style="font-size: 12px; font-weight: bold"><?php echo "<div style='background-color: #FEE173'>*** WARNING: FILTER APPLIED ! ***&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last Update: ".$updateat_equi[0]->updateat_equi;?></div></div>

                                
                                          <?php }else{ ?>     

                                         <div align="right" style="font-size: 12px; font-weight: bold"><?php echo "Last Update: ".$updateat_equi[0]->updateat_equi;?></div>

                                       <?php } ?>

                                    <!-- END FILTER VALIDATE  -->   

                                        <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="50"
                                          aria-valuemin="0" aria-valuemax="100" style="color:black;font-size: 15px;width:<?php echo round((($sum_per_pipe[0]->total_ppipehours)/($sum_per_epipe[0]->ehrspipes))*100,2)."%"; ?>; ?>;background-color: #A0AFD9">
                                            <span class="sr-only"></span><?php echo round((($sum_per_pipe[0]->total_ppipehours)/($sum_per_epipe[0]->ehrspipes))*100,2)."%"; ?>
                                          </div>
                                        </div>

              <button class="accordion btn btn-lg btn-default" style="padding: 2px 8px;font-size: 14px;">by Areas</button>
              <div class="panela">      
                <br>

                            
                            <!-- por Areas PIPING -->
         

                              @foreach ($units as $unitss)


                            <?php 

                              

                             
                               $ppipes = DB::select("SELECT COUNT(hours) as count, SUM(hours) AS epipeshours_area, SUM(ppipehours) as ppipeshours_area FROM ppipes_area WHERE area="."'".$unitss->name."'");

                               $weight_per_area = DB::select("SELECT SUM(hours) AS weight FROM pipesview WHERE area="."'".$unitss->name."'");

                               if (($ppipes[0]->count)==0){

                           

                                    $epipes = DB::select("SELECT COUNT(units_id) as count FROM epipes WHERE units_id=".$unitss->id); // Validar si el área está estimada 

                                    if (($epipes[0]->count)<>0){?>


                                  
                                    <center><div id="bar_equi" class="progress" style="width: 80%">
                                          <div style="position:absolute;z-index: 1;left:35%;font-size: 13px"><?php echo "Area ".$unitss->name.": ".round(0,2)."%"." (Weight: ".$weight_per_area[0]->weight.")";?></div>
                                          <div class="progress-bar" role="progressbar" style="width:"0%"; ?>;background-color: #B0BED9">

                                            <span class="sr-only"></span>
                                          </div>

                                        </div>
                              </center>    


                                    <?php }


                                  } 

                            $epipe = DB::select("SELECT * FROM pipesview");
                            $nodpipes=0;
                            
                            
                            $epipeshours_area= DB::select("SELECT SUM(hours) as hours FROM pipesview WHERE area="."'".$unitss->name."'"); //total de horas por area

                            

                            if ($ppipes[0]->epipeshours_area <>0) {  

                     
                               $total_pipe = (($ppipes[0]->ppipeshours_area)/($epipeshours_area[0]->hours))*100
                                

                            ?>

                 


                            <center><div id="bar_equi" class="progress" style="width: 80%">
                                          <div style="position:absolute;z-index: 1;left:35%;font-size: 13px"><?php echo "Area ".$unitss->name.": ".round($total_pipe,2)."%"." (Weight: ".$weight_per_area[0]->weight.")";?></div>
                                          <div class="progress-bar" role="progressbar" style="width:<?php echo $total_pipe."%"; ?>;background-color: #B0BED9">

                                            <span class="sr-only"></span>
                                          </div>

                                        </div>
                              </center>              

                             <?php } ?> 

                              @endforeach

                        
                </div>

                        <?php }else{ ?>


                           <div id="menu_sel" style="height: 60px;border-radius: 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9'" onMouseOut="this.style.background='white';"><a href="pipes" style="color:black;text-decoration:none;"><h4 style="padding-top: 10px"  onMouseOver="this.style.color='white'" onMouseOut="this.style.color='black'">&nbsp;&nbsp;<img src="{{ asset('images/pipe-icon.png') }}" style="width:40px;height:40px">&nbsp;&nbsp;&nbsp;Piping</h4></a></div>


                                        <?php 

                                          //$sum_per_pipe = DB::select("SELECT * FROM total_ppipes_view"); 
                                          $sum_per_epipe = DB::select("SELECT SUM(hours) as ehrspipes FROM pipesview");

                                          $weight_per_area= DB::select("SELECT SUM(hours) AS weight FROM pipesview WHERE area="."'".$unitss->name."'");

                                         ?>

                                        <div class="progress">
                                          <div class="progress-bar" role="progressbar" aria-valuenow="50"
                                          aria-valuemin="0" aria-valuemax="100" style="font-size: 16px;width:0%; ?>; ?>;background-color: #533D7A">
                                            <span class="sr-only"></span><?php echo "0%"; ?>
                                          </div>
                                        </div>



                       <?php } ?>

                       <!-- FIN PIPING -->
                       @endrole 
                </div>




          </div>
        </div>
       </div>
     </td>

   </tr>
     </table>
     </div>
    <!--  <h2 style="text-align: center"> <br><b>Sorry! :(

<br><i>*Piping by Areas*</i>&nbsp;&nbsp;is currently in maintenance.</b> 

<br><br><img src="{{ asset('images/maint-logo.png') }}" style="width:80px;height:80px">

<br><br>You can continue using the application through the menu bar.

<br><br><img src="{{ asset('images/menu-sorry.png') }}" style="width:300px;height:75px;"></h1>

<h3 style="text-align: center">For any questions or suggestions, notify to <a href="mailto:jreyess@technip.com">IT-Production</a><h3><br><br>

 -->

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
