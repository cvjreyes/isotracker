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
  
  $(document).on('click', '.comments-design-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));
         //   $('.requestbydesign').val($(this).data('requestbydesign'));
         //   $('.requestbylead').val($(this).data('requestbylead'));

        });

   $(document).on('click', '.comments-design-to-supports-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));
            //$('.requestbydesign').val($(this).data('requestbydesign'));
            //$('.requestbylead').val($(this).data('requestbylead'));

        });

    $(document).on('click', '.comments-design-to-materials-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));

        });

    $(document).on('click', '.comments-ldgdesign-to-stress-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));

        });

    $(document).on('click', '.comments-ldgdesign-to-supports-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));

        });

    $(document).on('click', '.comments-ldgdesign-to-materials-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));

        });

    $(document).on('click', '.comments-design-to-lead-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));

        });

    $(document).on('click', '.comments-design-to-iso-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));

        });

   $(document).on('click', '.reject-ldgdesign-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));

        }); 

  $(document).on('click', '.upload-design-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));
            $('.requestbydesign').val($(this).data('requestbydesign'));
            $('.requestbylead').val($(this).data('requestbylead'));
            $('.claimed').val($(this).data('claimed'));
            $('.verifydesign').val($(this).data('verifydesign'));
            $('.verifystress').val($(this).data('verifystress'));
            $('.verifysupports').val($(this).data('verifysupports'));

        });
</script>

<html>
<head>
<title>Design</title>

</head>
<body>

<div class="container">
  <div class="row">
    <!-- <h4>Agregar Nueva Descarga</h4> -->
    <hr style="margin-top:5px;margin-bottom: 5px;">
    <center><h2 style="padding-top: 4%"><b><i>IsoTracker</i></b></h2>
      <h3>Design</h3></center>
      <div class="panel-body">
    <form id="frm-example" class="form-horizontal" role="form" method="POST" action="{{ url('/sendfromdesignbulk') }}">    
       {!! csrf_field() !!}
      <table style='width: 100%'> 
        <td>      
       <button onclick="location.href='{{ url('isostatus') }}'" type="button" class="btn btn-info btn-lg" style="width:32%"><b>Status</b>
        </button>
         <button onclick="location.href='{{ url('hisoctrl') }}'" type="button" class="btn btn-info btn-lg" style="width:32%"><b>History</b>
        </button>
        <?php if (auth()->user()->hasRole('DesignAdmin')){ ?> 
        <button onclick="location.href='{{ url('file') }}'" type="button" class="btn btn-info btn-lg" style="width:32%"><b>Upload Isofiles</b>
        </button><?php }?>
        <?php if (auth()->user()->hasRole('DesignAdmin')){ ?> 
        <!-- <button onclick="location.href='{{ url('commontray') }}'" type="button" class="btn btn-info btn-lg" style="width:23%"><b>SPO/SIT</b> -->
        </button><?php }?>
      </td>
      <td>
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


            $('.filename').val($(this).data('filename'));
            $('.comments').val($(this).data('comments'));

        });

