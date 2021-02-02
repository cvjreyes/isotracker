@extends('layouts.datatablegeneric')

@section('content')
<?php 
//header("Refresh:0; url=navisattselect");
?>
<script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s5").style.fontWeight='bold';
                                     document.getElementById("s5").style.fontSize=10 + "pt";
                                     document.getElementById("s5").style.fontStyle="italic";;


                                 }

                            </script> 

<style type="text/css">
    

.dgcAlert {top: 0;position: absolute;width: 100%;display: block;height: 1000px; background: url(http://www.dgcmedia.es/recursosExternos/fondoAlert.png) repeat; text-align:center; opacity:0; display:none; z-index:999999999999999;}
.dgcAlert .dgcVentana{width: 500px; background: white;min-height: 150px;position: relative;margin: 0 auto;color: black;padding: 10px;border-radius: 10px;}
.dgcAlert .dgcVentana .dgcCerrar {height: 25px;width: 25px;float: right; cursor:pointer; background: url(http://www.dgcmedia.es/recursosExternos/cerrarAlert.jpg) no-repeat center center;}
.dgcAlert .dgcVentana .dgcMensaje { margin: 0 auto; padding-top: 0px; text-align: center; width: 400px;font-size: 20px;}
.dgcAlert .dgcVentana .dgcAceptar{background:#09C; bottom:20px; display: inline-block; font-size: 12px; font-weight: bold; height: 24px; line-height: 24px; padding-left: 5px; padding-right: 5px;text-align: center; text-transform: uppercase; width: 75px;cursor: pointer; color:#FFF; margin-top:25px;}

</style>
<script type="text/javascript">
    
function alertDGC(mensaje)
    {
    var dgcTiempo=500
    var ventanaCS='<div class="dgcAlert"><div class="dgcVentana"><div class="dgcCerrar"></div><div class="dgcMensaje">'+mensaje+'<br><div class="dgcAceptar">CLOSE</div></div></div></div>';
    $('body').append(ventanaCS);
    var alVentana=$('.dgcVentana').height();
    var alNav=$(window).height();
    var supNav=0//$(window).scrollTop();
    $('.dgcAlert').css('height',$(document).height());
    $('.dgcVentana').css('top',(30)+'%');
    //$('.dgcVentana').css('top',((alNav-alVentana)/2+supNav-100)+'px');
    $('.dgcAlert').css('display','block');
    $('.dgcAlert').animate({opacity:1},dgcTiempo);
     $('.dgcCerrar,.dgcAceptar').click(function(e) {
         $('.dgcAlert').animate({opacity:0},dgcTiempo);
         setTimeout("$('.dgcAlert').remove()",dgcTiempo);
     });
        }
        window.alert = function (message) {
          alertDGC(message);
        };


</script>
<style>
div.sticky {
  z-index: 100;
  position: -webkit-sticky;
  /*position: sticky;*/
  position: fixed;
  top: 0;
  background-color: #CBB956;
  padding: 0px;
  font-size: 20px;
  margin-top: 2%;
  border-radius: 0px 0px 15px 15px;
  width: 60%;


}

div.sticky:hover {

  background-color: #B6A338;

}
</style>


<html>
<head>
<title>Naviswork</title>

</head>
<body>

<div class="container">
  <div class="row">
    <!-- <h4>Agregar Nueva Descarga</h4> -->
    <hr style="margin-top:5px;margin-bottom: 5px;">
<!--     <center><h2 style="padding-top: 4%"><b><i>Naviswork</i></b></h2>
      <h3>Configuration</h3></center> -->


      <div class="panel-body">
    <form id="frm-navis" class="form-horizontal" role="form" method="POST" action="{{ url('/exportnavisxml') }}">    
       {!! csrf_field() !!}

       <?php $navisatts = DB::select("SELECT * FROM navis"); ?>

       <?php if (!file_exists("../public/storage/navis/navis.xml")) { ?> 

          <div class="sticky"><button id="genxml" class="btn btn-lg btn-warning" style="width: 100%;margin-top: 1%"><b><h3>Generate XML</h3></b></button></div>

        <?php } ?>

      <!-- DATATABLE-->

      <link href="{!! asset('css/jquery.dataTables.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
      <script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js') !!}"></script>

      

     <?php 

        $display = '';
        if (!file_exists("../public/storage/navis/navis.xml")) { 

          $display = '';

       }else{

          $display = 'display:none;';
          header("Refresh:2; url=navisattselect");

       } ?>

    <div style="<?php echo $display; ?>;padding-top: 10%">


      <table border id="tabla" data-page-length='1000' class="table table-hover table-condensed" style="width: 100%;font-size: 14px;font-weight: normal;white-space: nowrap;">

        

    <center><thead>
        <tr>
            <th style="text-align: center"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>          
            <th style="text-align: center">Object 3D</th>
            <th style="text-align: center">Attribute</th>
        </tr>
    </thead></center>
    <tfoot><tr>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
        </tr></tfoot>
  
    <!-- Buttons for export -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" rel="stylesheet">


      <tbody>
         
      <?php foreach ($navisatts as $navisatt) { 
        

        echo "<tr>";
          echo "<td style='text-align: center'>".$navisatt->id."</td>";
          echo"<td style='text-align: center'>".$navisatt->object."</td>";
          echo"<td>".$navisatt->value."</td>";
        echo "</tr>";
        
      }//ENDFOREACH?>

      </tbody>


    </table>

  </div>

      
     

       
    
     <!-- BUTTONS FOR SELECT ALL  --> 

     <script type="text/javascript">
       
        $(function(){
              $('#getxmlfake').click(function(){
                $('#getxml').show();
                //$('#getxmlfake').hide();
              });

              $('#getxml').click(function(){
                //$('#getxmlfake').show();
                $('#genxml').hide();
                $('#getxml').hide();
                $('#table').hide();
              });

              $('#genxml').click(function(){
                $('#genxml').hide();
              });
      })

     </script>
    
      <center>

          <button id="genxml" class="btn btn-lg btn-warning" style="display:none;">Generate XML</button>

      <?php if (file_exists("../public/storage/navis/navis.xml")) { ?> 

          &nbsp;&nbsp;<a id="getxml" target='_blank' href="{{ asset('../public/storage/navis/navis.xml') }}" class="btn btn-lg btn-success" style="padding-top: 1%;width: 100%"><b><h3>Download XML</h3></b></a>

      <?php }else{ ?>

          <!-- <button id="genxml" class="btn btn-lg btn-warning">Generate XML</button> -->


      <?php } ?>

      </center>



    <script type="text/javascript">
    
    setTimeout(function() {
    $('#messages').fadeOut('slow');
    }, 50000);

</script>



<script src="{{ asset('js/selectallnavis.js') }}"></script> <!-- select all -->

<script type="text/javascript">
    
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    //$('#tabla').DataTable({"order": [[ 3, 'desc' ]],"pageLength" : 8});
    
    $('#tabla tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width: 100%;font-size: 12px;font-weight: normal;white-space: nowrap" placeholder="Search '+title+'" />' );
    } );


    // Apply the search
    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );

</script>



</table>
</div>
<!-- SELECT ALL -->


<!-- Fin tabla--> 
  </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
</body>
</html>
@endsection
