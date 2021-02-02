<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use App\Item;
use App\Tequi;
use App\Pequi;
use App\Eequi;
use App\Eequisnew;
use App\Equisview;
use App\Unit;
use App\Area;
use App\Hequi;
use DB;
use Charts;

class DequiUiController extends Controller
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

     

    $eequis = DB::select("SELECT * FROM dequisfullview ORDER BY area");

     
      return Datatables::of($eequis)
            ->addColumn('action', function ($eequis) {
                return '<a onclick "" href="editequi/'.$eequis->id.'" class="edit-equi-modal btn btn-xs btn-primary" data-id ="'.$eequis->id.'" data-unit ="'.$eequis->unit.'" data-area ="'.$eequis->area.'"data-tequis_id ="'.$eequis->tequis_id.'" data-tag ="'.$eequis->tag.'" data-weight ="'.$eequis->weight.'" data-toggle="modal" data-target="#editequiModal"> Modify</a>&nbsp;

                <a href="delequi/'.$eequis->id.'" class="del-equi-modal btn btn-xs btn-danger" data-id ="'.$eequis->id.'" data-unit ="'.$eequis->unit.'" data-area ="'.$eequis->area.'"data-tequis_id ="'.$eequis->tequis_id.'" data-tag ="'.$eequis->tag.'" data-weight ="'.$eequis->weight.'" data-toggle="modal"data-target="#delequiModal"> Remove</a>';
            })

             ->make(true);



    }

         public function eequis(){


        return view('equipment.eequis');


    }

    public function eequisfullquery()
    {

         // GENERAR QUERY DE MODELADOS AUTOMATICAMENTE SEGUN STEPS

         $part1 = "SELECT eequisnews.id,eequisnews.units_id,eequisnews.areas_id,eequisnews.tequis_id,eequisnews.qty,
            (SELECT units.name FROM units WHERE units.id=eequisnews.units_id) AS unit,
            (SELECT areas.name FROM areas WHERE areas.id=eequisnews.areas_id) AS area,
            (SELECT tequis.name FROM tequis WHERE tequis.id=eequisnews.tequis_id) AS type_equi,
            (SELECT COUNT(*) FROM dequisfullview WHERE tequis_id=eequisnews.tequis_id AND areas_id=eequisnews.areas_id) AS modeled";
        
        $pequis = DB::select("SELECT percentage FROM pequis");
        $part2tmp = "";
        $returntemp = "";

        foreach ($pequis as $pequiss) {

            $part2tmp = ",(SELECT COUNT(*) FROM dequisfullview WHERE tequis_id=eequisnews.tequis_id AND areas_id=eequisnews.areas_id AND progress=".$pequiss->percentage.") AS modeled".$pequiss->percentage;           
                    
            $part2=$part2.$part2tmp;


        } 

        $eequisfullquery= $part1.$part2.' FROM eequisnews';
 
        // FIN GENERAR QUERY

        $eequisfull = DB::select($eequisfullquery);

                     return Datatables::of($eequisfull)
                     ->addColumn('action', function ($eequisfull) {
                return '<a href="deleequi/'.$eequisfull->id.'" class="del-eequis-modal btn btn-xs btn-danger" data-id ="'.$eequisfull->id.'" data-areas_id ="'.$eequisfull->areas_id.'" data-tequis_id ="'.$eequisfull->tequis_id.'" data-qty ="'.$eequisfull->qty.'" data-toggle="modal" data-target="#deleequisModal"> Remove</a>';
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
     $tequis = Tequi::pluck('name')->all();
     $hoursw = Tequi::pluck('hours')->all(); 
     $units = Unit::pluck('name')->all();
     $unitss =  Unit::pluck('name')->all();
     $areas = Area::pluck('name')->all();
     $areass =  Area::pluck('name')->all();


     $eequis = DB::select("SELECT * FROM equisview ORDER BY area");

     return view('equipment.indexequi')->with('tequis', $tequis)->with('units', $units)->with('areas', $areas)->with('eequis', $eequis)->with('unitss', $unitss)->with('areass', $areass);



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
                          $tequis_id = $request->input('tequis_id')[$i];
                          $qty = $request->input('qty')[$i];




                         $query = DB::select("SELECT areas_id,tequis_id,qty FROM eequisnews WHERE areas_id=".$areas_id." AND tequis_id=".$tequis_id);

                             /*validar si existe registro para cancelar o modificar*/   

                        if (!count($query)) {
                            
                            DB::table('eequisnews')->insert([
    
                            'areas_id' =>$request->input('areas_id')[$i],
                            'tequis_id' =>$request->input('tequis_id')[$i],
                            'qty' =>$request->input('qty')[$i],

                  

                         ]);

                            $added = $added+1;

                         }else{

                            $not_added = $not_added+1;

                         } 
                        
                      


                      }

                      if ($not_added > 0) {

                        return redirect()->route('eequis')
                        ->with('warning', 'WARNING! '.$added.' records were added to the database. '.$not_added.' already exist. Please, check the existing registers and make the respective modifications.');
                          
                      }else{

                          return redirect()->route('eequis') 
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
        $ideequis=DB::select("SELECT eequis.units_id,eequis.areas_id,eequis.tequis_id,eequis.hours,eequis.est_qty FROM `eequis` where eequis.id=$id");
        return view('equipment.editequi',compact('ideequis'))->with('ideequis', $ideequis);
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
        $tequis_id=$request->tequis_id;
        $est_qty=$request->est_qty;
        $tag=$request->tag;

        $this->validate($request, [
            'id' => 'required',
            'units_id' => 'required',
            'areas_id' => 'required',
            'tequis_id' => 'required',
            /*'est_qty' => 'required',*/
        ]);

         //$query = DB::select("SELECT units_id, tequis_id, est_qty FROM eequis WHERE units_id=".$units_id." AND tequis_id=".$tequis_id. " AND est_qty=".$est_qty);
         //$query = DB::select("SELECT tag FROM eequis WHERE tag="."'".$tag."'");

                             /*validar si existe registro para cancelar o modificar*/   


                                //if (!count($query)) {
                                
                                    Eequi::find($id)->update($request->all());

                                     /**Validar si excede el budget**/

                                    $budget = DB::select("SELECT weight FROM pmanagers WHERE name='equi'");
                                    $estimated = DB::select("SELECT * FROM pequis_view");


                                    return redirect()->route('equipments')
                                   ->with('success','SUCCESS! Record was successfully modified');

                                    
                         

                                    // }else{

                                        return redirect()->route('equipments')
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

        Eequisnew::find($id)->delete();
        return redirect()->route('eequis')
                        ->with('success','SUCCESS! Record were successfully removed.');
    }



    /*FUNCIONES FUERA DEL CRUD*/

    public function dequigetProgressByArea()
    {


        $dequigetprogressbyarea = DB::select("SELECT * FROM tpfmc_db.pequis_view");
                     return Datatables::of($dequigetprogressbyarea)
                         ->make(true);




    }
     /*FUNCION PARA EL GRÁFICO DE LÍNEAS*/
     public function dequidatatable()
    {
        

         $lineprogress = DB::select("SELECT date, SUM(count) AS count from hequis where progress<>0 group by date");


            return view('equipment/glineequi',['lineprogress'=>$lineprogress]);


    }

    public function updateMilestone()
    {

        $date_progress = DB::select("SELECT * from hequis");

                 foreach ($date_progress as $date_progressss) {

                    $milestone_date = DB::select("SELECT date from mequis where date='".$date_progressss->date."'");


                        if (count($milestone_date)>0) {

                            DB::table('hequis')->where('id', $date_progressss->id)->update(array('milestone' => 1));

                             }else{

                            DB::table('hequis')->where('id', $date_progressss->id)->update(array('milestone' => 0));    

                             }

                    
                    } 

            

    }

    public function gline(Request $request)
    {

         $hequis =DB::select("SELECT * FROM hequis");  

         if ((count($hequis))>0){ // VALIDACIÓN DE EXISTENCIA DE DATA INICIAL

            //CONTROL INICIO PRINCIPAL NO-REQUEST 

            $id=$request->units_id[0];


            if (is_null($id)){

                $id=0;

                $lineprogress=DB::select("SELECT progress FROM hequis WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

                while (($lineprogress)==NULL){

                    $id++;
                    $lineprogress=DB::select("SELECT progress FROM hequis WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

                }
              }

            $lineprogress=DB::select("SELECT DATE_FORMAT(hequis.date,'%d-%m-%Y') as date,area,progress FROM hequis WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

             $units = DB::table('units')->pluck('name')->all();

            // Se verifica si el área tiene contenidos modelados. En caso de no tenerlos va a otra vista.

            if (count($lineprogress)==0){

                $selected_area=DB::select("SELECT units.name FROM units WHERE units.id=".$id);

                  return view('equipment.glineequi_NODATA')->with('units', $units)->with('selected_area', $selected_area);  

            }


           return view('equipment.glineequi')->with('units', $units)->with('lineprogress', $lineprogress);

            }else{

            return view('equipment.glineequi_NOHIST');

        }

    }

    public function glineTotal()
    {

              $mequis =DB::select("SELECT * FROM mequis");  

         if ((count($mequis))>0 OR (count($mequis))>0){ // VALIDACIÓN DE EXISTENCIA DE DATA INICIAL



            $lineprogress=DB::select("SELECT DATE_FORMAT(hequis.date,'%d-%m-%Y') as date,area,progress FROM hequis WHERE area='TOTAL'");
            $lineprogress_count=DB::select("SELECT count(*) as count FROM glineequitotal");
            $lineestimated=DB::select("SELECT * FROM mequis WHERE area='TOTAL'");
            
           return view('equipment.glineequitotal')->with('lineprogress', $lineprogress)->with('lineprogress_count', $lineprogress_count)->with('lineestimated', $lineestimated);;

        }else{

            return view('equipment.glineequi_NOHIST');

        }


    }

   public function dequisfullquery(){


        $dequisfull = DB::select("SELECT * FROM dequisfullview;");

                     return Datatables::of($dequisfull)->make(true);


   } 


    public function modeled(){


        $dequisfullquery = DB::select("SELECT * FROM dequisfullview;");
        
        return view('equipment.modeledequi')->with('unit', $unit)->with('area', $area)->with('tag', $tag)->with('type_equi', $type_equi)->with('weight', $weight)->with('status', $status)->with('progress', $progress);


    }

    public function milestone(){

        $units = DB::table('units')->pluck('name')->all();
        return view('equipment.milestoneequi')->with('units', $units);


    }

    public function milestoneEqui()
    {

        $milestoneequi = DB::select("SELECT mequis.id, mequis.date,units.name AS area, mequis.quantity FROM mequis JOIN UNITS WHERE units.id=mequis.units_id ORDER BY mequis.date");
                     return Datatables::of($milestoneequi)
                     ->addColumn('action', function ($milestoneequi) {
                return '<a onclick "" href="editequi/'.$milestoneequi->id.'" class="edit-equi-modal btn btn-xs btn-primary" data-id ="'.$milestoneequi->id.'" data-date ="'.$milestoneequi->date.'" data-area ="'.$milestoneequi->area.'" data-qty ="'.$milestoneequi->quantity.'" data-toggle="modal" data-target="#editequiModal"> Modify</a>&nbsp;

                <a href="delequi/'.$milestoneequi->id.'" class="edit-equi-modal btn btn-xs btn-primary" data-id ="'.$milestoneequi->id.'" data-date ="'.$milestoneequi->date.'" data-area ="'.$milestoneequi->area.'" data-qty ="'.$milestoneequi->quantity.'" data-toggle="modal" data-target="#delequiModal"> Remove</a>';
            })
                         ->make(true);

    }

     public function createMilestoneEqui(Request $request)
    {
     $tequis = Tequi::pluck('name')->all();
     $hoursw = Tequi::pluck('hours')->all(); 
     $units = Unit::pluck('name')->all();
     $unitss =  Unit::pluck('name')->all();


     $eequis = DB::select("SELECT * FROM equisview ORDER BY area");

     return view('equipment.milestoneequi')->with('tequis', $tequis)->with('units', $units)->with('eequis', $eequis)->with('unitss', $unitss);



    }






}