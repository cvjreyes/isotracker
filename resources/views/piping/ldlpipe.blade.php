@if (Auth::guest())

@else

@extends('layouts.datatable')

@section('content')

<script>

 </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>




                            <script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s4").style.fontWeight='bold';
                                     document.getElementById("s4").style.fontSize=10 + "pt";
                                     document.getElementById("s4").style.fontStyle="italic";;


                                 }

                            </script> 

<br><br><br>

<div class="container" style="width: 100%"> <!-- ESTILO DEL DIV PARA DATATABLE OJO -->
    <link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>
<center><h3>PHOENIX Project EPC1</h3>
    <h4>HVO and PTT</h4>
</center>

                          <!--   <button onclick="location.href='{{ url('createlinewindow') }}'" type="button" target="_blank" class="btn btn-lg">Add Line&nbsp;&nbsp;<img src="{{ asset('images/add-icon.ico') }}" style="width:20px" ></button> -->

                            <button onclick="window.open('createlinewindow','_blank', 'directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, resizable=no,width=1920, height=1080');" type="button" target="_blank" class="btn btn-lg">Add Line&nbsp;&nbsp;<img src="{{ asset('images/add-icon.ico') }}" style="width:20px" ></button>
                           

<br><br><br>




<table border id="epipe" class="table table-hover table-condensed" style="width: 100%;font-size: 12px;font-weight: normal;white-space: nowrap">
    <center><thead>
        <tr>
            <th></th>
            <th colspan="2"></th> 
            <th style="text-align: center">DIAMETER</th>
            <th style="text-align: center">FLUID</th>
            <th style="text-align: center">LINE</th>
            <th style="text-align: center">PIPING</th>
            <th colspan="2" style="text-align: center">LOCATION</th>
            <th colspan="2" style="text-align: center">FLUID</th>
            <th style="text-align: center">DENSITY</th>
            <th colspan="2" style="text-align: center">OPERATION CONDITIONS</th>
            <th colspan="2" style="text-align: center">DESIGN CONDITIONS</th>
            <th colspan="2" style="text-align: center">ALT 1 - OTHERS OPERATION CONDITIONS</th>
            <th colspan="2" style="text-align: center">ALT 1 - OTHERS DESIGN CONDITIONS</th>
            <th colspan="2" style="text-align: center">ALT 2 - OTHERS OPERATION CONDITIONS</th>
            <th colspan="2" style="text-align: center">ALT 2 - OTHERS DESIGN CONDITIONS</th>
            <th style="text-align: center">DESIGN CONDITIONS</th>
            <th colspan="2" style="text-align: center">WALL THICKNESS</th>
            <th colspan="3" style="text-align: center">INSULATION</th>
            <th colspan="2" style="text-align: center">TRACING</th>
            <th></th>
            <th colspan="2" style="text-align: center">PAINT</th>
            <th colspan="3" style="text-align: center">TEST PRESSURE</th>
            <th colspan="3" style="text-align: center">AUTHORITY CONTROL</th>
            <th colspan="4" style="text-align: center"></th>
            <th colspan="3" style="text-align: center">SAFETY ACCESORIES</th>
        </tr>

        <tr>
            <th>ACTION</th>
            <th style="text-align: center">UNIT</th>
            <th style="text-align: center">SECTION</th>
            <th style="text-align: center">DN</th>
            <th style="text-align: center">CODE</th>
            <th style="text-align: center">NUMBER</th>
            <th style="text-align: center">SPEC</th>
            <th style="text-align: center">FROM</th>
            <th style="text-align: center">TO</th>
            <th style="text-align: center">DESCRIPTION</th>
            <th style="text-align: center">PHA</th>
            <th style="text-align: center">KG/M3</th>
            <th style="text-align: center">PRESS BAR G</th>
            <th style="text-align: center">TEMP ºC</th>
            <th style="text-align: center">PRESS BAR G</th>
            <th style="text-align: center">TEMP ºC</th>
            <th style="text-align: center">PRESS BAR G</th>
            <th style="text-align: center">TEMP ºC</th>
            <th style="text-align: center">PRESS BAR G</th>
            <th style="text-align: center">TEMP ºC</th>
            <th style="text-align: center">PRESS BAR G</th>
            <th style="text-align: center">TEMP ºC</th>
            <th style="text-align: center">PRESS BAR G</th>
            <th style="text-align: center">TEMP ºC</th>
            <th style="text-align: center">Tº FLEX ºC</th>
            <th style="text-align: center">SCH</th>
            <th style="text-align: center">COR MM</th>
            <th style="text-align: center">CODE</th>
            <th style="text-align: center">LIM</th>
            <th style="text-align: center">THK MM</th>
            <th style="text-align: center">SIZE</th>
            <th style="text-align: center">Nº</th>
            <th style="text-align: center">Tº MAIN ºC</th>
            <th style="text-align: center">1</th>
            <th style="text-align: center">2</th>
            <th style="text-align: center">TYP</th>
            <th style="text-align: center">MIN BAR G</th>
            <th style="text-align: center">MAX BAR G</th>
            <th style="text-align: center">PHA</th>
            <th style="text-align: center">GROUP</th>
            <th style="text-align: center">CATEGORY</th>
            <th style="text-align: center">CANCELLED</th>
            <th style="text-align: center">REVIEW</th>
            <th style="text-align: center">PID</th>
            <th style="text-align: center">NOTES</th>
            <th style="text-align: center">REQUIREMENT</th>
            <th style="text-align: center">ACCESORY</th>
            <th style="text-align: center">NOTES</th>

        </tr>
    </thead>
    <tfoot><tr>
            <th>ACTION</th>
            <th style="text-align: center">UNIT</th>
            <th style="text-align: center">SECTION</th>
            <th style="text-align: center">DN</th>
            <th style="text-align: center">CODE</th>
            <th style="text-align: center">NUMBER</th>
            <th style="text-align: center">SPEC</th>
            <th style="text-align: center">FROM</th>
            <th style="text-align: center">TO</th>
            <th style="text-align: center">DESCRIPTION</th>
            <th style="text-align: center">PHA</th>
            <th style="text-align: center">KG/M3</th>
            <th style="text-align: center">PRESS BAR G</th>
            <th style="text-align: center">TEMP ºC</th>
            <th style="text-align: center">PRESS BAR G</th>
            <th style="text-align: center">TEMP ºC</th>
            <th style="text-align: center">PRESS BAR G</th>
            <th style="text-align: center">TEMP ºC</th>
            <th style="text-align: center">PRESS BAR G</th>
            <th style="text-align: center">TEMP ºC</th>
            <th style="text-align: center">PRESS BAR G</th>
            <th style="text-align: center">TEMP ºC</th>
            <th style="text-align: center">PRESS BAR G</th>
            <th style="text-align: center">TEMP ºC</th>
            <th style="text-align: center">Tº FLEX ºC</th>
            <th style="text-align: center">SCH</th>
            <th style="text-align: center">COR MM</th>
            <th style="text-align: center">CODE</th>
            <th style="text-align: center">LIM</th>
            <th style="text-align: center">THK MM</th>
            <th style="text-align: center">SIZE</th>
            <th style="text-align: center">Nº</th>
            <th style="text-align: center">Tº MAIN ºC</th>
            <th style="text-align: center">1</th>
            <th style="text-align: center">2</th>
            <th style="text-align: center">TYP</th>
            <th style="text-align: center">MIN BAR G</th>
            <th style="text-align: center">MAX BAR G</th>
            <th style="text-align: center">PHA</th>
            <th style="text-align: center">GROUP</th>
            <th style="text-align: center">CATEGORY</th>
            <th style="text-align: center">CANCELLED</th>
            <th style="text-align: center">REVIEW</th>
            <th style="text-align: center">PID</th>
            <th style="text-align: center">NOTES</th>
            <th style="text-align: center">REQUIREMENT</th>
            <th style="text-align: center">ACCESORY</th>
            <th style="text-align: center">NOTES</th>

        </tr></tfoot>

        </center>
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
var action_bt = "Edit / Delete"
$(document).ready(function() {

    

    oTable = $('#epipe').DataTable({
        
        pageLength: 10,
       
        className: 'select-checkbox',
        clipboard:"selection",
        dom: 'Bfrtip',

        buttons: [            
            {
                extend: 'excelHtml5',
                title: 'Line List',
                exportOptions: {
                    columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Line List',
                exportOptions: {
                    columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47]
                }
            },

     
          
        ],
        "processing": true,
        "serverSide": false,

        "ajax": "{{ route('piping.ldlpipe') }}",
        "columns": [
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'area', name: 'area'},
            {data: 'section', name: 'section'},
            {data: 'diameter', name: 'diameter'},
            {data: 'fluid', name: 'fluid'},
            {data: 'line_number', name: 'line_number'},
            {data: 'spec', name: 'spec'},
            {data: 'loc_from', name: 'loc_from'},
            {data: 'loc_to', name: 'loc_to'},
            {data: 'flu_name', name: 'flu_name'},
            {data: 'flu_pha', name: 'flu_pha'},
            {data: 'density', name: 'density'},
            {data: 'oco_pressbar', name: 'oco_pressbar'},
            {data: 'oco_tempc', name: 'oco_tempc'},
            {data: 'dco_pressbar', name: 'dco_pressbar'},
            {data: 'dco_tempc', name: 'dco_tempc'},
            {data: 'oocoa_pressbar', name: 'oocoa_pressbar'},
            {data: 'oocoa_tempc', name: 'oocoa_tempc'},
            {data: 'odcoa_pressbar', name: 'odcoa_pressbar'},
            {data: 'odcoa_tempc', name: 'odcoa_tempc'},
            {data: 'oocob_pressbar', name: 'oocob_pressbar'},
            {data: 'oocob_tempc', name: 'oocob_tempc'},
            {data: 'odcob_pressbar', name: 'odcob_pressbar'},
            {data: 'odcob_tempc', name: 'odcob_tempc'},
            {data: 'dco_tflexc', name: 'dco_tflexc'},
            {data: 'wth_sch', name: 'wth_sch'},
            {data: 'wth_cormm', name: 'wth_cormm'},
            {data: 'ins_com', name: 'ins_com'},
            {data: 'ins_lim', name: 'ins_lim'},
            {data: 'ins_thkmm', name: 'ins_thkmm'},
            {data: 'tra_size', name: 'tra_size'},
            {data: 'tra_num', name: 'tra_num'},
            {data: 'tmainc', name: 'tmainc'},
            {data: 'paint_a', name: 'paint_a'},
            {data: 'paint_b', name: 'paint_b'},
            {data: 'tpr_typ', name: 'tpr_typ'},
            {data: 'tpr_minbarg', name: 'tpr_minbarg'},
            {data: 'tpr_maxbarg', name: 'tpr_maxbarg'},
            {data: 'aut_pha', name: 'aut_pha'},
            {data: 'aut_grp', name: 'aut_grp'},
            {data: 'aut_cat', name: 'aut_cat'},
            {data: 'cancelled', name: 'cancelled'},
            {data: 'rev', name: 'rev'},
            {data: 'pid', name: 'pid'},
            {data: 'notes', name: 'notes'},
            {data: 'sftyacces', name: 'sftyacces'},
            {data: 'sftyacces', name: 'sftyacces'},
            {data: 'sftyacces', name: 'sftyacces'},

]

    });
   
});


