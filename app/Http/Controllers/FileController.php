<?php

namespace App\Http\Controllers;
use Auth;

use Illuminate\Http\Request;
use App\Hisoctrl;
use App\Disoctrl;
use DB;

class FileController extends Controller
{
    
    public function index()
	{
    	return view('isoctrl.dropzone');
	}

    public function store(Request $request)
    {
            //$filespart = explode(".", $files);

            $path = public_path().'/storage/isoctrl/design/attach/';
            $path2 = public_path().'/storage/isoctrl/design/limbo/';
            $files = $request->file('file');
            
            $ifc = env('APP_IFC');

            foreach($files as $file){

                $fileName = $file->getClientOriginalName();

                $fileNamePart = explode(".", $fileName);

                $fileNameExt = $file->getClientOriginalExtension();

                if ($fileNameExt=="dxf"){

                    $fileNamePart = explode("-", $fileName);

                }else{

                    $fileNamePart = explode(".", $fileName);

                }

                $modeliso = DB::select("SELECT count(*) as count FROM dpipesfullview WHERE isoid='".$fileNamePart[0]."'");


                
                // PARA VALIDAR SI EXISTE
                $indesign = '../public/storage/isoctrl/design/'.$fileName;
                $instress = '../public/storage/isoctrl/stress/'.$fileName;
                $insupports = '../public/storage/isoctrl/supports/'.$fileName;
                $inmaterials = '../public/storage/isoctrl/materials/'.$fileName;
                $inlead = '../public/storage/isoctrl/lead/'.$fileName;
                $iniso = '../public/storage/isoctrl/iso/'.$fileName;
                $inisoissued = '../public/storage/isoctrl/iso/history/'.$fileNamePart[0]."-0.pdf"; // SI EXISTE EMITIDA NO SUBE, DEBE HACER REQUEST A ISOCTRL

                // PARA VALIDAR SI EXISTE PDF
                $pdfindesign = '../public/storage/isoctrl/design/'.$fileNamePart[0].".pdf";
                $pdfinstress = '../public/storage/isoctrl/stress/'.$fileNamePart[0].".pdf";
                $pdfinsupports = '../public/storage/isoctrl/supports/'.$fileNamePart[0].".pdf";
                $pdfinmaterials = '../public/storage/isoctrl/materials/'.$fileNamePart[0].".pdf";
                $pdfinlead = '../public/storage/isoctrl/lead/'.$fileNamePart[0].".pdf";
                $pdfiniso = '../public/storage/isoctrl/iso/'.$fileNamePart[0].".pdf";

                if (file_exists($indesign) OR file_exists($instress) OR file_exists($insupports) OR file_exists($inmaterials) OR file_exists($inlead) OR file_exists($iniso) OR file_exists($inisoissued)){

                        // NOTHING TO DO
                  
                   }else{

                if (($modeliso[0]->count)!=0){  //VALIDA SI EXISTE LINEA MODELADA    

                    if ($fileNameExt=="pdf"){ // SE COPIA EL PDF EN RUTA PRINCIPAL Y SE CAMBIA EL NOMBRE EN ATTACH

                        $file->move($path, $fileName);
                        
                         copy ("../public/storage/isoctrl/design/attach/".$fileName,"../public/storage/isoctrl/design/".$fileName);
                         rename ("../public/storage/isoctrl/design/attach/".$fileName,"../public/storage/isoctrl/design/attach/".$fileNamePart[0]."-CL.pdf");

                        // SE CREA REGISTRO DE FECHA

                        $currentdate = date('d-m-Y');
                        $exist = DB::select("SELECT count(*) AS count FROM disoctrls WHERE filename='".$fileName."'");

                        // PARA ASIGNAR PROGRESO

                          $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$fileNamePart[0]."'");

                            if ($ifc==1){

                                $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                                $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

                              }else{

                                $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                                $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                              }

                        //VALIDA EXISTENCIA

                        if (($exist[0]->count)==0){

                            Disoctrl::create([
                                'filename' =>$fileName,
                                'progress' =>$progress[0]->value,
                                'progressreal' =>$progress[0]->value,
                                'progressmax' =>$progressmax[0]->max,
                                'isostatus_id' =>1, //NEW
                                 ]);

                            Hisoctrl::create([
                                'filename' =>$fileName,
                                'comments' =>'Uploaded',//NEW
                                'from' =>'Design',
                                'to' =>'Design',
                                'user' =>Auth::user()->name,
                                 ]);

                        }

                    }else{ // SI ES ANEXO, SE COPIA EN LA RUTA DONDE EL PDF EXISTE

                        if (file_exists($pdfindesign)){$path = public_path().'/storage/isoctrl/design/attach/';$file->move($path, $fileName);}

                        elseif (file_exists($pdfinstress)){$path = public_path().'/storage/isoctrl/stress/attach/';$file->move($path, $fileName);}

                        elseif (file_exists($pdfinsupports)){$path = public_path().'/storage/isoctrl/supports/attach/';$file->move($path, $fileName);}

                        elseif (file_exists($pdfinmaterials)){$path = public_path().'/storage/isoctrl/materials/attach/';$file->move($path, $fileName);}

                        elseif (file_exists($pdfinlead)){$path = public_path().'/storage/isoctrl/lead/attach/';$file->move($path, $fileName);}

                        elseif (file_exists($pdfiniso)){$path = public_path().'/storage/isoctrl/iso/attach/';$file->move($path, $fileName);}else{$file->move($path2, $fileName);}


                    }

                   }// END VALIDA EXISTENCIA DE LINEA MODELADA

                   }
            }

