
<?php
if(isset($_POST["texto"]))

    $urole = DB::select("SELECT rol FROM uroles_view WHERE name="."'".$_POST["texto"]."'");

    $count=0;
    if (count($urole)>0){

        echo "<font size='5' color='#2579A9'><b>".$_POST["texto"]."</b></font>";
        echo "<br><b>USER ROLES</b>";
            //echo "<br>"."\n-------------------------\n";

        foreach ($urole as $uroles) {
            $count++;
            
            //echo "\n NOTE ".$count.": ";
            echo "<br>".$uroles->rol;
            //echo ";";
        }
    }else{

        echo "<font size='5' color='#2579A9'><b>".$_POST["texto"]."</b></font>";
        echo "<br>Does not have any Rol";


    }



?>
