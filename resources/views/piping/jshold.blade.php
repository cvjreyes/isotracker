<?php
        if(isset($_POST["texto"]))


    $lineid = DB::select("SELECT id FROM dpipesnews WHERE tag='".$_POST["texto"]."'");
    
    $holds = DB::select("SELECT * FROM holds WHERE dpipesnews_id='".$lineid[0]->id."'");

    
    if ($holds[1]->holds!=''){

        echo "<font size='5' color='#2579A9'><b>".$_POST["texto"]."</b></font>";
        echo "<br><table class='table table-hover table-condensed'>";
        echo "<tr><th style='text-align:center'> Hold</th><th style='text-align:center'>Description</th></tr>";
    

        foreach ($holds as $hold) {
            
            if ($hold->holds!=''){
             

             echo "<tr onmouseover=\"hilite(this)\" onmouseout=\"lowlite(this)\"><td style='text-align:center'>".$hold->holds."</td><td style='text-align:center'>".$hold->description."</td></tr>\n";
             
            
             }else{

       
            
            echo "<tr onmouseover=\"hilite(this)\" onmouseout=\"lowlite(this)\"><td  style='text-align:center'><font color='#E90700'>Empty</font></td><td style='text-align:center'><font color='#E90700'>Empty</font></td></tr>\n";

            }

            
        }
    
    }else{

        echo "<font size='5' color='#2579A9'><b>".$_POST["texto"]."</b></font>";
        echo "<br> Sin Holds";


    }
    echo "</table>";
    ?>