            $limbofiles = scandir("../public/storage/isoctrl/design/limbo");

            foreach ($limbofiles as $limbofile) {

                //$limbofileNameExt = $limbofile->getClientOriginalExtension();

                $limbofileNamePart = explode(".", $limbofile);

                 if ($limbofileNamePart[0]=="dxf"){

                     $limbofilePart = explode("-", $fileName);

                 }else{

                     $limbofilePart = explode(".", $fileName);

                 }

                // PARA VALIDAR SI EXISTE PDF LUEGO DE SUBIDOS
                $pdfindesign = '../public/storage/isoctrl/design/'.$limbofilePart[0].".pdf";
                $pdfinstress = '../public/storage/isoctrl/stress/'.$limbofilePart[0].".pdf";
                $pdfinsupports = '../public/storage/isoctrl/supports/'.$limbofilePart[0].".pdf";
                $pdfinmaterials = '../public/storage/isoctrl/materials/'.$limbofilePart[0].".pdf";
                $pdfinlead = '../public/storage/isoctrl/lead/'.$limbofilePart[0].".pdf";
                $pdfiniso = '../public/storage/isoctrl/iso/'.$limbofilePart[0].".pdf";
                
                if (file_exists($pdfindesign)){rename ("../public/storage/isoctrl/design/limbo/".$limbofile,"../public/storage/isoctrl/design/attach/".$limbofile);}

                if (file_exists($pdfinstress)){rename ("../public/storage/isoctrl/design/limbo/".$limbofile,"../public/storage/isoctrl/stress/attach/".$limbofile);}

                if (file_exists($pdfinsupports)){rename ("../public/storage/isoctrl/design/limbo/".$limbofile,"../public/storage/isoctrl/supports/attach/".$limbofile);}

                if (file_exists($pdfinmaterials)){rename ("../public/storage/isoctrl/design/limbo/".$limbofile,"../public/storage/isoctrl/materials/attach/".$limbofile);}

                if (file_exists($pdfinlead)){rename ("../public/storage/isoctrl/design/limbo/".$limbofile,"../public/storage/isoctrl/lead/attach/".$limbofile);}

                if (file_exists($pdfiniso)){rename ("../public/storage/isoctrl/design/limbo/".$limbofile,"../public/storage/isoctrl/iso/attach/".$limbofile);}

                

            }
         
    }

    
 
}
