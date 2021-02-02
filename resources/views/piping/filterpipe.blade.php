@if (Auth::guest())

@else

@role('Equi')

@extends('layouts.datatable')

@section('content')

<script>

 </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>




  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>


<script type="text/javascript">

    function initGui()
    {
        $('.date-iso8601').datepicker();
    }
   

    $(function () {
        $('.add').click(function () {

            var n = ($('.resultbody tr').length - 0) + 1;
            var tr = '<tr class="fila">' +
                    '<td>{!! Form::select('field[]', array('area' => 'Area', 'diameter' => 'Diameter')); !!}</td>'+
                    '<td>{!! Form::select('operator[]', array('=' => 'Equal', '!=' => 'Different', '>' => 'Greater Than', '>=' => 'Greater or Equal than', '<' => 'Less Than', '<=' => 'Less or Equal Than')); !!}</td>'+
                    '<td>{!! Form::text('comparison[]', null, array('placeholder' => 'Comparison','class' => 'form-control','style' => 'font-size: 14px;font-weight: normal;','required')) !!}</td>'+
                    '<td><input type="button" class="btn btn-danger delete" value="x"></td></tr>';
            $('.resultbody').append(tr);
        });

        $('.resultbody').delegate('.delete', 'click', function () {
            $(this).parent().parent().remove();
        });

        $('.resultbody').delegate('.obtainedmarks , .totalmarks', 'keyup', function () {
            var tr = $(this).parent().parent();
            var obtainedmarks = tr.find('.obtainedmarks').val() - 0;
            var totalmarks = tr.find('.totalmarks').val() - 0;

            var percentage = (obtainedmarks / totalmarks) * 100;
            tr.find('.percentage').val(percentage);
        });
    });

            
// SHOW/UPDATE EQUIPMENT 
$(document).on('click', '.edit-filterpipes-modal', function() {
         

            $('.id').val($(this).data('id'));

            $('.field').val($(this).data('field'));
            $('.operator').val($(this).data('operator'));
            $('.comparison').val($(this).data('comparison'));


        });

// DESTROY EQUIPMENT 
$(document).on('click', '.del-filterpipes-modal', function() {
         
            
         
            $('.id').val($(this).data('id'));

            $('.field').val($(this).data('field'));
            $('.operator').val($(this).data('operator'));
            $('.comparison').val($(this).data('comparison'));

        });

</script>


                            <script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s0").style.fontWeight='bold';
                                     document.getElementById("s0").style.fontSize=10 + "pt";
                                     document.getElementById("s0").style.fontStyle="italic";;


                                 }

                            </script> 


<br><br><br><br>
<div class="container">

    <center>

        <h2><b>Advanced Filter</b></h2>
        <h3>Piping</h3>

    </center>





 <!-- CREATE FILTER   -->

 <br> <br> 
  <form class="form-horizontal" role="form" method="POST" action="{{ url('/filterpipes') }}">
                        {!! csrf_field() !!}
