<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use DB;
use App\Tequi;

class DequiTypeController extends Controller
{
    public function types(){


        return view('equipment.typesequi');


    }

    public function typesEqui()
    {

        $typesequi = DB::select("SELECT * FROM tequis");
                     return Datatables::of($typesequi)
                     ->addColumn('action', function ($typesequi) {
                return '<a onclick "" href="edittypesequi/'.$typesequi->id.'" class="edit-typesequi-modal btn btn-xs btn-primary" data-id ="'.$typesequi->id.'" data-code ="'.$typesequi->code.'" data-name ="'.$typesequi->name.'" data-hours ="'.$typesequi->hours.'" data-toggle="modal" data-target="#edittypesequiModal"> Modify</a>&nbsp;

                <a href="deltypesequi/'.$typesequi->id.'" class="del-typesequi-modal btn btn-xs btn-danger" data-id ="'.$typesequi->id.'" data-code ="'.$typesequi->code.'" data-name ="'.$typesequi->name.'" data-hours ="'.$typesequi->hours.'" data-toggle="modal" data-target="#deltypesequiModal"> Remove</a>';
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


                         $id_tequi = DB::select("SELECT MAX(id) as max_id FROM tequis");// Para el ID debido a que no es AutoIncrement


                      $id =  $id_tequi[0]->max_id + 1; 
                      $code = $request->input('code')[$i];
                      $name = $request->input('name')[$i];
                      $hours = $request->input('hours')[$i];




                         $query = DB::select("SELECT code,name,hours FROM tequis WHERE code="."'".$code."'"." OR name="."'".$name."'");

                             /*validar si existe registro para cancelar o modificar*/   

                        if (!count($query)) {
                            
                            DB::table('tequis')->insert([
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

                        return redirect()->route('typesequi')
                        ->with('warning', 'WARNING! '.$added.' records were added to the database. '.$not_added.' already exist. Please, check the existing registers and make the respective modifications.');
                          
                      }else{

                          return redirect()->route('typesequi') 
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

         $query = DB::select("SELECT code,name,hours FROM tequis WHERE code="."'".$code."'"." AND name="."'".$name."'"."AND hours=".$hours );

                             /*validar si existe registro para cancelar o modificar*/   


                                if (!count($query)) {
                                
                                    Tequi::find($id)->update($request->all());
                                    return redirect()->route('typesequi')
                                   ->with('success','SUCCESS! Record was successfully modified!');
                               

                         

                                     }else{

                                        return redirect()->route('typesequi')
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

        Tequi::find($id)->delete();
        return redirect()->route('typesequi')
                        ->with('success','SUCCESS! Records were successfully removed.');
    }


}
