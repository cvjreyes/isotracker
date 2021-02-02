@if (Auth::guest())

@else
    
    <div class="modal fade" id="editelecModal" style="top:20%"; 
     tabindex="-1" role="dialog" 
     aria-labelledby="editelecModalLabel">
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
                <div class="panel-body">


                        @foreach ($eelecs as $key => $item)


         <!--           Form::model($item, ['method' => 'PATCH','route' => ['indexelec.update', $item->id]]) -->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/updateelec') }}">
                        @endforeach
                         
               
             <!--       <form class="form-horizontal" role="form" method="POST" action="{{ url('/editelec/') }}"> -->
                        {!! csrf_field() !!}

                        <!-- <div class="modal-header" style="background-color: #F5F8FA;border-radius: 4px;"> -->
                            <button type="button" class="close" data-dismiss="modal"" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            

                        <!-- </div> -->
                            <br>

                    <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="display:none;">Id</th>
                                    <th style="font-size: 14px;font-weight: bold;">Area</th>
                                    <th style="font-size: 14px;font-weight: bold;">Type</th>
                                    <th style="font-size: 14px;font-weight: bold;">Tag</th>
                                    <th style="font-size: 14px;font-weight: bold;">Quantity</th>
                                
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                                <tr>
                                    <td style="display:none;">{!! Form::text('id', null, array('class' => 'id')) !!}</td>
                                    <td>
                                        {!! Form::select('units_id', [null => 'Select Area...'] + $units, null, array('class' => 'units_id', 'style'=>'height:34px;font-size: 14px;font-weight: normal;','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::select('telecs_id', [null => 'Select Type...'] + $telecs , null, array('class' => 'telecs_id','style'=>'width: 150px;height:34px;font-size: 14px;font-weight: normal;','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('tag', null, array('placeholder' => 'Tag','class' => 'tag','style' => 'width: 200px;font-size: 14px;font-weight: normal;background: #FAFAFA;border:0px;','readonly')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('est_qty', null, array('placeholder' => 'Qty','class' => 'est_qty','style' => 'width: 100px;font-size: 14px;font-weight: normal;','required')) !!}
                                    </td>
                    
                                </tr>

                            </tbody>

                        </table>  
                        
                        <center>
                
                        <input type="submit" class="btn btn-lg btn-primary" style="padding: 8px 16px;font-size: 12px;" value="Modify">
                        <input type="submit" class="btn btn-lg btn-default" data-dismiss="modal" style="padding: 8px 16px;font-size: 12px;" value="Cancel">

                        </center>
                  

                        
                        </form>
                </div>
            </div>
        </div>

    </div><!-- First Row End -->
</div>

    {!! Form::close() !!}

@endif