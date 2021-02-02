<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;

use App\Epipe;
use App\Pipesview;
use App\Unit;
use App\Diameter;
use App\Filterpipes;

use DB;
use Charts;

class DpipeFilterController extends Controller
{

     public function __construct()
        {
            $this->middleware('auth');
         
        }

    public function filter(){


        $units = Unit::pluck('name')->all();
        $diameters = Diameter::pluck('dn')->all();

        return view('piping.filterpipe')->with('units',$units)->with('diameters',$diameters);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filterPipes(Request $request)
    {

     

    $filterpipes = DB::select("SELECT * FROM filterpipes ORDER by id");


       return Datatables::of($filterpipes)
            ->addColumn('action', function ($filterpipes) {
                return '<a href="delfilterpipes/'.$filterpipes->id.'" class="del-filterpipes-modal btn btn-xs btn-danger" data-id ="'.$filterpipes->id.'" data-field ="'.$filterpipes->field.'" data-operator ="'.$filterpipes->operator.'" data-comparison ="'.$filterpipes->comparison.'" data-toggle="modal" data-target="#delfilterpipesModal"> Remove</a>';
            })

             ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


       return view('piping.createfilterpipe');


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


     if(($request->input('comparison_a')==NULL) AND ($request->input('comparison_d')==NULL)){ 
     
        return redirect()->route('filterpipes') 
                        ->with('warning','WARNING! You must select a comparison item.');

     }else{  
        
        if(($request->input('comparison_a')!=NULL)){

            $comparison = DB::select("SELECT name AS comparison FROM units WHERE id="."'".$request->input('comparison_a')."'");

        }else{

            $comparison = DB::select("SELECT dn AS comparison FROM diameters WHERE id=".$request->input('comparison_d'));

        }

        $count = count($request->input('field'));

         $not_added = 0; /*variable para controlar el número de registros no insertados*/
        $added = 0; /*variable para controlar el número de registros insertados*/
                      for ($i = 0; $i < $count; $i++) {

                 
                        DB::table('filterpipes')->insert([
                            'field' =>$request->input('field')[$i],
                            'operator' =>$request->input('operator')[$i], 
                            'comparison' =>$comparison[0]->comparison, 
                         ]);

                            $added = $added+1;
                              

                      

                      }

                      return redirect()->route('filterpipes') 
                        ->with('success','SUCCESS! '.$added.' records were successfully added.');

      }                   

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
     
        $id=$request->id;

        Filterpipes::find($id)->delete();
        return redirect()->route('filterpipes')
                        ->with('success','SUCCESS! Records were successfully removed.');
    

    }



    /*FUNCIONES FUERA DEL CRUD*/

    public function dpipegetProgressByArea()
    {


   



    }
     /*FUNCION PARA EL GRÁFICO DE LÍNEAS*/
     public function dpipedatatable()
    {
        

     

    }

    public function updateMilestone()
    {

       
            

    }

    public function ldl(Request $request)
    {

     

    $epipes = DB::select("SELECT * FROM epipes");




       return Datatables::of($epipes)



       ->make(true);

    }

    public function modeled(){


        return view('piping.modeledpipe');


    }

    

    public function jsppipe(){


        return view('piping.jsppipe');


    }

    public function jscnotes(){


        return view('piping.jscnotes');


    }


}