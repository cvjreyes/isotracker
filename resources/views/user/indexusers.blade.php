@if (Auth::guest())

@else

@role('Equi')

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
                    '<td>{!! Form::select('roles_id[]', [null => 'Select Role...'] + $roles, null, array('style'=>'height: 35px;border-radius: 4px;','required')) !!}</td>'+
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
            
// SHOW/UPDATE USER ROLES
$(document).on('click', '.edit-createuroles-modal', function() {
         

            $('.id').val($(this).data('id'));

            $('.name').val($(this).data('name'));  

        });

// DESTROY EQUIPMENT 
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



<script type="text/javascript">
    
 function uroles(val)
    {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        // Esta es la variable que vamos a pasar
 
        var miVariableJS= val;
        // Enviamos la variable de javascript a archivo.php
        $.post("jsuroles",{"texto":miVariableJS},function(respuesta){
            alert(respuesta);

        });
    }

</script>


<br><br><br><br>
<div class="container">

    <center>

        <h2><b>Users List</b></h2>
        <h3><?php echo env('APP_NAMEPROJ') ?></h3>

    </center>

@role('EquiAdmin')<button style="align:right" type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#createtypesequiModal"><img src="{{ asset('images/add-icon.ico') }}" style="width:23px" ></button>&nbsp;@endrole
<button onclick="location.href='{{ url('exportindexusers') }}'" type="button" class="btn btn-lg btn-success" style="font-size: 16px;font-weight: bold">Excel</button><br>

<br>


<link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>

@role('EquiAdmin')
<table border id="indexusers" class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap">
    <center><thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
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
    oTable = $('#indexusers').DataTable({
        
        "processing": true,
        "serverSide": false,
        "ajax": "{{ route('user.index') }}",
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false}


        ]

    });

 
});
</script>
@else
<table border id="indexusers" class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap">
    <center><thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
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
    oTable = $('#indexusers').DataTable({
        
        "processing": true,
        "serverSide": false,
        "ajax": "{{ route('user.index') }}",
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'}


        ]

    });

 
});
</script>

@endrole
@extends('user.createuroles')

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
  <button onclick="location.href='{{ url('modeledequi') }}'" type="button" class="btn btn-primary btn-lg">Modeled</button>
  <!-- <button style="align:right" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modeledequiModal">Modeled</button> -->
  <button onclick="location.href='{{ url('glineequi') }}'" type="button" class="btn btn-primary btn-lg">Curve</button>
  <!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#glineequiModal">LineChart</button> -->
 <!--  <button onclick="location.href='{{ url('pmanager') }}'" type="button" class="btn btn-lg btn-default"><img src="{{ asset('images/config-icon.png') }}" style="width:25px" ></button> -->


  </center>

<!-- SCRIPT PARA BÚSQUEDA POR COLUMNAS   -->


<script type="text/javascript">
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#indexusers tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width: 100%;font-size: 12px;font-weight: normal;white-space: nowrap" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#indexusers').DataTable();
 
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
