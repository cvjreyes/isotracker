@if (Auth::guest())

@else
    
    <div class="modal fade" id="glineequiModal" style="top:12%"; 
     tabindex="-1" role="dialog" 
     aria-labelledby="glineequiModalLabel">

   <div class="row">
      <div class="col-md-9" style="left: 12%" >
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


                      
               
             <!--       <form class="form-horizontal" role="form" method="POST" action="{{ url('/editequi/') }}"> -->
                        {!! csrf_field() !!}

                        <div class="modal-header" style="background-color: #F5F8FA;border-radius: 4px;">
                            <button type="button" class="close" data-dismiss="modal"" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            

                        </div>
                     <form id="glineequi" class="form-horizontal" role="form" method="POST" action="{{ url('/glineequi') }}">
                       {{ csrf_field() }}
                        <script type="text/javascript">
                        function mySubmit() {
                                   var theForm = document.forms['glineequi'];
                                     if (!theForm) {
                                         theForm = document.glineequi;
                                     }
                                     theForm.submit();
                          }

                      </script>
                           
                          {!! Form::select('units_id[]', [null => 'Select Area...'] + $unitss, null, array( 'style'=>'height:31px','onchange'=>'mySubmit(this)','required')) !!}

                        <?php 

                                // $lineprogress = DB::select("SELECT DATE_FORMAT(hequis.date,'%d-%m-%Y') as date, SUM(hequis.count) AS count, mequis.quantity from hequis JOIN mequis where hequis.progress<>0 and hequis.milestone=1 and hequis.date=mequis.date group by hequis.date, mequis.date,mequis.quantity");

                                // $lineprogress = DB::select("SELECT DATE_FORMAT(hequis.date,'%d-%m-%Y') as date, SUM(hequis.count) AS count, mequis.quantity from hequis JOIN mequis where hequis.progress<>0 group by hequis.date, mequis.date,mequis.quantity");

                                 $lineprogress = DB::select("SELECT DATE_FORMAT(hequis.date,'%d-%m-%Y') as date, units.name AS area, SUM(hequis.count) AS count, mequis.quantity FROM hequis JOIN units JOIN mequis WHERE hequis.units_id=units.id AND mequis.units_id=units.id AND mequis.date=hequis.date AND progress <> 0 AND units.id=8 group by mequis.date,hequis.date,units.name,mequis.quantity");

                            ?>


                                        
                        <center>
                             <div id="linechart" class="linechart">

                                    <html>
                                    <h3>Line Progress Equipments</h3>
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


                            </form>
                        
                        <center>

                        <button data-dismiss="modal" value="Close" style="align:right" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modeledequiModal">Modeled</button>  
                        <input type="submit" style="height:48px" class="btn btn-lg btn-default" data-dismiss="modal" value="Close">

                        </center>
                 
                </div>
            </div>
        </div>

    </div><!-- First Row End -->
</div>

    {!! Form::close() !!}

@endif