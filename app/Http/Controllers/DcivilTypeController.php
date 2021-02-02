<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use DB;
use App\Tcivil;

class DcivilTypeController extends Controller
{
    public function types(){


        return view('civil.typescivil');


    }

    public function typescivil()
    {

        $typescivil = DB::select("SELECT * FROM tcivils");
                     return Datatables::of($typescivil)
                     ->addColumn('action', function ($typescivil) {
                return '<a onclick "" href="edittypescivil/'.$typescivil->id.'" class="edit-typescivil-modal btn btn-xs btn-primary" data-id ="'.$typescivil->id.'" data-code ="'.$typescivil->code.'" data-name ="'.$typescivil->name.'" data-hours ="'.$typescivil->hours.'" data-toggle="modal" data-target="#edittypescivilModal"> Modify</a>&nbsp;

                <a href="deltypescivil/'.$typescivil->id.'" class="del-typescivil-modal btn btn-xs btn-danger" data-id ="'.$typescivil->id.'" data-code ="'.$typescivil->code.'" data-name ="'.$typescivil->name.'" data-hours ="'.$typescivil->hours.'" data-toggle="modal" data-target="#deltypescivilModal"> Remove</a>';
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


                         $id_tcivil = DB::select("SELECT MAX(id) as max_id FROM tcivils");// Para el ID debido a que no es AutoIncrement


                      $id =  $id_tcivil[0]->max_id + 1; 
                      $code = $request->input('code')[$i];
                      $name = $request->input('name')[$i];
                      $hours = $request->input('hours')[$i];




                         $query = DB::select("SELECT code,name,hours FROM tcivils WHERE code="."'".$code."'"." OR name="."'".$name."'");

                             /*validar si existe registro para cancelar o modificar*/   

                        if (!count($query)) {
                            
                            DB::table('tcivils')->insert([
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

                        return redirect()->route('typescivil')
                        ->with('warning', 'WARNING! '.$added.' records were added to the database. '.$not_added.' already exist. Please, check the existing registers and make the respective modifications.');
                          
                      }else{

                          return redirect()->route('typescivil') 
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

         $query = DB::select("SELECT code,name,hours FROM tcivils WHERE code="."'".$code."'"." AND name="."'".$name."'"."AND hours=".$hours );

                             /*validar si existe registro para cancelar o modificar*/   


                                if (!count($query)) {
                                
                                    Tcivil::find($id)->update($request->all());
                                    return redirect()->route('typescivil')
                                   ->with('success','SUCCESS! Record was successfully modified!');
                               

                         

                                     }else{

                                        return redirect()->route('typescivil')
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

        Tcivil::find($id)->delete();
        return redirect()->route('typescivil')
                        ->with('success','SUCCESS! Records were successfully removed.');
    }


}