</script>

    <center><thead>
        <tr>
            <th style="text-align: center"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>          
            <th style="text-align: center">Iso ID</th>
            <!-- <th style="text-align: center">Check by</th> -->
            <th style="text-align: center">From</th>
            <th style="text-align: center">Date</th>
            <th style="text-align: center">Actions</th>
        </tr>
    </thead></center>
    <tfoot><tr>
            <th style="text-align: center"></th>
           <!--  <th style="text-align: center"></th> -->
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

       <!-- SI EL PROYECTO ES IFC SE DESHABILITAN DESDE DISEÑOS LOS ENVIOS A STRESS Y SOPORTES -->
          <?php 

              $ifc = 0;

              if ($ifc==1){

                $disabled2="disabled";
                $datatoggle="";//para desactivar

              }else{

                $disabled2="";
                $datatoggle="modal"; //para activar

              }

          ?>


       <!-- FIN COMPROBACIÓN IFC -->  

      <tbody>
            <?php
              $filename = scandir("../public/storage/isoctrl/design");
              //$filename = scandir("../storage/app/public/isoctrl/design");
              $num=0;

              for ($i=2; $i<count($filename); $i++)
              {$num++;
              ?>
        
      <?php 

        $extension = pathinfo($filename[$i], PATHINFO_EXTENSION);
            if (($extension == 'pdf')) {

      ?>

   
    <tr>

        <td><?php echo $filename[$i]; ?></td>

        

        <td><?php 

        $afilename=explode(".", $filename[$i]);

        $pdfcl= "../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf";
        $zip= "../public/storage/isoctrl/design/attach/".$afilename[0].".zip";
        $bfile= "../public/storage/isoctrl/design/attach/".$afilename[0].".b";
        $dxf= "../public/storage/isoctrl/design/attach/".$afilename[0]."-01.dxf";
        $cii= "../public/storage/isoctrl/design/attach/".$afilename[0].".cii";

        $pdftie= "../public/storage/isoctrl/design/attach/".$afilename[0]."-TIE.pdf";
        $pdfspo= "../public/storage/isoctrl/design/attach/".$afilename[0]."-SPO.pdf";
        $pdfsit= "../public/storage/isoctrl/design/attach/".$afilename[0]."-SIT.pdf";

           $issued = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

           $requested = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')"); // same query for request

                  // PARA VALIDAR SI TIENE TIE, SPO O SIT Y CONGELAR CHECKBOX

                    if ($issued[0]->tie==1 OR $issued[0]->tie==2 OR $issued[0]->tie==3){ ?>

                      <div style="display: none">9565</div> <!-- 9565 es tie al azar -->

                    <?php }

                    if ($issued[0]->spo==1 OR $issued[0]->spo==2 OR $issued[0]->spo==3){?>  

                      <div style="display: none">8575</div><!-- 8575 es spo al azar-->

                    <?php }

                    if ($issued[0]->sit==1 OR $issued[0]->sit==2 OR $issued[0]->sit==3){?>  

                      <div style="display: none">7595</div>  <!-- 7595 es sit al azar-->

                    <?php } ?> 

                    <!-- FIN PARA VALIDAR SI TIENE TIE, SPO O SIT Y CONGELAR CHECKBOX  -->

            <?php if ($issued[0]->requested==1 OR $issued[0]->requested==2){ ?> <!-- solicitud diseño -->

              <a class="btn btn-xs btn-warning"><b>RBD</b></a>

          
            <?php } ?>

            <?php if ($issued[0]->requestedlead==1 OR $issued[0]->requestedlead==2){ ?> <!-- solicitud lead -->

              <a class="btn btn-xs btn-warning"><b>RBL</b></a>
          
            <?php } ?>


         <?php if ($issued[0]->deleted==1){ ?> <!-- DELETED -->  
      
         <?php echo "<a target='_blank' href='../public/storage/isoctrl/".$filename[$i]."'><strike>". $filename[$i]."</strike></a>"; ?></td> 

          <?php }else{ ?>   

         <?php echo "<a target='_blank' href='../public/storage/isoctrl/".$filename[$i]."'>". $filename[$i]."</a>"; ?></td> 

         <?php } ?>

      <!--    <td> -->

          <!-- CHECK BY SPO/SIT -->
            <!-- @include('isoctrl.design-checkby') -->
        <!-- FIN CHECK BY SPO/SIT -->

   <!--      </td>  -->

       

      <?php if ($issued[0]->issued==2){ ?>
      
          <td><?php echo ""; ?></td>
          <td><?php echo ""; ?></td> <!-- Se utiliza la variable $issued solo para aprovechar -->    

      <?php }else{ ?>

      <td><?php echo $issued[0]->from; ?></td>
      <td><?php echo $issued[0]->created_at; ?></td> <!-- Se utiliza la variable $issued solo para aprovechar -->
      
      <?php } ?>

      <td>


        <?php if (auth()->user()->hasRole('DesignAdmin') AND $requested[0]->verifydesign==0 AND $requested[0]->deleted==0){ ?> 

          <?php if ($issued[0]->issued==0 OR $issued[0]->issued==2){ ?>

            <?php 

              if ($issued[0]->tie==1 || $issued[0]->tie==2 || $issued[0]->tie==3 || $issued[0]->spo==1 || $issued[0]->spo==2 || $issued[0]->spo==3 || $issued[0]->sit==1 || $issued[0]->spo==2 || $issued[0]->spo==3){
                $disabled="disabled";
              }else{
                $disabled="";
              }


            ?>

            <!-- SE ACTIVAN O DESACTIVAN SEGÚN CRITERIOS CLAIM -->

            <?php if ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){ ?>

                  <a class="btn btn-xs btn-danger" disabled><b>CLAIMED BY: <?php echo $requested[0]->user;?></b></a>

            <?php } ?>

            <a class="comments-design-modal btn btn-xs btn-success" data-filename ="<?php echo $filename[$i]; ?>" data-requestbydesign ="<?php echo $requested[0]->requested; ?>" data-requestbylead ="<?php echo $requested[0]->requestedlead; ?>" data-toggle="<?php echo $datatoggle; ?>" data-target="#commentsfromdesignModal" <?php echo $disabled2; ?> <?php if ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){echo "Style='display:none'";} ?>>Stress</a>
            <a class="comments-design-to-supports-modal btn btn-xs btn-primary" data-filename ="<?php echo $filename[$i]; ?>" data-requestbydesign ="<?php echo $requested[0]->requested; ?>" data-requestbylead ="<?php echo $requested[0]->requestedlead; ?>" data-toggle="<?php echo $datatoggle; ?>" data-target="#commentsfromdesigntosupportsModal" <?php echo $disabled2; ?>  <?php if ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){echo "Style='display:none'";} ?>>Supports</a>
            <a class="upload-design-modal btn btn-xs btn-info" data-filename ="<?php echo $filename[$i]; ?>" data-pathfrom="design" data-requestbydesign ="<?php echo $requested[0]->requested; ?>" data-requestbylead ="<?php echo $requested[0]->requestedlead; ?>" data-verifydesign ="<?php echo $requested[0]->verifydesign; ?>" data-verifystress ="<?php echo $requested[0]->verifystress; ?>"  data-verifysupports ="<?php echo $requested[0]->verifysupports; ?>" data-toggle="modal" data-target="#uploadfromdesignModal" <?php if ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){echo "Style='display:none'";} ?>>Upload File</a>
            
            <?php if ($requested[0]->verifydesign==1){ ?><!-- Switch para enviar o cancelar verify DesignLead -->

                 <a href="verifyfordesignlead/<?php echo $filename[$i]; ?>/0" class="btn btn-xs btn-warning" data-filename ="<?php echo $filename[$i]; ?>" data-request = "0"  <?php echo $disabled2; ?>  <?php if ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){echo "Style='display:none'";} ?>><b>WAITING FOR VERIFICATION</b></a>

            <?php }else{ ?>
         
                  <a href="verifyfordesignlead/<?php echo $filename[$i]; ?>/1" class="btn btn-xs btn-default" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1"  <?php if ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){echo "Style='display:none'";} ?>><b>VERIFY</b></a>

            <?php } ?>

            <?php if ($requested[0]->claimed==1 AND Auth::user()->name==$requested[0]->user){ ?><!-- Switch para enviar o cancelar reclamo Design -->

                 <a href="claimiso/<?php echo $filename[$i]; ?>/0" class="btn btn-xs btn-warning" data-filename ="<?php echo $filename[$i]; ?>" data-request = "0"><b>UNCLAIM</b></a>

            <?php }elseif ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){ ?><!-- Switch para enviar o cancelar reclamo Design -->
            
                 <!-- NOTHING TO DO -->

            <?php }else{ ?>
         
                  <a href="claimiso/<?php echo $filename[$i]; ?>/1" class="btn btn-xs btn-default" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1"><b>CLAIM</b></a>

            <?php } ?>

            &nbsp;&nbsp;<a onclick="vcomments(<?php echo $issued[0]->id; ?>)" ><img src="{{ asset('images/comment-icon.png') }}" class="mark-icon" style="width:20px;height:20px"></a>&nbsp;&nbsp;

          <?php if (file_exists($pdfcl)) { ?>  

             <?php echo "<a target='_blank' class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0]."-CL.pdf' download>". "<b>PDF</b>"."</a>"; ?>
             
          <?php } ?>

          <?php if (file_exists($zip)) { ?>  

             <?php echo "<a target='_blank' class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0].".zip' download>". "<b>ZIP</b>"."</a>"; ?>
             
          <?php } ?>

          <?php if (file_exists($bfile)) { ?>  

             <?php echo "<a class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0].".b' download>". "<b>BFL</b>"."</a>"; ?>
             
          <?php } ?>

          <?php if (file_exists($dxf)) { ?>  

             <?php echo "<a class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0].".dxf' download>". "<b>DXF</b>"."</a>"; ?>
           
          <?php } ?>

          <?php if (file_exists($cii)) { ?>  

             <?php echo "<a class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0].".cii' download>". "<b>CII</b>"."</a>"; ?>

          <?php } ?> 

          <?php if (file_exists($pdftie)) { ?>  

             <?php echo "<a target='_blank' class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0]."-TIE.pdf'>". "<b>TIE</b>"."</a>"; ?>
             
          <?php } ?>

          <?php if (file_exists($pdfspo)) { ?>  

             <?php echo "<a target='_blank' class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0]."-SPO.pdf'>". "<b>SPO</b>"."</a>"; ?>
             
          <?php } ?>

          <?php if (file_exists($pdfsit)) { ?>  

             <?php echo "<a target='_blank' class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0]."-SIT.pdf'>". "<b>SIT</b>"."</a>"; ?>
             
          <?php } ?>  


          <?php }else{ ?>

            <a class="comments-ldgdesign-to-stress-modal btn btn-xs btn-success" data-filename ="<?php echo $filename[$i]; ?>" data-requestbydesign ="<?php echo $requested[0]->requested; ?>" data-requestbylead ="<?php echo $requested[0]->requestedlead; ?>" data-verifydesign ="<?php echo $requested[0]->verifydesign; ?>" data-toggle="modal" data-target="#commentsfromldgdesigntostressModal" <?php echo $disabled2; ?>>Stress</a>
            <a class="comments-ldgdesign-to-supports-modal btn btn-xs btn-primary" data-filename ="<?php echo $filename[$i]; ?>" data-requestbydesign ="<?php echo $requested[0]->requested; ?>" data-requestbylead ="<?php echo $requested[0]->requestedlead; ?>" data-verifydesign ="<?php echo $requested[0]->verifydesign; ?>" data-toggle="modal" data-target="#commentsfromldgdesigntosupportsModal" <?php echo $disabled2; ?>>Supports</a>

            <!-- <a class="comments-design-to-iso-modal btn btn-xs btn-success" data-filename ="<?php //echo $filename[$i]; ?>" data-toggle="modal" data-target="#commentsfromdesigntoisoModal">To Issue</a> -->
            <a class="upload-design-modal btn btn-xs btn-info" data-filename ="<?php echo $filename[$i]; ?>" data-pathfrom="design" data-requestbydesign ="<?php echo $requested[0]->requested; ?>" data-requestbylead ="<?php echo $requested[0]->requestedlead; ?>" data-verifydesign ="<?php echo $requested[0]->verifydesign; ?>" data-verifystress ="<?php echo $requested[0]->verifystress; ?>"  data-verifysupports ="<?php echo $requested[0]->verifysupports; ?>" data-toggle="modal" data-target="#uploadfromdesignModal">Upload File</a>

          <?php } ?>  
        
        <?php }elseif(auth()->user()->hasRole('DesignLead') AND $requested[0]->verifydesign==1){ ?>

          <!-- SE ACTIVAN O DESACTIVAN SEGÚN CRITERIOS CLAIM -->

            <?php if ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){ ?>

                  <a class="btn btn-xs btn-danger" disabled><b>CLAIMED BY: <?php echo $requested[0]->user;?></b></a>

            <?php } ?>

          <a class="comments-ldgdesign-to-stress-modal btn btn-xs btn-success" data-filename ="<?php echo $filename[$i]; ?>" data-requestbydesign ="<?php echo $requested[0]->requested; ?>" data-requestbylead ="<?php echo $requested[0]->requestedlead; ?>" data-verifydesign ="<?php echo $requested[0]->verifydesign; ?>" data-toggle="modal" data-target="#commentsfromldgdesigntostressModal" <?php echo $disabled; ?> <?php if ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){echo "Style='display:none'";} ?>>Stress</a>
          <a class="comments-ldgdesign-to-supports-modal btn btn-xs btn-primary" data-filename ="<?php echo $filename[$i]; ?>" data-requestbydesign ="<?php echo $requested[0]->requested; ?>" data-requestbylead ="<?php echo $requested[0]->requestedlead; ?>" data-verifydesign ="<?php echo $requested[0]->verifydesign; ?>" data-toggle="modal" data-target="#commentsfromldgdesigntosupportsModal" <?php echo $disabled; ?> <?php if ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){echo "Style='display:none'";} ?>>Supports</a>
          <a class="comments-ldgdesign-to-materials-modal btn btn-xs btn-warning" data-filename ="<?php echo $filename[$i]; ?>" data-requestbydesign ="<?php echo $requested[0]->requested; ?>" data-requestbylead ="<?php echo $requested[0]->requestedlead; ?>" data-verifydesign ="<?php echo $requested[0]->verifydesign; ?>" data-toggle="modal" data-target="#commentsfromldgdesigntomaterialsModal" <?php echo $disabled; ?> <?php if ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){echo "Style='display:none'";} ?>>Spool</a>
          <a class="upload-design-modal btn btn-xs btn-info" data-filename ="<?php echo $filename[$i]; ?>" data-pathfrom="ldgdesign" data-requestbydesign ="<?php echo $requested[0]->requested; ?>" data-requestbylead ="<?php echo $requested[0]->requestedlead; ?>" data-verifydesign ="<?php echo $requested[0]->verifydesign; ?>" data-verifystress ="<?php echo $requested[0]->verifystress; ?>"  data-verifysupports ="<?php echo $requested[0]->verifysupports; ?>" data-toggle="modal" data-target="#uploadfromdesignModal" <?php if ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){echo "Style='display:none'";} ?>>Upload File</a>
               <a class="reject-ldgdesign-modal btn btn-xs btn-danger" data-filename ="<?php echo $filename[$i]; ?>" data-requestbydesign ="<?php echo $requested[0]->requested; ?>" data-requestbylead ="<?php echo $requested[0]->requestedlead; ?>" data-verifydesign ="<?php echo $requested[0]->verifydesign; ?>" data-toggle="modal" data-target="#rejectfromldgdesignModal" <?php if ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){echo "Style='display:none'";} ?>><b>Design</b></a>

          <?php if ($requested[0]->claimed==1 AND Auth::user()->name==$requested[0]->user){ ?><!-- Switch para enviar o cancelar reclamo Design -->

                 <a href="claimiso/<?php echo $filename[$i]; ?>/0" class="btn btn-xs btn-warning" data-filename ="<?php echo $filename[$i]; ?>" data-request = "0"><b>UNCLAIM</b></a>

            <?php }elseif ($requested[0]->claimed==1 AND Auth::user()->name!=$requested[0]->user){ ?><!-- Switch para enviar o cancelar reclamo Design -->
            
                 <!-- NOTHING TO DO -->

            <?php }else{ ?>
         
                  <a href="claimiso/<?php echo $filename[$i]; ?>/1" class="btn btn-xs btn-default" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1"><b>CLAIM</b></a>

            <?php } ?>     

          &nbsp;&nbsp;<a onclick="vcomments(<?php echo $issued[0]->id; ?>)" ><img src="{{ asset('images/comment-icon.png') }}" class="mark-icon" style="width:20px;height:20px"></a>&nbsp;&nbsp;

            <!-- PARA LDG DESIGN -->

                <?php if (file_exists($pdfcl)) { ?>  

             <?php echo "<a target='_blank' class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0]."-CL.pdf'>". "<b>PDF</b>"."</a>"; ?>
             
          <?php } ?>

          <?php if (file_exists($zip)) { ?>  

             <?php echo "<a target='_blank' class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0].".zip' download>". "<b>ZIP</b>"."</a>"; ?>
             
          <?php } ?>

          <?php if (file_exists($bfile)) { ?>  

             <?php echo "<a class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0].".b' download>". "<b>BFL</b>"."</a>"; ?>
             
          <?php } ?>

          <?php if (file_exists($dxf)) { ?>  

             <?php echo "<a class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0].".dxf' download>". "<b>DXF</b>"."</a>"; ?>
           
          <?php } ?>

            <!-- FIN PARA LDG DESIGN -->

        <?php }elseif(auth()->user()->hasRole('DesignAdmin') AND $requested[0]->verifydesign==1){ ?>

          <?php if ($requested[0]->claimed==1){?>

              <a class="btn btn-xs btn-danger" disabled><b>CLAIMED BY: <?php echo $requested[0]->user;?></b></a>
          
          <?php }else{ ?>
          
              <a href="verifyfordesignlead/<?php echo $filename[$i]; ?>/0" class="btn btn-xs btn-warning" data-filename ="<?php echo $filename[$i]; ?>" data-request = "0"><b>WAITING FOR VERIFICATION</b></a>
          
          <?php } ?>  

          


          &nbsp;&nbsp;<a onclick="vcomments(<?php echo $issued[0]->id; ?>)" ><img src="{{ asset('images/comment-icon.png') }}" class="mark-icon" style="width:20px;height:20px"></a>&nbsp;&nbsp;

          <?php if (file_exists($pdfcl)) { ?>  

             <?php echo "<a target='_blank' class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0]."-CL.pdf'>". "<b>PDF</b>"."</a>"; ?>
             
          <?php } ?>

          <?php if (file_exists($zip)) { ?>  

             <?php echo "<a target='_blank' class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0].".zip' download>". "<b>ZIP</b>"."</a>"; ?>
             
          <?php } ?>

          <?php if (file_exists($bfile)) { ?>  

             <?php echo "<a class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0].".b' download>". "<b>BFL</b>"."</a>"; ?>
             
          <?php } ?>

          <?php if (file_exists($dxf)) { ?>  

             <?php echo "<a class='btn btn-xs btn-default' href='../public/storage/isoctrl/attach/".$afilename[0].".dxf' download>". "<b>DXF</b>"."</a>"; ?>
           
          <?php } ?>

        
         <?php }elseif ($requested[0]->claimed==1){?>


              <?php if (auth()->user()->hasRole('IsoctrlAdmin')){?>

                <a href="claimiso/<?php echo $filename[$i]; ?>/0" class="btn btn-xs btn-warning" data-filename ="<?php echo $filename[$i]; ?>" data-request = "0"><b>FORCE UNCLAIM TO: <?php echo $requested[0]->user; ?></b></a>

              <?php }else{ ?>

              <center><b>CLAIMED BY: <?php echo $requested[0]->user; ?></b></center>

            <?php } ?>


        <?php }elseif (auth()->user()->hasRole('IsoctrlAdmin')){?>

            <?php if ($requested[0]->deleted==1){ ?>  <!-- Switch para enviar o cancelar solicitud -->

                 <a href="delfromleadoriso/<?php echo $filename[$i]; ?>/0" class="btn btn-xs btn-danger" data-filename ="<?php echo $filename[$i]; ?>" data-request = "0">Cancel Delete</a>

            <?php }else{ ?>
         
                  <a href="delfromleadoriso/<?php echo $filename[$i]; ?>/1" class="btn btn-xs btn-warning" data-filename ="<?php echo $filename[$i]; ?>" data-request = "1">Delete</a>

            <?php } ?>

         <?php }elseif ($requested[0]->deleted==1){ ?>

                <center><b>DELETED</b></center>

        <?php }elseif ($requested[0]->requested==1){ //REQUESTED A LDGSTRESS?>

              <a class="reject-ldgstress-to-design-modal btn btn-xs btn-danger" data-filename ="<?php echo $filename[$i]; ?>" data-requestbydesign ="<?php echo $requested[0]->requested; ?>" data-toggle="modal" data-target="#rejectfromldgstresstodesignModal">With Comments</a>

        <?php }else{ ?>
        
          <center><a class="comments-design-modal btn btn-xs btn-info" data-filename ="<?php echo $filename[$i]; ?>" data-toggle="modal" data-target=""><b>NO ACTIONS AVAILABLE!</b></a><center>
 
        <?php } ?>
        
      </td>
      </tr>

       <?php } ?> 
       <?php } ?>
      

          </tbody>


    </table>

       


     <!-- BUTTONS FOR SELECT ALL  --> 
     <?php if (auth()->user()->hasRole('DesignAdmin')){ ?>   
      <center><b>Click an action for selected IsoFiles:</b>

      <button class="btn btn-sm btn-success" name="destination" value="stress" <?php echo $disabled2; ?>>Stress</button>
      <button class="btn btn-sm btn-primary" name="destination" value="supports" <?php echo $disabled2; ?>>Supports</button>
      <!-- <button class="btn btn-sm btn-default" name="destination" value="ldgdesign"><b>VERIFY</b></button> -->
      <!-- <button target='_blank' class="btn btn-sm btn-default" name="destination" value="download"><b>DOWNLOAD</b></button> -->
      <br><br>
      {{ Form::textarea('comments', null, ['placeholder' => 'Comments', 'class' => 'comments' , 'cols' => 100, 'rows' =>2,'required' => '', 'maxlength' => "400"]) }} 

        </center>
      <?php } ?>


      <?php if (auth()->user()->hasRole('DesignLead')){ ?>   
      <center><b>Click an action for selected IsoFiles:</b>

      <button class="btn btn-sm btn-success" name="destination" value="ldgstress">Stress</button>
      <button class="btn btn-sm btn-primary" name="destination" value="ldgsupports">Supports</button>
      <button class="btn btn-sm btn-warning" name="destination" value="ldgmaterials">Spool</button>
      <!-- <button class="btn btn-sm btn-danger" name="destination" value="materials">Spool</button> -->
      <br><br>
      {{ Form::textarea('comments', null, ['placeholder' => 'Comments', 'class' => 'comments' , 'cols' => 100, 'rows' =>2,'required' => '', 'maxlength' => "400"]) }} 

        </center>
      <?php } ?>
