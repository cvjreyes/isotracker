<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use DB;
use Charts;




class DinstDatatableController extends Controller
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

    public function dinstdatatable()
    {
        

         $lineprogress = DB::select("SELECT date, SUM(count) AS count from hinsts where progress<>0 group by date");


            return view('datatables/dinstdatatable2',['lineprogress'=>$lineprogress]);


            $lineprogress = DB::select("SELECT pinsts.name as status, count(*) as count FROM dinsts JOIN pinsts ON dinsts.progress=pinsts.percentage group by pinsts.percentage, pinsts.name, dinsts.progress");


            return view('datatables/dinstdatatable3',['lineprogress'=>$lineprogress]);
        //return view('datatables/dinstdatatable');
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dinstgetPosts()
    {

        

        $dinst = DB::select( DB::raw("SELECT zone_name, inst_name, progress, name FROM dinsts, pinsts WHERE progress=percentage"));
         return Datatables::of($dinst)
             ->make(true);

             //SELECT DISTINCT count(*) as modeled FROM dinsts group by progress
    }

    public function dinstgetProgress()
    {

         $dinstgetprogress = DB::select("SELECT pinsts.percentage as progress, pinsts.name as status, count(*) as count FROM dinsts JOIN pinsts ON dinsts.progress=pinsts.percentage group by pinsts.percentage, pinsts.name, dinsts.progress");
         return Datatables::of($dinstgetprogress)
             ->make(true);


    }


   
    public function dinstgetProgressByArea()
    {




        $dinstgetprogressbyarea = DB::select("SELECT * FROM pinsts_view");
                     return Datatables::of($dinstgetprogressbyarea)
                         ->make(true);




    }



}