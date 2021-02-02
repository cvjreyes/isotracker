@if (Auth::guest())

@else

    <div class="modal fade" id="deleinstsModal" style="top:20%;" 
     tabindex="-1" role="dialog" 
     aria-labelledby="deleinstsModalLabel">
   <div class="row">
        <div class="col-md-4 col-md-offset-4">
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/deleinst') }}">
                       
                         
               
             <!--       <form class="form-horizontal" role="form" method="POST" action="{{ url('/editinst/') }}"> -->
                        {!! csrf_field() !!}
                    
                     
                        <center>
                        <br>
                            <h4 class="modal-title" style='margin: 0 auto; padding-top: 0px; text-align: center; width: 400px;font-size: 20px'>Are you sure you want to delete this entry?</h4>
                            <br>
                            <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="display:none">Id</th>
                                   
                                </tr>
                            </thead>
                            <tbody class="resultbody">
                           <tr>
                                    <td style="display:none">{!! Form::text('id', null, array('class' => 'id')) !!}</td>
                                   
                                </tr>
                                </tbody>

                        </table>  
                        </center>
                   <center>     
                    
                        </center>
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