@extends('layouts.datatable')

@section('content')

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

<!doctype html>
<script type="text/javascript">
  
  $(document).on('click', '.comments-materials-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));

        });

   $(document).on('click', '.reject-materials-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));

        });

   $(document).on('click', '.upload-design-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));

        });

  
</script>
<html>
<head>
<title>Materials</title>


</head>
<body>


<div class="container">
  <div class="row">
    <!-- <h4>Agregar Nueva Descarga</h4> -->
    <hr style="margin-top:5px;margin-bottom: 5px;">
    <div class="content"> </div>
    <center><h2 style="padding-top: 7%"><b>Iso Controller</b></h2>
      <h3>Materials</h3></center>
   
      <div class="panel-body">
 <button onclick="location.href='{{ url('hisoctrl') }}'" type="button" class="btn btn-default btn-lg">Go to History</button>
<table class="table">

      <!-- DATATABLE-->

      <link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
      <script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>

      <table border id="tabla" class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap">

        
         <script type="text/javascript">
    
function vcomments(val)
    {

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        // Esta es la variable que vamos a pasar
 
        var miVariableJS= val;
        // Enviamos la variable de javascript a archivo.php
        $.post("jsvcomments",{"texto":miVariableJS},function(respuesta){
            alert(respuesta);

        });


    }

$(document).on('click', '.show-vcomments-modal', function() {
         
         

            $('.id').val($(this).data('id'));


            $('.filename').val($(this).data('filename'));
            $('.comments').val($(this).data('comments'));

        });

</script>

    <center><thead>
        <tr>
            <th style="text-align: center">Iso ID</th>
            <th style="text-align: center">From</th>
            <th style="text-align: center">Date</th>
            <th style="text-align: center">Actions</th>
        </tr>
    </thead></center>
    <tfoot><tr>

            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
        </tr></tfoot>
  
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

      <tbody>
            <?php
              $filename = scandir("../public/storage/isoctrl/materials");
              $num=0;

              for ($i=2; $i<count($filename); $i++)
              {$num++;
              ?>
<p>  
 </p>
         
    <tr>
      <!-- <th scope="row"><?php //echo $num;?></th> -->
      <?php 

        $extension = pathinfo($filename[$i], PATHINFO_EXTENSION);
            if ($extension == 'pdf') {

      ?>


      <td>

         <?php 

            $afilename=explode(".", $filename[$i]);

        $pdfcl= "../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf";
        $bfile= "../public/storage/isoctrl/materials/attach/".$afilename[0].".bfile";
        $dxf= "../public/storage/isoctrl/materials/attach/".$afilename[0].".dxf";

           $requested = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename='".$filename[$i]."')");

        if ($requested[0]->requested==1){ ?> <!-- Aparece flag si tiene solicitud desde diseño -->

            <img src="{{ asset('images/req-icon.png') }}" class="req-icon" style="width:15px;height:15px">
          
        <?php } ?>

        <?php echo "<a target='_blank' href='../public/storage/isoctrl/".$filename[$i]."'>". $filename[$i]."</a>"; ?>
        
      </td>
       <td><?php echo $requested[0]->from; ?></td>
      <td><?php echo $requested[0]->created_at; ?></td> <!-- Se utiliza la variable $requested solo para aprovechar -->
       <td>

       <?php if (auth()->user()->hasRole('MaterialsAdmin')){ ?> 

           <?php if ($requested[0]->requested==0){ ?> <!-- Si no tiene solicitud desde diseño puede enviar a siguiente etapa -->

               <a class="comments-materials-modal btn btn-xs btn-success" data-filename ="<?php echo $filename[$i]; ?>" data-toggle="modal" data-target="#commentsfrommaterialsModal">To Issue</a>

          <?php } ?>

          <a class="reject-materials-modal btn btn-xs btn-danger" data-filename ="<?php echo $filename[$i]; ?>" data-toggle="modal" data-target="#rejectfrommaterialsModal">With Comments</a>
           <a class="upload-design-modal btn btn-xs btn-info" data-filename ="<?php echo $filename[$i]; ?>" data-pathfrom="materials" data-toggle="modal" data-target="#uploadfromdesignModal">Upload File</a>
           &nbsp;&nbsp;<a onclick="vcomments(<?php echo $requested[0]->id; ?>)" ><img src="{{ asset('images/comment-icon.png') }}" class="mark-icon" style="width:20px;height:20px"></a>&nbsp;&nbsp;

           <?php if (file_exists($pdfcl)) { ?>  

             <a class="btn btn-xs btn-default"><b>PDF</b></a>
             
          <?php } ?>

          <?php if (file_exists($bfile)) { ?>  

             <a class="btn btn-xs btn-default"><b>BFL</b></a>
             
          <?php } ?>

          <?php if (file_exists($dxf)) { ?>  

             <a class="btn btn-xs btn-default"><b>DXF</b></a>
             
          <?php } ?>   

        <?php }elseif (auth()->user()->hasRole('DesignAdmin')){?>

            <?php if ($requested[0]->requested==1){ ?>  <!-- Switch para enviar o cancelar solicitud -->

                 <a href="reqfromdesign/<?php echo $filename[$i]; ?>/0" class="btn btn-xs btn-danger" data-filename ="<?php echo $filename[$i]; ?>" data-request = "0">Cancel Request</a>

            <?php }else{ ?>
         
                  <a href="reqfromdesign/<?php echo $filename[$i]; ?>/1" class="btn btn-xs btn-warning" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1">Request</a>

            <?php } ?>

        <?php }else{ ?>

           <a class="comments-design-modal btn btn-xs btn-info" data-filename ="<?php echo $filename[$i]; ?>" data-toggle="modal" data-target=""><b>NO ACTIONS AVAILABLE!</b></a>

        <?php } ?>
 
      </td>



          
       <?php }}?> 
          </tbody>


    </table>

    @extends('isoctrl.commentsfrommaterials')
    @extends('isoctrl.rejectfrommaterials')
     @extends('isoctrl.uploadfromdesign')

<script type="text/javascript">
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#tabla tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width: 100%;font-size: 12px;font-weight: normal;white-space: nowrap" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#tabla').DataTable({"order": [[ 1, 'desc' ]]});
 
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



</table>

<!-- BUTTONS   -->
    <br><br>     
    <center>
        <button onclick="location.href='{{ url('design') }}'" type="button" class="btn btn-info btn-lg">Design</button>
        <img src="{{ asset('images/arrow-icon.png') }}" style="width:30px" >
        <button onclick="location.href='{{ url('stress') }}'" type="button" class="btn btn-info btn-lg">Stress</button>
        <img src="{{ asset('images/arrow-icon.png') }}" style="width:30px" >
        <button onclick="location.href='{{ url('supports') }}'" type="button" class="btn btn-info btn-lg">Supports</button>
        <img src="{{ asset('images/arrow-icon.png') }}" style="width:30px" >
        <button onclick="location.href='{{ url('materials') }}'" type="button" class="btn btn-primary btn-lg">Materials</button>
    </center>
    <br><br>    
    <center>
      <button onclick="location.href='{{ url('lead') }}'" type="button" class="btn btn-info btn-lg">Lead</button>
        <img src="{{ asset('images/arrow-icon.png') }}" style="width:30px" >
        <button onclick="location.href='{{ url('iso') }}'" type="button" class="btn btn-info btn-lg">IsoController</button>
    </center>
</div>
</div>

<!-- Fin tabla--> 
  </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
</body>
</html>
@endsection
