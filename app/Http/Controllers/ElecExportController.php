<?php

namespace App\Http\Controllers;


use App\Eelec;
use App\Delec;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class elecExportController extends Controller{

        public function exportelec(){


            Excel::create('Estimatedelec3D', function($excel) {

                $excel->sheet('Eelecs', function($sheet) {

                   $eelecs = DB::select("SELECT * FROM delecsfullview");
                   $data= [];

                   foreach ($eelecs as $eelec) {

                    $row = [];
                    $row['UNIT'] = $eelec->unit;
                    $row['AREA'] = $eelec->area;
                    $row['TAG'] = $eelec->tag;
                    $row['TYPE'] = $eelec->type_elec;
                    $row['WEIGHT'] = $eelec->weight;
                    $row['QUANTITY'] = $eelec->est_quantity;
                    $row['STATUS'] = $eelec->status;
                    $row['PROGRESS'] = $eelec->progress;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }


            public function exportmodeledelec(){


            Excel::create('Modeledelec3D', function($excel) {

                $excel->sheet('Delecs', function($sheet) {

                   $eelecs = DB::select("SELECT * FROM delecsfullview");
                   $data= [];

                   foreach ($eelecs as $eelec) {

                    $row = [];
                    $row['UNIT'] = $eelec->unit;
                    $row['AREA'] = $eelec->area;
                    $row['TAG'] = $eelec->tag;
                    $row['TYPE'] = $eelec->type_elec;
                    $row['WEIGHT'] = $eelec->weight;
                    $row['QUANTITY'] = $eelec->est_quantity;
                    $row['STATUS'] = $eelec->status;
                    $row['PROGRESS'] = $eelec->progress;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }

            public function exporttypeelec(){


            Excel::create('Typeelec3D', function($excel) {

                $excel->sheet('Telecs', function($sheet) {

                   $eelecs = DB::select("SELECT * FROM telecs");
                   $data= [];

                   foreach ($eelecs as $eelec) {

                    $row = [];
                    $row['CODE'] = $eelec->code;
                    $row['NAME'] = $eelec->name;
                    $row['WEIGHT'] = $eelec->hours;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }

    }