<?php

namespace App\Http\Controllers;


use App\Ecivil;
use App\Dcivil;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class civilExportController extends Controller{

        public function exportcivil(){


            Excel::create('Estimatedcivil3D', function($excel) {

                $excel->sheet('Ecivils', function($sheet) {

                   $ecivils = DB::select("SELECT * FROM dcivilsfullview");
                   $data= [];

                   foreach ($ecivils as $ecivil) {

                    $row = [];
                    $row['UNIT'] = $ecivil->unit;
                    $row['AREA'] = $ecivil->area;
                    $row['TAG'] = $ecivil->tag;
                    $row['TYPE'] = $ecivil->type_civil;
                    $row['WEIGHT'] = $ecivil->weight;
                    $row['QUANTITY'] = $ecivil->est_quantity;
                    $row['STATUS'] = $ecivil->status;
                    $row['PROGRESS'] = $ecivil->progress;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }


            public function exportmodeledcivil(){


            Excel::create('Modeledcivil3D', function($excel) {

                $excel->sheet('Dcivils', function($sheet) {

                   $ecivils = DB::select("SELECT * FROM dcivilsfullview");
                   $data= [];

                   foreach ($ecivils as $ecivil) {

                    $row = [];
                    $row['UNIT'] = $ecivil->unit;
                    $row['AREA'] = $ecivil->area;
                    $row['TAG'] = $ecivil->tag;
                    $row['TYPE'] = $ecivil->type_civil;
                    $row['WEIGHT'] = $ecivil->weight;
                    $row['QUANTITY'] = $ecivil->est_quantity;
                    $row['STATUS'] = $ecivil->status;
                    $row['PROGRESS'] = $ecivil->progress;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }

            public function exporttypecivil(){


            Excel::create('Typecivil3D', function($excel) {

                $excel->sheet('Tcivils', function($sheet) {

                   $ecivils = DB::select("SELECT * FROM tcivils");
                   $data= [];

                   foreach ($ecivils as $ecivil) {

                    $row = [];
                    $row['CODE'] = $ecivil->code;
                    $row['NAME'] = $ecivil->name;
                    $row['WEIGHT'] = $ecivil->hours;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }

    }