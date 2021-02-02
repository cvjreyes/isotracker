@if (Auth::guest())

@else

@extends('layouts.datatable')

@section('content')
    
  <script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s3").style.fontWeight='bold';
                                     document.getElementById("s3").style.fontSize=10 + "pt";
                                     document.getElementById("s3").style.fontStyle="italic";;


                                 }

                            </script> 

  <script type="text/javascript">
                        function mySubmit() {
                                   var theForm = document.forms['glineinst'];
                                     if (!theForm) {
                                         theForm = document.glineinst;

                                     }
                                     theForm.submit();


                                    
                          }

                      </script>

   <div class="row">
      <div class="col-md-9" style="left: 12%" >
            <div class="panel panel-default">
                <!-- <div class="panel-heading">Add instpment estimate</div> -->
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="panel-body" style="margin-top: 10%">


                        

                            
                        <center>
                          <form id="glineinst" class="form-horizontal" role="form" method="POST" action="{{ url('glineinst') }}">
                        {{ csrf_field() }}

                         <?php //$lineprogress=DB::select("SELECT DATE_FORMAT(hinsts.date,'%d-%m-%Y') as date,area,progress FROM hinsts");?> 

                             <div id="linechart" class="linechart">

                                    <html>

                                    <h3>Progress Curve Instruments</h3>
                                    <h4>3D Progress</h4>
                                    <h4><?php //echo $lineprogress[0]->area; ?></h4>


                                    <h3 style='background-color: #FCF8E3'>
                                        Sorry, there is still no progress information <br>to generate the curve</h3>
                                        <br><h4><b>Please, wait for the system to process <br>the necessary information</b></h4>

                                    <br><br>    
                            </center>                                             

                         </form>

                        <center>

                        <button onclick="location.href='{{ url('modeledinst') }}'" type="button" class="btn btn-primary btn-lg">Modeled</button>
                        <!-- <button data-dismiss="modal" value="Close" style="align:right" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modeledinstModal">Modeled</button>   -->
                        <button onclick="location.href='{{ url('insts') }}'" type="button" class="btn btn-lg btn-default">Estimated</button>

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