@if (Auth::guest())

@else

    <div class="modal fade" id="delfilterpipesModal" style="top:20%;" 
     tabindex="-1" role="dialog" 
     aria-labelledby="delfilterpipesModalLabel">
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
       

                       
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/deletefilterpipes') }}">
                            
               
          
                        {!! csrf_field() !!}
                    
                       
                            <button type="button" class="close" data-dismiss="modal"" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                         

                     
                        <center>
                        <br>
                            <h4 class="modal-title" style='font-size: 18px;font-weight: bold;'>Are you sure you want to delete this filter?</h4>
                            <br>
                      

                        </center>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="display:none;">Id</th>

                                </tr>
                            </thead>
                            <tbody class="resultbody">
                                <tr>
                                    <td style="display:none;">{!! Form::text('id', null, array('class' => 'id')) !!}</td>
           
                                </tr>

                            </tbody>

                        </table>  
                        <center>
                
                        <input type="submit" class="btn btn-lg btn-danger" style="padding: 8px 16px;font-size: 12px;" value="Remove">
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