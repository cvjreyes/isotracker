<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use App\Item;
use App\Tcivil;
use App\Pcivil;
use App\Ecivil;
use App\Ecivilsnew;
use App\Civilsview;
use App\Unit;
use App\Area;
use App\Hcivil;
use DB;
use Charts;

class DcivilUiController extends Controller
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

     

    $ecivils = DB::select("SELECT * FROM dcivilsfullview ORDER BY area");

     
      return Datatables::of($ecivils)
            ->addColumn('action', function ($ecivils) {
                return '<a onclick "" href="editcivil/'.$ecivils->id.'" class="edit-civil-modal btn btn-xs btn-primary" data-id ="'.$ecivils->id.'" data-unit ="'.$ecivils->unit.'" data-area ="'.$ecivils->area.'"data-tcivils_id ="'.$ecivils->tcivils_id.'" data-tag ="'.$ecivils->tag.'" data-weight ="'.$ecivils->weight.'" data-toggle="modal" data-target="#editcivilModal"> Modify</a>&nbsp;

                <a href="delcivil/'.$ecivils->id.'" class="del-civil-modal btn btn-xs btn-danger" data-id ="'.$ecivils->id.'" data-unit ="'.$ecivils->unit.'" data-area ="'.$ecivils->area.'"data-tcivils_id ="'.$ecivils->tcivils_id.'" data-tag ="'.$ecivils->tag.'" data-weight ="'.$ecivils->weight.'" data-toggle="modal"data-target="#delcivilModal"> Remove</a>';
            })

             ->make(true);



    }

         public function ecivils(){


        return view('civil.ecivils');


    }

    public function ecivilsfullquery()
    {

        // GENERAR QUERY DE MODELADOS AUTOMATICAMENTE SEGUN STEPS

         $part1 = "SELECT ecivilsnews.id,ecivilsnews.units_id,ecivilsnews.areas_id,ecivilsnews.tcivils_id,ecivilsnews.qty,
            (SELECT units.name FROM units WHERE units.id=ecivilsnews.units_id) AS unit,
            (SELECT areas.name FROM areas WHERE areas.id=ecivilsnews.areas_id) AS area,
            (SELECT tcivils.name FROM tcivils WHERE tcivils.id=ecivilsnews.tcivils_id) AS type_civil,
            (SELECT COUNT(*) FROM dcivilsfullview WHERE tcivils_id=ecivilsnews.tcivils_id AND areas_id=ecivilsnews.areas_id) AS modeled";
        
        $pcivils = DB::select("SELECT percentage FROM pcivils");
        $part2tmp = "";
        $returntemp = "";

        foreach ($pcivils as $pcivilss) {

            $part2tmp = ",(SELECT COUNT(*) FROM dcivilsfullview WHERE tcivils_id=ecivilsnews.tcivils_id AND areas_id=ecivilsnews.areas_id AND progress=".$pcivilss->percentage.") AS modeled".$pcivilss->percentage;           
                    
            $part2=$part2.$part2tmp;


        } 

        $ecivilsfullquery= $part1.$part2.' FROM ecivilsnews';


        $ecivilsfull = DB::select($ecivilsfullquery);

                     return Datatables::of($ecivilsfull)
                     ->addColumn('action', function ($ecivilsfull) {
                return '<a href="delecivil/'.$ecivilsfull->id.'" class="del-ecivils-modal btn btn-xs btn-danger" data-id ="'.$ecivilsfull->id.'" data-areas_id ="'.$ecivilsfull->areas_id.'" data-tcivils_id ="'.$ecivilsfull->tcivils_id.'" data-qty ="'.$ecivilsfull->qty.'" data-toggle="modal" data-target="#delecivilsModal"> Remove</a>';
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
     $tcivils = Tcivil::pluck('name')->all();
     $hoursw = Tcivil::pluck('hours')->all(); 
     $units = Unit::pluck('name')->all();
     $unitss =  Unit::pluck('name')->all();
     $areas = Area::pluck('name')->all();
     $areass =  Area::pluck('name')->all();


     $ecivils = DB::select("SELECT * FROM civilsview ORDER BY area");

     return view('civil.indexcivil')->with('tcivils', $tcivils)->with('units', $units)->with('areas', $areas)->with('ecivils', $ecivils)->with('unitss', $unitss)->with('areass', $areass);



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
                          $tcivils_id = $request->input('tcivils_id')[$i];
                          $qty = $request->input('qty')[$i];




                         $query = DB::select("SELECT areas_id,tcivils_id,qty FROM ecivilsnews WHERE areas_id=".$areas_id." AND tcivils_id=".$tcivils_id);

                             /*validar si existe registro para cancelar o modificar*/   

                        if (!count($query)) {
                            
                            DB::table('ecivilsnews')->insert([
    
                            'areas_id' =>$request->input('areas_id')[$i],
                            'tcivils_id' =>$request->input('tcivils_id')[$i],
                            'qty' =>$request->input('qty')[$i],

                  

                         ]);

                            $added = $added+1;

                         }else{

                            $not_added = $not_added+1;

                         } 
                        
                      


                      }

                      if ($not_added > 0) {

                        return redirect()->route('ecivils')
                        ->with('warning', 'WARNING! '.$added.' records were added to the database. '.$not_added.' already exist. Please, check the existing registers and make the respective modifications.');
                          
                      }else{

                          return redirect()->route('ecivils') 
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
        $idecivils=DB::select("SELECT ecivils.units_id,ecivils.areas_id,ecivils.tcivils_id,ecivils.hours,ecivils.est_qty FROM `ecivils` where ecivils.id=$id");
        return view('civil.editcivil',compact('idecivils'))->with('idecivils', $idecivils);
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
        $tcivils_id=$request->tcivils_id;
        $est_qty=$request->est_qty;
        $tag=$request->tag;

        $this->validate($request, [
            'id' => 'required',
            'units_id' => 'required',
            'areas_id' => 'required',
            'tcivils_id' => 'required',
            /*'est_qty' => 'required',*/
        ]);

         //$query = DB::select("SELECT units_id, tcivils_id, est_qty FROM ecivils WHERE units_id=".$units_id." AND tcivils_id=".$tcivils_id. " AND est_qty=".$est_qty);
         //$query = DB::select("SELECT tag FROM ecivils WHERE tag="."'".$tag."'");

                             /*validar si existe registro para cancelar o modificar*/   


                                //if (!count($query)) {
                                
                                    Ecivil::find($id)->update($request->all());

                                     /**Validar si excede el budget**/

                                    $budget = DB::select("SELECT weight FROM pmanagers WHERE name='civil'");
                                    $estimated = DB::select("SELECT * FROM pcivils_view");


                                    return redirect()->route('civils')
                                   ->with('success','SUCCESS! Record was successfully modified');

                                    
                         

                                    // }else{

                                        return redirect()->route('civils')
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

        Ecivilsnew::find($id)->delete();
        return redirect()->route('ecivils')
                        ->with('success','SUCCESS! Record were successfully removed.');
    }



    /*FUNCIONES FUERA DEL CRUD*/

    public function dcivilgetProgressByArea()
    {


        $dcivilgetprogressbyarea = DB::select("SELECT * FROM tpfmc_db.pcivils_view");
                     return Datatables::of($dcivilgetprogressbyarea)
                         ->make(true);




    }
     /*FUNCION PARA EL GRÁFICO DE LÍNEAS*/
     public function dcivildatatable()
    {
        

         $lineprogress = DB::select("SELECT date, SUM(count) AS count from hcivils where progress<>0 group by date");


            return view('civil/glinecivil',['lineprogress'=>$lineprogress]);


    }

    public function updateMilestone()
    {

        $date_progress = DB::select("SELECT * from hcivils");

                 foreach ($date_progress as $date_progressss) {

                    $milestone_date = DB::select("SELECT date from mcivils where date='".$date_progressss->date."'");


                        if (count($milestone_date)>0) {

                            DB::table('hcivils')->where('id', $date_progressss->id)->update(array('milestone' => 1));

                             }else{

                            DB::table('hcivils')->where('id', $date_progressss->id)->update(array('milestone' => 0));    

                             }

                    
                    } 

            

    }

    public function gline(Request $request)
    {

         $hcivils =DB::select("SELECT * FROM hcivils");  

         if ((count($hcivils))>0){ // VALIDACIÓN DE EXISTENCIA DE DATA INICIAL

            //CONTROL INICIO PRINCIPAL NO-REQUEST 

            $id=$request->units_id[0];


            if (is_null($id)){

                $id=0;

                $lineprogress=DB::select("SELECT progress FROM hcivils WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

                while (($lineprogress)==NULL){

                    $id++;
                    $lineprogress=DB::select("SELECT progress FROM hcivils WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

                }
              }

            $lineprogress=DB::select("SELECT DATE_FORMAT(hcivils.date,'%d-%m-%Y') as date,area,progress FROM hcivils WHERE area=(SELECT units.name FROM units WHERE units.id=".$id.")");

             $units = DB::table('units')->pluck('name')->all();

            // Se verifica si el área tiene contenidos modelados. En caso de no tenerlos va a otra vista.

            if (count($lineprogress)==0){

                $selected_area=DB::select("SELECT units.name FROM units WHERE units.id=".$id);

                  return view('civil.glinecivil_NODATA')->with('units', $units)->with('selected_area', $selected_area);  

            }


           return view('civil.glinecivil')->with('units', $units)->with('lineprogress', $lineprogress);

            }else{

            return view('civil.glinecivil_NOHIST');

        }

    }

    public function glineTotal()
    {

              $mcivils =DB::select("SELECT * FROM mcivils");  

         if ((count($mcivils))>0 OR (count($mcivils))>0){ // VALIDACIÓN DE EXISTENCIA DE DATA INICIAL



            $lineprogress=DB::select("SELECT DATE_FORMAT(hcivils.date,'%d-%m-%Y') as date,area,progress FROM hcivils WHERE area='TOTAL'");
            $lineprogress_count=DB::select("SELECT count(*) as count FROM glineciviltotal");
            $lineestimated=DB::select("SELECT * FROM mcivils WHERE area='TOTAL'");
            
           return view('civil.glineciviltotal')->with('lineprogress', $lineprogress)->with('lineprogress_count', $lineprogress_count)->with('lineestimated', $lineestimated);;

        }else{

            return view('civil.glinecivil_NOHIST');

        }


    }

   public function dcivilsfullquery(){


        $dcivilsfull = DB::select("SELECT * FROM dcivilsfullview;");

                     return Datatables::of($dcivilsfull)->make(true);


   } 


    public function modeled(){


        $dcivilsfullquery = DB::select("SELECT * FROM dcivilsfullview;");
        
        return view('civil.modeledcivil')->with('unit', $unit)->with('area', $area)->with('tag', $tag)->with('type_civil', $type_civil)->with('weight', $weight)->with('status', $status)->with('progress', $progress);


    }

    public function milestone(){

        $units = DB::table('units')->pluck('name')->all();
        return view('civil.milestonecivil')->with('units', $units);


    }

    public function milestonecivil()
    {

        $milestonecivil = DB::select("SELECT mcivils.id, mcivils.date,units.name AS area, mcivils.quantity FROM mcivils JOIN UNITS WHERE units.id=mcivils.units_id ORDER BY mcivils.date");
                     return Datatables::of($milestonecivil)
                     ->addColumn('action', function ($milestonecivil) {
                return '<a onclick "" href="editcivil/'.$milestonecivil->id.'" class="edit-civil-modal btn btn-xs btn-primary" data-id ="'.$milestonecivil->id.'" data-date ="'.$milestonecivil->date.'" data-area ="'.$milestonecivil->area.'" data-qty ="'.$milestonecivil->quantity.'" data-toggle="modal" data-target="#editcivilModal"> Modify</a>&nbsp;

                <a href="delcivil/'.$milestonecivil->id.'" class="edit-civil-modal btn btn-xs btn-primary" data-id ="'.$milestonecivil->id.'" data-date ="'.$milestonecivil->date.'" data-area ="'.$milestonecivil->area.'" data-qty ="'.$milestonecivil->quantity.'" data-toggle="modal" data-target="#delcivilModal"> Remove</a>';
            })
                         ->make(true);

    }

     public function createMilestonecivil(Request $request)
    {
     $tcivils = Tcivil::pluck('name')->all();
     $hoursw = Tcivil::pluck('hours')->all(); 
     $units = Unit::pluck('name')->all();
     $unitss =  Unit::pluck('name')->all();


     $ecivils = DB::select("SELECT * FROM civilsview ORDER BY area");

     return view('civil.milestonecivil')->with('tcivils', $tcivils)->with('units', $units)->with('ecivils', $ecivils)->with('unitss', $unitss);



    }






}