$(document).ready(function() {
    var table = $('#epipe').DataTable();
 
    $('#epipe tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
           
            var data = table.row( this ).data();
            //alert( 'You clicked on '+data[0]+'\'s row' );
        }
    } );
 
    $('#button').click( function () {
        table.row('.selected').remove().draw( false );

    } );
} );

</script>
<br>
<br>
<br>

<!-- BOTONES PARA REGRESAR SCROLL -->
<!-- BOTONES PARA REGRESAR SCROLL -->
<!-- BOTONES PARA REGRESAR SCROLL -->
<!-- BOTONES PARA REGRESAR SCROLL -->
<!-- BOTONES PARA REGRESAR SCROLL -->
<!-- BOTONES PARA REGRESAR SCROLL -->
<!-- BOTONES PARA REGRESAR SCROLL -->
<!-- BOTONES PARA REGRESAR SCROLL -->
<style>
#myBtn {
  display: none;
  position: fixed;
  bottom: 20px;
  right: 30px;
  z-index: 99;
  border: none;
  outline: none;
  background-color: red;
  color: white;
  cursor: pointer;
  padding: 15px;
  border-radius: 10px;
}

#myBtn:hover {
  background-color: #555;
}
</style>
</head>
<body>

<button onclick="topFunction()" id="myBtn" title="Go to top" style="width: 200px;font-size: 24px">Go to start</button>




<script>
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20 || document.body.scrollLeft > 20 || document.documentElement.scrollLeft > 20) {
        document.getElementById("myBtn").style.display = "block";
        //document.getElementById("thead").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }


}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
    document.body.scrollLeft = 0;
    document.documentElement.scrollLeft = 0;
}
</script>

  <center>
  <!-- <button style="align:right" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modeledpipeModal">Modeled</button>
  <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#glinepipeModal">LineChart</button>
  <button onclick="location.href='{{ url('home') }}'" type="button" class="btn btn-lg btn-default">Home</button> -->


  </center>







  <!-- SCRIPT PARA BÚSQUEDA POR COLUMNAS   -->


<script type="text/javascript">
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#epipe tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#epipe').DataTable();
 
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
