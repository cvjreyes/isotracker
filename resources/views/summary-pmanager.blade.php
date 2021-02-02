



<?php $sum_per_equi = DB::select("SELECT SUM(total_progress) as sum_per_equi FROM pequis_view"); ?>
<?php $sum_per_civil = DB::select("SELECT SUM(total_progress) as sum_per_civil FROM pcivils_view"); ?> 


<?php 


                          $pipemanager=DB::select("SELECT * FROM `pmanagers` WHERE name='pipe'");
                          $equimanager=DB::select("SELECT * FROM `pmanagers` WHERE name='equi'");
                          $civilmanager=DB::select("SELECT * FROM `pmanagers` WHERE name='civil'"); 
                          $selsitmanager=DB::select("SELECT * FROM `pmanagers` WHERE name='selsit'"); 

                          $est_pipelines=$pipemanager[0]->quantity;
                          $multiplier=$pipemanager[0]->multiplier;
                          $pipepercentage=$pipemanager[0]->percentage;

                          $pd_pipelines=$est_pipelines*$multiplier;
                          $total_pipelines=(100*$pd_pipelines)/$pipepercentage;

                          $equipercentage=$equimanager[0]->percentage;
                          $total_equi=($equipercentage*$total_pipelines)/100;

                          $civilpercentage=$civilmanager[0]->percentage;
                          $total_civil=($civilpercentage*$total_pipelines)/100;

                          $selsitpercentage=$selsitmanager[0]->percentage;
                          $total_selsit=($selsitpercentage*$total_pipelines)/100;


                          $pequis_view=DB::select("SELECT SUM(`equisview`.`est_hours`) as `mult_estimated` FROM `equisview`");
                          $sum_equi=$pequis_view[0]->mult_estimated;
                          $per_model_equi=$total_equi/$sum_equi;




                      ?>

<br>


<br><br>




    <div class="row">
        <div class="container-fluid" style="height: 60%;width: 80%">
            <div class="panel panel-default">
      
               
                </br>
                     <center>

                    <html>
                      <head>

                        </script>



                      </head>
  <body>
                      <form class="form-horizontal" role="form" method="POST" action="{{ url('/updatepmanager') }}">
                        {{ csrf_field() }}
                        
                      
                            <tbody class="resultbody">
                                <tr>
                                    <td>    
                                        <?php echo $total_pipelines; ?>
                                    </td>
                                    <td>
                                        <?php echo $total_equi; ?>
                                    </td>
                                    <td>
                                        <?php echo $total_civil; ?>
                                    </td>
                                    <td>
                                        <?php echo $total_selsit; ?>
                                    </td>
                    
                                </tr>
                                <div id="summary">
                                <tr>
                                    <td>    
                                        {!! Form::number('total_pipelines', $total_pipelines, array('placeholder' => 'Required','class' => 'total_pipelines','heigth'=>'3px' ,'disabled')) !!}
                                    </td>
                                    <td>
                                        <?php echo round($per_model_equi*100)/100;echo "%";?>
                                    </td>
                                    <td>
                                        {!! Form::number('total_civil', $total_civil, array('placeholder' => 'Required','class' => 'total_civil','disabled')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('total_selsit', $total_selsit, array('placeholder' => 'Readonly','class' => 'total_selsit','disabled')) !!}
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


