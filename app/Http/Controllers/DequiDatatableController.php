<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use DB;
use Charts;




class DequiDatatableController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
        {
            $this->middleware('auth');
        }

    public function dequidatatable()
    {
        

         $lineprogress = DB::select("SELECT date, SUM(count) AS count from hequis where progress<>0 group by date");


            return view('datatables/dequidatatable2',['lineprogress'=>$lineprogress]);


            $lineprogress = DB::select("SELECT pequis.name as status, count(*) as count FROM dequis JOIN pequis ON dequis.progress=pequis.percentage group by pequis.percentage, pequis.name, dequis.progress");


            return view('datatables/dequidatatable3',['lineprogress'=>$lineprogress]);
        //return view('datatables/dequidatatable');
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dequigetPosts()
    {

        

        $dequi = DB::select( DB::raw("SELECT zone_name, equi_name, progress, name FROM dequis, pequis WHERE progress=percentage"));
         return Datatables::of($dequi)
             ->make(true);

             //SELECT DISTINCT count(*) as modeled FROM dequis group by progress
    }

    public function dequigetProgress()
    {

         $dequigetprogress = DB::select("SELECT pequis.percentage as progress, pequis.name as status, count(*) as count FROM dequis JOIN pequis ON dequis.progress=pequis.percentage group by pequis.percentage, pequis.name, dequis.progress");
         return Datatables::of($dequigetprogress)
             ->make(true);


    }


   
    public function dequigetProgressByArea()
    {




        $dequigetprogressbyarea = DB::select("SELECT * FROM pequis_view");
                     return Datatables::of($dequigetprogressbyarea)
                         ->make(true);




    }



}