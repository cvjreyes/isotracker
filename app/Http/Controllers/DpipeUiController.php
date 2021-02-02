<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;

use App\Epipe;
use App\Epipesnew;
use App\Pipesview;
use App\Unit;
use App\Area;
use App\Diameter;
use App\Calc_note;

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

    $epipes= DB::select("SELECT * FROM dpipesfullview");




    
       return Datatables::of($epipes)
            ->addColumn('action', function ($epipes) {

                $cnote = DB::select("SELECT name FROM calc_notes WHERE pdms_linenumber="."'".$epipes->pdms_linenumber."'");


                if (count($cnote)){  


                    $class="del-cnotes-modal btn btn-xs btn-danger";
                    $classcnv="edit-cnotes-modal btn btn-xs btn-success";
                    $data_target="#delcnotesModal";

                }else{

                    $class="del-cnotes-modal btn btn-xs btn-default";
                    $classcnv="edit-cnotes-modal btn btn-xs btn-default";
                    $data_target="#DUMMYdelcnotesModal";
                }


                $progress = DB::select("SELECT (sum((pid*w_pid)+(iso*w_iso)+(stress*w_stress)+(support*w_support))/sum(weight)) as progress 
                    FROM dpipesfullview WHERE id=".$epipes->id); // para validar si tiene progreso.

                $holdspipes = DB::select("SELECT DISTINCT dpipesnews_id,holds FROM holds WHERE dpipesnews_id=".$epipes->id);
                foreach ($cnote as $cnotes) {
                    //echo $cnotes->name;
                }

              if ($progress[0]->progress>0 and $holdspipes[0]->holds!=''){  

                return '<a onclick="cnote('."'".$epipes->tag."'".')" href="" class="'.$classcnv.'" data-id ="'.$epipes->id.'" data-unit ="'.$epipes->unit.'" data-area ="'.$epipes->area.'" data-diameter_inch ="'.$epipes->diameter_inch.'" data-tag ="'.$epipes->tag.'" data-calc_notes ="'.$epipes->calc_notes.'" data-toggle="modal" data-target="#showcnotesModa">View CN</a>&nbsp;

                <a onclick="enviar('.$epipes->id.')" href="" class="progress-pipe-modal btn btn-xs btn-success" data-id ="'.$epipes->id.'" data-unit ="'.$epipes->unit.'" data-area ="'.$epipes->area.'" data-diameter_inch ="'.$epipes->diameter.'" data-tag ="'.$epipes->tag.'" data-calc_notes ="'.$epipes->calc_notes.'" data-toggle="modal" data-target="#progresspipeModa">Progress</a>&nbsp;

                <a onclick="hldspipes('."'".$epipes->tag."'".')" class="edit-holds-modal btn btn-xs btn-danger" data-tag ="'.$epipes->tag.'"> Holds</a>&nbsp;';

               

            }else if($progress[0]->progress>0 AND $holdspipes[0]->holds==''){

                return '<a onclick="cnote('."'".$epipes->tag."'".')" href="" class="'.$classcnv.'" data-id ="'.$epipes->id.'" data-unit ="'.$epipes->unit.'" data-area ="'.$epipes->area.'" data-diameter_inch ="'.$epipes->diameter_inch.'" data-tag ="'.$epipes->tag.'" data-calc_notes ="'.$epipes->calc_notes.'" data-toggle="modal" data-target="#showcnotesModa">View CN</a>&nbsp;

                <a onclick="enviar('.$epipes->id.')" href="" class="progress-pipe-modal btn btn-xs btn-success" data-id ="'.$epipes->id.'" data-unit ="'.$epipes->unit.'" data-area ="'.$epipes->area.'" data-diameter_inch ="'.$epipes->diameter.'" data-tag ="'.$epipes->tag.'" data-calc_notes ="'.$epipes->calc_notes.'" data-toggle="modal" data-target="#progresspipeModa">Progress</a>&nbsp;

                <a onclick "hldspipes('."'".$epipes->tag."'".')" class="edit-holds-modal btn btn-xs btn-default" data-tag ="'.$epipes->tag.'"> Holds</a>&nbsp;';


            }else if($progress[0]->progress==0 AND $holdspipes[0]->holds!=''){

                return '<a onclick="cnote('."'".$epipes->tag."'".')" href="" class="'.$classcnv.'" data-id ="'.$epipes->id.'" data-unit ="'.$epipes->unit.'" data-area ="'.$epipes->area.'" data-diameter_inch ="'.$epipes->diameter_inch.'" data-tag ="'.$epipes->tag.'" data-calc_notes ="'.$epipes->calc_notes.'" data-toggle="modal" data-target="#showcnotesModa">View CN</a>&nbsp;

                <a onclick="enviar('.$epipes->id.')" href="" class="progress-pipe-modal btn btn-xs btn-success" data-id ="'.$epipes->id.'" data-unit ="'.$epipes->unit.'" data-area ="'.$epipes->area.'" data-diameter_inch ="'.$epipes->diameter.'" data-tag ="'.$epipes->tag.'" data-calc_notes ="'.$epipes->calc_notes.'" data-toggle="modal" data-target="#progresspipeModa">Progress</a>&nbsp;

                
                <a onclick="hldspipes('."'".$epipes->tag."'".')" class="edit-holds-modal btn btn-xs btn-danger" data-tag ="'.$epipes->tag.'"> Holds</a>&nbsp;';


            }else{
                return '

                    <a onclick="cnote('."'".$epipes->tag."'".')" href="" class="'.$classcnv.'" data-id ="'.$epipes->id.'" data-unit ="'.$epipes->unit.'" data-area ="'.$epipes->area.'" data-diameter_inch ="'.$epipes->diameter_inch.'" data-tag ="'.$epipes->tag.'" data-calc_notes ="'.$epipes->calc_notes.'" data-toggle="modal" data-target="#showcnotesModa">View CN</a>&nbsp;

                <a onclick="enviar('.$epipes->id.')" href="" class="progress-pipe-modal btn btn-xs btn-default" data-id ="'.$epipes->id.'" data-unit ="'.$epipes->unit.'" data-area ="'.$epipes->area.'" data-diameter_inch ="'.$epipes->diameter_inch.'" data-tag ="'.$epipes->tag.'" data-calc_notes ="'.$epipes->calc_notes.'" data-toggle="modal" data-target="#progresspipeModa">Progress</a>&nbsp;
                
                    <a onclick "hldspipes('."'".$epipes->tag."'".')" class="edit-holds-modal btn btn-xs btn-default" data-tag ="'.$epipes->tag.'"> Holds</a>&nbsp;';

            

            }
        })
            ->make(true);

       

    }

     public function epipes(){


        return view('piping.epipes');


    }

    public function epipesfullquery()
    {




        $epipesfull = DB::select("SELECT epipesnews.id,epipesnews.units_id,epipesnews.areas_id,epipesnews.tpipes_id,epipesnews.qty,
(SELECT units.name FROM units WHERE units.id=epipesnews.units_id) AS unit,
(SELECT areas.name FROM areas WHERE areas.id=epipesnews.areas_id) AS area,
(SELECT tpipes.code FROM tpipes WHERE tpipes.id=epipesnews.tpipes_id) AS type_line,
(SELECT COUNT(*) FROM dpipesfullview WHERE tpipes_id=epipesnews.tpipes_id AND areas_id=epipesnews.areas_id) AS modeled
FROM epipesnews
");

                     return Datatables::of($epipesfull)
                     ->addColumn('action', function ($epipesfull) {
                return '<a href="delepipe/'.$epipesfull->id.'" class="del-epipes-modal btn btn-xs btn-danger" data-id ="'.$epipesfull->id.'" data-areas_id ="'.$epipesfull->areas_id.'" data-tpipes_id ="'.$epipesfull->tpipes_id.'" data-qty ="'.$epipesfull->qty.'" data-modeled ="'.$epipesfull->modeled.'" data-toggle="modal" data-target="#delepipesModal"> Remove</a>';
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



        $count = count($request->input('areas_id'));
  

        $not_added = 0; /*variable para controlar el número de registros no insertados*/
        $added = 0; /*variable para controlar el número de registros insertados*/
                      for ($i = 0; $i < $count; $i++) {


                        
                          $areas_id = $request->input('areas_id')[$i];
                          $tpipes_id = $request->input('tpipes_id')[$i];
                          $qty = $request->input('qty')[$i];




                         $query = DB::select("SELECT areas_id,tpipes_id,qty FROM epipesnews WHERE areas_id=".$areas_id." AND tpipes_id=".$tpipes_id);

                             /*validar si existe registro para cancelar o modificar*/   

                        if (!count($query)) {
                            
                            DB::table('epipesnews')->insert([
    
                            'areas_id' =>$request->input('areas_id')[$i],
                            'tpipes_id' =>$request->input('tpipes_id')[$i],
                            'qty' =>$request->input('qty')[$i],

                  

                         ]);

                            $added = $added+1;

                         }else{

                            $not_added = $not_added+1;

                         } 
                        
                      


                      }

                      if ($not_added > 0) {

                        return redirect()->route('epipes')
                        ->with('warning', 'WARNING! '.$added.' records were added to the database. '.$not_added.' already exist. Please, check the existing registers and make the respective modifications.');
                          
                      }else{

                          return redirect()->route('epipes') 
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
       $id=$request->id;

        Epipesnew::find($id)->delete();
        return redirect()->route('epipes')
                        ->with('success','SUCCESS! Records were successfully removed.');  
    }

    public function destroycnotes(Request $request)
    {
      
            $pdms_linenumber=$request->pdms_linenumber;

        DB::table('calc_notes')->where('pdms_linenumber','=',$pdms_linenumber)->delete();
        return redirect()->route('pipes')
                        ->with('success','SUCCESS! Record were successfully removed.');


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
    // metodos holds

    public function holds(){


        return view('piping.holds');


    }

     public function holdsPipes()
    {
    
            $holdspipes = DB::select("SELECT DISTINCT dpipesnews_id AS id, dpipesnews.tag FROM holds JOIN dpipesnews WHERE dpipesnews.id=holds.dpipesnews_id");
                      return Datatables::of($holdspipes)
                      ->addColumn('action', function ($holdspipes) {
                        return '<a onclick="hldspipes('."'".$holdspipes->tag."'".')" class="edit-holds-modal btn btn-xs btn-success" data-tag ="'.$holdspipes->tag.'"> ViewHolds</a>&nbsp;';
                        

                        // if($holdspipes[0]->holds!=''){
                        //     return '<a onclick="hldspipes('."'".$holdspipes->tag."'".')" class="edit-holds-modal btn btn-xs btn-success" data-tag ="'.$holdspipes->tag.'"> ViewHolds</a>&nbsp;';
                 
               

                        // }else{
                        //     return '<a onclick="hldspipes('."'".$holdspipes->tag."'".')" class="edit-holds-modal btn btn-xs btn-danger" data-tag ="'.$holdspipes->tag.'"> NoHolds</a>&nbsp;';


                        // }

                    })


                      ->make(true);

    }
     public function jshold(){


        return view('piping.jshold');


    }
}
