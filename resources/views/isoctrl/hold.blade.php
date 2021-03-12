@if (Auth::guest())

@else

@extends('layouts.datatable')

@section('content')
<script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s5").style.fontWeight='bold';
                                     document.getElementById("s5").style.fontSize=10 + "pt";
                                     document.getElementById("s5").style.fontStyle="italic";;


                                 }

                            </script> 

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
  
   $(document).on('click', '.comments-stress-modal', function() {

            $('.filenames').val($(this).data('filenames'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));

        });

   $(document).on('click', '.comments-stress-to-lead-modal', function() {

            $('.filenames').val($(this).data('filenames'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));

        });

   $(document).on('click', '.comments-ldgstress-to-materials-modal', function() {

            $('.filenames').val($(this).data('filenames'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));

        });

   $(document).on('click', '.reject-ldgstress-modal', function() {

            $('.filenames').val($(this).data('filenames'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));

        }); 

   $(document).on('click', '.reject-ldgstress-to-ldgsupports-modal', function() {

            $('.filenames').val($(this).data('filenames'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));
            $('.verifystress').val($(this).data('verifystress'));

        }); 

   $(document).on('click', '.reject-ldgstress-to-design-modal', function() {

            $('.filenames').val($(this).data('filenames'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));

        });

   $(document).on('click', '.reject-stress-modal', function() {

            $('.filenames').val($(this).data('filenames'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));

        });

    $(document).on('click', '.upload-design-modal', function() {

            $('.filenames').val($(this).data('filenames'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));
            $('.verifydesign').val($(this).data('verifydesign'));
            $('.verifystress').val($(this).data('verifystress'));
            $('.verifysupports').val($(this).data('verifysupports'));

        });


</script>

<html>
<head>
<title>Holdsy</title>

</head>
<body>

<div class="container">
  <div class="row">
    <!-- <h4>Agregar Nueva Descarga</h4> -->
    <hr style="margin-top:5px;margin-bottom: 5px;">
    <center><h2 style="padding-top: 4%"><b><i>IsoTracker</i></b></h2>
      <h3>Holds</h3></center>
      <div class="panel-body">
        <form id="frm-example" class="form-horizontal" role="form" method="POST" action="{{ url('/sendfromstressbulk') }}">    
       {!! csrf_field() !!}
        <table style='width: 100%'> 
        <td>         
          <button onclick="location.href='{{ url('isostatus') }}'" type="button" class="btn btn-info btn-lg" style="width:38%"><b>Status</b>
            </button> 
           <button onclick="location.href='{{ url('hisoctrl') }}'" type="button" class="btn btn-info btn-lg" style="width:38%"><b>History</b>
          </button>
        </td>
        <td style='width: 64%'>
   <!-- TABLA DE TOTALES SEGUN STATUS -->
            @include('isoctrl.totalesbystatus')
        <!-- FIN TABLA DE TOTALES SEGUN STATUS -->
        </td>
      </table>
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


            $('.filenames').val($(this).data('filenames'));
            $('.comments').val($(this).data('comments'));

        });

