@if (Auth::guest())

@else

@extends('layouts.datatable')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>


<script type="text/javascript">
    $(function () {
        $('.add').click(function () {
            var n = ($('.resultbody tr').length - 0) + 1;
            var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td>{!! Form::select('units_id[]', [null => 'Select Unidad...'] + $units, null, ['required']) !!}</td>'+
                    '<td>{!! Form::select('areas_id[]', [null => 'Select Area...'] + $areas, null, ['required']) !!}</td>'+
                    '<td>{!! Form::select('tequis_id[]', [null => 'Select Type...'] + $tequis, null, ['required']) !!}</td>'+
                    '<td>{!! Form::number('est_qty[]', null, array('placeholder' => 'Quantity','class' => 'form-control','required')) !!}</td>'+
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
</script>

<br><br><br><br>
<div class="container">


    <!-- <table id="example" class="display" cellspacing="0" width="100%">
        <tr>
            <th>Area</th>
            <th>Type of equipments</th>
            <th>Code</th>
            <th>Hours</th>
            <th>Estimated quantity</th>
            <th>Estimated Hours</th>
            <th width="280px">Action</th>
        </tr>
    @foreach ($eequis as $key => $item)
    <tr>
        <td>{{ $item->area }}</td>
        <td>{{ $item->type }}</td>
        <td>{{ $item->code }}</td>
        <td>{{ $item->hours }}</td>
        <td>{{ $item->est_quantity }}</td>
        <td>{{ $item->est_hours }}</td>

    </tr>
    @endforeach
    </table> -->
<button 
                               style="align:right"
                               type="button" 
                               class="btn btn-primary btn-lg" 
                               data-toggle="modal" 
                               data-target="#addequiModal">
                              Add Equipments
                            </button>
<br><br><br>



<table id="eequi" class="table table-hover table-condensed" style="width:100%">
<link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>

    <thead>
        <tr>
            <th>Unit</th>
            <th>Area</th>
            <th>Type of equipments</th>
            <th>Code</th>
            <th>Hours</th>
            <th>Estimated quantity</th>
            <th>Estimated Hours</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
  </table>
</div>

<script type="text/javascript">
var action_bt = "Edit / Delete"
$(document).ready(function() {
    oTable = $('#eequi').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('equipment.addequi') }}",
        "columns": [
            {data: 'unit', name: 'unit'},
            {data: 'area', name: 'area'},
            {data: 'type', name: 'type'},
            {data: 'code', name: 'code'},
            {data: 'hours', name: 'hours'},
            {data: 'est_quantity', name: 'est_quantity'},
            {data: 'est_hours', name: 'est_hours'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]

    });
});
</script>

    <div class="modal fade" id="addequiModal" 
     tabindex="-1" role="dialog" 
     aria-labelledby="addequiModalLabel">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">Add equipment estimate</div> -->
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="panel-body">
                <br>
                <br>
                <br>
                   <form class="form-horizontal" role="form" method="POST" action="{{ url('/addequi') }}">
                        {!! csrf_field() !!}
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Unit</th>
                                    <th>Area</th>
                                    <th>Equipment Type</th>
                                    <th>Estimated Quantity</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                                <tr>
                                    <td class="no">1</td>
                                    <td>
                                        {!! Form::select('units_id[]', [null => 'Select Unit...'] + $units, null, ['required']) !!}
                                    </td>
                                    <td>
                                        {!! Form::select('areas_id[]', [null => 'Select Area...'] + $areas, null, ['required']) !!}
                                    </td>
                                    <td>
                                        {!! Form::select('tequis_id[]', [null => 'Select Type...'] + $tequis, null, ['required']) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty[]', null, array('placeholder' => 'Quantity','class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>

                            </tbody>
                        </table>    
                        <center><input type="button" class="btn btn-lg btn-primary add" value="Add New Item">  
                        <input type="submit" class="btn btn-lg btn-default" value="Submit"></center>

                        
                        </form>
                </div>
            </div>
        </div>

    </div><!-- First Row End -->
</div> <!-- Container End -->


    @extends('equipment.editequi')
</div>

                            
@endsection
@endif