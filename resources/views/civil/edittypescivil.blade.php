@if (Auth::guest())

@else
    
    <div class="modal fade" id="edittypescivilModal" style="top:20%"; 
     tabindex="-1" role="dialog" 
     aria-labelledby="edittypescivilModalLabel">
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
                <div class="panel-body">


         


         <!--           Form::model($item, ['method' => 'PATCH','route' => ['indexcivil.update', $item->id]]) -->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/updatetypescivil') }}">
                     
                
               
             <!--       <form class="form-horizontal" role="form" method="POST" action="{{ url('/editcivil/') }}"> -->
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
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Weight</th>
                                
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                                <tr>
                                    <td style="display:none;">{!! Form::text('id', null, array('class' => 'id')) !!}</td>
                                    <td>
                                        {!! Form::text('code', null, array('placeholder' => 'Code','class' => 'code','maxlength' => '3','style' => 'text-transform: uppercase','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'name','required')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('hours', null, array('placeholder' => 'Hours','class' => 'hours','min' => '1','required')) !!}
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