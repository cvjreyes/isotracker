
<?php
if(isset($_POST["texto"]))

    $comments = DB::select("SELECT * FROM hisoctrls WHERE id="."'".$_POST["texto"]."'");


        echo "<font size='5' color='#2579A9'><b>".$comments[0]->filename."</b></font>";
        echo "<br><b>Comments</b>";
            //echo "<br>"."\n-------------------------\n";

        echo "<br>".$comments[0]->comments;
        echo "<font size='3' color='#2579A9'><br><br>".$comments[0]->user;
        echo "<font size='3' color='#2579A9'><br>".$comments[0]->created_at;

   

?>
