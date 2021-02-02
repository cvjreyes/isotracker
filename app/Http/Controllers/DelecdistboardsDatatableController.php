<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use DB;
//use Illuminate\Support\Facades\Auth;



    class DelecdistboardsDatatableController extends Controller
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
        
        public function delecdistboardsdatatable()
        {
            return view('datatables/delecdistboardsdatatable');
        }

        /**
         * Show the application dashboard.
         *
         * @return \Illuminate\Http\Response
         */
        public function delecdistboardsgetPosts()
        {
            
            $delec_dist_boards= DB::table('delec_dist_boards')->select('*');
            return Datatables::of($delec_dist_boards)
                ->make(true);
        }
}
