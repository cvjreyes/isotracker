@extends('layouts.datatable')

@section('content')

<?php $sum_per_equi = DB::select("SELECT SUM(total_progress) as sum_per_equi FROM pequis_view"); ?>
<?php $sum_per_civil = DB::select("SELECT SUM(total_progress) as sum_per_civil FROM pcivils_view"); ?> 

<br>


<br><br>


    

    <div class="row">
        <div class="container-fluid" style="height: 60%;width: 80%">
            <div class="panel panel-default">
      
                <div class="panel-heading" style="background-color: #ffffff;"><h4>Dashboard - 3D Progress Control</h4></div>
                </br>
                <table>
                  <!-- <tr>
                    <html>
                      <head>
                       <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                       <script type="text/javascript">
                          google.charts.load('current', {'packages':['gauge']});
                          google.charts.setOnLoadCallback(drawChart);

                          function drawChart() {

                            var data = google.visualization.arrayToDataTable([
                              ['Label', 'Value'],                                                                  
                              ['SMC', parseFloat('<?php //echo round($sum_per_equi[0]->sum_per_equi,2);?>')],
                              ['SOE', parseFloat('<?php //echo round($sum_per_civil[0]->sum_per_civil,2);?>')],
                              ['STU', 50],
                              ['SEL', 80],
                              ['SIT', 75],
                            ]);

                            var options = {
                              width: 800, height: 200,
                              redFrom: 90, redTo: 100,
                              yellowFrom:75, yellowTo: 90,
                              minorTicks: 0,

                            };

                            var chart = new google.visualization.Gauge(document.getElementById('chart_div1'));

                            chart.draw(data, options);

                            
                          }
                        </script>
                      </head>
  <body>
                      <center>Status Progress</br><div class="panel panel-default" id="chart_div1" style="width: 800px; height: 170px"></div></center>
  </body>
