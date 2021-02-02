<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use DB;
use Charts;




class DelecDatatableController extends Controller
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

    public function delecdatatable()
    {
        

         $lineprogress = DB::select("SELECT date, SUM(count) AS count from helecs where progress<>0 group by date");


            return view('datatables/delecdatatable2',['lineprogress'=>$lineprogress]);


            $lineprogress = DB::select("SELECT pelecs.name as status, count(*) as count FROM delecs JOIN pelecs ON delecs.progress=pelecs.percentage group by pelecs.percentage, pelecs.name, delecs.progress");


            return view('datatables/delecdatatable3',['lineprogress'=>$lineprogress]);
        //return view('datatables/delecdatatable');
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delecgetPosts()
    {

        

        $delec = DB::select( DB::raw("SELECT zone_name, elec_name, progress, name FROM delecs, pelecs WHERE progress=percentage"));
         return Datatables::of($delec)
             ->make(true);

             //SELECT DISTINCT count(*) as modeled FROM delecs group by progress
    }

    public function delecgetProgress()
    {

         $delecgetprogress = DB::select("SELECT pelecs.percentage as progress, pelecs.name as status, count(*) as count FROM delecs JOIN pelecs ON delecs.progress=pelecs.percentage group by pelecs.percentage, pelecs.name, delecs.progress");
         return Datatables::of($delecgetprogress)
             ->make(true);


    }


   
    public function delecgetProgressByArea()
    {




        $delecgetprogressbyarea = DB::select("SELECT * FROM pelecs_view");
                     return Datatables::of($delecgetprogressbyarea)
                         ->make(true);




    }



}