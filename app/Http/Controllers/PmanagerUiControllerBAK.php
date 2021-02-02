<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use App\Pmanager;

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
        
        return view('pmanager');
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
 
        $pd_pipe=$request->pd_pipe;
        $pd_equi=$request->pd_equi;
        $pd_civil=$request->pd_civil;
        $pd_sel=$request->pd_sel;
        $pd_sit=$request->pd_sit;

        $this->validate($request, [

            'pd_pipe' => 'required',
            'pd_equi' => 'required',
            'pd_civil' => 'required',
            'pd_sel' => 'required',
            'pd_sit' => 'required',
        ]);       
                                
                        
                        /* Valor proporcional de Pipe */

                        $id=DB::select("SELECT id FROM `pmanagers` where name='pipe'");  

                                    if ($pd_pipe>=30 AND $pd_pipe<=65){

                                        DB::table('pmanagers')->where('id', $id[0]->id)->update(array('percentage' => $request->pd_pipe,'quantity' => $request->est_pipelines,'multiplier' => $request->multiplier));

                                    }else{

                                        return redirect()->route('pmanager')
                                        ->with('warning', 'WARNING! the percentage of Piping must be between 30-65'); 

                                    }

                                    
             

                        /* Valor proporcional de Equi */

                        $id=DB::select("SELECT id FROM `pmanagers` where name='equi'");

                                    if ($pd_equi>=15 AND $pd_equi<=25){  

                                    DB::table('pmanagers')->where('id', $id[0]->id)->update(array('percentage' => $request->pd_equi));

                                     }else{

                                        return redirect()->route('pmanager')
                                        ->with('warning', 'WARNING! the percentage of Equipments must be between 15-25'); 

                                    }


                        /* Valor proporcional de Civil */

                        $id=DB::select("SELECT id FROM `pmanagers` where name='civil'");

                                    if ($pd_civil>=10 AND $pd_civil<=30){   

                                    DB::table('pmanagers')->where('id', $id[0]->id)->update(array('percentage' => $request->pd_civil));

                                    }else{

                                     return redirect()->route('pmanager')
                                        ->with('warning', 'WARNING! the percentage of Civil must be between 10-30'); 

                                    }    


                        /* Valor proporcional de SEL */

                        $id=DB::select("SELECT id FROM `pmanagers` where name='elect'");  

                                    DB::table('pmanagers')->where('id', $id[0]->id)->update(array('percentage' => $request->pd_sel));

                        /* Valor proporcional de SIT */

                        $id=DB::select("SELECT id FROM `pmanagers` where name='inst'");  

                                    DB::table('pmanagers')->where('id', $id[0]->id)->update(array('percentage' => $request->pd_sit));

                                    //return redirect()->route('pmanager');


                                   if($pd_pipe+$pd_equi+$pd_civil+$pd_sel+$pd_sit<>100){

                                        return redirect()->route('pmanager')
                                        ->with('warning', 'WARNING! the total of the percentages must be 100%');

                                   }else{

                                        return redirect()->route('pmanager');

                                   }

                            
                                         
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


}