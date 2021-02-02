<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use DB;
use App\Tinst;

class DinstTypeController extends Controller
{
    public function types(){


        return view('instruments.typesinst');


    }

    public function typesinst()
    {

        $typesinst = DB::select("SELECT * FROM tinsts");
                     return Datatables::of($typesinst)
                     ->addColumn('action', function ($typesinst) {
                return '<a onclick "" href="edittypesinst/'.$typesinst->id.'" class="edit-typesinst-modal btn btn-xs btn-primary" data-id ="'.$typesinst->id.'" data-code ="'.$typesinst->code.'" data-name ="'.$typesinst->name.'" data-hours ="'.$typesinst->hours.'" data-toggle="modal" data-target="#edittypesinstModal"> Modify</a>&nbsp;

                <a href="deltypesinst/'.$typesinst->id.'" class="del-typesinst-modal btn btn-xs btn-danger" data-id ="'.$typesinst->id.'" data-code ="'.$typesinst->code.'" data-name ="'.$typesinst->name.'" data-hours ="'.$typesinst->hours.'" data-toggle="modal" data-target="#deltypesinstModal"> Remove</a>';
            })
                         ->make(true);

    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $count = count($request->input('code'));

        $not_added = 0; /*variable para controlar el número de registros no insertados*/
        $added = 0; /*variable para controlar el número de registros insertados*/
                      for ($i = 0; $i < $count; $i++) {


                         $id_tinst = DB::select("SELECT MAX(id) as max_id FROM tinsts");// Para el ID debido a que no es AutoIncrement


                      $id =  $id_tinst[0]->max_id + 1; 
                      $code = $request->input('code')[$i];
                      $name = $request->input('name')[$i];
                      $hours = $request->input('hours')[$i];




                         $query = DB::select("SELECT code,name,hours FROM tinsts WHERE code="."'".$code."'"." OR name="."'".$name."'");

                             /*validar si existe registro para cancelar o modificar*/   

                        if (!count($query)) {
                            
                            DB::table('tinsts')->insert([
                            'id' => $id,    
                            'code' =>$request->input('code')[$i],
                            'name' =>$request->input('name')[$i],
                            'hours' =>$request->input('hours')[$i],

                  

                         ]);

                            $added = $added+1;

                         }else{

                            $not_added = $not_added+1;

                         } 
                        
                      


                      }

                      if ($not_added > 0) {

                        return redirect()->route('typesinst')
                        ->with('warning', 'WARNING! '.$added.' records were added to the database. '.$not_added.' already exist. Please, check the existing registers and make the respective modifications.');
                          
                      }else{

                          return redirect()->route('typesinst') 
                        ->with('success','SUCCESS! '.$added.' records were successfully added.');

                      }

                         

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
        $code=$request->code;
        $name=$request->name;
        $hours=$request->hours;

        $this->validate($request, [
            'id' => 'required',
            'code' => 'required',
            'name' => 'required',
            'hours' => 'required',
        ]);

         $query = DB::select("SELECT code,name,hours FROM tinsts WHERE code="."'".$code."'"." AND name="."'".$name."'"."AND hours=".$hours );

                             /*validar si existe registro para cancelar o modificar*/   


                                if (!count($query)) {
                                
                                    Tinst::find($id)->update($request->all());
                                    return redirect()->route('typesinst')
                                   ->with('success','SUCCESS! Record was successfully modified!');
                               

                         

                                     }else{

                                        return redirect()->route('typesinst')
                                        ->with('danger','ERROR! The registry was not modified because an attempt is made to duplicate an existing one!. Please, check the existing registers and make the respective modifications.');
                                    
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

        Tinst::find($id)->delete();
        return redirect()->route('typesinst')
                        ->with('success','SUCCESS! Records were successfully removed.');
    }


}
