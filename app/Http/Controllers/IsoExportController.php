<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class IsoExportController extends Controller{

        public function exportissuedwithnotsupports(){

          Excel::create('IssuedWithNotSupportReport', function($excel) {

            $excel->sheet('IsoStatus', function($sheet) {

             
              $isostatuss = DB::select("SELECT disoctrls.filename,dpipesfullview.tag,dpipesfullview.diameter,dpipesfullview.psupports,disoctrls.issuedfolder FROM dpipesfullview JOIN disoctrls
                WHERE disoctrls.issuedfolder LIKE 'TRN%' AND disoctrls.filename LIKE CONCAT(dpipesfullview.isoid,'%') AND psupports=0 AND diameter>50 GROUP BY disoctrls.filename");

               $data= [];

               foreach ($isostatuss as $isostatus) {

                    $row = [];
                    $row['ISO_ID'] = $isostatus->filename;
                    $row['TAG'] = $isostatus->tag;
                    $row['DIAMETER'] = $isostatus->diameter;
                    $row['PROGRESS_SUPPORTS'] = $isostatus->psupports;
                    $row['ISSUED_FOLDER'] = $isostatus->issuedfolder;
                    $data[] = $row;
                   
                   }

                    $sheet->fromArray($data);

                });

            })->export('xlsx');

        }

        public function exportisostatus(){

          Excel::create('IsoStatusReport', function($excel) {

            $excel->sheet('IsoStatus', function($sheet) {

              $isostatuss = DB::select("SELECT * FROM hisoctrls");
               $data= [];

               foreach ($isostatuss as $isostatus) {

                    $row = [];
                    $row['ISO_ID'] = $isostatus->filename;
                    $row['FROM'] = $isostatus->from;
                    $row['TO'] = $isostatus->to;
                    $row['DATE'] =   $isostatus->created_at;
                    $row['COMMENT'] = $isostatus->comments;
                    $row['USER'] = $isostatus->user;
                    $data[] = $row;
                   
                   }

                    $sheet->fromArray($data);

                });

            })->export('xlsx');

        }

        public function exportisostatuscountbytypeline(){


           Excel::create('IsoStatusCountbyTypeLineReport', function($excel) {

            $excel->sheet('IsoStatus', function($sheet) {

               $intrays = DB::select("SELECT design,if(count=0,'0',count) as qty FROM countbytypelinetotalview");
                $data= [];

               foreach ($intrays as $intray) {

                  $row = [];
                    $row['TRAY'] = $intray->design;
                    $row['QUANTITY'] = $intray->qty;
                    $data[] = $row;  

               }

               $sheet->fromArray($data);

              });
           
            })->export('xlsx');



        }

        public function exportisostatuswithdates(){

          Excel::create('IsoStatusWithDatesReport', function($excel) {

            $excel->sheet('IsoStatus', function($sheet) {

             
              $isostatuss = DB::select("SELECT  disoctrls.filename, if(disoctrls.isostatus_id=13, if(disoctrls.filename LIKE '%-0.pdf','ISSUED R0',if(disoctrls.filename LIKE '%-1.pdf','ISSUED R1',if(disoctrls.filename LIKE '%-2.pdf','ISSUED R2','ISSUED R3'))),if(disoctrls.deleted>0, 'DELETED','ON GOING')) AS deleted,disoctrls.created_at, isostatus.name, disoctrls.updated_at FROM disoctrls JOIN isostatus WHERE disoctrls.isostatus_id=isostatus.id GROUP BY disoctrls.filename");
               $data= [];

               foreach ($isostatuss as $isostatus) {

                    $row = [];
                    $row['ISO_ID'] = $isostatus->filename;
                    $row['START_DATE'] = $isostatus->created_at;
                    $row['CURRENT_STATUS'] = $isostatus->name;
                    $row['CURRENT_DATE'] =   $isostatus->updated_at;
                    $row['CONDITION'] =   $isostatus->deleted;
                    $data[] = $row;
                   
                   }

                    $sheet->fromArray($data);

                });

            })->export('xlsx');

        }

        public function exportisostatuswithdatesreport(){

          Excel::create('StatusReport-Isotracker', function($excel) {

            $excel->sheet('IsoStatus', function($sheet) {

             
              $isostatuss = DB::select("SELECT  disoctrls.filename, if(disoctrls.isostatus_id=13, 'ISSUED',if(disoctrls.deleted>0, 'DELETED','ON GOING')) AS deleted, disoctrls.created_at, isostatus.name, disoctrls.updated_at FROM disoctrls JOIN isostatus WHERE disoctrls.isostatus_id=isostatus.id GROUP BY disoctrls.filename");
               $data= [];

               foreach ($isostatuss as $isostatus) {

                    $row = [];
                    $row['ISO_ID'] = $isostatus->filename;
                    $row['START_DATE'] = $isostatus->created_at;
                    $row['CURRENT_STATUS'] = $isostatus->name;
                    $row['CURRENT_DATE'] =   $isostatus->updated_at;
                    $row['CONDITION'] =   $isostatus->deleted;
                    $data[] = $row;
                   
                   }

                    $sheet->fromArray($data);

                });

           })->store('xlsx', storage_path('reports'));

        }

        public function exportisostatusprogress(){


          $ifc = env('APP_IFC');

          if ($ifc==1){

            $tags = DB::select("SELECT dpipesfullview.tag,dpipesfullview.type_line, isostatusprogressview.filename, isostatusprogressview.name, isostatusprogressview.progress, ppipes_ifc.level  
            FROM isostatusprogressview JOIN ppipes_ifc JOIN dpipesfullview
            WHERE REPLACE(isostatusprogressview.name,'LDG ','') like ppipes_ifc.level AND
            isostatusprogressview.filename like CONCAT(dpipesfullview.isoid,'%')
            GROUP BY isostatusprogressview.filename");

          }else{

            $tags = DB::select("SELECT dpipesfullview.tag,dpipesfullview.type_line, isostatusprogressview.filename, isostatusprogressview.name, isostatusprogressview.progress, ppipes_ifd.level  
            FROM isostatusprogressview JOIN ppipes_ifd JOIN dpipesfullview
            WHERE REPLACE(isostatusprogressview.name,'LDG ','') like ppipes_ifd.level AND
            isostatusprogressview.filename like CONCAT(dpipesfullview.isoid,'%')
            GROUP BY isostatusprogressview.filename");


          }


          


          $fh = fopen("../public/storage/progress/statusprogresspipe.pmlmac", 'w') or die("Se produjo un error al crear el archivo");
  
            foreach ($tags as $tag) {

              if ($ifc==1){
                  
                  $texto = '/'.$tag->tag.' STMSET /TPI-EP-PROGRESS/PIPING/TOTAL-IFC /'.$tag->type_line.'-'.$tag->level.PHP_EOL;

              }else{

                  $texto = '/'.$tag->tag.' STMSET /TPI-EP-PROGRESS/PIPING/TOTAL-IFD /'.$tag->type_line.'-'.$tag->level.PHP_EOL;
              
              }    

                fwrite($fh, $texto) or die("No se pudo escribir en el archivo");

                }
                
                fclose($fh);
                
                echo "Se ha escrito sin problemas";

        }

        public function exportisostatuscount(){

          Excel::create('IsoStatusCountReport', function($excel) {

            $excel->sheet('IsoStatus', function($sheet) {

             
                                          $isostatus_qry1 ="SELECT isostatus.name, count(isostatus.name) as qty FROM disoctrls JOIN isostatus WHERE disoctrls.isostatus_id=isostatus.id AND ";

                              $isostatus_qry2 =" GROUP BY isostatus.name";

                              

                              $isostatus_new = DB::select($isostatus_qry1."isostatus.name='New'".$isostatus_qry2);
                              $isostatus_design = DB::select($isostatus_qry1."isostatus.name='Design'".$isostatus_qry2);
                              $isostatus_stress = DB::select($isostatus_qry1."isostatus.name='Stress'".$isostatus_qry2);
                              $isostatus_supports = DB::select($isostatus_qry1."isostatus.name='Supports'".$isostatus_qry2);
                              $isostatus_ldgdesign = DB::select($isostatus_qry1."isostatus.name='LDG Design'".$isostatus_qry2);
                              $isostatus_ldgstress = DB::select($isostatus_qry1."isostatus.name='LDG Stress'".$isostatus_qry2);
                              $isostatus_ldgsupports = DB::select($isostatus_qry1."isostatus.name='LDG Supports'".$isostatus_qry2);
                              $isostatus_materials = DB::select($isostatus_qry1."isostatus.name='Materials'".$isostatus_qry2);
                              $isostatus_lead = DB::select($isostatus_qry1."isostatus.name='Lead'".$isostatus_qry2);
                              $isostatus_toissue = DB::select($isostatus_qry1."isostatus.name='To Issue'".$isostatus_qry2);
                              $isostatus_issued = DB::select($isostatus_qry1."isostatus.name='Issued'".$isostatus_qry2);
                              $isostatus_issued_R0 = DB::select($isostatus_qry1."isostatus.name='Issued' AND disoctrls.filename LIKE '%-0.pdf'".$isostatus_qry2);
                              $isostatus_issued_R1 = DB::select($isostatus_qry1."isostatus.name='Issued'  AND disoctrls.filename LIKE '%-1.pdf'".$isostatus_qry2);
                              $isostatus_issued_R2 = DB::select($isostatus_qry1."isostatus.name='Issued'  AND disoctrls.filename LIKE '%-2.pdf'".$isostatus_qry2);
                              $isostatus_total = DB::select("SELECT COUNT(*) AS qty FROM disoctrls");


                              // SUMA DE ISO DE BANDEJA MAS RESPECTIVO LDG
                                                            
                              $new_qty = $isostatus_new[0]->qty + 0;
                              $design_qty = $isostatus_design[0]->qty + $isostatus_ldgdesign[0]->qty + $new_qty + 0;
                              $stress_qty = $isostatus_stress[0]->qty + $isostatus_ldgstress[0]->qty + 0;
                              $supports_qty = $isostatus_supports[0]->qty + $isostatus_ldgsupports[0]->qty + 0;
                              $materials_qty = $isostatus_materials[0]->qty + 0;
                              $lead_qty = $isostatus_lead[0]->qty + 0;
                              $toissue_qty = $isostatus_toissue[0]->qty + 0;
                              $Isocontrol_qty = $toissue_qty + $isostatus_issued[0]->qty + 0;
                              $total_qty = $isostatus_total[0]->qty + 0;

               $data= [];

               $progress = array("Design", "Stress", "Supports", "Materials", "Lead", "Isocontrol", "Total");
               $counter = array($design_qty, $stress_qty, $supports_qty, $materials_qty, $lead_qty, $isocontrol_qty, $total_qty);

               for ($i = 0; $i <= count($progress); $i++) {

                    $row = [];
                    $row['PROGRESS'] = $progress[$i];
                    $row['COUNTER'] = $counter[$i];
                    $data[] = $row;
                   
                   }

                    $sheet->fromArray($data);

                });

            })->export('xlsx');

        }

        public function exportissuedextended(){

            Excel::create('IsoStatusIssued', function($excel) {

            $excel->sheet('IsoStatusIssued', function($sheet) {

              $isostatuss = DB::select("SELECT * FROM disoctrls WHERE isostatus_id=13 ORDER BY updated_at ASC");

               foreach ($isostatuss as $isostatus) {

                if($isostatus->revision=='0'){$issuedate0 = $isostatus->issuedate;}else{$issuedate0='';}
                if($isostatus->revision=='1'){$issuedate1 = $isostatus->issuedate;}else{$issuedate1='';}
                if($isostatus->revision=='2'){$issuedate2 = $isostatus->issuedate;}else{$issuedate2='';}
                if($isostatus->revision=='3'){$issuedate3 = $isostatus->issuedate;}else{$issuedate3='';}
                if($isostatus->revision=='4'){$issuedate4 = $isostatus->issuedate;}else{$issuedate4='';}

                    $row = [];
                    $row['ISO_ID'] = $isostatus->filename;
                    $row['REV0'] = $issuedate0;
                    $row['REV1'] = $issuedate1;
                    $row['REV2'] = $issuedate2;
                    $row['REV3'] = $issuedate3;
                    $row['REV4'] = $issuedate4;
                    $row['FOLDER'] = $isostatus->issuedfolder;

                    
                    $data[] = $row;
                   
                   }

                    $sheet->fromArray($data);

                });

            })->export('xlsx');

        }

          public function exportissued(){

            Excel::create('IsoStatusIssued', function($excel) {

            $excel->sheet('IsoStatusIssued', function($sheet) {

              $isostatuss = DB::select("SELECT * FROM disoctrlsextendedview_pivot;");

               foreach ($isostatuss as $isostatus) {


                    $row = [];
                    $row['ISO_ID'] = $isostatus->isoid;
                    $row['REV0'] = $isostatus->A;
                    $row['REV1'] = $isostatus->B;
                    $row['REV2'] = $isostatus->C;
                    $row['REV3'] = $isostatus->D;
                    $row['REV4'] = $isostatus->E;
                   
                    $data[] = $row;
                   
                   }

                    $sheet->fromArray($data);

                });

            })->export('xlsx');

        }


        public function exportisodates(){


            Excel::create('IsoController', function($excel) {

                $excel->sheet('Design', function($sheet) {

                   $iso = DB::select("SELECT * FROM disoctrls ORDER BY filename");
                   $data= [];

                   foreach ($iso as $isos) {

                    $row = [];
                    $row['ISOMETRIC'] = $isos->filename;
                    $row['REV'] = $isos->revision;
                    $row['DATE'] = $isos->ddesign;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

                $excel->sheet('Stress', function($sheet) {

                   $iso = DB::select("SELECT * FROM disoctrls WHERE id IN (SELECT MAX(id) FROM disoctrls GROUP BY filename) ORDER BY id DESC"); //QUERY PARA TODOS MENOS DESIGN
                   $data= [];

                   foreach ($iso as $isos) {

                    $row = [];
                    $row['ISOMETRIC'] = $isos->filename;
                    $row['INBOX'] = $isos->instress;
                    $row['DATE'] = $isos->dstress;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

                $excel->sheet('Supports', function($sheet) {

                   $iso = DB::select("SELECT * FROM disoctrls WHERE id IN (SELECT MAX(id) FROM disoctrls GROUP BY filename) ORDER BY id DESC"); //QUERY PARA TODOS MENOS DESIGN
                   $data= [];

                   foreach ($iso as $isos) {

                    $row = [];
                    $row['ISOMETRIC'] = $isos->filename;
                    $row['INBOX'] = $isos->insupports;
                    $row['DATE'] = $isos->dsupports;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

                $excel->sheet('Materials', function($sheet) {

                   $iso = DB::select("SELECT * FROM disoctrls WHERE id IN (SELECT MAX(id) FROM disoctrls GROUP BY filename) ORDER BY id DESC"); //QUERY PARA TODOS MENOS DESIGN
                   $data= [];

                   foreach ($iso as $isos) {

                    $row = [];
                    $row['ISOMETRIC'] = $isos->filename;
                    $row['INBOX'] = $isos->inmaterials;
                    $row['DATE'] = $isos->dmaterials;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }


            public function exportmodeledequi(){


            Excel::create('ModeledEqui3D', function($excel) {

                $excel->sheet('Dequis', function($sheet) {

                   $eequis = DB::select("SELECT * FROM dequisfullview");
                   $data= [];

                   foreach ($eequis as $eequi) {

                    $row = [];
                    $row['UNIT'] = $eequi->unit;
                    $row['AREA'] = $eequi->area;
                    $row['TAG'] = $eequi->tag;
                    $row['TYPE'] = $eequi->type_equi;
                    $row['WEIGHT'] = $eequi->weight;
                    $row['QUANTITY'] = $eequi->est_quantity;
                    $row['STATUS'] = $eequi->status;
                    $row['PROGRESS'] = $eequi->progress;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }

            public function exporttypeequi(){


            Excel::create('TypeEqui3D', function($excel) {

                $excel->sheet('Tequis', function($sheet) {

                   $eequis = DB::select("SELECT * FROM tequis");
                   $data= [];

                   foreach ($eequis as $eequi) {

                    $row = [];
                    $row['CODE'] = $eequi->code;
                    $row['NAME'] = $eequi->name;
                    $row['WEIGHT'] = $eequi->hours;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }

            public function exportstatussitspo(){

              Excel::create('IsoStatusSIT-SPO', function($excel) {
  
              $excel->sheet('IsoStatusSIT-SPO', function($sheet) {
  
                $isostatuss = DB::select("SELECT filename,spo,sit,updated_at FROM hisoctrls 
                WHERE id IN (SELECT MAX(id) FROM hisoctrls GROUP BY filename) AND sit<>0 OR spo<>0 ORDER BY id DESC");

  
                 foreach ($isostatuss as $isostatus) {

                  $sitstatus = $isostatus->sit;
                  $spostatus = $isostatus->spo;
  
                  switch ( $sitstatus ) {
                    case 0:
                          $sitstatus='---';
                          break;      
                    case 1:
                          $sitstatus='TO CHECK';
                          break;
                    case 2:
                          $sitstatus='APPROVED';
                          break;
                    case 3:
                          $sitstatus='REJECTED';
                          break;
                    }

                  switch ( $spostatus ) {
                      case 0:
                            $spostatus='---';
                            break;      
                      case 1:
                            $spostatus='TO CHECK';
                            break;
                      case 2:
                            $spostatus='APPROVED';
                            break;
                      case 3:
                            $spostatus='REJECTED';
                            break;
                      }
  
                      $row = [];
                      $row['ISO_ID'] = $isostatus->filename;
                      $row['PROCESS'] = $spostatus;
                      $row['INSTRUMENTATION'] = $sitstatus;
                      $row['UPDATED AT'] = $isostatus->updated_at;
  
                      
                      $data[] = $row;
                     
                     }
  
                      $sheet->fromArray($data);
  
                  });
  
              })->export('xlsx');

    }
  }