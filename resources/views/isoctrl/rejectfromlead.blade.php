@if (Auth::guest())

@else
    
    <div class="modal fade" id="rejectfromleadModal" style="top:20%"; 
     tabindex="-1" role="dialog" 
     aria-labelledby="rejectfromleadModalLabel">
   <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
       
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="panel-body">


             


        
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/rejectfromlead') }}">
         
                         
               
   
                        {!! csrf_field() !!}

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            

                
                            <br>

                    <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="font-size: 14px;font-weight: bold;">Iso ID</th>
                                    <th style="font-size: 14px;font-weight: bold;">Comments</th>
                                
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                                <tr>

                                    <td style="display: none;"> {!! Form::text('requestbydesign', null, array('placeholder' => 'requestbydesign','class' => 'requestbydesign','readonly')) !!}
                                    </td>

                                    <td style="display: none;"> {!! Form::text('requestbylead', null, array('placeholder' => 'requestbylead','class' => 'requestbylead','readonly')) !!}
                                    </td>
                                    
                                    <td> {!! Form::text('filename', null, array('placeholder' => 'filename','class' => 'filename','style' => 'width: 300px;font-size: 14px;font-weight: normal;background: #FAFAFA;border:0px;','readonly')) !!}</td>
                                   
                                    <td>
                                        {{ Form::textarea('comments', null, ['placeholder' => 'Comments', 'class' => 'comments' , 'cols' => 50, 'rows' =>10,'required' => '', 'maxlength' => "400"]) }} 

                                    </td>
                    
                                </tr>

                            </tbody>

                        </table>  
                        
                        <center>
                
                        <input type="submit" class="btn btn-lg btn-danger" style="padding: 8px 16px;font-size: 12px;" value="With Comments">
                        <input type="submit" class="btn btn-lg btn-default" data-dismiss="modal" style="padding: 8px 16px;font-size: 12px;" value="Cancel">

                        </center>
                  

                        
                        </form>
                </div>
            </div>
        </div>

    </div>
</div>

    {!! Form::close() !!}

@endif