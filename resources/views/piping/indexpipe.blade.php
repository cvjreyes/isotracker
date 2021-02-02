@if (Auth::guest())

@else

@extends('layouts.datatable')

@section('content')

<!-- CSS PARA ALERT PERSONALIZADO-->
<style type="text/css">
    

.dgcAlert {top: 0;position: absolute;width: 100%;display: block;height: 1000px; background: url(http://www.dgcmedia.es/recursosExternos/fondoAlert.png) repeat; text-align:center; opacity:0; display:none; z-index:999999999999999;}
.dgcAlert .dgcVentana{width: 500px; background: white;min-height: 150px;position: relative;margin: 0 auto;color: black;padding: 10px;border-radius: 10px;}
.dgcAlert .dgcVentana .dgcCerrar {height: 25px;width: 25px;float: right; cursor:pointer; background: url(http://www.dgcmedia.es/recursosExternos/cerrarAlert.jpg) no-repeat center center;}
.dgcAlert .dgcVentana .dgcMensaje { margin: 0 auto; padding-top: 0px; text-align: center; width: 400px;font-size: 20px;}
.dgcAlert .dgcVentana .dgcAceptar{background:#09C; bottom:20px; display: inline-block; font-size: 12px; font-weight: bold; height: 24px; line-height: 24px; padding-left: 5px; padding-right: 5px;text-align: center; text-transform: uppercase; width: 75px;cursor: pointer; color:#FFF; margin-top:25px;}

</style>

<script type="text/javascript">
    


</script>


</script>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script type="text/javascript">

<?php $areas = DB::table('areas')->pluck('name')->all();
              $tpipes = DB::table('tpipes')->pluck('code')->all(); 
              ?>


    $(function () {
        $('.add').click(function () {

            var n = ($('.resultbody tr').length - 0) + 1;
             var tr = '<tr class="fila">' +
                    '<td>{!! Form::select('units_id[]', [null => 'Select Unit...'] + $units, null, array( 'style'=>'height:34px;font-size: 14px;font-weight: normal;','required')) !!}</td>'+
                    '<td>{!! Form::select('areas_id[]', [null => 'Select Area...'] + $areas, null, array( 'style'=>'height:34px;font-size: 14px;font-weight: normal;','required')) !!}</td>'+
                    '<td>{!! Form::select('tequis_id[]', [null => 'Select Type...'] + $tpipes, null, array( 'style'=>'height:34px;font-size: 14px;font-weight: normal;','required')) !!}</td>'+
                    '<td>{!! Form::text('tag[]', null, array('placeholder' => 'Tag','class' => 'form-control','style' => 'font-size: 14px;font-weight: normal;','required')) !!}</td>'+
                    '<td>{!! Form::number('est_qty[]', null, array('placeholder' => 'Qty','class' => 'form-control','style' => 'width: 70px;font-size: 14px;font-weight: normal;','required')) !!}</td>'+
                    '<td><input type="button" class="btn btn-danger delete" value="x"></td></tr>';
            $('.resultbody').append(tr);
        });

        $('.resultbody').delegate('.delete', 'click', function () {
            $(this).parent().parent().remove();
        });

        $('.resultbody').delegate('.obtainedmarks , .totalmarks', 'keyup', function () {
            var tr = $(this).parent().parent();
            var obtainedmarks = tr.find('.obtainedmarks').val() - 0;
            var totalmarks = tr.find('.totalmarks').val() - 0;

            var percentage = (obtainedmarks / totalmarks) * 100;
            tr.find('.percentage').val(percentage);
        });
    });


   
</script>




                            <script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s2").style.fontWeight='bold';
                                     document.getElementById("s2").style.fontSize=10 + "pt";
                                     document.getElementById("s2").style.fontStyle="italic";;


                                 }

                            </script> 


<script type="text/javascript">


    
      
 // SHOW/UPDATE PIPE 
   $(document).on('click', '.edit-pipe-modal', function() {
                         

       $('.id').val($(this).data('id'));

       $('.units_id').val($(this).data('units_id'));
       $('.diameters_id').val($(this).data('diameters_id'));
       $('.line_number').val($(this).data('line_number'));
       $('.pdms_linenumber').val($(this).data('pdms_linenumber'));
                  

   });

  
  // SHOW/UPDATE CNOTES PIPE
$(document).on('click', '.edit-cnotes-modal', function() {
         
        
         
             //$('#est_qtya').val($(this).data('est_qty'));
            $('.id').val($(this).data('id'));


            $('.units_id').val($(this).data('units_id'));
            $('.diameter').val($(this).data('diameter'));
            $('.pdms_linenumber').val($(this).data('pdms_linenumber'));
            // $('.sec_number').val($(this).data('sec_number'));
            // $('.spec').val($(this).data('spec'));
            $('.calc_notes').val($(this).data('calc_notes'));

        });

// DELETE CNOTES PIPE
$(document).on('click', '.del-cnotes-modal', function() {
         
        
         
             //$('#est_qtya').val($(this).data('est_qty'));
            $('.id').val($(this).data('id'));


            $('.units_id').val($(this).data('units_id'));
            $('.diameter').val($(this).data('diameter'));
            $('.pdms_linenumber').val($(this).data('pdms_linenumber'));
            // $('.sec_number').val($(this).data('sec_number'));
            // $('.spec').val($(this).data('spec'));
            $('.calc_notes').val($(this).data('calc_notes'));

        });

// PROGRESS PIPE




$(document).on('click', '.progress-pipe-modal', function() {
         
         

            $('.id').val($(this).data('id'));


            $('.units_id').val($(this).data('units_id'));
            $('.diameter').val($(this).data('diameter'));
            $('.pdms_linenumber').val($(this).data('pdms_linenumber'));
            $('.pdms_linenumber_progress').val($(this).data('pdms_linenumber'));
            // $('.sec_number').val($(this).data('sec_number'));
            // $('.spec').val($(this).data('spec'));
            $('.calc_notes').val($(this).data('calc_notes'));

        });

</script>
                                                

<br><br><br><br>




<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
    

    <script>

    function enviar(val)
    {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        // Esta es la variable que vamos a pasar
        //var miVariableJS=$("#texto").val();
 
        var miVariableJS= val;
        // Enviamos la variable de javascript a jsppipe.blade.php
        $.post("jsppipe",{"texto":miVariableJS},function(respuesta){
            alert(respuesta);

        });
    }

    function cnote(val)
    {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        // Esta es la variable que vamos a pasar
 
        var miVariableJS= val;
        // Enviamos la variable de javascript a archivo.php
        $.post("jscnotes",{"texto":miVariableJS},function(respuesta){
            alert(respuesta);

        });
    }
    
    
    </script>

<script type="text/javascript">
    
    function hldspipes(val)
    {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        // Esta es la variable que vamos a pasar
 
        var miVariableJS= val;
        // Enviamos la variable de javascript a archivo.php
        $.post("jshold",{"texto":miVariableJS},function(respuesta){
            alert(respuesta);

        });
    }

</script>




    <!-- /////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
<div class="container">

    

                                                <center>
                                                    
                                                <h2><b>Modelled Piping</b></h2>

                                                     <!--   Se comprueba el peso deseado (BUDGET/AREAS) -->

                                                <?php $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='pipe'");?>


                                            <?php if ($weight_total[0]->weight_total==0) :?>    

                                                <?php $total_weight= DB::select("SELECT SUM(weight*qty) AS weight FROM epipesfullview;");?> 

                                            <?php else: ?>

                                                 <?php $total_weight= DB::select("SELECT weight FROM pmanagers WHERE name='pipe'");?>   

                                            <?php endif ?>

                                     <!--   FIN DE LA COMPROBACIÓN (BUDGET/AREAS) -->   

                                   
                                            
                                                
                                            <?php $sub_total_progress = DB::select("SELECT (SUM((pid*w_pid)+(iso*w_iso)+(stress*w_stress)+(support*w_support))) as  sub_total_progress 
                                                            FROM dpipesfullview");

                                            $total_progress = (($sub_total_progress[0]->sub_total_progress)/$total_weight[0]->weight);
                                            ?>



                                                
                                            <?php if ($total_weight[0]->weight!=0) :?>

                                                    <h3>Estimated Weight: <?php echo $total_weight[0]->weight; ?>
                                                    <?php $sub_total_progress = DB::select("SELECT (SUM((pid*w_pid)+(iso*w_iso)+(stress*w_stress)+(support*w_support))) as  sub_total_progress 
                                                            FROM dpipesfullview");

                                                    $total_progress = (($sub_total_progress[0]->sub_total_progress)/$total_weight[0]->weight);
                                                    ?>

                                                <br>Total Progress: <?php echo round($total_progress,1)."%";?></h3>


                                                <?php else: ?>

                                                    <h3>Estimated Weight: <?php echo "0"; ?>
                                                    <br>Total Progress: <?php echo "0%";?></h3>

                                                <?php endif ?>

                                                    </h3>
                                                <h4></h4>
                                            <?php endif; ?>

                                                </center>
                                                <br>
                                                <button onclick="location.href='{{ url('exportpipe') }}'" type="button" class="btn btn-lg btn-success" style="font-size: 16px;font-weight: bold">Excel</button><br>

<br>

<?php 
//PARA OBTENER ISO-ID
    $epipes= DB::select("SELECT * FROM dpipesfullview"); 
    $tagpart=explode("-", $epipes[0]->tag); //PARA OBTENER ISO-ID
    $isoid=str_replace('/','',$tagpart[0]).$tagpart[0].$tagpart[0].$tagpart[0];

?>

<link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>
<table border id="epipe" class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap">
    <center><thead>
        <tr>
            <th>Unit</th>
            <th>Area</th>
            <th>Nominal Diameter</th>
            <th>Line ID</th>
           <!--  <th>Secuence Number</th>
            <th>Specification</th> -->
            <th>Iso ID</th>
            <th>Type</th>
            <th>Weight</th>
            <th>Action</th>
        </tr>
    </thead></center>
    <tfoot><tr>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
            <!-- <th style="text-align: center"></th>
            <th style="text-align: center"></th> -->
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
        </tr></tfoot>
  </table>
</div>
  
  <!-- Buttons for export -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" rel="stylesheet">

<script type="text/javascript">
var action_bt = "Edit / Delete"
$(document).ready(function() {
    oTable = $('#epipe').DataTable({
        
        "order": [[ 2, "asc" ]],
        "pageLength": 8,
        "processing": true,
        "serverSide": false,
        "ajax": "{{ route('piping.indexpipe') }}",
        "columns": [
            {data: 'unit', name: 'unit'},
            {data: 'area', name: 'area'},
            {data: 'diameter_inch', name: 'diameter_inch'},
            {data: 'tag', name: 'tag'},
            //{data: 'sec_number', name: 'sec_number'}, NO BORRAR - LISTA DE LINEAS
            //{data: 'spec', name: 'spec'},NO BORRAR - LISTA DE LINEAS
            {data: 'isoid', name: 'isoid'},
            {data: 'type_line', name: 'type_line'},
            {data: 'weight', name: 'weight'},
            {data: 'action', name: 'action', orderable: false, searchable: false}


        ]

    });

 
});
</script>
<br>
<br>
<br>

  @extends('piping.editpipe') 

    
  @extends('piping.createcnotes')
  @extends('piping.delcnotes')



<script type="text/javascript">
    
    setTimeout(function() {
    $('#messages').fadeOut('slow');
}, 10000);

</script>


  <center>
   <!--  <button onclick="location.href='{{ url('modeledpipe') }}'" type="button" class="btn btn-primary btn-lg">Modeled</button> -->
  <!-- <button style="align:right" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modeledpipeModal">Modeled</button> -->
  <!-- <button onclick="location.href='{{ url('glinepipe') }}'" type="button" class="btn btn-primary btn-lg">CurveByArea</button> -->
  <button onclick="location.href='{{ url('glinepipetotal') }}'" type="button" class="btn btn-primary btn-lg">Curve</button>
  <button onclick="location.href='{{ url('home') }}'" type="button" class="btn btn-lg btn-default">Home</button>


  </center>

  <!-- SCRIPT PARA BÚSQUEDA POR COLUMNAS   -->


<script type="text/javascript">
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#epipe tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width: 100%;font-size: 12px;font-weight: normal;white-space: nowrap" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#epipe').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );

</script>


    <!-- FIN DE BÚSQUEDA POR COLUMNAS   -->
@endsection

