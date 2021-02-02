@if (Auth::guest())

@else
    
    <div class="modal fade" id="editmilestonesinstModal" style="top:20%"; 
     tabindex="-1" role="dialog" 
     aria-labelledby="editmilestonesinstModalLabel">
   <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">Add instpment estimate</div> -->
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="panel-body">


         


         <!--           Form::model($item, ['method' => 'PATCH','route' => ['indexinst.update', $item->id]]) -->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/updatemilestonesinst') }}">
                     
                
               
             <!--       <form class="form-horizontal" role="form" method="POST" action="{{ url('/editinst/') }}"> -->
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
                                    <th>Week</th>
                                    <th>Estimated (%)</th>
                                
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                                <tr>
                                    <td style="display:none;">{!! Form::text('id', null, array('class' => 'id')) !!}</td>
                                    <td>
                                        {!! Form::text('area', null, array('placeholder' => 'Area','class' => 'area','maxlength' => '3','style'=>'border:none', 'readonly')) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('week', null, array('placeholder' => 'Week','class' => 'week','style'=>'border:none', 'readonly')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('estimated', null, array('placeholder' => 'Estimated','class' => 'estimated','step'=>'any','required')) !!}
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