</script>

    <center><thead>
        <tr>
            <th style="text-align: center"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
            <th style="text-align: center">Iso ID</th>        
            <th style="text-align: center">trays</th>
            <th style="text-align: center">Date</th>
            <th style="text-align: center">Actions</th>
        </tr>
    </thead></center>
    <tfoot><tr>
            <th style="text-align: center"></th>  
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
              //$filenames = scandir("../public/storage/isoctrl/design/TRASH");
              $num=0;

              for ($i=0; $i<count($filenames); $i++)
              {$num++;
              ?>
        
      <?php 

        $extension = pathinfo($filenames[$i], PATHINFO_EXTENSION);
            if (($extension == 'pdf')) {

      ?>

    <tr>

        <td><?php echo $filenames[$i]; ?></td>

        <td><?php 

        $afilenames=explode(".", $filenames[$i]);

        $pdfcl= "../public/storage/isoctrl/stress/attach/".$afilenames[0]."-CL.pdf";
        $zip= "../public/storage/isoctrl/stress/attach/".$afilenames[0].".zip";
        $bfile= "../public/storage/isoctrl/stress/attach/".$afilenames[0].".b";
        $dxf= "../public/storage/isoctrl/stress/attach/".$afilenames[0]."-01.dxf";
        $cii= "../public/storage/isoctrl/stress/attach/".$afilenames[0].".cii";

        $pdftie= "../public/storage/isoctrl/stress/attach/".$afilenames[0]."-TIE.pdf";
        $pdfspo= "../public/storage/isoctrl/stress/attach/".$afilenames[0]."-PROC.pdf";
        $pdfsit= "../public/storage/isoctrl/stress/attach/".$afilenames[0]."-INST.pdf";

           $issued = DB::select("SELECT * FROM misoctrls WHERE filename = '".$filenames[$i]."'");

            $requested = DB::select("SELECT * FROM misoctrls WHERE filename = '".$filenames[$i]."'"); // same query for request

       if ($issued[0]->requested==1){ ?> <!-- solicitud diseño -->

            
              
          
            <?php } ?>

       



         <?php if ($issued[0]->deleted==1 AND $issued[0]->requested==1){ ?> <!-- DELETED -->  
      
         <?php echo "<a target='_blank' href='../public/storage/isoctrl/".$filenames[$i]."'><strike>". $filenames[$i]."</strike></a>"; ?></td> 

          <?php }else{ ?>   

         <?php echo "<a target='_blank' href='../public/storage/isoctrl/".$filenames[$i]."'>". $filenames[$i]."</a>"; ?></td> 

         <?php } ?>


      


      <?php if ($issued[0]->issued==2){ ?>
      
          <td><?php echo ""; ?></td>
          <td><?php echo ""; ?></td> <!-- Se utiliza la variable $issued solo para aprovechar -->    

      <?php }else{ ?>

      <td><?php echo ucfirst($trays[$i]); ?></td>
      <td><?php echo $issued[0]->updated_at; ?></td> <!-- Se utiliza la variable $issued solo para aprovechar -->
      
      <?php } ?>

      <td>


        <?php if (auth()->user()->hasRole('DesignLead') || auth()->user()->hasRole('IsoctrlAdmin') || auth()->user()->hasRole('LeadAdmin')){?>

            <?php if ($requested[0]->hold==1){ ?>  <!-- Switch para enviar o cancelar solicitud -->

                 <a href="holdfromleadoriso/<?php echo $filenames[$i]; ?>/0/<?php echo $trays[$i]; ?>" class="btn btn-xs btn-success" data-filenames ="<?php echo $filenames[$i]; ?>" data-request = "0">Restore</a>

            <?php }else{ ?>
         
                  <a href="holdfromleadoriso/<?php echo $filenames[$i]; ?>/1/<?php echo $trays[$i]; ?>" class="btn btn-xs btn-warning" data-filenames ="<?php echo $filenames[$i]; ?>" data-request = "1">Hold</a>

            <?php } ?>

         <?php }elseif ($requested[0]->hold==1){ ?>

                <center><b>HOLD</b></center>

        
        <?php }else{ ?>

          <center><a class="comments-design-modal btn btn-xs btn-info" data-filenames ="<?php echo $filenames[$i]; ?>" data-toggle="modal" data-target=""><b>NO ACTIONS AVAILABLE!</b></a></center>

        <?php } ?>
        
      </td>
      </tr>

       <?php } ?> 
       <?php } ?>
      

          </tbody>


    </table>


 
    <script type="text/javascript">
    
    setTimeout(function() {
    $('#messages').fadeOut('slow');
    }, 50000);

</script>

    <!-- BUTTONS   -->
    <br>
   <center>
       
        

        <button onclick="location.href='{{ url('design') }}'" type="button" class="btn btn-default btn-lg" style="width:15%"><b>Design</b></button>&nbsp;&nbsp;

        <button onclick="location.href='{{ url('stress') }}'" type="button" class="btn btn-default btn-lg" style="width:15%"><b>Stress</b></button>&nbsp;&nbsp;

        <button onclick="location.href='{{ url('supports') }}'" type="button" class="btn btn-default btn-lg" style="width:15%"><b>Supports</b></button>&nbsp;&nbsp;

        <button onclick="location.href='{{ url('materials') }}'" type="button" class="btn btn-default btn-lg" style="width:15%"><b>Materials</b></button>&nbsp;&nbsp;

        <button onclick="location.href='{{ url('lead') }}'" type="button" class="btn btn-default btn-lg" style="width:15%"><b>Issuer</b></button>&nbsp;&nbsp;

        <button onclick="location.href='{{ url('iso') }}'" type="button" class="btn btn-default btn-lg" style="width:15%"><b>LDE/Isocontrol</b></button>


    </center> 



<script src="{{ asset('js/selectall.js') }}"></script> <!-- select all -->

<script type="text/javascript">
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell

    $('#tabla tfoot th').each( function () {
        //"order": [[ 1, 'desc' ]],"pageLength" : 8
        var title = $(this).text();
        $(this).html( '<input type="text" style="width: 100%;font-size: 12px;font-weight: normal;white-space: nowrap" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    //var table = $('#tabla').DataTable({"order": [[ 1, 'desc' ]],"pageLength" : 8});


 
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
</div>

<!-- Fin tabla--> 
  </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
</body>
</html>
@endsection

@endif