@if (Auth::guest())

@else

@extends('layouts.datatable')

@section('content')




                <div class="panel-body">

<!DOCTYPE html>
<html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>
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

   


<head>
    <title>TechnipFMC.app - Equipments</title>
    

</head>
<body>

                            <?php $sum_per_equi = DB::select("SELECT SUM(total_progress) as sum_per_equi FROM pequis_view"); ?>

<script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s0").style.fontWeight='bold';
                                     document.getElementById("s0").style.fontSize=12 + "pt";
                                     document.getElementById("s0").style.fontStyle="italic";;


                                 }

                            </script> 


<div class="container">
</br></br>






                                                <center>
                                                <h3>Modeled Table</h3>
                                                <h4><?php echo round($sum_per_equi[0]->sum_per_equi,2)."%"; ?></h4>
                                                </center>

<div class="container" style="width:100%">
<table id="dequigetprogressbyarea" class="table table-hover table-condensed" style="width:100%">
    <thead>
        <tr>
            <th>Zone</th>
            <th>Type of Equipments</th>
            <th>Progress</th>
            <th>Status</th>
            <th>Modeled</th>
            <th>MultProgress</th>
            <th>MultEstimated</th>
            <th>Total Progress (%)</th>
        </tr>
    </thead>
  </table>



<script type="text/javascript">
$(document).ready(function() {
    oTable = $('#dequigetprogressbyarea').DataTable({
        dom: 'Bfrtip',
        buttons: [            
            {
                extend: 'excelHtml5',
                title: 'EQP-Modeled',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'EQP-Modeled',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            },
          
        ],
        "processing": true,
        "serverSide": false,
        "autoWidth": false,
        "ajax": "{{ route('dequidatatable.dequigetprogressbyarea') }}",
        "columns": [
            {data: 'zone_name', name: 'zone_name'},
            {data: 'type_equi', name: 'type_equi'},
            {data: 'progress', name: 'progress'},
            {data: 'status', name: 'status'},
            {data: 'modeled', name: 'modeled'},
            {data: 'mult_progress', name: 'mult_progress'},
            {data: 'mult_estimated', name: 'mult_estimated'},   
            {data: 'total_progress', name: 'total_progress'} 
        ]


    });
});
</script>

</div>

</body>

</html>

<br>
<br>

</center>
    <center>

        <button data-dismiss="modal" value="Close" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#glineequiModal">LineChart</button>
        <input type="submit" style="height:48px" class="btn btn-lg btn-default" data-dismiss="modal" value="Close">
    
    </center>

</div>
</div>
</div>
</div>
</div>


@endsection
@endif
