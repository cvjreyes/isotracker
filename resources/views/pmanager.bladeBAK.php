@extends('layouts.datatable')

@section('content')




<?php $sum_per_equi = DB::select("SELECT SUM(total_progress) as sum_per_equi FROM pequis_view"); ?>
<?php $sum_per_civil = DB::select("SELECT SUM(total_progress) as sum_per_civil FROM pcivils_view"); ?> 


<?php 


                          $pipemanager=DB::select("SELECT * FROM `pmanagers` WHERE name='pipe'");
                          $equimanager=DB::select("SELECT * FROM `pmanagers` WHERE name='equi'");
                          $civilmanager=DB::select("SELECT * FROM `pmanagers` WHERE name='civil'"); 
                          $selmanager=DB::select("SELECT * FROM `pmanagers` WHERE name='elect'");
                          $sitmanager=DB::select("SELECT * FROM `pmanagers` WHERE name='inst'");  

                          $est_pipelines=$pipemanager[0]->quantity;
                          $multiplier=$pipemanager[0]->multiplier;
                          $pipepercentage=$pipemanager[0]->percentage;

                          $pd_pipelines=$est_pipelines*$multiplier;
                          $total_pipelines=(100*$pd_pipelines)/$pipepercentage;

                          $equipercentage=$equimanager[0]->percentage;
                          $total_equi=($equipercentage*$total_pipelines)/100;

                          $civilpercentage=$civilmanager[0]->percentage;
                          $total_civil=($civilpercentage*$total_pipelines)/100;

                          $selpercentage=$selmanager[0]->percentage;
                          $total_sel=($selpercentage*$total_pipelines)/100;

                          $sitpercentage=$sitmanager[0]->percentage;
                          $total_sit=($sitpercentage*$total_pipelines)/100;


                          $pequis_view=DB::select("SELECT SUM(`equisview`.`est_hours`) as `mult_estimated` FROM `equisview`");
                          $sum_equi=$pequis_view[0]->mult_estimated;
                          $per_model_equi=$total_equi/$sum_equi;




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
                        
                      <center><h3><b>Budget of Hours</b></h3></center></br><div class="panel panel-default" id="chart_div1" style="width: 800px; height: 170px">

                      <script type="text/javascript">
                        function mySubmit() {
                                   var theForm = document.forms['summary'];
                                     if (!theForm) {
                                         theForm = document.summary;
                                     }
                                     theForm.submit();
                          }

                      </script>

                        <table class="table table-striped"  style="width:100%;font-size: 14px;font-weight: normal">
                            <thead>
                                <tr>
                                    <th><h5><b>STU</b></h5></th>
                                    <th><h5><b>EQP</b></h5></th>
                                    <th><h5><b>SOE</b></h5></th>
                                    <th><h5><b>SEL</b></h5></th>
                                    <th><h5><b>SIT</b></h5></th>
                                
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                                <tr>
                                    <td>    
                                        {!! Form::number('pd_pipe', $pipepercentage, array('placeholder' => 'Required','class' => 'pd_pipe','style'=>'width:80px;height:30px','required')) !!}
                                        </br>(30-65)
                                    </td>
                                    <td>
                                        {!! Form::number('pd_equi', $equipercentage, array('placeholder' => 'Required','class' => 'pd_equi','style'=>'width:80px;height:30px','required')) !!}
                                        </br>(15-25)
                                    </td>
                                    <td>
                                        {!! Form::number('pd_civil', $civilpercentage, array('placeholder' => 'Required','class' => 'pd_civil','style'=>'width:80px;height:30px','required')) !!}
                                        </br>(10-30)
                                    </td>
                                    <td>
                                        {!! Form::number('pd_sel', $selpercentage, array('placeholder' => 'Readonly','class' => 'pd_sel','style'=>'width:80px;height:30px','readonly')) !!}
                                        </br>(1-5)
                                    </td>
                                    <td>
                                        {!! Form::number('pd_sit', $sitpercentage, array('placeholder' => 'Readonly','class' => 'pd_sit','style'=>'width:80px;height:30px','readonly')) !!}
                                        </br>(1-5)
                                    </td>
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

                    
                        
                      <center><h4>Estimation of Pipes</h4><div class="panel panel-default" id="chart_div1" style="width: 800px; height: 170px"> 
            
                        <table class="table table-striped" style="width:100%;font-size: 14px;font-weight: normal">
                            <thead>
                                <tr>
                                    <th>Estimated PipeLines</th>
                                    <th>Multiplier</th>                               
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                                <tr>
                                    <td style="height: 30px">
                                        {!! Form::number('est_pipelines', $est_pipelines, array('placeholder' => 'Quantity','class' => 'est_pipelines','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('multiplier', $multiplier, array('placeholder' => 'Required','class' => 'multiplier','readonly')) !!}
                                    </td>
                    
                                </tr>

                            </tbody>

                        </table>  
                          
                     </div>

                          </form>

                          </br>
                              
                        <center><h4>Summary</h4><div class="panel panel-default" id="chart_div1" style="width: 800px; height: 170px"> 
            
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
                                <div id="summary">
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
