          <?php if ((auth()->user()->hasRole('DesignAdmin')) OR (auth()->user()->hasRole('LeadAdmin'))){ ?> 
          <center>
            <?php //if ($requested[0]->tie==1){ ?>  <!-- Switch para enviar o cancelar solicitud -->

                 <!-- <a href="chktie/<?php echo $filename[$i]; ?>/0" class="btn btn-xs btn-warning" data-filename ="<?php echo $filename[$i]; ?>" data-request = "0"><b>TIE</b></a>
                 {!! Form::text('tie[]', 1, array('style' => 'display:none')) !!} -->

            <?php //}elseif($requested[0]->tie==0){ ?>
         
                <!--   <a href="chktie/<?php echo $filename[$i]; ?>/1" class="btn btn-xs btn-default" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1"><b>TIE</b></a>
                  {!! Form::text('tie[]', 0, array('style' => 'display:none')) !!} -->

            <?php //}elseif($requested[0]->tie==2){ ?>

                    <!-- <a href="chktie/<?php echo $filename[$i]; ?>/4" class="btn btn-xs btn-success" data-filename ="<?php echo $filename[$i]; ?>" data-request = "4"><b>TIE</b></a>
                  {!! Form::text('tie[]', 0, array('style' => 'display:none')) !!} -->
         

            <?php //}elseif($requested[0]->tie==3){ ?>
         
                  <!-- <a class="btn btn-xs btn-danger" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1"><b>TIE</b></a>
                  {!! Form::text('tie[]', 0, array('style' => 'display:none')) !!} -->

            <?php //}elseif($requested[0]->tie==4){ ?>
         
                  <!-- <a class="btn btn-xs btn-success" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1"><b>TIE</b></a>
                  {!! Form::text('tie[]', 0, array('style' => 'display:none')) !!}        -->        

            <?php //} ?>

            <?php if ($requested[0]->spo==1 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>  <!-- Switch para enviar o cancelar solicitud -->

                 <a href="chkspo/<?php echo $filename[$i]; ?>/0" class="btn btn-xs btn-warning" data-filename ="<?php echo $filename[$i]; ?>" data-request = "0"><b>P</b></a>
                 {!! Form::text('spo[]', 1, array('style' => 'display:none')) !!}

            <?php }elseif($requested[0]->spo==0 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>
         
                  <a href="chkspo/<?php echo $filename[$i]; ?>/1" class="btn btn-xs btn-default" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1"><b>P</b></a>
                  {!! Form::text('spo[]', 0, array('style' => 'display:none')) !!}

            <?php }elseif($requested[0]->spo==2 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>
         
                  <a class="btn btn-xs btn-success" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1"><b>P</b></a>
                  {!! Form::text('spo[]', 0, array('style' => 'display:none')) !!}

            <?php }elseif($requested[0]->spo==3 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>
         
                  <a class="btn btn-xs btn-danger" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1"><b>P</b></a>
                  {!! Form::text('spo[]', 0, array('style' => 'display:none')) !!}             

            <?php } ?>

            <?php if ($requested[0]->sit==1 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>  <!-- Switch para enviar o cancelar solicitud -->

                 <a href="chksit/<?php echo $filename[$i]; ?>/0" class="btn btn-xs btn-warning" data-filename ="<?php echo $filename[$i]; ?>" data-request = "0"><b>I</b></a>
                 {!! Form::text('sit[]', 1, array('style' => 'display:none')) !!}

            <?php }elseif($requested[0]->sit==0 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>
         
                  <a href="chksit/<?php echo $filename[$i]; ?>/1" class="btn btn-xs btn-default" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1"><b>I</b></a>
                  {!! Form::text('sit[]', 0, array('style' => 'display:none')) !!}

            <?php }elseif($requested[0]->sit==2 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>
         
                  <a class="btn btn-xs btn-success" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1"><b>I</b></a>
                  {!! Form::text('sit[]', 0, array('style' => 'display:none')) !!}

            <?php }elseif($requested[0]->sit==3 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>
         
                  <a class="btn btn-xs btn-danger" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1"><b>I</b></a>
                  {!! Form::text('sit[]', 0, array('style' => 'display:none')) !!}             

            <?php } ?>

          </center>

            <?php }else{ ?>

          <center>
        
          <?php if ($requested[0]->spo==1 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>  

                 <a class="btn btn-xs btn-warning"><b>P</b></a>

            <?php }elseif($requested[0]->spo==0 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>
         
                  <a class="btn btn-xs btn-default"><b>P</b></a>

            <?php }elseif($requested[0]->spo==2 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>
         
                  <a class="btn btn-xs btn-success"><b>P</b></a>

            <?php }elseif($requested[0]->spo==3 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>
         
                  <a class="btn btn-xs btn-danger"><b>P</b></a>    

            <?php } ?>

            <?php if ($requested[0]->sit==1 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>  <!-- Switch para enviar o cancelar solicitud -->

                 <a class="btn btn-xs btn-warning"><b>I</b></a>

            <?php }elseif($requested[0]->sit==0 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>
         
                  <a class="btn btn-xs btn-default"><b>I</b></a>

            <?php }elseif($requested[0]->sit==2 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>
         
                  <a class="btn btn-xs btn-success"><b>I</b></a>

            <?php }elseif($requested[0]->sit==3 AND $requested[0]->deleted==0 AND $requested[0]->issued!=2){ ?>
         
                  <a class="btn btn-xs btn-danger"><b>I</b></a>             

            <?php } ?>

          </center> 
 
        <?php } ?>