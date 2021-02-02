@if (Auth::guest())

@else
    





    <div class="modal fade" id="progresspipeModal" style="top:20%"; 
     tabindex="-1" role="dialog" 
     aria-labelledby="progresspipeModalLabel">
   <div class="row">
        <div class="col-md-5 col-md-offset-3">
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


                        @foreach ($epipes as $key => $item)


         <!--           Form::model($item, ['method' => 'PATCH','route' => ['indexequi.update', $item->id]]) -->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/updatepipe') }}">
                        @endforeach
                         
               
             <!--       <form class="form-horizontal" role="form" method="POST" action="{{ url('/editequi/') }}"> -->
                        {!! csrf_field() !!}

                        <div class="modal-header" style="background-color: #F5F8FA;border-radius: 4px;">
                            <button type="button" class="close" data-dismiss="modal"" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            

                        </div>
                            <br>

                   

                    <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="display:none;">Id</th>
                                    <th>Area</th>
                                    <th>PDMS Linenumber</th>
                                    <th>Progress</th>
                                
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                                <tr>
                                    <td style="display:none;">{!! Form::text('id', null, array('class' => 'id')) !!}</td>
                                    <td>
                                        {!! Form::select('units_id', [null => 'Select Area...'] + $units, null, array('class' => 'units_id', 'style'=>'height:31px','disabled')) !!}
                                    </td>
                                    
                                    <td>
                                        {!! Form::text('pdms_linenumber', null, array('placeholder' => '-','class' => 'pdms_linenumber','disabled')) !!}
                                    </td>

                                    
                                    <td>
                                       {!! Form::text('calc_notes', null, array('placeholder' => 'Calculation Note','class' => 'calc_notes')) !!}                                       
                                    </td>
                                </tr>

                            </tbody>

                        </table>  
                        
                        <center>
                
                        <input type="submit" class="btn btn-lg btn-primary" value="Modify">
                        <input type="submit" class="btn btn-lg btn-default" data-dismiss="modal" value="Cancel">

                        </center>
                  

                        
                        </form>
                </div>
            </div>
        </div>

    </div><!-- First Row End -->
</div>

    {!! Form::close() !!}

@endif