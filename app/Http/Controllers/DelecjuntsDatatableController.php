<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use DB;

class DelecjuntsDatatableController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delecjuntsdatatable()
    {
        return view('datatables/delecjuntsdatatable');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delecjuntsgetPosts()
    {
    	
        $delec_junts = DB::table('delec_junts')->select('*');
        return Datatables::of($delec_junts)
            ->make(true);
    }
}