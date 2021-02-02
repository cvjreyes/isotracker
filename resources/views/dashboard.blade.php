@extends('layouts.datatable')

@section('content')

<?php $sum_per_equi = DB::select("SELECT SUM(total_progress) as sum_per_equi FROM pequis_view"); ?>
<?php $sum_per_civil = DB::select("SELECT SUM(total_progress) as sum_per_civil FROM pcivils_view"); ?> 

<?php 
// PROCESO DE CÁLCULO PROGRESO STU
                                        //FILTER PIPE QUERYS (HOURS)
                            $filterpipe = DB::select("SELECT * FROM filterpipes");
                            $countfilterpipe = DB::select("SELECT COUNT(*) as count FROM filterpipes");
                            $count=$countfilterpipe[0]->count;
                            $sum_per_epipe_1 = "SELECT SUM(`pipesview`.`hours`) as ehrspipes FROM `pipesview` ";
                            $sum_per_epipe_2 = "WHERE ";

                            for ($i = 0; $i < $count; $i++){

                                if($i < $count-1){

                                  if ($filterpipe[$i+1]->field=='area'){  

                                    $sum_per_epipe_2 = $sum_per_epipe_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."' OR ";
                                  }else{

                                    $sum_per_epipe_2 = $sum_per_epipe_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."' AND ";

                                  }  
    
                                }else{

                                    $sum_per_epipe_2 = $sum_per_epipe_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."'";

                                }

                            }

                            if ($count>0){
                                $sum_per_epipe=$sum_per_epipe_1.$sum_per_epipe_2;
                            }else{
                                $sum_per_epipe=$sum_per_epipe_1;
                            }


                            $sum_per_epipe = DB::select($sum_per_epipe); 

                            //END FILTER PIPE QUERYS (HOURS)

                            //FILTER PIPE QUERYS (PROGRESS)

                                $sum_per_pipe_1 = "SELECT SUM(((`ppipes_view_bak`.`total_progress` * `ppipes_view_bak`.`hours`) / 100)) AS `total_ppipehours` FROM `ppipes_view_bak` "; 
                                $sum_per_pipe_2 = "WHERE ";

                                for ($i = 0; $i < $count; $i++){

                                if($i < $count-1){

                                    $sum_per_pipe_2 = $sum_per_pipe_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."' OR ";
    
                                }else{

                                    $sum_per_pipe_2 = $sum_per_pipe_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."'";

                                }

                                }

                                if ($count>0){
                                    $sum_per_pipe=$sum_per_pipe_1.$sum_per_pipe_2;
                                }else{
                                    $sum_per_pipe=$sum_per_pipe_1;
                                }

                                $sum_per_pipe = DB::select($sum_per_pipe); 

?>
<br>


<br><br>


    

    <div class="row">
        <div class="container-fluid" style="height: 60%;width: 80%">
  
      
                <div class="panel-heading" style="background-color: #ffffff;"><h4>Dashboard - 3D Progress Control</h4></div>
                </br>
                <table>
                  
                  <tr>  <!--BARRAS-->
                    
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                      <script type="text/javascript">
                        google.charts.load("current", {packages:['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                          var data = google.visualization.arrayToDataTable([
                            ["Element", "Progress (%)", { role: "style" } ],
                            ["SMC", parseFloat('<?php echo round($sum_per_equi[0]->sum_per_equi,2);?>'), "#B0BED9"],
                            ["SOE", 0, "#3366CC"],
                            ["STU", parseFloat('<?php echo round((($sum_per_pipe[0]->total_ppipehours)/($sum_per_epipe[0]->ehrspipes))*100,2);?>'), "#B0BED9"],
                            ["SEL", 0, "#3366CC"],
                            ["SIT", 0, "#B0BED9"],
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
                            title: "3D Progress by Disciplines",
                            width: 1024,
                            height: 768,
                            bar: {groupWidth: "95%"},
                            legend: { position: "none" },
                          };
                          var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                          chart.draw(view, options);
                      }
                      </script>
                    <center><div id="columnchart_values" style="width: 1024px; height: 600px;"></div></center>
                    </br></br></br></br>
                    <div class="panel-heading"></div>
                   
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
