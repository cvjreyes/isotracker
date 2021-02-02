
<?php
if(isset($_POST["texto"]))

    $cnote = DB::select("SELECT name FROM calc_notes WHERE pdms_linenumber="."'".$_POST["texto"]."'");

    $count=0;
    if (count($cnote)>0){

        echo "<font size='5' color='#2579A9'><b>".$_POST["texto"]."</b></font>";
        echo "<br><b>CALCULATION NOTES</b>";
            //echo "<br>"."\n-------------------------\n";

        foreach ($cnote as $cnotes) {
            $count++;
            
            //echo "\n NOTE ".$count.": ";
            echo "<br>".$cnotes->name;
            //echo ";";
        }
    }else{

        echo "<font size='5' color='#2579A9'><b>".$_POST["texto"]."</b></font>";
        echo "<br>Does not have Calculation Note";


    }



?>
