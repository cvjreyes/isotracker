@if (Auth::guest())

@else
    
    <div class="modal fade" id="uploadfromdesignModal" style="top:20%"; 
     tabindex="-1" role="dialog" 
     aria-labelledby="uploadfromdesignModalLabel">
   <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
       
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="panel-body">


                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>


        
                   <form method="POST" action="{{route('subir')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                      {{ csrf_field() }}

                    {!! Form::text('pathfrom', null, array('class' => 'pathfrom','style' => 'display:none','readonly')) !!}

                    {!! Form::text('claimed', null, array('class' => 'claimed','style' => 'display:none','readonly')) !!}

                      <br><label for="archivo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{!! Form::text('filename', null, array('placeholder' => 'filename','class' => 'filename','style' => 'width: 550px;font-size: 18px;font-weight: bold;background: #FFFddd;border:0px;','readonly')) !!}</label><br><br>

                      
                     
                      <center>
                         <input type="file" accept="application/pdf" style="width: 550px" class="btn btn-sm btn-default" name="archivo" required>
                      <br>
                        <font size="3" style="font-weight: bold" color="red">***WARNING!*** This action will replace the current file. Take appropriate cautions.</font><br>
                        <font size="2" color="red">If you are not sure of this action, click cancel and contact your supervisor.</font><br><br>
                       <input type="submit" class="btn btn-lg btn-info" style="padding: 8px 16px;font-size: 12px;" value="Upload">
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