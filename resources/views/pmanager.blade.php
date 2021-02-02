@extends('layouts.datatable')

@section('content')
<!-- TOGGLE BUTTON -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 25px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 7px;
  bottom: 3px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #01A1DD;
}

input:focus + .slider {
  box-shadow: 0 0 1px #01A1DD;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">




<?php $sum_per_equi = DB::select("SELECT SUM(total_progress) as sum_per_equi FROM pequis_view"); ?>
<?php $sum_per_civil = DB::select("SELECT SUM(total_progress) as sum_per_civil FROM pcivils_view"); ?> 


<?php 


                          $pipemanager=DB::select("SELECT * FROM `pmanagers` WHERE name='pipe'");
                          $equimanager=DB::select("SELECT * FROM `pmanagers` WHERE name='equi'");
                          $civilmanager=DB::select("SELECT * FROM `pmanagers` WHERE name='civil'"); 
                          $selmanager=DB::select("SELECT * FROM `pmanagers` WHERE name='elect'");
                          $sitmanager=DB::select("SELECT * FROM `pmanagers` WHERE name='inst'"); 
                          $totaldb=DB::select("SELECT SUM(weight) AS total FROM pmanagers");
                          $period = DB::select("SELECT * FROM `pmanagers`"); 

                          $total= $totaldb[0]->total; 

                          $est_pipelines=$pipemanager[0]->quantity;
                          $multiplier=$pipemanager[0]->multiplier;
                          $pipeweight=$pipemanager[0]->weight;
                          $pipepercentage=($pipeweight*100)/$total;

                          $pd_pipelines=$est_pipelines*$multiplier;
                          $total_pipelines=(100*$pd_pipelines)/$pipeweight;

                          $equiweight=$equimanager[0]->weight;
                          $equipercentage=($equiweight*100)/$total;
                          $total_equi=($equiweight*$total_pipelines)/100;

                          $civilweight=$civilmanager[0]->weight;
                          $civilpercentage=($civilweight*100)/$total;
                          $total_civil=($civilweight*$total_pipelines)/100;

                          $selweight=$selmanager[0]->weight;
                          $selpercentage=($selweight*100)/$total;
                          $total_sel=($selweight*$total_pipelines)/100;

                          $sitweight=$sitmanager[0]->weight;
                          $sitpercentage=($sitweight*100)/$total;
                          $total_sit=($sitweight*$total_pipelines)/100;


                          $pequis_view=DB::select("SELECT SUM(`equisview`.`est_hours`) as `mult_estimated` FROM `equisview`");
                          $sum_equi=$pequis_view[0]->mult_estimated;
                          $per_model_equi=$total_equi/$sum_equi;

                          //PROJECT PERIOD
                          $start=$period[0]->start;
                          $end=$period[0]->end;
                          $weeks=$period[0]->weeks;

                          // START WEEK
                          $pipesweek = $pipemanager[0]->startweek;
                          $equisweek = $equimanager[0]->startweek;
                          $civilsweek = $civilmanager[0]->startweek;
                          $selsweek = $selmanager[0]->startweek;
                          $sitsweek = $sitmanager[0]->startweek;

                      ?>

<br>


<br><br>



    <div class="row">
        <div class="container-fluid" style="height: 60%;width: 80%">
            <div class="panel panel-default">
      
                <div class="panel-heading" style="background-color: #ffffff;"><h4>Project Manager</h4></div>

                                       
                                    
                </br>
                     <center>

                    <html>
                      <head>

                        </script>



                      </head>
  <body>

                      <form id="summary" class="form-horizontal" role="form" method="POST" action="{{ url('/updatepmanager') }}">
                        {{ csrf_field() }}
                      

                     
                      <center><!-- <button type="submit" class="btn btn-default btn-lg">Refresh&nbsp;&nbsp;<img src="{{ asset('images/refresh-icon.png') }}" style="width:30px" ></button> -->

                        <h3><b>Project Setup</b></h3></center></br><div class="panel panel-default" id="chart_div1" style="width: 800px; height: 570px">



                      <script type="text/javascript">
                        function mySubmit() {
                                   var theForm = document.forms['summary'];
                                     if (!theForm) {
                                         theForm = document.summary;
                                     }
                                     theForm.submit();
                          }

                      </script>
               


                        <table border="1" bordercolor="#D6D4D3" class="table table-striped"  style="width:100%;font-size: 14px;font-weight: normal;background-color: #FFFFFF">
                            <thead>
                                <tr>
                                  <th colspan="5"><h4><b>Project Period</b></h4></th>
                                </tr>
                               
                            </thead>


                            <tbody class="resultbody" >

                               <?php if ($locked==0){?>   
                                <tr>
                                    <td style="text-align:center;">Start:&nbsp;     
                                        {!! Form::text('start', $start, array('id' => 'datepicker')) !!}
                                    
                                    </td>
                                    <td>End:&nbsp; 
                                         {!! Form::text('end', $end, array('id' => 'datepicker_end')) !!}
                                    
                                    </td>
                                    <td>Weeks:&nbsp; 
                                        {!! Form::number('weeks', $weeks, array('placeholder' => 'Required','class' => 'weeks','style'=>'width:80px;height:30px;border:0px;background-color:#F9F9F9','readonly')) !!}
                                    
                                    </td>
                                    <td style="display:none;">
                                        {!! Form::number('locked', $locked=1, array('placeholder' => 'Required','class' => 'weeks','style'=>'width:80px;height:30px;border:0px;background-color:#F9F9F9','required')) !!}
                                    
                                    </td>
                                    <td>
                                      <center>


                                                        🔓<label class="switch">
                                                          <input onclick="mySubmit();" type="checkbox" name="lock">
                                                          <span class="slider round"></span>
                                                        </label>🔒

                                    </center>
                                  </td>
                                  <td>
                                
                                    <center><button type="submit" class="" style="border:none;background-color: #F9F9F9"><img src="{{ asset('images/refresh-icon.png') }}" style="width:25px"></button></button></center>
                                  </td>

</body>
</html> 

                                        <!-- <button type="submit" style="border:none;background-color: #F9F9F9"><img src="{{ asset('images/unlocked-icon.png') }}" style="width:27px" ></button></center> --></td>
                                    
                                </tr>

                              <?php }else{ ?>

                                <tr>
                                    <td style="text-align:center;">Start:&nbsp;     
                                        {!! Form::text('start', $start, array('id' => 'datepicker_dummy','style' => 'border:none;background-color: #F9F9F9','readonly')) !!}
                                    
                                    </td>
                                    <td>End:&nbsp; 
                                         {!! Form::text('end', $end, array('id' => 'datepicker_end_dummy','style' => 'border:none;background-color: #F9F9F9','readonly')) !!}
                                    
                                    </td>
                                    <td>Weeks:&nbsp; 
                                        {!! Form::number('weeks', $weeks, array('placeholder' => 'Required','class' => 'weeks','style'=>'width:80px;height:30px;border:0px;background-color:#F9F9F9','disabled')) !!}
                                    
                                    </td>
                                    <td style="display:none;">
                                        {!! Form::number('locked', $locked=0, array('placeholder' => 'Required','class' => 'weeks','style'=>'width:80px;height:30px;border:0px;background-color:#F9F9F9','required')) !!}
                                    
                                    </td>
                                    <td> <center> 🔓<label class="switch">
                                                          <input onclick="mySubmit();" type="checkbox" name="lock" checked>
                                                          <span class="slider round"></span>
                                                        </label>🔒</td></center>
                                     <td>
                                
                                    <center><button type="" class="" style="border:none;background-color: #F9F9F9"><img src="{{ asset('images/locked-icon.png') }}" style="width:25px"></button></center>
                                  </td>                    
                                    
                                </tr>

                                       

                              <?php }?>

                            </tbody>

                                <script src="//code.jquery.com/jquery-1.10.2.js"></script>
                                <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
                                <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                              
                                <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                                <script>
                                $(function() {
                                    $( "#datepicker" ).datepicker({
                                      changeMonth: true,
                                      changeYear: true,
                                      dateFormat: 'yy-mm-dd'
                                    });
                                  });

                                $(function() {
                                    $( "#datepicker_end" ).datepicker({
                                      changeMonth: true,
                                      changeYear: true,
                                      dateFormat: 'yy-mm-dd'
                                    });
                                  });
                                </script>


                        </table>  
              
                        <!-- <table border="1" bordercolor="#D6D4D3" class="table table-striped"  style="width:100%;font-size: 14px;font-weight: normal;background-color: #FFFFFF">
                            <thead>
                                <tr>
                                  <th colspan="6"><h4><b>Start Week</b></h4></th>
                                </tr>
                               
                            </thead>

                            <tbody class="resultbody" >
                                <tr>

                                    <?php 

                                         $setting_td=DB::select("SELECT * FROM `hpipes`"); 

                                         if(count($setting_td)>0){ // Se coloca en readonly en caso de existir historial, la idea es no modificar después de generada la primera curva

                                            $setting_td='readonly';
                                            $style_setting_td='background-color:#F9F9F9;border:0;width:80px;height:30px';

                                         }else{

                                            $setting_td='required';
                                            $style_setting_td='width:80px;height:30px';
                                         }


                                    ?>
                                    <td style="text-align:center;">Piping:&nbsp;     
                                        {!! Form::number('sw_pipe', $pipesweek, array('placeholder' => 'Required','class' => 'sw_pipe','style'=>$style_setting_td,$setting_td)) !!}<br>
                                    
                                    </td>
                                    
                                    <?php 

                                         $setting_td=DB::select("SELECT * FROM `hequis`"); 

                                         if(count($setting_td)>0){ // Se coloca en readonly en caso de existir historial, la idea es no modificar después de generada la primera curva

                                            $setting_td='readonly';
                                            $style_setting_td='background-color:#F9F9F9;border:0;width:80px;height:30px';

                                         }else{

                                            $setting_td='required';
                                            $style_setting_td='width:80px;height:30px';

                                         }


                                    ?>

                                    <td>Equipment:&nbsp; 
                                        {!! Form::number('sw_equi', $equisweek, array('placeholder' => 'Required','class' => 'sw_equi','style'=>$style_setting_td,$setting_td)) !!}<br>
                                    
                                    </td>

                                    <td>Civil:&nbsp; 
                                        {!! Form::number('sw_civil', $civilsweek, array('placeholder' => 'Required','class' => 'sw_civil','style'=>'width:80px;height:30px','required')) !!}<br>
                                    
                                    </td>

                                    <td>Instrumentation:&nbsp; 
                                        {!! Form::number('sw_sit', $sitsweek, array('placeholder' => 'Readonly','class' => 'sw_sit','style'=>'width:80px;height:30px','required')) !!}<br>
                                     
                                    </td>
                                    
                                    <td>Electrical:&nbsp; 
                                        {!! Form::number('sw_sel', $selsweek, array('placeholder' => 'Readonly','class' => 'sw_sel','style'=>'width:80px;height:30px','required')) !!}<br>
                                      
                                    </td>
                                    
                                    
                                    
                                    <td><center><button type="submit" class="" style="border:none;background-color: #F9F9F9"><img src="{{ asset('images/refresh-icon.png') }}" style="width:25px"></button></center></td>
                                </tr>

                                  
                            </tbody>

                        </table>   -->

                        <table border="1" bordercolor="#D6D4D3" class="table table-striped"  style="width:100%;font-size: 14px;font-weight: normal;background-color: #FFFFFF">
                            <thead>
                                <tr>
                                  <th colspan="6"><h4><b>Weight Budget</b></h4></th>
                                </tr>
                               
                            </thead>
                            <tbody class="resultbody" >
                                <tr>

                                  <!-- SE COMPRUEBA LA SELECCIÓN DE weight_total PARA PIPING   -->

                                    <?php if ($wtpipe==0){?> 


                                      <td style="text-align:center;width: 150px">Piping&nbsp;<br>
                                        <br>
                                        <font Size=2>Area</font>
                                        {{ Form::radio('wtpipe', '0' , true) }}
                                        {{ Form::radio('wtpipe', '1' , false) }}
                                        <font Size=2>Total</font>

                                        <br><br>                  
                                    
                                    <?php }else{ ?>


                                      <td style="text-align:center;width: 150px">Piping&nbsp;<br>
                                         <br>
                                         <font Size=2>Area</font>
                                         {{ Form::radio('wtpipe', '0' , false) }}
                                         {{ Form::radio('wtpipe', '1' , true) }}
                                         <font Size=2>Total</font>
                                         <br><br>
                                                         


                                    <?php } ?>    
                                    <!-- FIN COMPROBACIÓN   -->
                                     
                                        {!! Form::number('pd_pipe', $pipeweight, array('placeholder' => 'Required','class' => 'pd_pipe','style'=>'width:80px;height:30px','required')) !!}<br><div style="text-align: center;font-weight: bold"><?php echo round($pipepercentage); ?>% </div>
                                                       
                                    </td>
                                    
                                      <!-- SE COMPRUEBA LA SELECCIÓN DE weight_total PARA EQUIPMENT  -->

                                    <?php if ($wtequi==0){?> 


                                      <td style="text-align:center;width: 150px">Equipment&nbsp;<br>
                                        <br>
                                        <font Size=2>Area</font>
                                        {{ Form::radio('wtequi', '0' , true) }}
                                        {{ Form::radio('wtequi', '1' , false) }}
                                        <font Size=2>Total</font>

                                        <br><br>                  
                                    
                                    <?php }else{ ?>


                                      <td style="text-align:center;width: 150px">Equipment&nbsp;<br>
                                         <br>
                                         <font Size=2>Area</font>
                                         {{ Form::radio('wtequi', '0' , false) }}
                                         {{ Form::radio('wtequi', '1' , true) }}
                                         <font Size=2>Total</font>
                                         <br><br>
                                                         


                                    <?php } ?>    
                                    <!-- FIN COMPROBACIÓN   -->


                                        {!! Form::number('pd_equi', $equiweight, array('placeholder' => 'Required','class' => 'pd_equi','style'=>'width:80px;height:30px','required')) !!}<br><div style="text-align: center;font-weight: bold"><?php echo round($equipercentage); ?>% </div>
                                    
                                    </td>
                                    <!-- SE COMPRUEBA LA SELECCIÓN DE weight_total PARA CIVIL  -->

                                    <?php if ($wtcivil==0){?> 


                                      <td style="text-align:center;width: 150px">Civil&nbsp;<br>
                                        <br>
                                        <font Size=2>Area</font>
                                        {{ Form::radio('wtcivil', '0' , true) }}
                                        {{ Form::radio('wtcivil', '1' , false) }}
                                        <font Size=2>Total</font>

                                        <br><br>                  
                                    
                                    <?php }else{ ?>


                                      <td style="text-align:center;width: 150px">Civil&nbsp;<br>
                                         <br>
                                         <font Size=2>Area</font>
                                         {{ Form::radio('wtcivil', '0' , false) }}
                                         {{ Form::radio('wtcivil', '1' , true) }}
                                         <font Size=2>Total</font>
                                         <br><br>
                                                         


                                    <?php } ?>    
                                    <!-- FIN COMPROBACIÓN   -->
                                        {!! Form::number('pd_civil', $civilweight, array('placeholder' => 'Required','class' => 'pd_civil','style'=>'width:80px;height:30px','required')) !!}<br><div style="text-align: center;font-weight: bold"><?php echo round($civilpercentage); ?>% </div>
                                    
                                    </td>

                                    <!-- SE COMPRUEBA LA SinstCIÓN DE weight_total PARA INSTRUMENTATION  -->

                                    <?php if ($wtinst==0){?> 


                                      <td style="text-align:center;width: 150px">Instrumentation&nbsp;<br>
                                        <br>
                                        <font Size=2>Area</font>
                                        {{ Form::radio('wtinst', '0' , true) }}
                                        {{ Form::radio('wtinst', '1' , false) }}
                                        <font Size=2>Total</font>

                                        <br><br>                  
                                    
                                    <?php }else{ ?>


                                      <td style="text-align:center;width: 150px">Instrumentation&nbsp;<br>
                                         <br>
                                         <font Size=2>Area</font>
                                         {{ Form::radio('wtinst', '0' , false) }}
                                         {{ Form::radio('wtinst', '1' , true) }}
                                         <font Size=2>Total</font>
                                         <br><br>
                                                         


                                    <?php } ?>    
                                    <!-- FIN COMPROBACIÓN   -->
                                        {!! Form::number('pd_sit', $sitweight, array('placeholder' => 'Readonly','class' => 'pd_sit','style'=>'width:80px;height:30px','required')) !!}<br><div style="text-align: center;font-weight: bold"><?php echo round($sitpercentage); ?>% </div>
                                     
                                    </td> 

                                    <!-- SE COMPRUEBA LA SELECCIÓN DE weight_total PARA ELECTRICAL  -->

                                    <?php if ($wtelec==0){?> 


                                      <td style="text-align:center;width: 150px">Electrical&nbsp;<br>
                                        <br>
                                        <font Size=2>Area</font>
                                        {{ Form::radio('wtelec', '0' , true) }}
                                        {{ Form::radio('wtelec', '1' , false) }}
                                        <font Size=2>Total</font>

                                        <br><br>                  
                                    
                                    <?php }else{ ?>


                                      <td style="text-align:center;width: 150px">Electrical&nbsp;<br>
                                         <br>
                                         <font Size=2>Area</font>
                                         {{ Form::radio('wtelec', '0' , false) }}
                                         {{ Form::radio('wtelec', '1' , true) }}
                                         <font Size=2>Total</font>
                                         <br><br>
                                                         


                                    <?php } ?>    
                                    <!-- FIN COMPROBACIÓN   -->
                                        {!! Form::number('pd_sel', $selweight, array('placeholder' => 'Readonly','class' => 'pd_sel','style'=>'width:80px;height:30px','required')) !!}<br><div style="text-align: center;font-weight: bold"><?php echo round($selpercentage); ?>% </div>
                                      
                                    </td>
                                    
                                    <td><center><button type="submit" class="" style="border:none;background-color: #F9F9F9"><img src="{{ asset('images/refresh-icon.png') }}" style="width:25px"></button></center></td>
                                </tr>

                                  
                            </tbody>

                        </table>  

                         <table border="1" bordercolor="#D6D4D3"  class="table table-striped"  style="width:100%;font-size: 14px;font-weight: normal;background-color: #FFFFFF">
                            <thead>
                                <tr>
                                  <th colspan="5"><h4><b>Types</b></h4></th>
                                </tr>
                                
                            </thead>
                            <tbody class="resultbody" style="margin-left: 40%">
                                <tr>
                                    
                                    <td style="">
                                        <button onclick="location.href='{{ url('typesequi') }}'" type="button" class="btn btn-default btn-lg">EQP&nbsp;&nbsp;<img src="{{ asset('images/equi-icon.png') }}" style="width:50px" ></button>
                                    </td>
                                     <td style="">
                                        <button onclick="location.href='{{ url('typescivil') }}'" type="button" class="btn btn-default btn-lg">CIV&nbsp;&nbsp;<img src="{{ asset('images/stru-icon.png') }}" style="width:50px" ></button>
                                    </td>
                                    <td style="">
                                        <button onclick="location.href='{{ url('typesinst') }}'" type="button" class="btn btn-default btn-lg">INS&nbsp;&nbsp;<img src="{{ asset('images/inst-icon.png') }}" style="width:50px" ></button>
                                    </td>
                                    <td style="">
                                        <button onclick="location.href='{{ url('typeselec') }}'" type="button" class="btn btn-default btn-lg">ELE&nbsp;&nbsp;<img src="{{ asset('images/elec-icon.png') }}" style="width:50px" ></button>
                                    </td>
                                    <!-- <td>
                                        <button onclick="location.href='{{ url('typesequi') }}'" type="button" class="btn btn-default btn-lg">SOE&nbsp;&nbsp;<img src="{{ asset('images/stru-icon.png') }}" style="width:50px" ></button>
                                    </td>
                                
                                    <td>
                                        <button onclick="location.href='{{ url('typesequi') }}'" type="button" class="btn btn-default btn-lg">SEL&nbsp;&nbsp;<img src="{{ asset('images/elec-icon.png') }}" style="width:50px" ></button>
                                    </td>
                                    <td>
                                        <button onclick="location.href='{{ url('typesequi') }}'" type="button" class="btn btn-default btn-lg">SIT&nbsp;&nbsp;<img src="{{ asset('images/inst-icon.png') }}" style="width:50px" ></button>
                                    </td> -->
                                    
                                </tr>


                            </tbody>



                        </table> 
                          
                     </div>

                     @if ($message = Session::get('warning'))
                          <br>
                          <br>

                                  <div class="alert alert-warning"> 
                                      <p>{{ $message }}</p>
                                  </div>

                              @endif

                    
                        
                      <center>

                          </form>

                          </br>
                              
                        <!-- <center><h4>Summary</h4> --><div class="panel panel-default" id="chart_div1" style="width: 800px; height: 170px; display:none;"> 
            
                    <!-- Cálculos resumen -->

                      


                        <table class="table table-striped" style="width:100%;font-size: 14px;font-weight: normal">
                            <thead>
                                <tr>
                                    <th>Piping</th>
                                    <th>Equipment</th>
                                    <th>Civil</th>
                                    <th>Electricity</th>
                                    <th>Instrumentation</th>
                                
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                                <tr>
                                    <td>    
                                        <?php echo round($total_pipelines); ?>
                                    </td>
                                    <td>
                                        <?php echo round($total_equi); ?>
                                    </td>
                                    <td>
                                        <?php echo round($total_civil); ?>
                                    </td>
                                    <td>
                                        <?php echo round($total_sel); ?>
                                    </td>
                                    <td>
                                        <?php echo round($total_sit); ?>
                                    </td>
                                </tr>
                                <div id="summary" style="">
                                <tr>
                                    <td>    
                                        {!! Form::number('total_pipelines', round($total_pipelines*100)/100, array('placeholder' => 'Required','class' => 'total_pipelines','heigth'=>'3px' ,'style'=>'width:100px','disabled')) !!}
                                    </td>
                                    <td>
                                        <?php echo round($per_model_equi*100)/100;echo "%";?>
                                    </td>
                                    <td>
                                        {!! Form::number('total_civil', round($total_civil*100)/100, array('placeholder' => 'Required','class' => 'total_civil','style'=>'width:100px','disabled')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('total_sel', round($total_sel*100)/100, array('placeholder' => 'Readonly','class' => 'total_sel','style'=>'width:100px','disabled')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('total_sit', round($total_sit*100)/100, array('placeholder' => 'Readonly','class' => 'total_sit','style'=>'width:100px','disabled')) !!}
                                    </td>
                                </tr>
                              </div>
                            </tbody>

                        </table>  
                      </div>
  </body>
</html>
                  </tr>


<div class="panel-body">
                    
                </div>
            </div>
        </div>
    </div>
    

</div>



@include('common.footer')
@endsection
