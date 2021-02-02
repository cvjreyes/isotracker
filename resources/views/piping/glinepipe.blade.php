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
      <div class="col-md-9" style="left: 12%;margin-top: 4%" >
            <div class="panel panel-default">
         
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="panel-body" style="margin-top: 4%">


                        

                            
                        <center>
                          <form id="glinepipe" class="form-horizontal" role="form" method="POST" action="{{ url('glinepipe') }}">
                        {{ csrf_field() }}

              

                             <div id="linechart" class="linechart">

                                    <html>
                                    
                                    {!! Form::select('units_id[]', [null => 'Select Area...'] + $units, null, array( 'style'=>'height:31px','onchange'=>'mySubmit(this)','required')) !!}

                                    <h3>Progress Curve Piping</h3>
                                    <h4>3D Progress</h4>
                                    <h3 style='background-color: #F1F1F1'><b><?php echo $lineprogress[0]->area; ?></b></h3>




                                  <div id="glinepipee">
                                      <head>
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                          <script type="text/javascript">
                                            google.charts.load('current', {'packages':['corechart']});
                                            google.charts.setOnLoadCallback(drawChart);

                                            function drawChart() {
                                              var data = google.visualization.arrayToDataTable([

                                                //['Date', 'Estimated','Modeled'],
                                                ['Date','Progress'],

                                                 @foreach ($lineprogress as $lineprogressss)
                                                    //['{{ $lineprogressss->date}}', {{ $lineprogressss->area}}, {{ $lineprogressss->progress}} ],
                                                    ['{{ $lineprogressss->date}}', {{ $lineprogressss->progress}}],
                                                @endforeach

                                            ]);

                                              var options = {
                                                'width':1100,
                                                'height':500,                                               
                                                hAxis: { title: 'Date',titleTextStyle: { fontName: 'Quicksand,sans-serif',italic: false,fontSize: 24},textStyle: { fontName: 'Quicksand,sans-serif', bold: false,fontSize: 14}},
                                                vAxis: { title: 'Progress (%)',titleTextStyle: { fontName: 'Quicksand,sans-serif',italic: false,fontSize: 24},textStyle: { fontName: 'Quicksand,sans-serif',bold: false,fontSize: 14}},
                                                curveType: 'function',
                                                colors: ['#D3282F'],
                                                legend: { fontName: 'Quicksand,sans-serif', position: 'right'},
                                                crosshair: { trigger: 'both', color: '#01A1DD',opacity: 0.5},
                                                pointSize: 5,
                                              };

                                        
                                              var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                                              // Wait for the chart to finish drawing before calling the getImageURI() method.
                                                // google.visualization.events.addListener(chart, 'ready', function () {
                                                //   curve_chart.innerHTML = '<img src="' + chart.getImageURI() + '">';
                                                //   console.log(curve_chart.innerHTML);
                                                // });                                   

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

                        <br><br><center>


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