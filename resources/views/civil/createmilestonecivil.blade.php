@if (Auth::guest())

@else
 <div class="modal fade" id="createcivilModal";
     tabindex="-1" role="dialog" data-backdrop="static" 
     aria-labelledby="createcivilModalLabel">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">Add civilpment estimate</div> -->
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif

        <?php $sum_per_civil = DB::select("SELECT SUM(total_progress) as sum_per_civil FROM pcivils_view"); ?>



                <div class="panel-body">

                   <form class="form-horizontal" role="form" method="POST" action="{{ url('/milestonecivil') }}">
                        {!! csrf_field() !!}
                    
                        <div class="modal-header" style="background-color: #F5F8FA;border-radius: 4px;">
                            <button onclick="location.href='{{ url('milestonecivil') }}'" type="button" class="close" data-dismiss="modal"" aria-label="Close">
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
                                    
                                    <th>Date</th>
                                    <th>Area</th>
                                    <th>Quantity</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                             
                                <tr>
                                    
                                    <td>
                                        <p><input id= "date[]" class="date form-control" type="text"></p>
                                    </td>
                                    <td>
                                        {!! Form::select('units_id[]', [null => 'Select Area...'] + $units, null, array( 'style'=>'height:31px','required')) !!}
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
                        <center><input id="add_btn" type="button" class="btn btn-lg btn-info add" value="Add New (+)">  
                        <input type="submit" class="btn btn-lg btn-primary" value="Create">
                        <input onclick="location.href='{{ url('milestonecivil') }}'" type="submit" class="btn btn-lg btn-default" data-dismiss="modal" value="Cancel">

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