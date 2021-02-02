

<?php
if(isset($_POST["texto"]))
{
	// if($_POST["texto"])
	// 	echo "He recibido en el archivo.php: ".$_POST["texto"];
	// else
	// 	echo "He recibido un campo vacio";
}

    $line_id = DB::select("SELECT id FROM dpipesfullview WHERE id=".$_POST["texto"]);


    DB::statement(DB::raw("SET @line_id = '".$line_id[0]->id."'"));

    $progress_by_line= DB::select(DB::raw("SELECT tag, pid,iso,stress,support, (((pid*w_pid)+(iso*w_iso)+(stress*w_stress)+(support*w_support))/(weight)) as progress 
FROM dpipesfullview
WHERE id=@line_id"));

    

    if(isset($progress_by_line[0]->progress)){

    	    echo "<font size='5' color='#2579A9'><b>".$progress_by_line[0]->tag."</b></font>"."<br><b>PROGRESS: ".round($progress_by_line[0]->progress,1)."%</b>"."<br>PID: ".$progress_by_line[0]->pid."%"."<br>ISO: ".$progress_by_line[0]->iso."%"."<br>STRESS: ".$progress_by_line[0]->stress."%"."<br>SUPPORT: ".$progress_by_line[0]->support."%";
    	}else{
    		
            echo "<font size='5' color='#2579A9'><b>".$progress_by_line[0]->tag."</b></font>";
            echo "<br>The pipeline has not been modeled";
         
    	}


?>
