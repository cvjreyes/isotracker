<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use App\Item;
use App\Tinst;
use App\Pinst;
use App\Einst;
use App\Einstsnew;
use App\Instsview;
use App\Unit;
use App\Area;
use App\Hinst;
use DB;
use Charts;

class DinstUiController extends Controller
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

     

    $einsts = DB::select("SELECT * FROM dinstsfullview ORDER BY area");

     
      return Datatables::of($einsts)
            ->addColumn('action', function ($einsts) {
                return '<a onclick "" href="editinst/'.$einsts->id.'" class="edit-inst-modal btn btn-xs btn-primary" data-id ="'.$einsts->id.'" data-unit ="'.$einsts->unit.'" data-area ="'.$einsts->area.'"data-tinsts_id ="'.$einsts->tinsts_id.'" data-tag ="'.$einsts->tag.'" data-weight ="'.$einsts->weight.'" data-toggle="modal" data-target="#editinstModal"> Modify</a>&nbsp;

                <a href="delinst/'.$einsts->id.'" class="del-inst-modal btn btn-xs btn-danger" data-id ="'.$einsts->id.'" data-unit ="'.$einsts->unit.'" data-area ="'.$einsts->area.'"data-tinsts_id ="'.$einsts->tinsts_id.'" data-tag ="'.$einsts->tag.'" data-weight ="'.$einsts->weight.'" data-toggle="modal"data-target="#delinstModal"> Remove</a>';
            })

             ->make(true);



    }

         public function einsts(){


        return view('instruments.einsts');


    }

    public function einstsfullquery()
    {


// GENERAR QUERY DE MODELADOS AUTOMATICAMENTE SEGUN STEPS

         $part1 = "SELECT einstsnews.id,einstsnews.units_id,einstsnews.areas_id,einstsnews.tinsts_id,einstsnews.qty,
            (SELECT units.name FROM units WHERE units.id=einstsnews.units_id) AS unit,
            (SELECT areas.name FROM areas WHERE areas.id=einstsnews.areas_id) AS area,
            (SELECT tinsts.name FROM tinsts WHERE tinsts.id=einstsnews.tinsts_id) AS type_inst,
            (SELECT COUNT(*) FROM dinstsfullview WHERE tinsts_id=einstsnews.tinsts_id AND areas_id=einstsnews.areas_id) AS modeled";
        
        $pinsts = DB::select("SELECT percentage FROM pinsts");
        $part2tmp = "";
        $returntemp = "";

        foreach ($pinsts as $pinstss) {

            $part2tmp = ",(SELECT COUNT(*) FROM dinstsfullview WHERE tinsts_id=einstsnews.tinsts_id AND areas_id=einstsnews.areas_id AND progress=".$pinstss->percentage.") AS modeled".$pinstss->percentage;           
                    
            $part2=$part2.$part2tmp;


        } 

        $einstsfullquery= $part1.$part2.' FROM einstsnews';
 
        // FIN GENERAR QUERY

        $einstsfull = DB::select($einstsfullquery);

                     return Datatables::of($einstsfull)
                     ->addColumn('action', function ($einstsfull) {
                return '<a href="deleinst/'.$einstsfull->id.'" class="del-einsts-modal btn btn-xs btn-danger" data-id ="'.$einstsfull->id.'" data-areas_id ="'.$einstsfull->areas_id.'" data-tinsts_id ="'.$einstsfull->tinsts_id.'" data-qty ="'.$einstsfull->qty.'" data-toggle="modal" data-target="#deleinstsModal"> Remove</a>';
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
     $tinsts = Tinst::pluck('name')->all();
     $hoursw = Tinst::pluck('hours')->all(); 
     $units = Unit::pluck('name')->all();
     $unitss =  Unit::pluck('name')->all();
     $areas = Area::pluck('name')->all();
     $areass =  Area::pluck('name')->all();


     $einsts = DB::select("SELECT * FROM instsview ORDER BY area");

     return view('instruments.indexinst')->with('tinsts', $tinsts)->with('units', $units)->with('areas', $areas)->with('einsts', $einsts)->with('unitss', $unitss)->with('areass', $areass);



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
                          $tinsts_id = $request->input('tinsts_id')[$i];
                          $qty = $request->input('qty')[$i];




                         $query = DB::select("SELECT areas_id,tinsts_id,qty FROM einstsnews WHERE areas_id=".$areas_id." AND tinsts_id=".$tinsts_id);

                             /*validar si existe registro para cancelar o modificar*/   

                        if (!count($query)) {
                            
                            DB::table('einstsnews')->insert([
    
                            'areas_id' =>$request->input('areas_id')[$i],
                            'tinsts_id' =>$request->input('tinsts_id')[$i],
                            'qty' =>$request->input('qty')[$i],

                  

                         ]);

                            $added = $added+1;

                         }else{

                            $not_added = $not_added+1;

                         } 
                        
                      


                      }

                      if ($not_added > 0) {

                        return redirect()->route('einsts')
                        ->with('warning', 'WARNING! '.$added.' records were added to the database. '.$not_added.' already exist. Please, check the existing registers and make the respective modifications.');
                          
                      }else{

                          return redirect()->route('einsts') 
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
        $ideinsts=DB::select("SELECT einsts.units_id,einsts.areas_id,einsts.tinsts_id,einsts.hours,einsts.est_qty FROM `einsts` where einsts.id=$id");
        return view('inst.editinst',compact('ideinsts'))->with('ideinsts', $ideinsts);
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
        $tinsts_id=$request->tinsts_id;
        $est_qty=$request->est_qty;
        $tag=$request->tag;

        $this->validate($request, [
            'id' => 'rinstred',
            'units_id' => 'rinstred',
            'areas_id' => 'rinstred',
            'tinsts_id' => 'rinstred',
            /*'est_qty' => 'rinstred',*/
        ]);

         //$query = DB::select("SELECT units_id, tinsts_id, est_qty FROM einsts WHERE units_id=".$units_id." AND tinsts_id=".$tinsts_id. " AND est_qty=".$est_qty);
         //$query = DB::select("SELECT tag FROM einsts WHERE tag="."'".$tag."'");

                             /*validar si existe registro para cancelar o modificar*/   


                                //if (!count($query)) {
                                
                                    Einst::find($id)->update($request->all());

                                     /**Validar si excede el budget**/

                                    $budget = DB::select("SELECT weight FROM pmanagers WHERE name='inst'");
                                    $estimated = DB::select("SELECT * FROM pinsts_view");


                                    return redirect()->route('insts')
                                   ->with('success','SUCCESS! Record was successfully modified');

                                    
                         

                                    // }else{

                                        return redirect()->route('insts')
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

        Einstsnew::find($id)->delete();
        return redirect()->route('einsts')
                        ->with('success','SUCCESS! Record were successfully removed.');
    }



    /*FUNCIONES FUERA DEL CRUD*/

    public function dinstgetProgressByArea()
    {


        $dinstgetprogressbyarea = DB::select("SELECT * FROM tpfmc_db.pinsts_view");
                     return Datatables::of($dinstgetprogressbyarea)
                         ->make(true);




    }
     /*FUNCION PARA EL GRÁFICO DE LÍNEAS*/
     public function dinstdatatable()
    {
        

         $lineprogress = DB::select("SELECT date, SUM(count) AS count from hinsts where progress<>0 group by date");


            return view('inst/glineinst',['lineprogress'=>$lineprogress]);


    }

    public function updateMilestone()
    {

        $date_progress = DB::select("SELECT * from hinsts");

                 foreach ($date_progress as $date_progressss) {

                    $milestone_date = DB::select("SELECT date from minsts where date='".$date_progressss->date."'");


                        if (count($milestone_date)>0) {

                            DB::table('hinsts')->where('id', $date_progressss->id)->update(array('milestone' => 1));

                             }else{

                            DB::table('hinsts')->where('id', $date_progressss->id)->update(array('milestone' => 0));    

                             }

                    
                    } 

            

    }

    public function gline(Request $request)
    {

         $hinsts =DB::select("SELECT * FROM hinsts");  

         if ((count($hinsts))>0){ // VALIDACIÓN DE EXISTENCIA DE DATA INICIAL

            //CONTROL INICIO PRINCIPAL NO-REQUEST 

            $id=$request->units_id[0];


            if (is_null($id)){

                $id=0;

                $lineprogress=DB::select("SELECT progress FROM hinsts WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

                while (($lineprogress)==NULL){

                    $id++;
                    $lineprogress=DB::select("SELECT progress FROM hinsts WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

                }
              }

            $lineprogress=DB::select("SELECT DATE_FORMAT(hinsts.date,'%d-%m-%Y') as date,area,progress FROM hinsts WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

             $units = DB::table('units')->pluck('name')->all();

            // Se verifica si el área tiene contenidos modelados. En caso de no tenerlos va a otra vista.

            if (count($lineprogress)==0){

                $selected_area=DB::select("SELECT units.name FROM units WHERE units.id=".$id);

                  return view('inst.glineinst_NODATA')->with('units', $units)->with('selected_area', $selected_area);  

            }


           return view('instruments.glineinst')->with('units', $units)->with('lineprogress', $lineprogress);

            }else{

            return view('instruments.glineinst_NOHIST');

        }

    }

    public function glineTotal()
    {

              $minsts =DB::select("SELECT * FROM minsts");  

         if ((count($minsts))>0 OR (count($minsts))>0){ // VALIDACIÓN DE EXISTENCIA DE DATA INICIAL



            $lineprogress=DB::select("SELECT DATE_FORMAT(hinsts.date,'%d-%m-%Y') as date,area,progress FROM hinsts WHERE area='TOTAL'");
            $lineprogress_count=DB::select("SELECT count(*) as count FROM glineinsttotal");
            $lineestimated=DB::select("SELECT * FROM minsts WHERE area='TOTAL'");
            
           return view('instruments.glineinsttotal')->with('lineprogress', $lineprogress)->with('lineprogress_count', $lineprogress_count)->with('lineestimated', $lineestimated);;

        }else{

            return view('instruments.glineinst_NOHIST');

        }


    }

   public function dinstsfullquery(){


        $dinstsfull = DB::select("SELECT * FROM dinstsfullview;");

                     return Datatables::of($dinstsfull)->make(true);


   } 


    public function modeled(){


        $dinstsfullquery = DB::select("SELECT * FROM dinstsfullview;");
        
        return view('instruments.modeledinst')->with('unit', $unit)->with('area', $area)->with('tag', $tag)->with('type_inst', $type_inst)->with('weight', $weight)->with('status', $status)->with('progress', $progress);


    }

    public function milestone(){

        $units = DB::table('units')->pluck('name')->all();
        return view('instruments.milestoneinst')->with('units', $units);


    }

    public function milestoneinst()
    {

        $milestoneinst = DB::select("SELECT minsts.id, minsts.date,units.name AS area, minsts.quantity FROM minsts JOIN UNITS WHERE units.id=minsts.units_id ORDER BY minsts.date");
                     return Datatables::of($milestoneinst)
                     ->addColumn('action', function ($milestoneinst) {
                return '<a onclick "" href="editinst/'.$milestoneinst->id.'" class="edit-inst-modal btn btn-xs btn-primary" data-id ="'.$milestoneinst->id.'" data-date ="'.$milestoneinst->date.'" data-area ="'.$milestoneinst->area.'" data-qty ="'.$milestoneinst->quantity.'" data-toggle="modal" data-target="#editinstModal"> Modify</a>&nbsp;

                <a href="delinst/'.$milestoneinst->id.'" class="edit-inst-modal btn btn-xs btn-primary" data-id ="'.$milestoneinst->id.'" data-date ="'.$milestoneinst->date.'" data-area ="'.$milestoneinst->area.'" data-qty ="'.$milestoneinst->quantity.'" data-toggle="modal" data-target="#delinstModal"> Remove</a>';
            })
                         ->make(true);

    }

     public function createMilestoneinst(Request $request)
    {
     $tinsts = Tinst::pluck('name')->all();
     $hoursw = Tinst::pluck('hours')->all(); 
     $units = Unit::pluck('name')->all();
     $unitss =  Unit::pluck('name')->all();


     $einsts = DB::select("SELECT * FROM instsview ORDER BY area");

     return view('inst.milestoneinst')->with('tinsts', $tinsts)->with('units', $units)->with('einsts', $einsts)->with('unitss', $unitss);



    }






}