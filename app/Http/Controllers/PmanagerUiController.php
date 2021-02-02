<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use DateTime;
use App\Pmanager;
use App\Mpipe;
use App\Mequi;
use App\Mcivil;
use App\Mcinst;

use DB;
use Charts;

class PmanagerUiController extends Controller
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

     

    $eequis = DB::select("SELECT * FROM equisview ORDER BY area");


      return Datatables::of($eequis)
            ->addColumn('action', function ($eequis) {
                return '<a onclick "" href="editequi/'.$eequis->id.'" class="edit-equi-modal btn btn-xs btn-primary" data-id ="'.$eequis->id.'" data-units_id ="'.$eequis->units_id.'" data-tequis_id ="'.$eequis->tequis_id.'" data-hours ="'.$eequis->hours.'" data-est_qty ="'.$eequis->est_qty.'" data-toggle="modal" data-target="#editequiModal"> Modify</a>&nbsp;

                <a href="delequi/'.$eequis->id.'" class="del-equi-modal btn btn-xs btn-danger" data-id ="'.$eequis->id.'" data-units_id ="'.$eequis->units_id.'" data-tequis_id ="'.$eequis->tequis_id.'" data-hours ="'.$eequis->hours.'" data-est_qty ="'.$eequis->est_qty.'" data-toggle="modal" data-target="#delequiModal"> Remove</a>';
            })

             ->make(true);

    }

    public function pmanager()
    {
        
        $locked = DB::select("SELECT locked FROM pmanagers");
        $locked = $locked[0]->locked;

        $wtpipe = DB::select("SELECT weight_total FROM pmanagers WHERE name='pipe'");
        $wtpipe = $wtpipe[0]->weight_total;

        $wtequi = DB::select("SELECT weight_total FROM pmanagers WHERE name='equi'");
        $wtequi = $wtequi[0]->weight_total;

        $wtcivil = DB::select("SELECT weight_total FROM pmanagers WHERE name='civil'");
        $wtcivil = $wtcivil[0]->weight_total;

        $wtelec = DB::select("SELECT weight_total FROM pmanagers WHERE name='elect'");
        $wtelec = $wtelec[0]->weight_total;

        $wtinst = DB::select("SELECT weight_total FROM pmanagers WHERE name='inst'");
        $wtinst = $wtinst[0]->weight_total;



        return view('pmanager')->with('locked', $locked)->with('wtpipe', $wtpipe)->with('wtequi', $wtequi)->with('wtcivil', $wtcivil)->with('wtelec', $wtelec)->with('wtinst', $wtinst);
    }

    public function summary_pmanager()
    {
        
        return view('summary-pmanager');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
     $tequis = Tequi::pluck('name')->all();
     $hoursw = Tequi::pluck('hours')->all(); 
     $units = Unit::pluck('name')->all();
     $unitss =  Unit::pluck('name')->all();


     $eequis = DB::select("SELECT * FROM equisview ORDER BY area");

     return view('equipment.indexequi')->with('tequis', $tequis)->with('units', $units)->with('eequis', $eequis)->with('unitss', $unitss);



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $count = count($request->input('units_id'));

        $not_added = 0; /*variable para controlar el número de registros no insertados*/
        $added = 0; /*variable para controlar el número de registros insertados*/
                      for ($i = 0; $i < $count; $i++) {




                      $units_id = $request->input('units_id')[$i];
                      $tequis_id = $request->input('tequis_id')[$i];
                      $hours = $request->input('hours')[$i];



                         $query = DB::select("SELECT units_id, tequis_id,hours FROM eequis WHERE units_id=".$units_id." AND tequis_id=".$tequis_id." AND hours=".$hours );

                             /*validar si existe registro para cancelar o modificar*/   

                        if (!count($query)) {
                            
                            DB::table('eequis')->insert([
                            'units_id' =>$request->input('units_id')[$i],
                            'tequis_id' =>$request->input('tequis_id')[$i],
                            'hours' =>$request->input('hours')[$i],
                            'est_qty' =>$request->input('est_qty')[$i],

                  

                         ]);

                            $added = $added+1;

                         }else{

                            $not_added = $not_added+1;

                         } 
                        
                      


                      }

                      if ($not_added > 0) {

                        return redirect()->route('equipments')
                        ->with('warning', 'WARNING! '.$added.' records were added to the database. '.$not_added.' already exist. Please, check the existing registers and make the respective modifications.');
                          
                      }else{

                          return redirect()->route('equipments') 
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
        $ideequis=DB::select("SELECT eequis.units_id,eequis.tequis_id,eequis.hours,eequis.est_qty FROM `eequis` where eequis.id=$id");
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
 
        DB::table('pmanagers')->where('id', 1)->update(array('weight_total' => $_POST['wtpipe']));

        DB::table('pmanagers')->where('id', 2)->update(array('weight_total' => $_POST['wtequi']));

        DB::table('pmanagers')->where('id', 3)->update(array('weight_total' => $_POST['wtcivil']));

        DB::table('pmanagers')->where('id', 4)->update(array('weight_total' => $_POST['wtelec']));

        DB::table('pmanagers')->where('id', 5)->update(array('weight_total' => $_POST['wtinst']));
        

        if(isset($_POST['lock']))
                {
                $locked=1;
                }
                else
                {
                $locked=0;
                }

        

       

        $pd_pipe=$request->pd_pipe;
        if($request->pd_pipe<=0){$request->pd_pipe=1;} // para evitar un 0 o (-) se suma 1


        $pd_equi=$request->pd_equi;
        if($request->pd_equi<=0){$request->pd_equi=1;} // para evitar un 0 o (-) se suma 1

        $pd_civil=$request->pd_civil;
        if($request->pd_civil<=0){$request->pd_civil=1;} // para evitar un 0 o (-) se suma 1

        $pd_sel=$request->pd_sel;
        if($request->pd_sel<=0){$request->pd_sel=1;} // para evitar un 0 o (-) se suma 1

        $pd_sit=$request->pd_sit;
        if($request->pd_sit<=0){$request->pd_sit=1;} // para evitar un 0 o (-) se suma 1

        $this->validate($request, [

            'pd_pipe' => 'required',
            'pd_equi' => 'required',
            'pd_civil' => 'required',
            'pd_sel' => 'required',
            'pd_sit' => 'required',
        ]);       
                                
                        
                        /* Valor proporcional de Pipe */

                        $id=DB::select("SELECT id FROM `pmanagers` where name='pipe'");  


                        $start = new DateTime($request->start);
                        $end = new DateTime($request->end);
                        $interval = $start->diff($end);
                        $weeks = floor(($interval->format('%a') / 7)); 

                        /*Validar si el intervalo de fechas existe con tal de no modificar la personalización milestone*/

                        $exist_dates=DB::select("SELECT start,end FROM `pmanagers`");

                        if ((($request->start)!=($exist_dates[0]->start)) OR (($request->end)!=($exist_dates[0]->end))){

                            DB::table('pmanagers')->where('id', $id[0]->id)->update(array('weight' => $request->pd_pipe,'quantity' => $request->est_pipelines,'multiplier' => $request->multiplier,'start' => $request->start,'end' => $request->end,'weeks' => $weeks,'startweek' => $request->sw_pipe,'locked' => $locked));


                             /** Proceso para cálculo de curva S para Pipe*/

                            DB::table('mpipes')->truncate();
                            $weeks_two = -($weeks/2);
                            $count = $weeks_two;

                            for ($i = 1; $i <= $weeks; $i++) {
                                    
                                    DB::table('mpipes')->insert([

                                        'week'=> $i,
                                        'area'=> 'TOTAL',
                                        'estimated' => (1/(1+(pow(M_E,-$weeks_two))))*100,

                                     ]);

                                    $weeks_two = $weeks_two+1;


                                }
   

                        /** FIN proceso para cálculo de curva S para Pipe*/

                         /** Proceso para cálculo de curva S para Equi*/

                            DB::table('mequis')->truncate();
                            $weeks_two = -($weeks/2);
                            $count = $weeks_two;

                            for ($i = 1; $i <= $weeks; $i++) {
                                    
                                    DB::table('mequis')->insert([

                                        'week'=> $i,
                                        'area'=> 'TOTAL',
                                        'estimated' => (1/(1+(pow(M_E,-$weeks_two))))*100,

                                     ]);

                                    $weeks_two = $weeks_two+1;


                                }


                 

                        /** FIN proceso para cálculo de curva S para Equi*/

                         /** Proceso para cálculo de curva S para Civil*/

                            DB::table('mcivils')->truncate();
                            $weeks_two = -($weeks/2);
                            $count = $weeks_two;

                            for ($i = 1; $i <= $weeks; $i++) {
                                    
                                    DB::table('mcivils')->insert([

                                        'week'=> $i,
                                        'area'=> 'TOTAL',
                                        'estimated' => (1/(1+(pow(M_E,-$weeks_two))))*100,

                                     ]);

                                    $weeks_two = $weeks_two+1;


                                }


                 

                        /** FIN proceso para cálculo de curva S para Civil*/

                          /** Proceso para cálculo de curva S para Inst*/

                            DB::table('minsts')->truncate();
                            $weeks_two = -($weeks/2);
                            $count = $weeks_two;

                            for ($i = 1; $i <= $weeks; $i++) {
                                    
                                    DB::table('minsts')->insert([

                                        'week'=> $i,
                                        'area'=> 'TOTAL',
                                        'estimated' => (1/(1+(pow(M_E,-$weeks_two))))*100,

                                     ]);

                                    $weeks_two = $weeks_two+1;


                                }


                 

                        /** FIN proceso para cálculo de curva S para Inst*/

                        }else{

                            DB::table('pmanagers')->where('id', $id[0]->id)->update(array('weight' => $request->pd_pipe,'quantity' => $request->est_pipelines,'multiplier' => $request->multiplier,'startweek' => $request->sw_pipe,'locked' => $locked));

                 

                        }
                        /**/

                                        

                       

                        /* Valor proporcional de Equi */

                        $id=DB::select("SELECT id FROM `pmanagers` where name='equi'");



                                    DB::table('pmanagers')->where('id', $id[0]->id)->update(array('weight' => $request->pd_equi,'startweek' => $request->sw_equi));



                        /* Valor proporcional de Civil */

                        $id=DB::select("SELECT id FROM `pmanagers` where name='civil'");


                                    DB::table('pmanagers')->where('id', $id[0]->id)->update(array('weight' => $request->pd_civil,'startweek' => $request->sw_civil));



                        /* Valor proporcional de SEL */

                        $id=DB::select("SELECT id FROM `pmanagers` where name='elect'");  

                                    DB::table('pmanagers')->where('id', $id[0]->id)->update(array('weight' => $request->pd_sel,'startweek' => $request->sw_sel));

                        /* Valor proporcional de SIT */

                        $id=DB::select("SELECT id FROM `pmanagers` where name='inst'");  

                                    DB::table('pmanagers')->where('id', $id[0]->id)->update(array('weight' => $request->pd_sit,'startweek' => $request->sw_sit));

                                    //return redirect()->route('pmanager');


                                        return redirect()->route('pmanager');

                                   

                            
                                         
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

        Eequi::find($id)->delete();
        return redirect()->route('equipments')
                        ->with('success','SUCCESS! Records were successfully removed.');
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

    // MILESTONES PIPING

    public function mpipes(){


        return view('piping.mpipes');


    }

    public function milestonesPipe()
    {

        $mpipes = DB::select("SELECT * FROM mpipes");
                     return Datatables::of($mpipes)
                     ->addColumn('action', function ($mpipes) {
                return '<a onclick "" href="editmilestonespipe/'.$mpipes->id.'" class="edit-milestonespipe-modal btn btn-xs btn-primary" data-id ="'.$mpipes->id.'" data-area ="'.$mpipes->area.'" data-week ="'.$mpipes->week.'" data-estimated ="'.$mpipes->estimated.'" data-toggle="modal" data-target="#editmilestonespipeModal"> Modify</a>&nbsp;';
            })
                         ->make(true);

    }

    public function updatemilestonesPipe(Request $request){


        $id=$request->id;
        $estimated=$request->estimated;

       
                                
                                    Mpipe::find($id)->update($request->all());
                                    return redirect()->route('milestonespipe')
                                   ->with('success','SUCCESS! Record was successfully modified!');
                               

    }

   // MILESTONES EQUI 

   public function mequis(){


        return view('equipment.mequis');


    }

    public function milestonesEqui()
    {

        $mequis = DB::select("SELECT * FROM mequis");
                     return Datatables::of($mequis)
                     ->addColumn('action', function ($mequis) {
                return '<a onclick "" href="editmilestonesequi/'.$mequis->id.'" class="edit-milestonesequi-modal btn btn-xs btn-primary" data-id ="'.$mequis->id.'" data-area ="'.$mequis->area.'" data-week ="'.$mequis->week.'" data-estimated ="'.$mequis->estimated.'" data-toggle="modal" data-target="#editmilestonesequiModal"> Modify</a>&nbsp;';
            })
                         ->make(true);

    }

    public function updatemilestonesequi(Request $request){


        $id=$request->id;
        $estimated=$request->estimated;

       
                                
                                    Mequi::find($id)->update($request->all());
                                    return redirect()->route('milestonesequi')
                                   ->with('success','SUCCESS! Record was successfully modified!');
                               

    } 

    // MILESTONES CIVIL

   public function mcivils(){


        return view('civil.mcivils');


    }

    public function milestonescivil()
    {

        $mcivils = DB::select("SELECT * FROM mcivils");
                     return Datatables::of($mcivils)
                     ->addColumn('action', function ($mcivils) {
                return '<a onclick "" href="editmilestonescivil/'.$mcivils->id.'" class="edit-milestonescivil-modal btn btn-xs btn-primary" data-id ="'.$mcivils->id.'" data-area ="'.$mcivils->area.'" data-week ="'.$mcivils->week.'" data-estimated ="'.$mcivils->estimated.'" data-toggle="modal" data-target="#editmilestonescivilModal"> Modify</a>&nbsp;';
            })
                         ->make(true);

    }

    public function updatemilestonescivil(Request $request){


        $id=$request->id;
        $estimated=$request->estimated;

       
                                
                                    Mcivil::find($id)->update($request->all());
                                    return redirect()->route('milestonescivil')
                                   ->with('success','SUCCESS! Record was successfully modified!');
                               

    } 

    // MILESTONES INST

       public function minsts(){


        return view('inst.minsts');


    }

    public function milestonesinst()
    {

        $minsts = DB::select("SELECT * FROM minsts");
                     return Datatables::of($minsts)
                     ->addColumn('action', function ($minsts) {
                return '<a onclick "" href="editmilestonesinst/'.$minsts->id.'" class="edit-milestonesinst-modal btn btn-xs btn-primary" data-id ="'.$minsts->id.'" data-area ="'.$minsts->area.'" data-week ="'.$minsts->week.'" data-estimated ="'.$minsts->estimated.'" data-toggle="modal" data-target="#editmilestonesinstModal"> Modify</a>&nbsp;';
            })
                         ->make(true);

    }

    public function updatemilestonesinst(Request $request){


        $id=$request->id;
        $estimated=$request->estimated;

       
                                
                                    Minst::find($id)->update($request->all());
                                    return redirect()->route('milestonesinst')
                                   ->with('success','SUCCESS! Record was successfully modified!');
                               

    } 


}