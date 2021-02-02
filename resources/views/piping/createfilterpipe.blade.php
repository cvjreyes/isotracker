@if (Auth::guest())

@else
 <div class="modal fade" id="createfilterpipeModal";
     tabindex="-1" role="dialog" data-backdrop="static" 
     aria-labelledby="createfilterpipeModalLabel">
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
</div> <!-- Container End -->


@endif
