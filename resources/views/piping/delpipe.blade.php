@if (Auth::guest())

@else

    <div class="modal fade" id="delequiModal" style="top:20%;" 
     tabindex="-1" role="dialog" 
     aria-labelledby="delequiModalLabel">
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
       

                        @foreach ($eequis as $key => $item)


         <!--           Form::model($item, ['method' => 'PATCH','route' => ['indexequi.update', $item->id]]) -->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/deleteequi') }}">
                        @endforeach
                         
               
             <!--       <form class="form-horizontal" role="form" method="POST" action="{{ url('/editequi/') }}"> -->
                        {!! csrf_field() !!}
                    
                       <div class="modal-header" style="background-color: #F5F8FA;border-radius: 4px;">
                            <button type="button" class="close" data-dismiss="modal"" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                         

                        </div>
                        <center>
                        <br>
                            <h4 class="modal-title">Are you sure you want to delete the following equipments?</h4>
                            <br>
                           

                        </center>
                   <center>     
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="display:none;">Id</th>
                                    <th>Area</th>
                                    <th>Type</th>
                                    <th>Hours</th>
                                    <th>Estimated Quantity</th>
                                
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                                <tr>
                                    <td style="display:none;">{!! Form::text('id', null, array('class' => 'id')) !!}</td>
                                    <td>
                                        {!! Form::select('units_id', [null => 'Select Area...'] + $units, null, array('class' => 'units_id', 'style'=>'height:31px','disabled')) !!}
                                    </td>
                                    <td>
                                        {!! Form::select('tequis_id', [null => 'Select Type...'] + $tequis, null, array('class' => 'tequis_id', 'style'=>'height:31px','disabled')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('hours', null, array('placeholder' => 'Hours','class' => 'hours','disabled')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty', null, array('placeholder' => 'Quantity','class' => 'est_qty','disabled')) !!}

                                       
                                    </td>
                        
                                </tr>

                            </tbody>

                        </table>  
                        </center>
                        <center>
                
                        <input type="submit" class="btn btn-lg btn-danger" value="Remove">
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