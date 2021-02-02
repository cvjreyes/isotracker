@if (Auth::guest())

@else

@extends('layouts.datatable')

@section('content')
    
  <script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s2").style.fontWeight='bold';
                                     document.getElementById("s2").style.fontSize=10 + "pt";
                                     document.getElementById("s2").style.fontStyle="italic";;


                                 }

                            </script> 

  <script type="text/javascript">
                        function mySubmit() {
                                   var theForm = document.forms['glinepipe'];
                                     if (!theForm) {
                                         theForm = document.glinepipe;

                                     }
                                     theForm.submit();


                                    
                          }

                      </script>

   <div class="row">
      <div class="col-md-9" style="left: 12%" >
            <div class="panel panel-default">
         
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="panel-body" style="margin-top: 10%">


                        

                            
                        <center>
                          <form id="glinepipe" class="form-horizontal" role="form" method="POST" action="{{ url('glinepipe') }}">
                        {{ csrf_field() }}

               

                             <div id="linechart" class="linechart">

                                    <html>

                                    <h3>Progress Curve Piping</h3>
                                    <h4>3D Progress</h4>
                                    <h4><?php //echo $lineprogress[0]->area; ?></h4>


                                    <h3 style='background-color: #FCF8E3'>
                                        The area <?php echo $selected_area[0]->name; ?> does not contain modeled pipes!</h3>
                                        <br><h4><b>Please, check the model <br>and select another one...</b></h4>

                                  
                                  
                                    {!! Form::select('units_id[]', [null => 'Select Area...'] + $units, null, array( 'style'=>'height:31px','onchange'=>'mySubmit(this)','required')) !!}
                                    <br><br>    
                            </center>                                             

                         </form>

                        <center>

              
                        <button onclick="location.href='{{ url('pipes') }}'" type="button" class="btn btn-lg btn-primary">Main</button>

                          <script type="text/javascript">
    
                                      setTimeout(function() {
                                      $('#messages').fadeOut('slow');
                                  }, 10000);

                                  </script>

                        <div id="messages">
                         @if ($message = Session::get('warning'))
                          <br>
                          <br>

                                  <div class="alert alert-warning"> 
                                      <p>{{ $message }}</p>
                                  </div>

                              @endif
                        </div>
                        </center>
                 
                </div>
            </div>
        </div>

    </div><!-- First Row End -->


    @endsection

@endif