</html>
                  </tr> -->



                  <tr>  <!--BARRAS-->
                    
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                      <script type="text/javascript">
                        google.charts.load("current", {packages:['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                          var data = google.visualization.arrayToDataTable([
                            ["Element", "Density", { role: "style" } ],
                            ["SMC", parseFloat('<?php echo round($sum_per_equi[0]->sum_per_equi,2);?>'), "#B0BED9"],
                            ["SOE", parseFloat('<?php echo round($sum_per_civil[0]->sum_per_civil,2);?>'), "#3366CC"],
                            ["STU", 50, "#B0BED9"],
                            ["SEL", 80, "color: #3366CC"],
                            ["SIT", 75, "color: #B0BED9"],
                          ]);

                          var view = new google.visualization.DataView(data);
                          view.setColumns([0, 1,
                                           { calc: "stringify",
                                             sourceColumn: 1,
                                             type: "string",
                                             role: "annotation" },
                                           2]);

                          var options = {
                            fontName: 'Quicksand,sans-serif',
                            title: "Progress by Disciplines",
                            width: 900,
                            height: 500,
                            bar: {groupWidth: "95%"},
                            legend: { position: "none" },
                          };
                          var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                          chart.draw(view, options);
                      }
                      </script>
                    <center><div id="columnchart_values" style="width: 900px; height: 400px;"></div></center>
                    </br></br></br></br>
                    <div class="panel-heading"></div>
                    <center><h5><strong>Progress - LineCharts by Disciplines</strong></h5></center>

                  </tr>
                </br>
                 <tr> </center>
                  
                  <th> <!-- LINEA EQUIPOS-->
                    <?php 

                                $line_equi = DB::select("SELECT DATE_FORMAT(hequis.date,'%d-%m-%Y') as date, SUM(hequis.count) AS count, mequis.quantity from hequis JOIN mequis where hequis.progress<>0 and hequis.milestone=1 and hequis.date=mequis.date group by hequis.date, mequis.date,mequis.quantity");

                            ?>
                    <html>                  
                    <head>
                      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                      <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                          var data = google.visualization.arrayToDataTable([
                                                ['Date', 'Estimated','Modeled'],

                                                 @foreach ($line_equi as $line_equiss)
                                                    ['{{ $line_equiss->date}}', {{ $line_equiss->quantity}}, {{ $line_equiss->count}} ],
                                                @endforeach
                          ]);

                          var options = {
                            fontName: 'Quicksand,sans-serif',
                            title: 'Equipments',
                            curveType: 'function',
                            crosshair: { trigger: 'both' },
                            legend: "none",
                            pointSize: 3,
                          };

                          var chart = new google.visualization.LineChart(document.getElementById('curve_chart_equi'));

                          chart.draw(data, options);
                        }
                      </script>
                    </head>
                    <body>
                      <div id="curve_chart_equi" style="width: 500px; height: 300px"></div>
                    </body>
                  </html>
                </th>
                <th> <!-- LINEA CIVIL-->
                  <html>
                  <th>
                    <?php 

                                $line_civi = DB::select("SELECT DATE_FORMAT(hcivils.date,'%d-%m-%Y') as date, SUM(hcivils.count) AS count, mcivils.quantity from hcivils JOIN mcivils where hcivils.progress<>0 and hcivils.milestone=1 and hcivils.date=mcivils.date group by hcivils.date, mcivils.date,mcivils.quantity");

                            ?>
                    <head>
                      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                      <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                           var data = google.visualization.arrayToDataTable([
                                                ['Date', 'Estimated','Modeled'],

                                                 @foreach ($line_civi as $line_civiss)
                                                    ['{{ $line_civiss->date}}', {{ $line_civiss->quantity}}, {{ $line_civiss->count}} ],
                                                @endforeach
                          ]);

                          var options = {
                            fontName: 'Quicksand,sans-serif',
                            title: 'Civil',
                            curveType: 'function',
                            crosshair: { trigger: 'both' },
                            legend: "none",
                            pointSize: 3,
                          };

                          var chart = new google.visualization.LineChart(document.getElementById('curve_chart_civi'));

                          chart.draw(data, options);
                        }
                      </script>
                    </head>
                    <body>
                      <div id="curve_chart_civi" style="width: 500px; height: 300px"></div>
                    </body>
                  </html>
                </th>
                <th>
                  <html>
                  <th> <!-- LINEA PIPING-->
                    <head>
                      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                      <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                          var data = google.visualization.arrayToDataTable([
                            ['Year', 'Sales', 'Expenses'],
                            ['2004',  1000,      400],
                            ['2005',  1170,      460],
                            ['2006',  660,       1231],
                            ['2007',  1030,      540]
                          ]);

                          var options = {
                            fontName: 'Quicksand,sans-serif',
                            title: 'Piping',
                            curveType: 'function',
                            legend: "none",
                            crosshair: { trigger: 'both' },
                            pointSize: 3,
                          };

                          var chart = new google.visualization.LineChart(document.getElementById('curve_chart_pipe'));

                          chart.draw(data, options);
                        }
                      </script>
                    </head>
                    <body>
                      <div id="curve_chart_pipe" style="width: 500px; height: 300px"></div>
                    </body>
                  </html>
                </th>
              </tr>

              <tr> 
                  <th> <!-- LINEA ELECTRICIDAD-->
                    <html>                  
                    <head>
                      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                      <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                          var data = google.visualization.arrayToDataTable([
                            ['Year', 'Sales', 'Expenses'],
                            ['2004',  1000,      400],
                            ['2005',  1170,      460],
                            ['2006',  660,       1120],
                            ['2007',  1030,      540]
                          ]);

                          var options = {
                            fontName: 'Quicksand,sans-serif',
                            title: 'Electrical',
                            curveType: 'function',
                            legend: "none",
                            crosshair: { trigger: 'both' },
                            pointSize: 3,
                          };

                          var chart = new google.visualization.LineChart(document.getElementById('curve_chart_elec'));

                          chart.draw(data, options);
                        }
                      </script>
                    </head>
                    <body>
                      <div id="curve_chart_elec" style="width: 500px; height: 300px"></div>
                    </body>
                  </html>
                </th>
                <th> <!-- LINEA INSTRUMENTACIÓN-->
                  <html>
                  <th>
                    <head>
                      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                      <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                          var data = google.visualization.arrayToDataTable([
                            ['Year', 'Sales', 'Expenses'],
                            ['2004',  1000,      400],
                            ['2005',  1170,      460],
                            ['2006',  660,       1231],
                            ['2007',  1030,      540]
                          ]);

                          var options = {
                            fontName: 'Quicksand,sans-serif',
                            title: 'Instrumentation',
                            curveType: 'function',
                            legend: "none",
                            crosshair: { trigger: 'both' },
                            pointSize: 3,
                          };

                          var chart = new google.visualization.LineChart(document.getElementById('curve_chart_inst'));

                          chart.draw(data, options);
                        }
                      </script>
                    </head>
                    <body>
                      <div id="curve_chart_inst" style="width: 500px; height: 300px"></div>
                    </body>
                  </html>
                </th>
                <th>
                  <html>
                  
              </tr>



                 </table>
<div class="panel-body">
                    
                </div>
            </div>
        </div>
    </div>
    

</div>


@include('common.footer')
@endsection
