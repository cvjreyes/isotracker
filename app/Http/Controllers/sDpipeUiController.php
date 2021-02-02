<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;

use App\Epipe;
use App\Pipesview;
use App\Unit;
use App\Diameter;

use DB;
use Charts;

class DpipeUiController extends Controller
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

    $epipes_1 = "SELECT * FROM pipesview "; 

    //FILTER PIPE QUERYS (SHOW DATATABLE)
                            $filterpipe = DB::select("SELECT * FROM filterpipes");
                            $countfilterpipe = DB::select("SELECT COUNT(*) as count FROM filterpipes");
                            $count=$countfilterpipe[0]->count;
                            $epipes_1 = "SELECT * FROM pipesview ";
                            $epipes_2 = "WHERE ";

                            for ($i = 0; $i < $count; $i++){

                                if($i < $count-1){

                                  if ($filterpipe[$i+1]->field=='area'){  

                                    $epipes_2 = $epipes_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."' OR ";
                                  }else{

                                    $epipes_2 = $epipes_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."' AND ";

                                  }  
    
                                }else{

                                    $epipes_2 = $epipes_2.$filterpipe[$i]->field.$filterpipe[$i]->operator."'".$filterpipe[$i]->comparison."'";

                                }

                            }

                            if ($count>0){
                                $epipes=$epipes_1.$epipes_2;
                            }else{
                                $epipes=$epipes_1;
                            }


                            $epipes = DB::select($epipes); 

                            //END FILTER PIPE QUERYS (SHOW DATATABLE)








       return Datatables::of($epipes)
            ->addColumn('action', function ($epipes) {

                $cnote = DB::select("SELECT name FROM calc_notes WHERE pdms_linenumber="."'".$epipes->pdms_linenumber."'");

                foreach ($cnote as $cnotes) {
                    //echo $cnotes->name;
                }

                return '

                    <a onclick "" href="" class="edit-pipe-modal btn btn-xs btn-primary" data-id ="'.$epipes->id.'" data-units_id ="'.$epipes->units_id.'" data-diameters_id ="'.$epipes->diameters_id.'" data-pdms_linenumber ="'.$epipes->pdms_linenumber.'" data-line_number ="'.$epipes->line_number.'" data-toggle="modal" data-target="#editpipeModal">Modify</a>&nbsp;

                    <a onclick "" href="editpipe/'.$epipes->id.'" class="edit-cnotes-modal btn btn-xs btn-info" data-id ="'.$epipes->id.'" data-units_id ="'.$epipes->units_id.'" data-diameter ="'.$epipes->diameter.'" data-pdms_linenumber ="'.$epipes->pdms_linenumber.'" data-calc_notes ="'.$epipes->calc_notes.'" data-toggle="modal" data-target="#createcnotesModal">Add CN</a>&nbsp;

                    <a onclick="cnote('."'".$epipes->pdms_linenumber."'".')" href="" class="edit-cnotes-modal btn btn-xs btn-default" data-id ="'.$epipes->id.'" data-units_id ="'.$epipes->units_id.'" data-diameter ="'.$epipes->diameter.'" data-pdms_linenumber ="'.$epipes->pdms_linenumber.'" data-calc_notes ="'.$epipes->calc_notes.'" data-toggle="modal" data-target="#showcnotesModa">View CN</a>&nbsp;

                <a onclick="enviar('.$epipes->id.')" href="" class="progress-pipe-modal btn btn-xs btn-success" data-id ="'.$epipes->id.'" data-units_id ="'.$epipes->units_id.'" data-diameter ="'.$epipes->diameter.'" data-pdms_linenumber ="'.$epipes->pdms_linenumber.'" data-calc_notes ="'.$epipes->calc_notes.'" data-toggle="modal" data-target="#progresspipeModa">Progress</a>&nbsp;';
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


        $units = Unit::pluck('name')->all();
        //$diameters = Diameter::pluck('dn')->all();
        $diameters = DB::table('diameters')->pluck('dn')->all();

     $epipes = DB::select("SELECT * FROM pipesview ORDER BY area");

     return view('piping.indexpipe')->with('units', $units)->with('diameters', $diameters)->with('epipes', $epipes);



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $count = count($request->input('name'));

         $not_added = 0; /*variable para controlar el número de registros no insertados*/
        $added = 0; /*variable para controlar el número de registros insertados*/
                      for ($i = 0; $i < $count; $i++) {

                         //$pipesview_id = $request->input('pipesview_id');
                         //$name = $request->input('name')[$i];


                        DB::table('calc_notes')->insert([
                            'name' =>$request->input('name')[$i],
                            'pdms_linenumber' =>$request->input('pdms_linenumber')[0], //coloco en '0' porque siempre es el mismo pipesview_id
          

                         ]);

                            $added = $added+1;
                              

                      

                      }

                      return redirect()->route('pipes') 
                        ->with('success','SUCCESS! '.$added.' records were successfully added.');

                         

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
 
        $id=$request->id;
        


        $this->validate($request, [
            'id' => 'required',

        ]);
                  
                                
                                    Epipe::find($id)->update($request->all());
                                    return redirect()->route('pipes')
                                   ->with('success','SUCCESS! Record was successfully modified!');
                               

    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function gline(Request $request)
    {


        $hpipes =DB::select("SELECT * FROM hpipes");  

         if ((count($hpipes))>0){ // VALIDACIÓN DE EXISTENCIA DE DATA INICIAL
            //CONTROL INICIO PRINCIPAL NO-REQUEST 

            $id=$request->units_id[0];

        $hpipes_noarea =DB::select("SELECT * FROM hpipes WHERE area<>'TOTAL'"); 

        if (count($hpipes_noarea)>0){  // VALIDACIÓN SI HAY AREAS, EN CASO DE NO TENER INFO DE AREAS EN LAS LINEAS

            if (is_null($id)){

                $id=0;

                $lineprogress=DB::select("SELECT progress FROM hpipes WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

                while (($lineprogress)==NULL){

                    $id++;
                    $lineprogress=DB::select("SELECT progress FROM hpipes WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

                }
              }
            

            $lineprogress=DB::select("SELECT DATE_FORMAT(hpipes.date,'%d-%m-%Y') as date,area,progress FROM hpipes WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

             $units = DB::table('units')->pluck('name')->all();

            // Se verifica si el área tiene contenidos modelados. En caso de no tenerlos va a otra vista.

            if (count($lineprogress)==0){

                $selected_area=DB::select("SELECT units.name FROM units WHERE units.id=".$id);

                  return view('piping.glinepipe_NODATA')->with('units', $units)->with('selected_area', $selected_area);  

            }


           return view('piping.glinepipe')->with('units', $units)->with('lineprogress', $lineprogress);

            }else{

            return view('piping.glinepipe_NOHIST');

        }

            }else{return view('piping.glinepipe_NOHIST');}

    }

    public function glineTotal()
    {

        $hpipes =DB::select("SELECT * FROM hpipes"); 
        $mpipes =DB::select("SELECT * FROM mpipes"); 

         if ((count($hpipes))>0 OR (count($mpipes))>0){ // VALIDACIÓN DE EXISTENCIA DE DATA INICIAL
            //CONTROL INICIO PRINCIPAL NO-REQUEST 

            $lineprogress=DB::select("SELECT * FROM glinepipetotal");
            $lineprogress_count=DB::select("SELECT count(*) as count FROM glinepipetotal");
            $lineestimated=DB::select("SELECT * FROM mpipes WHERE area='TOTAL'");

            
           return view('piping.glinepipetotal')->with('lineprogress', $lineprogress)->with('lineprogress_count', $lineprogress_count)->with('lineestimated', $lineestimated);

            }else{

                        return view('piping.glinepipe_NOHIST');

                    }

    }

    public function destroy(Request $request)
    {
        
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
            // ->addColumn('action', function ($epipes) {
            //     return '<a onclick "" href="editpipe/'.$epipes->id.'" class="edit-pipe-modal btn btn-xs btn-primary" data-id ="'.$epipes->id.'" data-units_id ="'.$epipes->units_id.'" data-diameter ="'.$epipes->diameter.'" data-pdms_linenumber ="'.$epipes->pdms_linenumber.'" data-sec_number ="'.$epipes->sec_number.'" data-spec ="'.$epipes->spec.'" data-calc_notes ="'.$epipes->calc_notes.'" data-toggle="modal" data-target="#editpipeModal"> Calculation Note</a>&nbsp;';
            // })



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