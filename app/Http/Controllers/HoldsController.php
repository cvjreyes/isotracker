<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Hold;
use DB;

class HoldsController extends Controller
{


public function importholds(){

	DB::table('holds')->truncate();

	Excel::load('e3dreports\holds.xlsx', function($reader)
	{
		
		 foreach ($reader->get() as $hold) {
		 	echo $hold->tag."<br>";

		 		$lineid = DB::select("SELECT id FROM dpipesnews WHERE tag='".$hold->tag."'");


		 		for ($i=1;$i<10;$i++) { 
		 		
		 			$desc = "description".$i;
		 			$holds = "hold".$i;
		 		
		     		Hold::create([ 

		     				'dpipesnews_id' => $lineid[0]->id,	     				
		     				'holds' => $hold->$holds,
		     				'description' => $hold->$desc,

				     		
				     	]);
							

				     }
		 		};
    
    

    

		});

		return Hold::all();

	}
}