<!-- 
      <b>Data submitted to the server:</b><br>
      <pre id="example-console">

      </pre>
      </form> -->

    <script type="text/javascript">
    
    setTimeout(function() {
    $('#messages').fadeOut('slow');
    }, 50000);

</script>

    <!-- BUTTONS   -->
    <br>
   <center>
       


        <button onclick="location.href='{{ url('design') }}'" type="button" class="btn btn-primary btn-lg" style="width:15%"><b>Design</b></button>&nbsp;&nbsp;

        <button onclick="location.href='{{ url('stress') }}'" type="button" class="btn btn-default btn-lg" style="width:15%"><b>Stress</b></button>&nbsp;&nbsp;

        <button onclick="location.href='{{ url('supports') }}'" type="button" class="btn btn-default btn-lg" style="width:15%"><b>Supports</b></button>&nbsp;&nbsp;

        <button onclick="location.href='{{ url('materials') }}'" type="button" class="btn btn-default btn-lg" style="width:15%"><b>Spool</b></button>&nbsp;&nbsp;

        <button onclick="location.href='{{ url('lead') }}'" type="button" class="btn btn-default btn-lg" style="width:15%"><b>Issuer</b></button>&nbsp;&nbsp;

        <button onclick="location.href='{{ url('iso') }}'" type="button" class="btn btn-default btn-lg" style="width:15%"><b>LDE/Isocontrol</b></button>


    </center> 


    @extends('isoctrl.commentsfromdesign')
    @extends('isoctrl.commentsfromdesigntosupports')
    @extends('isoctrl.commentsfromdesigntomaterials')
    @extends('isoctrl.commentsfromldgdesigntomaterials')
    @extends('isoctrl.commentsfromldgdesigntostress')
    @extends('isoctrl.commentsfromldgdesigntosupports')
    @extends('isoctrl.rejectfromldgdesign')
    @extends('isoctrl.commentsfromdesigntolead')
    @extends('isoctrl.commentsfromdesigntoiso')
    @extends('isoctrl.uploadfromdesign')

<script src="{{ asset('js/selectall.js') }}"></script> <!-- select all -->

<script type="text/javascript">
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    //$('#tabla').DataTable({"order": [[ 3, 'desc' ]],"pageLength" : 8});
    $('#tabla tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width: 100%;font-size: 12px;font-weight: normal;white-space: nowrap" placeholder="Search '+title+'" />' );
    } );


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
<!-- SELECT ALL -->


<!-- Fin tabla--> 
  </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
</body>
</html>
@endsection

@endif