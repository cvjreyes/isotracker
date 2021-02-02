<?php

namespace App\Http\Controllers;


use App\Eequi;
use App\Dequi;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class EquiExportController extends Controller{

        public function exportequi(){


            Excel::create('EstimatedEqui3D', function($excel) {

                $excel->sheet('Eequis', function($sheet) {

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

    }