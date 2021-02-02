<?php

namespace App\Http\Controllers;


use App\Einst;
use App\Dinst;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class instExportController extends Controller{

        public function exportinst(){


            Excel::create('Estimatedinst3D', function($excel) {

                $excel->sheet('Einsts', function($sheet) {

                   $einsts = DB::select("SELECT * FROM dinstsfullview");
                   $data= [];

                   foreach ($einsts as $einst) {

                    $row = [];
                    $row['UNIT'] = $einst->unit;
                    $row['AREA'] = $einst->area;
                    $row['TAG'] = $einst->tag;
                    $row['TYPE'] = $einst->type_inst;
                    $row['WEIGHT'] = $einst->weight;
                    $row['QUANTITY'] = $einst->est_quantity;
                    $row['STATUS'] = $einst->status;
                    $row['PROGRESS'] = $einst->progress;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }


            public function exportmodeledinst(){


            Excel::create('Modeledinst3D', function($excel) {

                $excel->sheet('Dinsts', function($sheet) {

                   $einsts = DB::select("SELECT * FROM dinstsfullview");
                   $data= [];

                   foreach ($einsts as $einst) {

                    $row = [];
                    $row['UNIT'] = $einst->unit;
                    $row['AREA'] = $einst->area;
                    $row['TAG'] = $einst->tag;
                    $row['TYPE'] = $einst->type_inst;
                    $row['WEIGHT'] = $einst->weight;
                    $row['QUANTITY'] = $einst->est_quantity;
                    $row['STATUS'] = $einst->status;
                    $row['PROGRESS'] = $einst->progress;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }

            public function exporttypeinst(){


            Excel::create('Typeinst3D', function($excel) {

                $excel->sheet('Tinsts', function($sheet) {

                   $einsts = DB::select("SELECT * FROM tinsts");
                   $data= [];

                   foreach ($einsts as $einst) {

                    $row = [];
                    $row['CODE'] = $einst->code;
                    $row['NAME'] = $einst->name;
                    $row['WEIGHT'] = $einst->hours;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }

    }