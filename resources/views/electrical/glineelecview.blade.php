@if (Auth::guest())

@else
    
    <div class="modal fade" id="glineelecModal" style="top:12%"; 
     tabindex="-1" role="dialog" 
     aria-labelledby="glineelecModalLabel">
   <div class="row">
      <div class="col-md-9" style="left: 12%" >
            <div class="panel panel-default">
                <!-- <div class="panel-heading">Add elecpment estimate</div> -->
                @if(count($errors) >0 )
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="panel-body">


                      
               
             <!--       <form class="form-horizontal" role="form" method="POST" action="{{ url('/editelec/') }}"> -->
                        {!! csrf_field() !!}

                        <div class="modal-header" style="background-color: #F5F8FA;border-radius: 4px;">
                            <button type="button" class="close" data-dismiss="modal"" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            

                        </div>
                           


                        <?php 

                                $lineprogress = DB::select("SELECT DATE_FORMAT(helecs.date,'%d-%m-%Y') as date, SUM(helecs.count) AS count, melecs.quantity from helecs JOIN melecs where helecs.progress<>0 and helecs.milestone=1 and helecs.date=melecs.date group by helecs.date, melecs.date,melecs.quantity");

                            ?>


                                        
                        <center>
                             <div id="linechart" class="linechart">

                                    <html>
                                    <h3>Line Progress elecpments</h3>
                                    <h4>Estimated vs Modeled</h4>
                                      <head>
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                          <script type="text/javascript">
                                            google.charts.load('current', {'packages':['corechart']});
                                            google.charts.setOnLoadCallback(drawChart);

                                            function drawChart() {
                                              var data = google.visualization.arrayToDataTable([
                                                ['Date', 'Estimated','Modeled'],

                                                 @foreach ($lineprogress as $lineprogressss)
                                                    ['{{ $lineprogressss->date}}', {{ $lineprogressss->quantity}}, {{ $lineprogressss->count}} ],
                                                @endforeach

                                            ]);

                                              var options = {
                                                'width':1400,
                                                'height':500,
                                                curveType: 'function',
                                                fontName: 'Quicksand,sans-serif',
                                                legend: { position: 'left'},
                                                crosshair: { trigger: 'both' },
                                                pointSize: 5,
                                              };

                                        
                                              var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));                                   

                                              chart.draw(data, options);

                                            }
                                          </script>
                                      </head>
                                      <body>
                                        <div id="curve_chart" style="height: 60%"></div>
                                      </body>
                                    </html>

                                    </div>           
                            </center>                                             


                       
                        
                        <center>

                          
                        <input type="submit" style="height:48px" class="btn btn-lg btn-default" data-dismiss="modal" value="Close">

                        </center>
                 
                </div>
            </div>
        </div>

    </div><!-- First Row End -->
</div>

    {!! Form::close() !!}

@endif