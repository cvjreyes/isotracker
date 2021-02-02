@extends('layouts.datatable')

@section('content')
<br><br><br><br>

<?php
$directory = opendir("../storage/app/isoctrl"); //ruta actual
while ($filename = readdir($directory)) //obtenemos un filename y luego otro sucesivamente
{
    if (is_dir($filename))//verificamos si es o no un directory
    {
        echo "[".$filename . "]<br />"; //de ser un directory lo envolvemos entre corchetes
    }
    else
    {
        // $file = '201903nomina.pdf';
        // $filename = '201903nomina.pdf';
        // header('Content-type: application/pdf');  
        // header('Content-Disposition: inline; filename="' . $filename . '"');          
        // header('Content-Transfer-Encoding: binary');          
        // header('Accept-Ranges: bytes');
        // @readfile($file);

        //echo $filename."<br />";

        echo "<a href='../storage/app/isoctrl/".$filename . "'>".$filename."<br /></a>";


    }
}
?>

@endsection
