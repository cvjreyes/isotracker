<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use DB;

class DeleclightsDatatableController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleclightsdatatable()
    {
        return view('datatables/deleclightsdatatable');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleclightsgetPosts()
    {
    	
        $delec_lights= DB::table('delec_lights')->select('*');
        return Datatables::of($delec_lights)
            ->make(true);
    }
}