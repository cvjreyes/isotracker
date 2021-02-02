@if (Auth::guest())

@else

@extends('layouts.datatable')

@section('content')



    <script type="text/javascript">
        // PARA MOSTRAR EL PROGRESO POR LINEA
        function val_id(val) {
        var epipes_id=val;
        }
</script>







<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>




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
         
        
         
             //$('#est_qtya').val($(this).data('est_qty'));
            $('.id').val($(this).data('id'));


            $('.units_id').val($(this).data('units_id'));
            $('.diameter').val($(this).data('diameter'));
            $('.pdms_linenumber').val($(this).data('pdms_linenumber'));
            $('.sec_number').val($(this).data('sec_number'));
            $('.spec').val($(this).data('spec'));
            $('.calc_notes').val($(this).data('calc_notes'));

        });

// PROGRESS PIPE




$(document).on('click', '.progress-pipe-modal', function() {
         
         

            $('.id').val($(this).data('id'));


            $('.units_id').val($(this).data('units_id'));
            $('.diameter').val($(this).data('diameter'));
            $('.pdms_linenumber').val($(this).data('pdms_linenumber'));
            $('.pdms_linenumber_progress').val($(this).data('pdms_linenumber'));
            $('.sec_number').val($(this).data('sec_number'));
            $('.spec').val($(this).data('spec'));
            $('.calc_notes').val($(this).data('calc_notes'));

        });

</script>
                                                

<br><br><br><br>




<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
    <script>
    function enviar()
    {
        // Esta es la variable que vamos a pasar
        var miVariableJS=$("#texto").val();
 
        // Enviamos la variable de javascript a archivo.php
        $.post("archivo",{"texto":miVariableJS},function(respuesta){
            alert(respuesta);
        });
    }
    </script>
        


        <input type="text" id="texto">
        <input type="button" value="Enviar variable a PHP" onclick="enviar()">



    <!-- /////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
<div class="container">

    <?php $sum_per_epipe = DB::select("SELECT SUM(hours) as ehrspipes FROM pipesview"); ?>

                                                <center>
                                                <h3>Estimated Pipes</h3>
                                                <h4><?php echo $sum_per_epipe[0]->ehrspipes." hours"; ?></h4>
                                                </center>

<br>

<link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>
<table id="epipe" class="table table-hover table-condensed">
    <center><thead>
        <tr>
            <th>Area</th>
            <th>Diameter</th>
            <th>LN</th>
            <th>SN</th>
            <th>Specification</th>
            <th>PDMS LN</th>
            <th>TL</th>
            <th>Hours</th>
            <th>CN</th>
            <th>Action</th>
        </tr>
    </thead></center>
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
        

        dom: 'Bfrtip',

        buttons: [            
            {
                extend: 'excelHtml5',
                title: 'PIP-Estimated',
                exportOptions: {
                    columns: [ 0, 1, 3, 4]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'PIP-Estimated',
                exportOptions: {
                    columns: [ 0, 1, 3, 4]
                }
            },

     
          
        ],
        "processing": true,
        "serverSide": false,
        "ajax": "{{ route('piping.indexpipe') }}",
        "columns": [
            {data: 'area', name: 'area'},
            {data: 'diameter', name: 'diameter'},
            {data: 'line_number', name: 'line_number'},
            {data: 'sec_number', name: 'sec_number'},
            {data: 'spec', name: 'spec'},
            {data: 'pdms_linenumber', name: 'pdms_linenumber'},
            {data: 'type_line', name: 'type_line'},
            {data: 'hours', name: 'hours'},
            {data: 'calc_notes', name: 'calc_notes'},
            {data: 'action', name: 'action', orderable: false, searchable: false}


        ]

    });

 
});
</script>
<br>
<br>
<br>

  @extends('piping.editpipe') 
  @extends('piping.progresspipe') 
  @extends('piping.glinepipe')

<script type="text/javascript">
    
    setTimeout(function() {
    $('#messages').fadeOut('slow');
}, 10000);

</script>


  <center>
    <button onclick="location.href='{{ url('modeledpipe') }}'" type="button" class="btn btn-primary btn-lg">Modeled</button>
  <!-- <button style="align:right" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modeledpipeModal">Modeled</button> -->
  <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#glinepipeModal">LineChart</button>
  <button onclick="location.href='{{ url('home') }}'" type="button" class="btn btn-lg btn-default">Home</button>


  </center>
@endsection

@endif
