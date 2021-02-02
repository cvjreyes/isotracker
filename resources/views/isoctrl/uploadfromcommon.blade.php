@if (Auth::guest())

@else


<script type="text/javascript" src="{!! asset('js/jquery.js') !!}"></script>

<style type="text/css">
    

.dgcAlert {top: 0;position: absolute;width: 100%;display: block;height: 1000px; background: url(http://www.dgcmedia.es/recursosExternos/fondoAlert.png) repeat; text-align:center; opacity:0; display:none; z-index:999999999999999;}
.dgcAlert .dgcVentana{width: 500px; background: white;min-height: 150px;position: relative;margin: 0 auto;color: black;padding: 10px;border-radius: 10px;}
.dgcAlert .dgcVentana .dgcCerrar {height: 25px;width: 25px;float: right; cursor:pointer; background: url(http://www.dgcmedia.es/recursosExternos/cerrarAlert.jpg) no-repeat center center;}
.dgcAlert .dgcVentana .dgcMensaje { margin: 0 auto; padding-top: 0px; text-align: center; width: 400px;font-size: 20px;}
.dgcAlert .dgcVentana .dgcAceptar{background:#09C; bottom:20px; display: inline-block; font-size: 12px; font-weight: bold; height: 24px; line-height: 24px; padding-left: 5px; padding-right: 5px;text-align: center; text-transform: uppercase; width: 75px;cursor: pointer; color:#FFF; margin-top:25px;}

</style>
<script type="text/javascript">
    
function alertDGC(mensaje)
    {
    var dgcTiempo=500
    var ventanaCS='<div class="dgcAlert"><div class="dgcVentana"><div class="dgcCerrar"></div><div class="dgcMensaje">'+mensaje+'<br><div class="dgcAceptar">CLOSE</div></div></div></div>';
    $('body').append(ventanaCS);
    var alVentana=$('.dgcVentana').height();
    var alNav=$(window).height();
    var supNav=0//$(window).scrollTop();
    $('.dgcAlert').css('height',$(document).height());
    $('.dgcVentana').css('top',(30)+'%');
    //$('.dgcVentana').css('top',((alNav-alVentana)/2+supNav-100)+'px');
    $('.dgcAlert').css('display','block');
    $('.dgcAlert').animate({opacity:1},dgcTiempo);
     $('.dgcCerrar,.dgcAceptar').click(function(e) {
         $('.dgcAlert').animate({opacity:0},dgcTiempo);
         setTimeout("$('.dgcAlert').remove()",dgcTiempo);
     });
        }
        window.alert = function (message) {
          alertDGC(message);
        };


</script>

<script type="text/javascript">

// función para advertir nombre diferente de archivo al subir y habilitar botón.

$("document").ready(function(){


      $("#pdfspo").change(function() {

       var file_ext = $(".filename").val();
       var file_split = file_ext.split(".");
       var file = file_split[0];

       var uplfile_pdfspo_tmp = $("#pdfspo").val();
       var uplfile_pdfspo_ext = uplfile_pdfspo_tmp.substr(12); // 12 comprende C:\FAKEPATH
       var uplfile_pdfspo_split = uplfile_pdfspo_ext.split(".");
       var uplfile_pdfspo = uplfile_pdfspo_split[0];

      //$("#upload").prop('disabled', false); 

      if ((file != uplfile_pdfspo)){
          
          alert("WARNING! The file you are trying to upload has a different name than the original. Please, try again.");
          $("#pdfspo").val('');
          //$("#upload").prop('disabled', true);

      }

    });

        $("#pdfsit").change(function() {

       var file_ext = $(".filename").val();
       var file_split = file_ext.split(".");
       var file = file_split[0];

       var uplfile_pdfsit_tmp = $("#pdfsit").val();
       var uplfile_pdfsit_ext = uplfile_pdfsit_tmp.substr(12); // 12 comprende C:\FAKEPATH
       var uplfile_pdfsit_split = uplfile_pdfsit_ext.split(".");
       var uplfile_pdfsit = uplfile_pdfsit_split[0];

      //$("#upload").prop('disabled', false); 

      if ((file != uplfile_pdfsit)){
          
          alert("WARNING! The file you are trying to upload has a different name than the original. Please, try again.");
          $("#pdfsit").val('');
          //$("#upload").prop('disabled', true);

      }

    });

});
    


</script>

    
    <div class="modal fade" id="uploadfromcommonModal" style="top:20%"; 
     tabindex="-1" role="dialog" 
     aria-labelledby="uploadfromcommonModalLabel">
   <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
       
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="panel-body">


                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>


        
                   <form style="background-color: #F5F8FA" method="POST" action="{{route('subircommon')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                      {{ csrf_field() }}

                    {!! Form::text('pathfrom', null, array('class' => 'pathfrom','style' => 'display:none','readonly')) !!}

                    {!! Form::text('requestbydesign', null, array('class' => 'requestbydesign','style' => 'display:none','readonly')) !!}

                    {!! Form::text('requestbylead', null, array('class' => 'requestbylead','style' => 'display:none','readonly')) !!}

                    {!! Form::text('claimed', null, array('class' => 'claimed','style' => 'display:none','readonly')) !!}

                    {!! Form::text('verifydesign', null, array('class' => 'verifydesign','style' => 'display:none','readonly')) !!}
                    
                    {!! Form::text('verifystress', null, array('class' => 'verifystress','style' => 'display:none','readonly')) !!}

                    {!! Form::text('verifysupports', null, array('class' => 'verifysupports','style' => 'display:none','readonly')) !!}

                      <br><center><label for="archivo" style="padding-right: 50%">{!! Form::text('filename', null, array('placeholder' => 'filename','class' => 'filename','style' => 'text-align:center;border:2px;width: 280%;font-size: 16px;font-weight: bold;background: #F5F8FA;border:0px','readonly')) !!}</label></center><br>

                      

                      <center>
                         

                        <?php if (auth()->user()->hasRole('ProcessLead')){ ?> 

                          <table>                               
                            <tr> 
                          <select name='procapprej' style="height:34px;font-size: 14px;font-weight: normal;border-radius: 6px;">                             
                                <option value="2">Approve</option>
                                <option value="3">Reject</option>  
                             </select>
                          </tr>
                          <br><tr>-</tr>
                          <tr><td><a class="btn btn-xs btn-primary"><b>Process PDF</b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                          <td><input id="pdfspo" border="0" type="file" accept="application/pdf" style="width: 130%" class="btn btn-sm btn-default" name="pdfspo" required></td></tr>
                          
                            </tr>
                       </table> 

                        <?php } ?>

                        <?php if (auth()->user()->hasRole('InstrumentLead')){ ?> 

                        <table>                               
                          <tr> 
                          <select name='instapprej' style="height:34px;font-size: 14px;font-weight: normal;border-radius: 6px;">                             
                                <option value="2">Approve</option>
                                <option value="3">Reject</option>  
                             </select>
                          </tr>
                          <br><tr>-</tr>
                          <tr><td><a class="btn btn-xs btn-primary"><b>Instrumentation PDF</b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                          <td><input id="pdfsit" border="0" type="file" accept="application/pdf" style="width: 130%" class="btn btn-sm btn-default" name="pdfsit" required></td></tr>

                          </tr>
                       </table>

                        <?php } ?>

                      <br>
                      <div style="background: #FFFF34;border-radius: 6px;">
                        <font size="3" style="font-weight: bold;background: #FFFF34" color="black">***WARNING!*** This action will replace the current(s) file(s). Take appropriate cautions.</font><br>
                        <font size="2" style="background: #FFFF34" color="black">If you are not sure of this action, click cancel and contact your supervisor.</font>
                      </div>
                      <br><br>
                       <input id="upload" onclick="" type="submit" class="btn btn-lg btn-info" style="padding: 8px 16px;font-size: 12px;" value="Check">
                       <input type="submit" class="btn btn-lg btn-default" data-dismiss="modal" style="padding: 8px 16px;font-size: 12px;" value="Cancel">
                    </center>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>


   {!! Form::close() !!}
@endif