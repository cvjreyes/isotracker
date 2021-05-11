<?php

namespace App\Http\Controllers;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Hisoctrl;
use App\Disoctrl;
use DB;


class FileNavisController extends Controller
{
    
    public function index()
    {

        return view('navis.navisdropzone');
    }

    public function store(Request $request)
    {

            unlink('..public\storage\navis\navis.xml');

            $path = public_path().'/storage/navis/';

                    
                    foreach ($request->atts as $key =>$navis) {

                          $navisatts = DB::select("SELECT * FROM navis WHERE id=".$navis);

                            $textoatta[$key]="                            <optionset name=''>
                                  <option name='category'>
                                    <data type='name'>
                                      <name internal='lcldrvm_props'>PDMS</name>
                                    </data>
                                  </option>
                                  <option name='property'>
                                    <data type='name'>
                                      <name internal='lcldrvm_prop_".strtolower($navisatts[0]->value)."'>".$navisatts[0]->value."</name>
                                    </data>
                                  </option>
                                </optionset>\n";


                          $textoatt =$textoatt.$textoatta[$key];
                           

                      }



          $fh = fopen("../public/storage/navis/navis.xml", 'w') or die("Se produjo un error al crear el archivo");

          


  
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

           return redirect('navisattselect');   
 
    }

        public function show()
    {



        //$design = is_file( "../public/storage/navis/navis.xml");

        
        header('Content-type: application/xml');  
        header('Content-Disposition: attachment; filename="navis.xml"');          
        header('Content-Transfer-Encoding: binary');          
        header('Accept-Ranges: bytes');

         readfile("../public/storage/navis/navis.xml");

         unlink("../public/storage/navis/navis.xml");


           

    }
       
    
}