<center><table id="eequi" class="table table-hover table-condensed" style="width: 60%;font-size: 14px;font-weight: normal;white-space: nowrap">
                                  <thead>
                                      <tr>
                                          <th style="font-size: 14px;font-weight: bold;">Field</th>
                                          <th style="font-size: 14px;font-weight: bold;">Operator</th>
                                          <th style="font-size: 14px;font-weight: bold;">Comparison</th>
                                          <th style="font-size: 14px;font-weight: bold;">Action</th>

                                      </tr>
                                  </thead>
                                  <tbody class="resultbody">
                                   
                                      <tr>
                                          <td>
                                             <select onchange="select();" id="field" name="field[]" style="height: 35px;border-radius: 4px;">
                                                  <option value="area" selected="selected">Area</option>
                                                  <option value="diameter">Diameter</option>
                                            </select>
                                            
                                          </td>
                                          <td>
                                             <select id="operator" name="operator[]" style="height: 35px;border-radius: 4px;display:none;">
                                                  <option value="=" selected="selected">Equal</option>
                                                  <option value="!=">Different</option>
                                                  <option value=">">Greater Than</option>
                                                  <option value=">=">Greater or Equal than</option>
                                                  <option value="<">Less Than</option>
                                                  <option value="<=">Less or Equal Than</option>
                                            </select>
                                            <select id="onlyequal" name="operator[]" style="height: 35px;border-radius: 4px;">
                                                  <option value="=" selected="selected">Equal</option>
                                            </select>
                                       
                                          </td>
                                         
                                          <td>
                                                  {!! Form::select('comparison_a', [null => 'Select Area...'] + $units, null, array('id' => 'units_id','class' => 'comparison', 'style'=>'height:35px;border-radius: 4px;font-size: 14px;font-weight: normal;')) !!}
                                         
                                              
                                           
                                                 {!! Form::select('comparison_d', [null => 'Select Diameter...'] + $diameters, null, array('id' => 'diameters_id','class' => 'comparison', 'style'=>'height:35px;border-radius: 4px;font-size: 14px;font-weight: normal;display:none')) !!}
                                          
                                          </td>
                                          <td>
                                               <button id="action" type="submit" class="btn btn-lg btn-default" style="padding: 8px 16px;font-size: 12px"><img src="{{ asset('images/add-icon.ico') }}" style="width:18px" ></button>
                                          </td>
                                      </tr>

                                  </tbody>
                              </table> </center> 

                         <!-- Validar Selects -->
                         
                              <script type="text/javascript">
                                
                                function select() {

                                    $("#operator").hide();
                                    $("#onlyequal").hide();
                                
                                    if($("#field option:selected").val() == 'diameter') {
                                        $("#onlyequal").hide();
                                        $("#operator").show();
                                        $("#units_id").hide();
                                        $("#diameters_id").show();
                                        return false;
                                    
                                    }else{

                                        $("#onlyequal").show();
                                        $("#units_id").show();
                                        $("#diameters_id").hide();

                                    }
                                }

                                

                              </script>

                         <!-- Fin Validar Selects-->       


                       <!--  <center><input id="add_btn" type="button" class="btn btn-lg btn-info add" style="padding: 8px 16px;font-size: 12px;" value="Add New (+)">  
                       
                        <input onclick="location.href='{{ url('filterpipes') }}'" type="submit" class="btn btn-lg btn-default" data-dismiss="modal" style="padding: 8px 16px;font-size: 12px;" value="Cancel"> -->

                        <!--  /* Evento que se ejecuta cada vez que se selecciona un elemento en el 
                                                select del área */ -->
                                     

                        </center>

                        
                        </form>


 <!-- END CREATE FILTER   -->

@role('PipeAdmin')<!-- <button style="align:right" type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#createfilterpipeModal"><img src="{{ asset('images/add-icon.ico') }}" style="width:23px" ></button> -->@endrole
<br>

<br>


<link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>

