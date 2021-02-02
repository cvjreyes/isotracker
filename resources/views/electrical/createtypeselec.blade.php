@if (Auth::guest())

@else
 <div class="modal fade" id="createtypeselecModal";
     tabindex="-1" role="dialog" data-backdrop="static" 
     aria-labelledby="createtypeselecModalLabel">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">Add elec estimate</div> -->
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif

        <?php $sum_per_elec = DB::select("SELECT SUM(total_progress) as sum_per_elec FROM pelecs_view"); ?>



                <div class="panel-body">

                   <form class="form-horizontal" role="form" method="POST" action="{{ url('/typeselec') }}">
                        {!! csrf_field() !!}
                    
                        <div class="modal-header" style="background-color: #F5F8FA;border-radius: 4px;">
                            <button onclick="location.href='{{ url('typeselec') }}'" type="button" class="close" data-dismiss="modal"" aria-label="Close">
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
                                    
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Weight</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                             
                                <tr>
                                    
                                    <td>
                                        {!! Form::text('code[]', null, array('placeholder' => 'Code','class' => 'form-control','maxlength' => '3','style' => 'text-transform: uppercase','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('name[]', null, array('placeholder' => 'Name','class' => 'form-control','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('hours[]', null, array('placeholder' => 'Hours','class' => 'form-control','min' => '1','required')) !!}
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>

                            </tbody>
                        </table>   
                        <center><input id="add_btn" type="button" class="btn btn-lg btn-info add" value="Add New (+)">  
                        <input type="submit" class="btn btn-lg btn-primary" value="Create">
                        <input onclick="location.href='{{ url('typeselec') }}'" type="submit" class="btn btn-lg btn-default" data-dismiss="modal" value="Cancel">

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