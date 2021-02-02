@if (Auth::guest())

@else
 <div class="modal fade" id="createepipeModal";
     tabindex="-1" role="dialog" data-backdrop="static" 
     aria-labelledby="createepipeModalLabel">
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
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

                   <form class="form-horizontal" role="form" method="POST" action="{{ url('/pipes') }}">
                        {!! csrf_field() !!}
                    
                        <div class="modal-header" style="background-color: #F5F8FA;border-radius: 4px;">
                            <button onclick="location.href='{{ url('epipes') }}'" type="button" class="close" data-dismiss="modal"" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                           

                        </div>
                            <br>

                                     

   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
  
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                    
                                    <th>Area</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                             
                                <tr>
                                    
                                    <td>
                                        {!! Form::select('areas_id[]', [null => 'Select Area...'] + $areas, null, array( 'style'=>'height:34px;font-size: 14px;font-weight: normal;','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::select('tpipes_id[]', [null => 'Select Type...'] + $type_line, null, array( 'style'=>'height:34px;font-size: 14px;font-weight: normal;','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('qty[]', null, array('placeholder' => 'Qty','style'=>'width: 75px','class' => 'form-control','min' => '1','required')) !!}
                                    </td>
                                    <td>
                                        <!-- <input type="button" class="btn btn-danger delete" value="x"> -->
                                    </td>
                                </tr>

                            </tbody>
                        </table>   
                       <center><input id="add_btn" type="button" class="btn btn-lg btn-info add" style="padding: 8px 16px;font-size: 12px;" value="Add New (+)">  
                        <input type="submit" class="btn btn-lg btn-primary" style="padding: 8px 16px;font-size: 12px;" value="Create">
                        <input onclick="location.href='{{ url('epipes') }}'" type="submit" class="btn btn-lg btn-default" style="padding: 8px 16px;font-size: 12px;" data-dismiss="modal" value="Cancel">

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
</div> <!-- Container End -->


@endif