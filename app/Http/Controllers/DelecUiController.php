<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use App\Item;
use App\Telec;
use App\Pelec;
use App\Eelec;
use App\Eelecsnew;
use App\elecsview;
use App\Unit;
use App\Area;
use App\Helec;
use DB;
use Charts;

class DelecUiController extends Controller
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

     

    $eelecs = DB::select("SELECT * FROM delecsfullview ORDER BY area");

     
      return Datatables::of($eelecs)
            ->addColumn('action', function ($eelecs) {
                return '<a onclick "" href="editelec/'.$eelecs->id.'" class="edit-elec-modal btn btn-xs btn-primary" data-id ="'.$eelecs->id.'" data-unit ="'.$eelecs->unit.'" data-area ="'.$eelecs->area.'"data-telecs_id ="'.$eelecs->telecs_id.'" data-tag ="'.$eelecs->tag.'" data-weight ="'.$eelecs->weight.'" data-toggle="modal" data-target="#editelecModal"> Modify</a>&nbsp;

                <a href="delelec/'.$eelecs->id.'" class="del-elec-modal btn btn-xs btn-danger" data-id ="'.$eelecs->id.'" data-unit ="'.$eelecs->unit.'" data-area ="'.$eelecs->area.'"data-telecs_id ="'.$eelecs->telecs_id.'" data-tag ="'.$eelecs->tag.'" data-weight ="'.$eelecs->weight.'" data-toggle="modal"data-target="#delelecModal"> Remove</a>';
            })

             ->make(true);



    }

         public function eelecs(){


        return view('electrical.eelecs');


    }

    public function eelecsfullquery()
    {

// GENERAR QUERY DE MODELADOS AUTOMATICAMENTE SEGUN STEPS

         $part1 = "SELECT eelecsnews.id,eelecsnews.units_id,eelecsnews.areas_id,eelecsnews.telecs_id,eelecsnews.qty,
            (SELECT units.name FROM units WHERE units.id=eelecsnews.units_id) AS unit,
            (SELECT areas.name FROM areas WHERE areas.id=eelecsnews.areas_id) AS area,
            (SELECT telecs.name FROM telecs WHERE telecs.id=eelecsnews.telecs_id) AS type_elec,
            (SELECT COUNT(*) FROM delecsfullview WHERE telecs_id=eelecsnews.telecs_id AND areas_id=eelecsnews.areas_id) AS modeled";
        
        $pelecs = DB::select("SELECT percentage FROM pelecs");
        $part2tmp = "";
        $returntemp = "";

        foreach ($pelecs as $pelecss) {

            $part2tmp = ",(SELECT COUNT(*) FROM delecsfullview WHERE telecs_id=eelecsnews.telecs_id AND areas_id=eelecsnews.areas_id AND progress=".$pelecss->percentage.") AS modeled".$pelecss->percentage;           
                    
            $part2=$part2.$part2tmp;


        } 

        $eelecsfullquery= $part1.$part2.' FROM eelecsnews';
 
        // FIN GENERAR QUERY

        $eelecsfull = DB::select($eelecsfullquery);

                     return Datatables::of($eelecsfull)
                     ->addColumn('action', function ($eelecsfull) {
                return '<a href="deleelec/'.$eelecsfull->id.'" class="del-eelecs-modal btn btn-xs btn-danger" data-id ="'.$eelecsfull->id.'" data-areas_id ="'.$eelecsfull->areas_id.'" data-telecs_id ="'.$eelecsfull->telecs_id.'" data-qty ="'.$eelecsfull->qty.'" data-toggle="modal" data-target="#deleelecsModal"> Remove</a>';
            })
                         ->make(true);

    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     $telecs = Telec::pluck('name')->all();
     $hoursw = Telec::pluck('hours')->all(); 
     $units = Unit::pluck('name')->all();
     $unitss =  Unit::pluck('name')->all();
     $areas = Area::pluck('name')->all();
     $areass =  Area::pluck('name')->all();


     $eelecs = DB::select("SELECT * FROM elecsview ORDER BY area");

     return view('electrical.indexelec')->with('telecs', $telecs)->with('units', $units)->with('areas', $areas)->with('eelecs', $eelecs)->with('unitss', $unitss)->with('areass', $areass);



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
                          $telecs_id = $request->input('telecs_id')[$i];
                          $qty = $request->input('qty')[$i];




                         $query = DB::select("SELECT areas_id,telecs_id,qty FROM eelecsnews WHERE areas_id=".$areas_id." AND telecs_id=".$telecs_id);

                             /*validar si existe registro para cancelar o modificar*/   

                        if (!count($query)) {
                            
                            DB::table('eelecsnews')->insert([
    
                            'areas_id' =>$request->input('areas_id')[$i],
                            'telecs_id' =>$request->input('telecs_id')[$i],
                            'qty' =>$request->input('qty')[$i],

                  

                         ]);

                            $added = $added+1;

                         }else{

                            $not_added = $not_added+1;

                         } 
                        
                      


                      }

                      if ($not_added > 0) {

                        return redirect()->route('eelecs')
                        ->with('warning', 'WARNING! '.$added.' records were added to the database. '.$not_added.' already exist. Please, check the existing registers and make the respective modifications.');
                          
                      }else{

                          return redirect()->route('eelecs') 
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
        $item = Item::find($id);
        return view('ItemCRUD.show',compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ideelecs=DB::select("SELECT eelecs.units_id,eelecs.areas_id,eelecs.telecs_id,eelecs.hours,eelecs.est_qty FROM `eelecs` where eelecs.id=$id");
        return view('elec.editelec',compact('ideelecs'))->with('ideelecs', $ideelecs);
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
        $units_id=$request->units_id;
        $areas_id=$request->areas_id;
        $telecs_id=$request->telecs_id;
        $est_qty=$request->est_qty;
        $tag=$request->tag;

        $this->validate($request, [
            'id' => 'relecred',
            'units_id' => 'relecred',
            'areas_id' => 'relecred',
            'telecs_id' => 'relecred',
            /*'est_qty' => 'relecred',*/
        ]);

         //$query = DB::select("SELECT units_id, telecs_id, est_qty FROM eelecs WHERE units_id=".$units_id." AND telecs_id=".$telecs_id. " AND est_qty=".$est_qty);
         //$query = DB::select("SELECT tag FROM eelecs WHERE tag="."'".$tag."'");

                             /*validar si existe registro para cancelar o modificar*/   


                                //if (!count($query)) {
                                
                                    Eelec::find($id)->update($request->all());

                                     /**Validar si excede el budget**/

                                    $budget = DB::select("SELECT weight FROM pmanagers WHERE name='elec'");
                                    $estimated = DB::select("SELECT * FROM pelecs_view");


                                    return redirect()->route('elecs')
                                   ->with('success','SUCCESS! Record was successfully modified');

                                    
                         

                                    // }else{

                                        return redirect()->route('elecs')
                                        ->with('danger','ERROR! The registry was not modified because an attempt is made to duplicate an existing one!. Please, check the existing registers and make the respective modifications.');
                                    
                                    // } 

    
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

        Eelecsnew::find($id)->delete();
        return redirect()->route('eelecs')
                        ->with('success','SUCCESS! Record were successfully removed.');
    }



    /*FUNCIONES FUERA DEL CRUD*/

    public function delecgetProgressByArea()
    {


        $delecgetprogressbyarea = DB::select("SELECT * FROM tpfmc_db.pelecs_view");
                     return Datatables::of($delecgetprogressbyarea)
                         ->make(true);




    }
     /*FUNCION PARA EL GRÁFICO DE LÍNEAS*/
     public function delecdatatable()
    {
        

         $lineprogress = DB::select("SELECT date, SUM(count) AS count from helecs where progress<>0 group by date");


            return view('elec/glineelec',['lineprogress'=>$lineprogress]);


    }

    public function updateMilestone()
    {

        $date_progress = DB::select("SELECT * from helecs");

                 foreach ($date_progress as $date_progressss) {

                    $milestone_date = DB::select("SELECT date from melecs where date='".$date_progressss->date."'");


                        if (count($milestone_date)>0) {

                            DB::table('helecs')->where('id', $date_progressss->id)->update(array('milestone' => 1));

                             }else{

                            DB::table('helecs')->where('id', $date_progressss->id)->update(array('milestone' => 0));    

                             }

                    
                    } 

            

    }

    public function gline(Request $request)
    {

         $helecs =DB::select("SELECT * FROM helecs");  

         if ((count($helecs))>0){ // VALIDACIÓN DE EXISTENCIA DE DATA INICIAL

            //CONTROL INICIO PRINCIPAL NO-REQUEST 

            $id=$request->units_id[0];


            if (is_null($id)){

                $id=0;

                $lineprogress=DB::select("SELECT progress FROM helecs WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

                while (($lineprogress)==NULL){

                    $id++;
                    $lineprogress=DB::select("SELECT progress FROM helecs WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

                }
              }

            $lineprogress=DB::select("SELECT DATE_FORMAT(helecs.date,'%d-%m-%Y') as date,area,progress FROM helecs WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

             $units = DB::table('units')->pluck('name')->all();

            // Se verifica si el área tiene contenidos modelados. En caso de no tenerlos va a otra vista.

            if (count($lineprogress)==0){

                $selected_area=DB::select("SELECT units.name FROM units WHERE units.id=".$id);

                  return view('elec.glineelec_NODATA')->with('units', $units)->with('selected_area', $selected_area);  

            }


           return view('electrical.glineelec')->with('units', $units)->with('lineprogress', $lineprogress);

            }else{

            return view('electrical.glineelec_NOHIST');

        }

    }

    public function glineTotal()
    {

              $melecs =DB::select("SELECT * FROM melecs");  

         if ((count($melecs))>0 OR (count($melecs))>0){ // VALIDACIÓN DE EXISTENCIA DE DATA INICIAL



            $lineprogress=DB::select("SELECT DATE_FORMAT(helecs.date,'%d-%m-%Y') as date,area,progress FROM helecs WHERE area='TOTAL'");
            $lineprogress_count=DB::select("SELECT count(*) as count FROM glineelectotal");
            $lineestimated=DB::select("SELECT * FROM melecs WHERE area='TOTAL'");
            
           return view('electrical.glineelectotal')->with('lineprogress', $lineprogress)->with('lineprogress_count', $lineprogress_count)->with('lineestimated', $lineestimated);;

        }else{

            return view('electrical.glineelec_NOHIST');

        }


    }

   public function delecsfullquery(){


        $delecsfull = DB::select("SELECT * FROM delecsfullview;");

                     return Datatables::of($delecsfull)->make(true);


   } 


    public function modeled(){


        $delecsfullquery = DB::select("SELECT * FROM delecsfullview;");
        
        return view('electrical.modeledelec')->with('unit', $unit)->with('area', $area)->with('tag', $tag)->with('type_elec', $type_elec)->with('weight', $weight)->with('status', $status)->with('progress', $progress);


    }

    public function milestone(){

        $units = DB::table('units')->pluck('name')->all();
        return view('electrical.milestoneelec')->with('units', $units);


    }

    public function milestoneelec()
    {

        $milestoneelec = DB::select("SELECT melecs.id, melecs.date,units.name AS area, melecs.quantity FROM melecs JOIN UNITS WHERE units.id=melecs.units_id ORDER BY melecs.date");
                     return Datatables::of($milestoneelec)
                     ->addColumn('action', function ($milestoneelec) {
                return '<a onclick "" href="editelec/'.$milestoneelec->id.'" class="edit-elec-modal btn btn-xs btn-primary" data-id ="'.$milestoneelec->id.'" data-date ="'.$milestoneelec->date.'" data-area ="'.$milestoneelec->area.'" data-qty ="'.$milestoneelec->quantity.'" data-toggle="modal" data-target="#editelecModal"> Modify</a>&nbsp;

                <a href="delelec/'.$milestoneelec->id.'" class="edit-elec-modal btn btn-xs btn-primary" data-id ="'.$milestoneelec->id.'" data-date ="'.$milestoneelec->date.'" data-area ="'.$milestoneelec->area.'" data-qty ="'.$milestoneelec->quantity.'" data-toggle="modal" data-target="#delelecModal"> Remove</a>';
            })
                         ->make(true);

    }

     public function createMilestoneelec(Request $request)
    {
     $telecs = Telec::pluck('name')->all();
     $hoursw = Telec::pluck('hours')->all(); 
     $units = Unit::pluck('name')->all();
     $unitss =  Unit::pluck('name')->all();


     $eelecs = DB::select("SELECT * FROM elecsview ORDER BY area");

     return view('elec.milestoneelec')->with('telecs', $telecs)->with('units', $units)->with('eelecs', $eelecs)->with('unitss', $unitss);



    }






}