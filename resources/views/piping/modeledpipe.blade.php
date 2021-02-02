@if (Auth::guest())

@else

@extends('layouts.datatable')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>TechnipFMC.app - Equipments</title>
    <link href="{!! asset('css/app.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('js/jquery.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>


</head>
<body>
<div class="modal-header" style="background-color: #F5F8FA;border-radius: 4px;">
                            <button type="button" class="close" data-dismiss="modal"" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <table>
                            <?php //$sum_per_pipe = DB::select("SELECT * FROM total_ppipes_view"); ?>

                            </table>
        
                        </div>
                        
<!-- Data Table Progress By Area -->


                                                <center>
                                                <h3>Modeled Table</h3>
                                                <h4><?php //echo round((($sum_per_pipe[0]->total_epipe_hours)/($sum_per_pipe[0]->est_hours))*100,2)."%"; ?></h4>
                                                </center>

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

<div class="container" style="width:100%">
<table id="dequigetprogressbyarea" class="table table-hover table-condensed" style="width:100%;font-size: 14px;font-weight: normal">
    <thead>
        <tr>
        <!--     <th>Zone</th> -->
            <!-- <th>Line Name</th> -->
            <th>PDMS LineNumber</th>
            <th>Pid Progress</th>
            <th>Pid Status</th>
            <th>Iso Progress</th>
            <th>Iso Status</th>
            <th>Stress Progress</th>
            <th>Stress Status</th>
            <th>Support Progress</th>
            <th>Support Status</th>

            
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
        "ajax": "{{ route('dpipedatatable.dpipegetposts') }}",
        "columns": [
            // {data: 'zone_name', name: 'zone_name'},
            // {data: 'pipe_name', name: 'pipe_name'},
            {data: 'pdms_linenumber', name: 'pdms_linenumber'},
            {data: 'pid', name: 'pid'},
            {data: 'pidpname', name: 'pidpname'},
            {data: 'iso', name: 'iso'},
            {data: 'isospname', name: 'isospname'},
            {data: 'stress', name: 'stress'},
            {data: 'stressespname', name: 'stressespname'},
            {data: 'support', name: 'support'},
            {data: 'supportspname', name: 'supportspname'}
            
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
