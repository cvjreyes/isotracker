@if (Auth::guest())

@else
 <div class="modal fade" id="createurolesModal";
     tabindex="-1" role="dialog" data-backdrop="static" 
     aria-labelledby="createurolesModalLabel">
    <div class="row">
        <div class="col-md-2 col-md-offset-4">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">Add equipment estimate</div> -->
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif

     <!--    <?php $sum_per_equi //= DB::select("SELECT SUM(total_progress) as sum_per_equi FROM pequis_view"); ?> -->



                <div class="panel-body">

                   <form class="form-horizontal" role="form" method="POST" action="{{ url('/storecnotes') }}">
                        {!! csrf_field() !!}
                    
                        <div class="modal-header" style="background-color: #F5F8FA;border-radius: 4px;">
                            {!! Form::text('name[]', null, array('placeholder' => 'USER ROLES','class' => 'name','style' => 'border:none;background: #F5F8FA;font-size:16px;font-weight:bold','disabled')) !!}
                                
                            <button onclick="location.href='{{ url('indexusers') }}'" type="button" class="close" data-dismiss="modal"" aria-label="Close">
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
                                    
                                    <th>Roles</th>
                               
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                             
                                <tr>
                                    <td>
                                        {!! Form::select('roles_id[]', [null => 'Select Role...'] + $roles, null, array('style'=>'height: 35px;border-radius: 4px;','required')) !!}
                                    </td>
                                   <td style="display: none">
                                        {!! Form::text('id[]', null, array('placeholder' => 'pdms_linenumber','class' => 'id','style' => 'text-transform: uppercase','required')) !!}
                                    </td>
                                    
                                        
                                 
                                   
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>

                            </tbody>
                        </table>   
                        <center><input id="add_btn" type="button" class="btn btn-lg btn-info add" style="padding: 8px 16px;font-size: 12px;" value="Add New (+)">  
                        <input type="submit" class="btn btn-lg btn-primary" style="padding: 8px 16px;font-size: 12px;" value="Create">
                        <input onclick="location.href='{{ url('indexusers') }}'" type="submit" class="btn btn-lg btn-default" data-dismiss="modal" style="padding: 8px 16px;font-size: 12px;" value="Cancel">

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