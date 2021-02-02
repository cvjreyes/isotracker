@if (Auth::guest())

@else

@extends('layouts.datatable')

@section('content')

<script>

 </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>



                            <script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s1").style.fontWeight='bold';
                                     document.getElementById("s1").style.fontSize=10 + "pt";
                                     document.getElementById("s1").style.fontStyle="italic";;


                                 }

                            </script> 
            <?php 
                    $sum_per_ecivil = DB::select("SELECT SUM(est_hours) as ehrscivils FROM civilsview");
                    $sum_per_civil = DB::select("SELECT SUM(total_progress) as sum_per_civil FROM pcivils_view"); 
                    ?>
<br><br><br><br>
<div class="container">
                                                <center>
                                              <h2><b>Modelled Civil</b></h2>

                                                 <!--   Se comprueba el peso deseado (BUDGET/AREAS) -->

                                                <?php $weight_total= DB::select("SELECT weight_total FROM pmanagers WHERE name='civil'");?>

                                            <?php if ($weight_total[0]->weight_total==0) :?>    

                                                <?php $total_weight= DB::select("SELECT SUM(weight*qty) AS weight FROM ecivilsfullview;");?> 

                                            <?php else: ?>

                                                 <?php $total_weight= DB::select("SELECT weight FROM pmanagers WHERE name='civil'");?>   

                                            <?php endif ?>

                                     <!--   FIN DE LA COMPROBACIÓN (BUDGET/AREAS) -->   
                                                <?php if ($total_weight[0]->weight!=0) :?>

                                                    <h3>Estimated Weight: <?php echo $total_weight[0]->weight; ?>
                                                    <?php $total_progress = DB::select("SELECT SUM((weight*progress)/".$total_weight[0]->weight.") as total_progress FROM dcivilsfullview;");

                                                  
                                                    ?>

                                                <br>Total Progress: <?php echo round($total_progress[0]->total_progress,1)."%";?></h3>


                                                <?php else: ?>

                                                    <h3>Estimated Weight: <?php echo "0"; ?>
                                                    <br>Total Progress: <?php echo "0%";?></h3>

                                                <?php endif ?>
                                                </center>



<br>
<button onclick="location.href='{{ url('typescivil') }}'" type="button" class="btn btn-lg btn-default"><img src="{{ asset('images/stru-icon.png') }}" style="width:23px" ></button>
<button onclick="location.href='{{ url('exportmodeledcivil') }}'" type="button" class="btn btn-lg btn-success" style="font-size: 16px;font-weight: bold">Excel</button><br>
<br>



<link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>
<table border id="modeledcivil" class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap">
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
    oTable = $('#modeledcivil').DataTable({
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
        "ajax": "{{ route('civil.dcivilsfullquery') }}",
        "columns": [
            {data: 'unit', name: 'unit'},
            {data: 'area', name: 'area'},
            {data: 'tag', name: 'tag'},
            {data: 'type_civil', name: 'type_civil'},
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
  <!-- <button onclick="location.href='{{ url('glinecivil') }}'" type="button" class="btn btn-primary btn-lg">CurveByArea</button> -->
  <button onclick="location.href='{{ url('glineciviltotal') }}'" type="button" class="btn btn-primary btn-lg">Curve</button>
  <!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#glinecivilModal">LineChart</button> -->
  <button onclick="location.href='{{ url('civilpments') }}'" type="button" class="btn btn-lg btn-default">Estimated</button>


  </center>

  <!-- SCRIPT PARA BÚSQUEDA POR COLUMNAS   -->


<script type="text/javascript">
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#modeledcivil tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width: 100%;font-size: 12px;font-weight: normal;white-space: nowrap" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#modeledcivil').DataTable();
 
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
