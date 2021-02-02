@if (Auth::guest())

@else

@role('Equi')

@extends('layouts.datatable')

@section('content')

<script>

 </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>




  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>


<script type="text/javascript">

    function initGui()
    {
        $('.date-iso8601').datepicker();
    }
   

    $(function () {
        $('.add').click(function () {


            var n = ($('.resultbody tr').length - 0) + 1;
            var tr = '<tr class="fila">' +
                    '<td>{!! Form::text('code[]', null, array('placeholder' => 'Code','class' => 'form-control','required')) !!}</td>'+
                    '<td>{!! Form::text('name[]', null, array('placeholder' => 'Name','class' => 'form-control','required')) !!}</td>'+
                    '<td>{!! Form::number('hours[]', null, array('placeholder' => 'Hours','class' => 'form-control','required')) !!}</td>'+
                    '<td><input type="button" class="btn btn-danger delete" value="x"></td></tr>';
            $('.resultbody').append(tr);


              var newRow = tr.clone();

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
            
// SHOW/UPDATE equi 
$(document).on('click', '.edit-typesequi-modal', function() {
         

            $('.id').val($(this).data('id'));

            $('.code').val($(this).data('code'));
            $('.name').val($(this).data('name'));
            $('.hours').val($(this).data('hours'));
  

        });

// DESTROY equi 
$(document).on('click', '.del-typesequi-modal', function() {
         
            
         
            $('.id').val($(this).data('id'));

            $('.code').val($(this).data('code'));
            $('.name').val($(this).data('name'));
            $('.hours').val($(this).data('hours'));

        });

</script>


                            <script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s0").style.fontWeight='bold';
                                     document.getElementById("s0").style.fontSize=10 + "pt";
                                     document.getElementById("s0").style.fontStyle="italic";;


                                 }

                            </script> 


<br><br><br><br>
<div class="container">

    <center>

        <h2><b>Equipment Types</b></h2>
        <h3><?php echo env('APP_NAMEPROJ') ?></h3>

    </center>

@role('EquiAdmin')<button style="align:right" type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#createtypesequiModal"><img src="{{ asset('images/add-icon.ico') }}" style="width:23px" ></button>&nbsp;@endrole
<button onclick="location.href='{{ url('exporttypeequi') }}'" type="button" class="btn btn-lg btn-success" style="font-size: 16px;font-weight: bold">Excel</button><br>

<br>


<link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>

@role('EquiAdmin')
<table border id="typeequi" class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap">
    <center><thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Weight</th>
            <th>Action</th>
        </tr>
    </thead></center>
    <tfoot><tr>
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
    oTable = $('#typeequi').DataTable({
        
        "processing": true,
        "serverSide": false,
        "ajax": "{{ route('equipment.types') }}",
        "columns": [
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'hours', name: 'hours'},
            {data: 'action', name: 'action', orderable: false, searchable: false}


        ]

    });

 
});
</script>
@else
<table border id="typeequi" class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap">
    <center><thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Weight</th>
        </tr>
    </thead></center>
    <tfoot><tr>
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
    oTable = $('#typeequi').DataTable({
        
        "processing": true,
        "serverSide": false,
        "ajax": "{{ route('equipment.types') }}",
        "columns": [
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'hours', name: 'hours'}


        ]

    });

 
});
</script>

@endrole
@extends('equipment.createtypesequi')

  @extends('equipment.edittypesequi')
  @extends('equipment.deltypesequi')
<br>
<br>
<br>











<script type="text/javascript">
    
    setTimeout(function() {
    $('#messages').fadeOut('slow');
}, 10000);

</script>




  </center> 


  <center>
  <button onclick="location.href='{{ url('modeledequi') }}'" type="button" class="btn btn-primary btn-lg">Modelled</button>
  <!-- <button style="align:right" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modeledequiModal">Modeled</button> -->
  <button onclick="location.href='{{ url('glineequi') }}'" type="button" class="btn btn-primary btn-lg">Curve</button>
  <!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#glineequiModal">LineChart</button> -->
<!--   <button onclick="location.href='{{ url('pmanager') }}'" type="button" class="btn btn-lg btn-default"><img src="{{ asset('images/config-icon.png') }}" style="width:25px" ></button> -->


  </center>

<!-- SCRIPT PARA BÚSQUEDA POR COLUMNAS   -->


<script type="text/javascript">
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#typeequi tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width: 100%;font-size: 12px;font-weight: normal;white-space: nowrap" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#typeequi').DataTable();
 
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
