<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use DB;
use Charts;




class DcivilDatatableController extends Controller
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

    public function dcivildatatable()
    {
        

         $lineprogress = DB::select("SELECT date, SUM(count) AS count from hcivils where progress<>0 group by date");


            return view('datatables/dcivildatatable2',['lineprogress'=>$lineprogress]);


            $lineprogress = DB::select("SELECT pcivils.name as status, count(*) as count FROM dcivils JOIN pcivils ON dcivils.progress=pcivils.percentage group by pcivils.percentage, pcivils.name, dcivils.progress");


            return view('datatables/dcivildatatable3',['lineprogress'=>$lineprogress]);
        //return view('datatables/dcivildatatable');
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dcivilgetPosts()
    {

        

        $dcivil = DB::select( DB::raw("SELECT zone_name, civil_name, progress, name FROM dcivils, pcivils WHERE progress=percentage"));
         return Datatables::of($dcivil)
             ->make(true);

             //SELECT DISTINCT count(*) as modeled FROM dcivils group by progress
    }

    public function dcivilgetProgress()
    {

         $dcivilgetprogress = DB::select("SELECT pcivils.percentage as progress, pcivils.name as status, count(*) as count FROM dcivils JOIN pcivils ON dcivils.progress=pcivils.percentage group by pcivils.percentage, pcivils.name, dcivils.progress");
         return Datatables::of($dcivilgetprogress)
             ->make(true);


    }


   
    public function dcivilgetProgressByArea()
    {




        $dcivilgetprogressbyarea = DB::select("SELECT * FROM pcivils_view");
                     return Datatables::of($dcivilgetprogressbyarea)
                         ->make(true);




    }



}