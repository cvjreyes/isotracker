@extends('layouts.datatable')

@section('content')
<!doctype html>
<script type="text/javascript">
  
  $(document).on('click', '.comments-supports-modal', function() {

            $('.filename').val($(this).data('filename'));
            $('.pathfrom').val($(this).data('pathfrom'));

        });

   $(document).on('click', '.reject-supports-modal', function() {

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
<title>Supports</title>


</head>
<body>


<div class="container">
  <div class="row">
    <!-- <h4>Agregar Nueva Descarga</h4> -->
    <hr style="margin-top:5px;margin-bottom: 5px;">
    <div class="content"> </div>
    <center><h2 style="padding-top: 7%"><b>Iso Controller</b></h2>
      <h3>Supports</h3></center>

      <div class="panel-body">
        <button onclick="location.href='{{ url('hisoctrl') }}'" type="button" class="btn btn-default btn-lg">Go to History</button>
      <table class="table">

      <!-- DATATABLE-->

      <link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
      <script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>

      <table border id="tabla" class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap">
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
              $filename = scandir("../public/storage/isoctrl/supports");
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

           $requested = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename='".$filename[$i]."')");

        if ($requested[0]->requested==1){ ?> <!-- Aparece flag si tiene solicitud desde diseño -->

            <img src="{{ asset('images/req-icon.png') }}" class="req-icon" style="width:15px;height:15px">
          
        <?php } ?>
        
        <?php echo "<a target='_blank' href='../public/storage/isoctrl/".$filename[$i]."'>". $filename[$i]."</a>"; ?>
      </td>


        <td><?php echo $requested[0]->from; ?></td>
      <td><?php echo $requested[0]->created_at; ?></td> <!-- Se utiliza la variable $requested solo para aprovechar -->

      <td>

       <?php if (auth()->user()->hasRole('SupportsAdmin')){ ?> 

           <?php if ($requested[0]->requested==0){ ?> <!-- Si no tiene solicitud desde diseño puede enviar a siguiente etapa -->

              <a class="comments-supports-modal btn btn-xs btn-success" data-filename ="<?php echo $filename[$i]; ?>" data-toggle="modal" data-target="#commentsfromsupportsModal">Send to Materials</a>

          <?php } ?>

          <a class="reject-supports-modal btn btn-xs btn-danger" data-filename ="<?php echo $filename[$i]; ?>" data-toggle="modal" data-target="#rejectfromsupportsModal">With Comments</a>
          <a class="upload-design-modal btn btn-xs btn-info" data-filename ="<?php echo $filename[$i]; ?>" data-pathfrom="supports" data-toggle="modal" data-target="#uploadfromdesignModal">Upload File</a>

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

    @extends('isoctrl.commentsfromsupports')
    @extends('isoctrl.rejectfromsupports')
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
        <button onclick="location.href='{{ url('supports') }}'" type="button" class="btn btn-primary btn-lg">Supports</button>
        <img src="{{ asset('images/arrow-icon.png') }}" style="width:30px" >
        <button onclick="location.href='{{ url('materials') }}'" type="button" class="btn btn-info btn-lg">Materials</button>
    </center>
    <br><br>    
    <center>
        <button onclick="location.href='{{ url('iso') }}'" type="button" class="btn btn-info btn-lg">IsoController</button>
    </center>
</div>

<!-- Fin tabla--> 
  </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
</body>
</html>
@endsection
