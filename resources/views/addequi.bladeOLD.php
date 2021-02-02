<!-- <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
{!! Form::open(array('route' => 'itemCRUD.store','method'=>'POST')) !!}
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
             <div class="form-group">
                <strong>Site:</strong>
                {!! Form::select('Site', $units) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Type:</strong>

                {!! Form::select('type', $tequis) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Quantity:</strong>
                {!! Form::number('qty', null, array('placeholder' => 'Quantity','class' => 'form-control')) !!}
            </div>
        </div>
     
        <!-- <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Type:</strong>
                {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control','style'=>'height:100px')) !!}
            </div>
        </div> -->

        <!-- <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
 -->
   <!--  </div>
    {!! Form::close() !!}
</body>
</html> -->

@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script type="text/javascript">
    $(function () {
        $('.add').click(function () {
            var n = ($('.resultbody tr').length - 0) + 1;
            var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td>{!! Form::select('Site', $units) !!}</td>'+
                    '<td>{!! Form::select('type', $tequis) !!}</td>'+
                    '<td>{!! Form::number('qty', null, array('placeholder' => 'Quantity','class' => 'form-control')) !!}</td>'+
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

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Add Results</div>
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="panel-body">
                   <form class="form-horizontal" role="form" method="POST" action="{{ url('/itemCRUD') }}">
                        {!! csrf_field() !!}
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
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
                                        {!! Form::select('Site', $units) !!}
                                    </td>
                                    <td>
                                        {!! Form::select('type', $tequis) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('qty', null, array('placeholder' => 'Quantity','class' => 'form-control')) !!}
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

@endsection
