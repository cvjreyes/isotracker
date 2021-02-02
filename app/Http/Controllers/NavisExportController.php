<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class NavisExportController extends Controller{


        public function exportxml(){

          

          Excel::load('estimated\resumen.xlsx', function($reader) {

            

                    
                    foreach ($reader->get() as $key =>$navis) {

                          $selected=$navis->selected;

                          if($selected!=''){

                            $narray[$key]=$navis->navis;

                            $textoatta[$key]="                            <optionset name=''>
                                  <option name='category'>
                                    <data type='name'>
                                      <name internal='lcldrvm_props'>PDMS</name>
                                    </data>
                                  </option>
                                  <option name='property'>
                                    <data type='name'>
                                      <name internal='lcldrvm_prop_".strtolower($navis->navis)."'>".$navis->navis."</name>
                                    </data>
                                  </option>
                                </optionset>\n";

                     
                            
                        

                          }

                          $textoatt =$textoatt.$textoatta[$key];
                          
                           

                      }



          $fh = fopen("prueba.xml", 'w') or die("Se produjo un error al crear el archivo");
  
              $texto1 = <<<_END
            <?xml version="1.0" encoding="UTF-8" ?>

            <exchange xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://download.autodesk.com/us/navisworks/schemas/nw-exchange-12.0.xsd">
              <optionset name="">
                <optionset name="interface">
                  <optionset name="smart_tags">
                    <option name="enabled">
                      <data type="bool">true</data>
                    </option>
                    <option name="hide_category" flags="32">
                      <data type="bool">false</data>
                    </option>
                    <optionarray name="definitions">\n
            _END;


            $texto2 = <<<_END
                            </optionarray>
                      </optionset>
                    </optionset>
                  </optionset>
                </exchange>
            _END;
              
              fwrite($fh, $texto1.$textoatt.$texto2) or die("No se pudo escribir en el archivo");
              
              fclose($fh);
              
              echo "Se ha escrito sin problemas";

         });

        

        }


    }

?>