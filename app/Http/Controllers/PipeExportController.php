<?php

namespace App\Http\Controllers;


use App\Epipe;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class PipeExportController extends Controller{

        public function exportpipe(){


            Excel::create('ProgressPipe3D', function($excel) {

                $excel->sheet('Epipe', function($sheet) {

                   

       
                   $ppipes = DB::select("SELECT * FROM dpipesfullview");
                   $data= [];

                   foreach ($ppipes as $ppipe) {

                    // PROGRESO POR LINEA

                    $progress_by_line= DB::select(DB::raw("SELECT tag, pid,iso,stress,support, (((pid*w_pid)+(iso*w_iso)+(stress*w_stress)+(support*w_support))/(weight)) as progress 
                      FROM dpipesfullview
                      WHERE id=".$ppipe->id));

                    // -------------------------

                    $row = [];
                    $row['TAG'] = $ppipe->tag;
                    $row['PID'] = $ppipe->pid;
                    $row['ISO'] = $ppipe->iso;
                    $row['STRESS'] = $ppipe->stress;
                    $row['SUPPORT'] = $ppipe->support;
                    $row['PROGRESS'] = round($progress_by_line[0]->progress,1)."%" ;
                    $data[] = $row;
                   
                   }


                   //$epipes = Epipe::all();
                   $sheet->fromArray($data);

                });

            })->export('xlsx');
           
          
            
            }

    }