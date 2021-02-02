@if (Auth::guest())

@else

@extends('layouts.datatable')

@section('content')

<script>

 </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>



                            <script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s3").style.fontWeight='bold';
                                     document.getElementById("s3").style.fontSize=10 + "pt";
                                     document.getElementById("s3").style.fontStyle="italic";;


                                 }

                            </script> 
            <?php 
                    $sum_per_einst = DB::select("SELECT SUM(est_hours) as ehrsinsts FROM instsview");
                    $sum_per_inst = DB::select("SELECT SUM(total_progress) as sum_per_inst FROM pinsts_view"); 
                    ?>
<br><br><br><br>
<div class="container">
                                                <center>
                                              <h2><b>Modelled Instruments</b></h2>

                                                 <!--   Se comprueba el peso deseado (BUDGET/AREAS) -->

                                                <?php $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='inst'");?>

                                            <?php if ($weight_total[0]->weight_total==0) :?>    

                                                <?php $total_weight= DB::select("SELECT SUM(weight*qty) AS weight FROM einstsfullview;");?> 

                                            <?php else: ?>

                                                 <?php $total_weight= DB::select("SELECT weight FROM pmanagers WHERE name='inst'");?>   

                                            <?php endif ?>

                                     <!--   FIN DE LA COMPROBACIÓN (BUDGET/AREAS) -->   
                                                <?php if ($total_weight[0]->weight!=0) :?>

                                                    <h3>Estimated Weight: <?php echo $total_weight[0]->weight; ?>
                                                    <?php $total_progress = DB::select("SELECT SUM((weight*progress)/".$total_weight[0]->weight.") as total_progress FROM dinstsfullview;");

                                                  
                                                    ?>

                                                <br>Total Progress: <?php echo round($total_progress[0]->total_progress,1)."%";?></h3>


                                                <?php else: ?>

                                                    <h3>Estimated Weight: <?php echo "0"; ?>
                                                    <br>Total Progress: <?php echo "0%";?></h3>

                                                <?php endif ?>
                                                </center>



<br>
<button onclick="location.href='{{ url('typesinst') }}'" type="button" class="btn btn-lg btn-default"><img src="{{ asset('images/stru-icon.png') }}" style="width:23px" ></button>
<button onclick="location.href='{{ url('exportmodeledinst') }}'" type="button" class="btn btn-lg btn-success" style="font-size: 16px;font-weight: bold">Excel</button><br>
<br>



<link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>
<table border id="modeledinst" class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap">
    <thead>
        <tr>
            <th>Unit</th>
            <th>Area</th>
            <th>Tag</th>
            <th>Type</th>
            <th>Weight</th>
            <th>Status</th>
            <th>Progress</th>

        </tr>
    </thead>
    <tfoot><tr>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
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
$(document).ready(function() {
    oTable = $('#modeledinst').DataTable({
        // dom: 'Bfrtip',
        // buttons: [            
        //     {
        //         extend: 'excelHtml5',
        //         title: 'EQP-Modeled',
        //         exportOptions: {
        //             columns: [ 0, 1, 2, 3, 4, 5 ]
        //         }
        //     },
        //     {
        //         extend: 'pdfHtml5',
        //         title: 'EQP-Modeled',
        //         exportOptions: {
        //             columns: [ 0, 1, 2, 3, 4, 5 ]
        //         }
        //     },
          
        // ],
        "processing": true,
        "serverSide": false,
        "autoWidth": false,
        "ajax": "{{ route('instruments.dinstsfullquery') }}",
        "columns": [
            {data: 'unit', name: 'unit'},
            {data: 'area', name: 'area'},
            {data: 'tag', name: 'tag'},
            {data: 'type_inst', name: 'type_inst'},
            {data: 'weight', name: 'weight'},
            {data: 'status', name: 'status'},
            {data: 'progress', name: 'progress'}
   

        ]


    });
});
</script>
<br>
<br>
<br>





<script type="text/javascript">
    
    setTimeout(function() {
    $('#messages').fadeOut('slow');
}, 10000);

</script>
<center><strong><div id="messages">
@if ($message = Session::get('success'))

<br>


        <div class="alert alert-success"> 
            <p>{{ $message }}</p>
        </div>

    @endif

@if ($message = Session::get('warning'))
<br>
<br>

        <div class="alert alert-warning"> 
            <p>{{ $message }}</p>
        </div>

    @endif

@if ($message = Session::get('danger'))
<br>
<br>

        <div class="alert alert-danger"> 
            <p>{{ $message }}</p>
        </div>

    @endif
</div>
</strong></center>



  </center> 


  <center>
  <!-- <button onclick="location.href='{{ url('glineinst') }}'" type="button" class="btn btn-primary btn-lg">CurveByArea</button> -->
  <button onclick="location.href='{{ url('glineinsttotal') }}'" type="button" class="btn btn-primary btn-lg">Curve</button>
  <!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#glineinstModal">LineChart</button> -->
  <button onclick="location.href='{{ url('instpments') }}'" type="button" class="btn btn-lg btn-default">Estimated</button>


  </center>

  <!-- SCRIPT PARA BÚSQUEDA POR COLUMNAS   -->


<script type="text/javascript">
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#modeledinst tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width: 100%;font-size: 12px;font-weight: normal;white-space: nowrap" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#modeledinst').DataTable();
 
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

@endif
