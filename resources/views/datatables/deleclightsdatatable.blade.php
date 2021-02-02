

<!DOCTYPE html>
<html>
<head>
    <title>TechnipFMC.app - ElecLights</title>
    <link href="{!! asset('css/app.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('js/jquery.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>


</head>
<body>
<img src="{{ asset('images/tpfmc_logo.png') }}" style="width:400px;position: relative; left:380px; top:30px" >
<img src="{{ asset('images/total_logo.png') }}" style="width:300px;position: relative; left:860px; top:20px" >
<br>
<br>
<center><h1>Progress - Electrical Lightning</h1></center><br>
<div class="container">
  <table id="deleclights" class="table table-hover table-condensed" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Zone Name</th>
            <th>Item Name</th>
            <th>Item Type</th>
            <th>Status</th>
        </tr>
    </thead>
  </table>
</div>

<script type="text/javascript">
$(document).ready(function() {
    oTable = $('#deleclights').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('deleclightsdatatable.deleclightsgetposts') }}",
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'zone_name', name: 'zone_name'},
            {data: 'item_name', name: 'item_name'},
            {data: 'item_type', name: 'item_type'},
            {data: 'status_lighting', name: 'status_lighting'}
        ]
    });
});
</script>
</body>
</html>

