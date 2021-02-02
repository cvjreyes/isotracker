<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Collection as Collection;
use Illuminate\Http\Request;
use Datatables;
use DB;

class DpipeDatatableController extends Controller
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

    public function dpipedatatable()
    {
        return view('datatables/dpipedatatable');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dpipegetPosts()
    {
        
        $dpipes = DB::select( DB::raw("SELECT * FROM tpfmc_db.ppipes_view;") );
         return Datatables::of($dpipes)
             ->make(true);
    }

    public function dpipegetAreas()
    {
        
        // $dpipegetareas = DB::select( DB::raw("SELECT DISTINCT SUBSTRING(zone_name,2,5) AS area, count(*) as modeled FROM dpipes group by area"));
        $dpipegetareas = DB::select( DB::raw("SELECT DISTINCT SUBSTRING_INDEX(zone_name,'/',2) AS area, count(*) as modeled FROM dpipes group by area"));
        

              return Datatables::of($dpipegetareas)
             ->make(true);


       
    }

    // public function dpipegetModeled()
    // {
        
    //     $dpipegetmodeled = DB::select( DB::raw("SELECT COUNT(*) AS count FROM dpipes WHERE pipe_name LIKE '%'+$dpipegetareas+'%'") );
    //      return Datatables::of($dpipegetmodeled)
    //          ->make(true);
    // }
}