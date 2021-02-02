

@if (Auth::guest())

@else

@role('Inst')

@extends('layouts.datatable')

@section('content')

<!-- ESTILOS DE MODAL -->
<style type="text/css">
    

.dgcAlert {top: 0;position: absolute;width: 100%;display: block;height: 1000px; background: url(http://www.dgcmedia.es/recursosExternos/fondoAlert.png) repeat; text-align:center; opacity:0; display:none; z-index:999999999999999;}
.dgcAlert .dgcVentana{width: 500px; background: white;min-height: 150px;position: relative;margin: 0 auto;color: black;padding: 10px;border-radius: 10px;}
.dgcAlert .dgcVentana .dgcCerrar {height: 25px;width: 25px;float: right; cursor:pointer; background: url(http://www.dgcmedia.es/recursosExternos/cerrarAlert.jpg) no-repeat center center;}
.dgcAlert .dgcVentana .dgcMensaje { margin: 0 auto; padding-top: 0px; text-align: center; width: 400px;font-size: 20px;}
.dgcAlert .dgcVentana .dgcAceptar{background:#09C; bottom:20px; display: inline-block; font-size: 12px; font-weight: bold; height: 24px; line-height: 24px; padding-left: 5px; padding-right: 5px;text-align: center; text-transform: uppercase; width: 75px;cursor: pointer; color:#FFF; margin-top:25px;}

</style>





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>


<script type="text/javascript">



    $(function () {
        $('.add').click(function () {

            var n = ($('.resultbody tr').length - 0) + 1;
            var tr = '<tr class="fila">' +
                    '<td>{!! Form::select('units_id[]', [null => 'Select Area...'] + $units, null, array( 'style'=>'height:34px;font-size: 14px;font-weight: normal;','required')) !!}</td>'+
                    '<td>{!! Form::select('tinsts_id[]', [null => 'Select Type...'] + $tinsts, null, array( 'style'=>'height:34px;font-size: 14px;font-weight: normal;','required')) !!}</td>'+
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

// SHOW/UPDATE inst 
$(document).on('click', '.edit-inst-modal', function() {
         
       
         
             //$('#est_qtya').val($(this).data('est_qty'));
            $('.id').val($(this).data('id'));


            $('.units_id').val($(this).data('units_id'));
            $('.tinsts_id').val($(this).data('tinsts_id'));
            $('.tag').val($(this).data('tag'));
            $('.hours').val($(this).data('hours'));
            $('.est_qty').val($(this).data('est_qty'));

        });

// DESTROY inst 
$(document).on('click', '.del-inst-modal', function() {
         
            
         
             //$('#est_qtya').val($(this).data('est_qty'));
            $('.id').val($(this).data('id'));


            $('.units_id').val($(this).data('units_id'));
            $('.tinsts_id').val($(this).data('tinsts_id'));
            $('.tag').val($(this).data('tag'));
            $('.hours').val($(this).data('hours'));
            $('.est_qty').val($(this).data('est_qty'));

        });
   
</script>

                            <script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s3").style.fontWeight='bold';
                                     document.getElementById("s3").style.fontSize=10 + "pt";
                                     document.getElementById("s3").style.fontStyle="italic";


                                 }

                            </script> 

<br><br><br><br>
<div class="container" style="width: 70%">
                                                <?php 
                                                    $sum_per_einst = DB::select("SELECT SUM(est_hours) as ehrsinsts FROM instsview");
                                                    $budget = DB::select("SELECT weight FROM pmanagers WHERE name='inst'"); $total_progress = DB::select("SELECT SUM(total_progress) as total_progress FROM pinsts_view"); 
                                                    ?>

                                                <center>
                                                    <?php 

                                                 if ($sum_per_einst[0]->ehrsinsts > $budget[0]->weight){
                                                    echo "<h3 style='background-color: #FCF8E3'>The estimated exceed the budget!</h3>";

                                                 }   

                                                ?>
                                                <h2><b>Instrumentation</b></h2>
                                                <h3>Estimated Weight: <?php echo $sum_per_einst[0]->ehrsinsts; ?>
                                                <br>Total Progress: <?php echo round($total_progress[0]->total_progress,2)."%"; ?></h3>
                                                </center>

<br>


@role('InstAdmin')<button style="align:right" type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#createinstModal"><img src="{{ asset('images/add-icon.ico') }}" style="width:23px" ></button>&nbsp;@endrole
<button onclick="location.href='{{ url('typesinst') }}'" type="button" class="btn btn-lg btn-default"><img src="{{ asset('images/inst-icon.png') }}" style="width:23px" ></button>
<button onclick="location.href='{{ url('exportinst') }}'" type="button" class="btn btn-lg btn-success" style="font-size: 16px;font-weight: bold">Excel</button><br>

<br>



<link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>
<table border id="einst" class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap">
    <center><thead>
        <tr>
            <th>Area</th>
            <th>Type</th>
            <!-- <th>Code</th> -->
            <th>Tag</th>
            <th>Weight</th>
           <!--  <th>Quantity</th> -->
            <!-- <th>Estimated</th> -->
            @role('InstAdmin') <th>Action</th> @endrole
        </tr>
    </thead></center>
    <tfoot><tr>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
            <!-- <th style="text-align: center">Code</th> -->
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
<!--             <th style="text-align: center"></th> -->
            <!-- <th style="text-align: center"></th> -->
            @role('InstAdmin') <th style="text-align: center"></th> @endrole
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

@role('InstAdmin')
    <script type="text/javascript">
    var action_bt = "Edit / Delete"
    $(document).ready(function() {
        oTable = $('#einst').DataTable({
            
            pageLength: 8,

            "processing": true,
            "serverSide": false,
            "ajax": "{{ route('instruments.indexinst') }}",
            "columns": [
                {data: 'area', name: 'area'},
                {data: 'type', name: 'type'},
                //{data: 'code', name: 'code'},
                {data: 'tag', name: 'tag'},
                {data: 'hours', name: 'hours'},
                //{data: 'est_quantity', name: 'est_quantity'},
                // {data: 'est_hours', name: 'est_hours'},
                {data: 'action', name: 'action', orderable: false, searchable: false}


            ]

        });

     
    });

    </script>
@else
    <script type="text/javascript">
    var action_bt = "Edit / Delete"
    $(document).ready(function() {
        oTable = $('#einst').DataTable({
            
            pageLength: 8,

            "processing": true,
            "serverSide": false,
            "ajax": "{{ route('instruments.indexinst') }}",
            "columns": [
                {data: 'area', name: 'area'},
                {data: 'type', name: 'type'},
                //{data: 'code', name: 'code'},
                {data: 'tag', name: 'tag'},
                {data: 'hours', name: 'hours'},
                // {data: 'est_quantity', name: 'est_quantity'},
                // {data: 'est_hours', name: 'est_hours'}


            ]

        });

     
    });

    </script>
@endrole

<br>
<br>
<br>


    @extends('instruments.createinst')
    @extends('instruments.editinst')
    @extends('instruments.delinst')






<?php 

    $sum_per = DB::select("SELECT SUM(percentage) as sum_per FROM pinsts");
    $sum_est_qty = DB::select("SELECT SUM(est_qty) as sum_est_qty FROM einsts");
    $sum_hours = DB::select("SELECT SUM(hours) as sum_hours FROM instsview");
    $mult_estimated = DB::select("SELECT SUM(`est_hours`) AS mult_estimated FROM instsview");


    $qty_x_hours=$sum_est_qty[0]->sum_est_qty * $sum_hours[0]->sum_hours;

?>



  </center> 


  <center>
  <button onclick="location.href='{{ url('modeledinst') }}'" type="button" class="btn btn-primary btn-lg">Modeled</button>
  <!-- <button style="align:right" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modeledinstModal">Modeled</button> -->
  <button onclick="location.href='{{ url('glineinst') }}'" type="button" class="btn btn-primary btn-lg">CurveByArea</button>
  <button onclick="location.href='{{ url('glineinsttotal') }}'" type="button" class="btn btn-primary btn-lg">Curve</button>
  <!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#glineinstModal">LineChart</button> -->

  <button onclick="location.href='{{ url('home') }}'" type="button" class="btn btn-lg btn-default">Home</button>


  </center>

<!-- SCRIPT PARA BÚSQUEDA POR COLUMNAS   -->


<script type="text/javascript">
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#einst tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width: 100%;font-size: 12px;font-weight: normal;white-space: nowrap" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#einst').DataTable();
 
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

@else
@include('common.forbidden')

@endrole

@endif