@role('PipeAdmin')
<table border id="filterpipes" class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap">
    <center><thead>
        <tr>
            <th>Field</th>
            <th>Operator</th>
            <th>Comparison</th>
            <th>Action</th>
        </tr>
    </thead></center>
    <tfoot><tr>
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
var action_bt = "Edit / Delete"
$(document).ready(function() {
    oTable = $('#filterpipes').DataTable({
        
        "processing": true,
        "serverSide": false,
        "ajax": "{{ route('piping.filter') }}",
        "columns": [
            {data: 'field', name: 'field'},
            {data: 'operator', name: 'operator'},
            {data: 'comparison', name: 'comparison'},
            {data: 'action', name: 'action', orderable: false, searchable: false}


        ]

    });

 
});
</script>
@else
<table border id="filterpipes" class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap">
    <center><thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Weight</th>
        </tr>
    </thead></center>
    <tfoot><tr>
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
var action_bt = "Edit / Delete"
$(document).ready(function() {
    oTable = $('#filterpipes').DataTable({
        
        "processing": true,
        "serverSide": false,
        "ajax": "{{ route('piping.filterpipes') }}",
        "columns": [
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'hours', name: 'hours'}


        ]

    });

 
});
</script>
 <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">Add equipment estimate</div> -->
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif

        <?php $sum_per_equi = DB::select("SELECT SUM(total_progress) as sum_per_equi FROM pequis_view"); ?>



                <div class="panel-body">

                   <form class="form-horizontal" role="form" method="POST" action="{{ url('/filterpipes') }}">
                        {!! csrf_field() !!}
                    
                        <div class="modal-header" style="background-color: #F5F8FA;border-radius: 4px;">
                            <button onclick="location.href='{{ url('filterpipe') }}'" type="button" class="close" data-dismiss="modal"" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                           

                        </div>
                            <br>

                                     

   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

               <center><table id="eequi" class="table table-hover table-condensed" style="width: 40%;font-size: 14px;font-weight: normal;white-space: nowrap">
                                  <thead>
                                      <tr>
                                          <th style="font-size: 14px;font-weight: bold;">Field</th>
                                          <th style="font-size: 14px;font-weight: bold;">Operator</th>
                                          <th style="font-size: 14px;font-weight: bold;">Comparison</th>
                                          <th style="font-size: 14px;font-weight: bold;">Action</th>

                                      </tr>
                                  </thead>
                                  <tbody class="resultbody">
                                   
                                      <tr>
                                          <td>
                                             {!! Form::select('field[]', array('area' => 'Area', 'diameter' => 'Diameter')); !!}
                                          </td>
                                          <td>
                                             {!! Form::select('operator[]', array('=' => 'Equal', '!=' => 'Different', '>' => 'Greater Than', '>=' => 'Greater or Equal than', '<' => 'Less Than', '<=' => 'Less or Equal Than')); !!}
                                          </td>
                                         
                                              <td>
                                                {!! Form::text('comparison[]', null, array('placeholder' => 'Comparison','class' => 'form-control','style' => 'width:120px;font-size: 14px;font-weight: normal;','required')) !!}
                                            </td>
                                          
                                          <td>
                                              <input type="button" class="btn btn-danger delete" value="x">
                                          </td>
                                      </tr>

                                  </tbody>
                              </table> </center> 
                        <center><input id="add_btn" type="button" class="btn btn-lg btn-info add" style="padding: 8px 16px;font-size: 12px;" value="Add New (+)">  
                        <input type="submit" class="btn btn-lg btn-primary" style="padding: 8px 16px;font-size: 12px;" value="Create">
                        <input onclick="location.href='{{ url('filterpipes') }}'" type="submit" class="btn btn-lg btn-default" data-dismiss="modal" style="padding: 8px 16px;font-size: 12px;" value="Cancel">

                        <!--  /* Evento que se ejecuta cada vez que se selecciona un elemento en el 
                                                select del área */ -->
                                     

                        </center>

                        
                        </form>
                        <script type="text/javascript">
                                            $('.date').datepicker({  
                                               format: 'mm-dd-yyyy',
                                               forceParse: false
                                             });  
                                        </script> 
                </div>
            </div>
        </div>

    </div><!-- First Row End -->

@endrole

@extends('piping.createfilterpipe')
@extends('piping.delfilterpipe')
<br>
<br>
<br>











<script type="text/javascript">
    
    setTimeout(function() {
    $('#messages').fadeOut('slow');
}, 10000);

</script>




  </center> 


  <center>
  <button onclick="location.href='{{ url('pipes') }}'" type="button" class="btn btn-primary btn-lg">Main</button>


  <button onclick="location.href='{{ url('home') }}'" type="button" class="btn btn-lg btn-default">Home</button>


  </center>

<!-- SCRIPT PARA BÚSQUEDA POR COLUMNAS   -->


<script type="text/javascript">
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#filterpipes tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width: 100%;font-size: 12px;font-weight: normal;white-space: nowrap" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#filterpipes').DataTable();
 
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

@else
@include('common.forbidden')

@endrole

@endif
