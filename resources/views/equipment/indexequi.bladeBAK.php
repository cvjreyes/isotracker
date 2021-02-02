@if (Auth::guest())

@else
@extends('layouts.datatable')

@section('content')
@if ($message = Session::get('success'))
<li id="menu-item-65" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-65"><a href="http://localhost:2431/?page_id=60">Moon Itinerary</a></li>
<br>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>


<script type="text/javascript">
    $(function () {
        $('.add').click(function () {
            var n = ($('.resultbody tr').length - 0) + 1;
            var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td>{!! Form::select('units_id[]', [null => 'Select Area...'] + $units, null, ['required']) !!}</td>'+
                    '<td>{!! Form::select('tequis_id[]', [null => 'Select Area...'] + $tequis, null, ['required']) !!}</td>'+
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

$(document).on('click', '.edit-equi-modal', function() {
         
            
         
             //$('#est_qtya').val($(this).data('est_qty'));
            
            $('#units_id').val($(this).data('units_id'));
            $('#tequis_id').val($(this).data('tequis_id'));
            $('#est_qty').val($(this).data('est_qty'));

            // alert($('#units_id').val());
            // alert($('#tequis_id').val());
            // alert($('#est_qty').val());

        });

</script>

<br><br><br><br>
<div class="container">


    <table id="example" class="display" cellspacing="0" width="100%">
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
    </table>
<button 
                               style="align:right"
                               type="button" 
                               class="btn btn-primary btn-lg" 
                               data-toggle="modal" 
                               data-target="#createequiModal">
                              Add Equipments
                            </button>
<br><br><br>



<table id="eequi" class="table table-hover table-condensed" style="width:100%">
<link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>

    <thead>
        <tr>
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
        "ajax": "{{ route('equipment.indexequi') }}",
        "columns": [
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


@extends('equipment.createequi')



  @extends('equipment.editequi')


                            
@endsection

@endif
