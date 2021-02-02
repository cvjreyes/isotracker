<!--     <link href="{!! asset('css/all.css') !!}" media="all" rel="stylesheet" type="text/css" /> -->
    <!-- <script type="text/javascript" src="{!! asset('js/app.min.js') !!}"></script> -->
  
@if (Auth::guest())

@else

@extends('layouts.datatable')

@section('content')
                        <script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s3").style.fontWeight='bold';
                                     document.getElementById("s3").style.fontSize=10 + "pt";
                                     document.getElementById("s3").style.fontStyle="italic";;


                                 }

                            </script>  
<!DOCTYPE html>
<html>
<head>
    <title>TechnipFMC.app - Electrical Distribution Boards</title>

    <link href="{!! asset('css/app.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<!--     <link href="{!! asset('css/tabulator.min.css') !!}" media="all" rel="stylesheet" type="text/css" /> -->

    <script type="text/javascript" src="{!! asset('js/jquery.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/dataTables.buttons.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/dataTables.select.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/dataTables.keyTable.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/dataTables.editor.min.js') !!}"></script>
<!--     <script type="text/javascript" src="{!! asset('js/tabulator.min.js') !!}"></script> -->

</head>
<body>
<div id="fixhead" style="width:100%;background-color: #f5f8fa; position: fixed;z-index: 1;">
<br>
<!-- <img src="{{ asset('images/tpfmc_logo.png') }}" style="width:400px;position: absolute; left:20%; top:40px" >-->
<img src="{{ asset('images/total_logo.png') }}" style="width:10%;position: absolute; left:70%; top:30%" > 
<br>
<br>
<br>
<br>
<br>
<center><a href="home"><h4>Dashboard</h4></a></center>
<center><h1>Progress - Electrical Distribution Boards</h1></center><br>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="container">
  <table id="delecdistboards" class="table table-hover table-condensed" style="width:100%">
    <thead>
        <tr>

            <th>Zone Name</th>
            <th>Item Name</th>
            <th>Item Type</th>
            <th>Progress</th>
        </tr>
    </thead>
  </table>
</div>

<!-- <script>
   var editor;  
$(document).ready(function() {
    editor = new $.fn.dataTable.Editor( {
        ajax: "{{ route('delecdistboardsdatatable.delecdistboardsgetposts') }}",
        table: "#delecdistboards",
        fields: [ {
                label: "zone_name:",
                name: "zone_name"
            }, {
                label: "item_name:",
                name: "item_name"
            }, {
                label: "item_type:",
                name: "item_type'"
            }, {
                label: "status_boards:",
                name: "status_boards"
            }
        ]
    } );
 
    // Activate an inline edit on click of a table cell
    $('#delecdistboards').on( 'click', 'tbody td:not(:first-child)', function (e) {
        editor.inline( this );
    } );
 
    $('#delecdistboards').DataTable( {
        dom: "Bfrtip",
        ajax: "{{ route('delecdistboardsdatatable.delecdistboardsgetposts') }}",
        order: [[ 1, 'asc' ]],
        columns: [
            {
                data: null,
                defaultContent: '',
                className: 'select-checkbox',
                orderable: false
            },
            { data: "zone_name" },
            { data: "item_name" },
            { data: "item_type" },
            { data: "status_boards" }

        ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        buttons: [
            { extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor }
        ]
    } );
} );


</script> -->



<script type="text/javascript">

$(document).ready(function() {


    
    
    $('#delecdistboards').on( 'click', 'tbody td:not(:first-child)', function (e) {
        editor.inline( this );
    } );
    oTable = $('#delecdistboards').DataTable({

        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('delecdistboardsdatatable.delecdistboardsgetposts') }}",
        "columns": [
            {data: 'zone_name', name: 'zone_name'},
            {data: 'item_name', name: 'item_name'},
            {data: 'item_type', name: 'item_type'},
            {data: 'status_boards', name: 'status_boards'},

        ]
    });
});
</script>
<br>
<br>
<br>
<br>
@include('common.footer')
</body>
</html>
</div>
@endsection
@endif
