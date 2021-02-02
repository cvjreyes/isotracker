<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;

use App\Epipe;
use App\Pipesview;
use App\Unit;
use App\Diameter;
use App\Spec;
use App\Fluid;
use App\Flu_desc;
use App\Flu_pha;
use App\Ins_code;


use DB;
use Charts;

class DldlpipeUiController extends Controller
{

     public function __construct()
        {
            $this->middleware('auth');
         
        }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
                
    return view('piping.ldlpipe');

    }

    public function getDatatableLdl(Request $request)
    {


$ldlpipes = DB::select("SELECT * FROM pipesview ORDER BY area");

       

       return Datatables::of($ldlpipes)
        ->addColumn('action', function ($ldlpipes) {
                return '<a onclick "" href="createlinewindow/'.$ldlpipes->id.'" class="edit-equi-modal btn btn-xs btn-primary"> Modify</a>&nbsp;';
            })
       ->make(true);


       // return '<a onclick "" href="createlinewindow/'.$ldlpipes->id.'" class="edit-equi-modal btn btn-xs btn-primary"> Modify</a>&nbsp;';

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $units = Unit::all();
        $diameters = Diameter::all();
        $specs = Spec::all();
        $fluids = Fluid::all();
        $flu_descs = Flu_desc::all();
        $flu_phas = Flu_pha::all();
        $ins_codes = Ins_code::all();


     $epipes = DB::select("SELECT * FROM pipesview ORDER BY area");

     //return view('piping.createpipe')->with('units', $units);

     return view('piping.createpipe', compact('units','diameters','specs','fluids','flu_descs','flu_phas','ins_codes'));



    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



                         

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
 

    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
    }



    /*FUNCIONES FUERA DEL CRUD*/

    public function dequigetProgressByArea()
    {


   



    }
     /*FUNCION PARA EL GRÁFICO DE LÍNEAS*/
     public function dequidatatable()
    {
        

     

    }

    public function updateMilestone()
    {

       
            

    }


}