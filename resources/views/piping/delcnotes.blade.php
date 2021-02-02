@if (Auth::guest())

@else

    <div class="modal fade" id="delcnotesModal" style="top:20%;" 
     tabindex="-1" role="dialog" 
     aria-labelledby="delcnotesModalLabel">
   <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">Add cnotespment estimate</div> -->
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="panel-body">
       

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/deletecnotes') }}">

                        {!! csrf_field() !!}


                            <button onclick="location.href='{{ url('pipes') }}'" type="button" class="close" data-dismiss="modal"" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                           

                        </div>
                    
                       
                         
                     
                        <center>
                        <br>
                            <h4 class="modal-title" style='margin: 0 auto; padding-top: 0px; text-align: center; width: 400px;font-size: 20px;font-weight: normal;'>Are you sure you want to delete all Calculation Notes of this line?</h4>
                            <br>
                           
                        </center>
                   <center>   

                   <?php $cnote = DB::select("SELECT name FROM calc_notes WHERE pdms_linenumber="."'".$epipes[0]->pdms_linenumber."'");  ?>

                    <table class="table table-striped">

                         {!! Form::text('pdms_linenumber', null, array('placeholder' => 'Calculation Note','class' => 'pdms_linenumber','style' => 'text-transform: uppercase;border:none;background: #F5F8FA;font-size:18px;font-weight:normal;width: 70%','readonly')) !!}

                           

                        </table>  
                        </center>
                        <center>
                
                        <input type="submit" class="btn btn-lg btn-danger" style="padding: 8px 16px;font-size: 12px;" value="Remove">
                        <input type="submit" class="btn btn-lg btn-default" data-dismiss="modal" style="padding: 8px 16px;font-size: 12px;" value="Cancel">
                        <br> <br> <br> <br>

                        </center>
                        </form>
                </div>
            </div>
        </div>

    </div><!-- First Row End -->
</div>

    {!! Form::close() !!}

@endif