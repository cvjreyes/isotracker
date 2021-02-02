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
      <div class="col-md-9" style="left: 12%;margin-top: 4%;" >
            <div class="panel panel-default">
                <!-- <div class="panel-heading">Add instpment estimate</div> -->
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="panel-body" style="margin-top: 4%">


                        

                            
                        <center>
                          <form id="glineinst" class="form-horizontal" role="form" method="POST" action="{{ url('glineinst') }}">
                        {{ csrf_field() }}

              

                             <div id="linechart" class="linechart">

                                    <html>
                                    
                                    
                                    <h3>Progress Curve Instruments</h3>
                                    <h4>3D Progress</h4>
                                    <h3 style='background-color: #F1F1F1'><b><?php echo $lineestimated[0]->area; ?></b></h3>

                                    <?php $i=0; ?>
                                  <div id="glineinsti">
                                      <head>
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                          <script type="text/javascript">
                                            google.charts.load('current', {'packages':['corechart']});
                                            google.charts.setOnLoadCallback(drawChart);

                                            function drawChart() {
                                              var data = google.visualization.arrayToDataTable([
                                                //['Date', 'Estimated','Modeled'],
                                                ['Week','Progress','Estimated'],

                                                 @foreach ($lineestimated as $lineestimatedd)

                                                      
                                                  <?php 

                                                   $hinsts =DB::select("SELECT * FROM hinsts");//validar si existe hinsts para mantener la curva en 0 o en su ultimo valor

                                                  if ((count($hinsts))>0 AND ($i<($lineprogress_count[0]->count))){  

                                                              $last_progress = $lineprogress[$i]->progress;

                                                        }else{

                                                            $last_progress = NULL;

                                                        }



                                                  if ($i<($lineprogress_count[0]->count)){?>

                                                    ['{{ 'W'.$lineestimatedd->week}}', {{ $lineprogress[$i]->progress }},{{$lineestimatedd->estimated}}],
                                                  
                                               
                                                  <?php 

                                                        



                                                    }else{ ?>
                                                
                                                    ['{{ 'W'.$lineestimatedd->week}}', {{ $last_progress }},{{$lineestimatedd->estimated}}],

                                                    <?php 

                                                        }
                                                        $i=$i+1;

                                                    ?> 
                                                @endforeach

                                              /////////////////////////////////////
                                               
                                            ]);

                                              var options = {
                                                'width':1100,
                                                'height':500,                                               
                                                hAxis: { title: 'Week',titleTextStyle: { fontName: 'Quicksand,sans-serif',italic: false,fontSize: 24},textStyle: { fontName: 'Quicksand,sans-serif', bold: false,fontSize: 14}},
                                                vAxis: { title: 'Progress (%)',titleTextStyle: { fontName: 'Quicksand,sans-serif',italic: false,fontSize: 24},textStyle: { fontName: 'Quicksand,sans-serif',bold: false,fontSize: 14}},
                                                curveType: 'function',
                                                legend: { fontName: 'Quicksand,sans-serif', position: 'right'},
                                                crosshair: { trigger: 'both', color: '#01A1DD',opacity: 0.5},
                                                pointSize: 3,
                                                explorer: {},
                                              };


                                        
                                              var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));                                   

                                              chart.draw(data, options);

                                            }
                                          </script>
                                      </head>
                                    </div>

                                      <body>
                                        <div id="curve_chart" style="height: 60%"></div>
                                      </body>
                                    </html>

                                    </div>           
                            </center>                                             

                         </form>

                        <center>
                           <br><br>
                        <button onclick="location.href='{{ url('insts') }}'" type="button" class="btn btn-primary btn-lg">Estimated</button>
                        <button onclick="location.href='{{ url('milestonesinst') }}'" type="button" class="btn btn-primary btn-lg">Milestones</button>
                     <!--     <button onclick="location.href='{{ url('pmanager') }}'" type="button" class="btn btn-lg btn-default"><img src="{{ asset('images/config-icon.png') }}" style="width:20px" ></button> -->

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