<?php

namespace App\Http\Controllers;
use Auth;

use Illuminate\Http\Request;
use App\Hisoctrl;
use App\Misoctrl;
use App\Disoctrl;
use Illuminate\Support\Facades\Input;
use Validator;
use Datatables;
use DB;

// PARA GENERAR LA TABLA hisoctrls_temp LA CUAL ALIMENTA LAS INTERFACES

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;


/* DB::statement(DB::raw("TRUNCATE TABLE `hisoctrls_temp`"));
        

        DB::statement(DB::raw("INSERT INTO hisoctrls_temp (id,filename,revision,tie,spo,sit,requested,requestedlead,issued,deleted,claimed,
                                        verifydesign,verifystress,verifysupports,fromldgsupports,comments,`from`,`to`,`user`,`created_at`) 
                                        SELECT id,filename,revision,tie,spo,sit,requested,requestedlead,issued,deleted,claimed,
                                        verifydesign,verifystress,verifysupports,fromldgsupports,comments,`from`,`to`,`user`,`created_at` FROM hisoctrls WHERE id IN (SELECT MAX(id) FROM hisoctrls GROUP BY filename) ORDER BY id DESC"));*/


// FIN DE LA GENERACIÓN DE hisoctrls_temp

class IsoController extends Controller
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
    public function index()
    {
        return view('isoctrl.index');
    }

    public function isostatusindex()
    {
        return view('isoctrl.isostatusindex');
    }

    public function design()
    {
        return view('isoctrl.design');
    }

    public function stress()
    {
        return view('isoctrl.stress');
    }

    public function supports()
    {
        return view('isoctrl.supports');
    }

    public function materials()
    {
        return view('isoctrl.materials');
    }

    public function trash()
    {
       
        $filename = scandir("../public/storage/isoctrl/TRASH");

       return view('isoctrl.trash')->with('filenames', $filenames);
    }

    public function commontray()
    {

             

              $filename_ds = scandir("../public/storage/isoctrl/design"); // DESIGN
              $filename_st = scandir("../public/storage/isoctrl/stress");// STRESS
              $filename_sp = scandir("../public/storage/isoctrl/supports");// SUPPORTS
              $filename_mt = scandir("../public/storage/isoctrl/materials");// MATERIALS
              $filename_ld = scandir("../public/storage/isoctrl/lead");// LEAD
              $filename_ic = scandir("../public/storage/isoctrl/iso");// ISO


              $n=0; // contador para cargar el array filename[]
              $m=0; // contador para cargar el array filenames[] (valid)

              for ($i=1; $i<count($filename_ds); $i++){
               
                    $extension = pathinfo($filename_ds[$i], PATHINFO_EXTENSION);
                    if (($extension == 'pdf')) {

                      $filename[$n] = $filename_ds[$i];
                      $tray[$n] = 'design'; // para saber en que bandeja de encuentra
                      $n++;              

                    }

                  } //endfor DS

              for ($i=1; $i<count($filename_st); $i++){
               
                    $extension = pathinfo($filename_st[$i], PATHINFO_EXTENSION);
                    if (($extension == 'pdf')) {

                      $filename[$n] = $filename_st[$i];
                      $tray[$n] = 'stress'; // para saber en que bandeja de encuentra
                      $n++;                

                    }

                  } //endfor ST

              for ($i=1; $i<count($filename_sp); $i++){
               
                    $extension = pathinfo($filename_sp[$i], PATHINFO_EXTENSION);
                    if (($extension == 'pdf')) {

                      $filename[$n] = $filename_sp[$i];
                      $tray[$n] = 'supports'; // para saber en que bandeja de encuentra
                      $n++;                

                    }

                  } //endfor SP

              for ($i=1; $i<count($filename_mt); $i++){
               
                    $extension = pathinfo($filename_mt[$i], PATHINFO_EXTENSION);
                    if (($extension == 'pdf')) {

                      $filename[$n] = $filename_mt[$i];
                      $tray[$n] = 'materials'; // para saber en que bandeja de encuentra
                      $n++;                 

                    }

                  } //endfor MT

              for ($i=1; $i<count($filename_ld); $i++){
               
                    $extension = pathinfo($filename_ld[$i], PATHINFO_EXTENSION);
                    if (($extension == 'pdf')) {

                      $filename[$n] = $filename_ld[$i];
                      $tray[$n] = 'lead'; // para saber en que bandeja de encuentra
                      $n++;                   

                    }

                  } //endfor LD

              for ($i=1; $i<count($filename_ic); $i++){
               
                    $extension = pathinfo($filename_ic[$i], PATHINFO_EXTENSION);
                    if (($extension == 'pdf')) {

                      $filename[$n] = $filename_ic[$i];
                      $tray[$n] = 'isoctrl'; // para saber en que bandeja de encuentra
                      $n++;                  

                    }

                  } //endfor IC   

              
              for ($i=0; $i<$n; $i++){

                  $afilename=explode(".", $filename[$i]);

                  $valid = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE filename LIKE '%".$afilename[0]."%')");


                  if (($valid[0]->tie !=0) OR ($valid[0]->spo !=0) OR ($valid[0]->sit !=0)){

                      $filenames[$m] = $filename[$i];
                      $trays[$m] = $tray[$i]; // correspondiente bandeja por archivo
                      $eachfile=DB::select("SELECT * FROM hisoctrls WHERE id IN (SELECT MAX(id) FROM hisoctrls WHERE filename LIKE '".$filenames[$m]."') ");

                      $tie[$m]=$eachfile[0]->tie;
                      $spo[$m]=$eachfile[0]->spo;
                      $sit[$m]=$eachfile[0]->sit;

                      $m++;

                  }

              }   //endfor 

             

        return view('isoctrl.commontray')->with('filenames', $filenames)->with('trays', $trays)->with('tie', $tie)->with('spo', $spo)->with('sit', $sit);
    }

    public function iso()
    {



        $path = "../public/storage/isoctrl/iso/transmittals/";
        $trntmp  = scandir($path);

        $length=count($trntmp);

        for($i=2; $i<=$length-1; $i++){
            
            $trn[$i] = $trntmp[$i];
        
        }


        return view('isoctrl.iso')->with('trn', $trn);
    }

    public function lead()
    {
        return view('isoctrl.lead');
    }

    public function hisoctrl()
    {

       $hisoctrls = DB::select("SELECT * FROM hisoctrls ORDER BY created_at DESC");
                     return Datatables::of($hisoctrls)
                     ->addColumn('action', function ($hisoctrls) {

                return '<a onclick="vcomments('."'".$hisoctrls->id."'".')" href="" class="show-vcomments-modal btn btn-xs btn-info" data-id ="'.$hisoctrls->id.'" data-filename ="'.$hisoctrls->filename.'" data-comments ="'.$hisoctrls->comments.'"  data-toggle="modal" data-target="showvcommentsModa">View Comments</a>&nbsp;';
            })->make(true);

    }

    public function isostatus()
    {


        $isostatus = DB::select("SELECT * FROM isostatusprogressview");
        
                     return Datatables::of($isostatus)->make(true);

    }

    public function jsvcomments(){


        return view('isoctrl.jsvcomments');


    }

 
    public function sendtodesign($filename)
    {

             

        rename ("../public/storage/isoctrl/".$filename,"../public/storage/isoctrl/design/".$filename);

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'from' =>'IsoController',
            'to' =>'Design',
            'comments' =>'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum',
            'user' =>Auth::user()->name,
             ]);



        return view('isoctrl.index');

    }


 
    public function sendtostressfromdesign(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $spo=$request->spo;
        $sit=$request->sit;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo=$check[0]->spo;
         $sit=$check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/stress/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/stress/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF

        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/stress/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/stress/attach/".$afilename[0].".cii");



         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

            $progress = env('APP_PROGRESS');

            if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

                }else{

                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,//STRESS
              //'revision' =>$revision,
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

            }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,//STRESS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

            }


        return redirect('design')->with('success','SUCCESS! '.$filename.' has been sent to Stress!');

    }


        public function sendtostressfromsupports(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        rename ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/stress/".$filename);
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".zip","../public/storage/isoctrl/stress/attach/".$afilename[0].".zip");


        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".b","../public/storage/isoctrl/stress/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".cii","../public/storage/isoctrl/stress/attach/".$afilename[0].".cii");


         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Supports',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Supports',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

          // PARA ASIGNAR PROGRESO

            $progress = env('APP_PROGRESS');

            if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,//STRESS
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

              }else{

                Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,//STRESS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


              }


        return redirect('supports')->with('success','SUCCESS! '.$filename.' has been sent to Stress!');

    }

        public function sendfromdesignbulk(Request $request)
    {

              $ifc = env('APP_IFC');
              $destination = $_POST['destination'];
              $comments=$request->comments;

       if (!is_null($request->filenames)){       

              foreach ($request->filenames as $filename) {

                $afilename=explode(".", $filename);
                $results = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

                  $requestbydesign=$results[0]->requestbydesign;
                  $requestbylead=$results[0]->requestbylead;

                  //para mantener el request pero no bloquear
                  if ($requestbydesign==1){$requestbydesign=2;}
                  if ($requestbylead==1){$requestbylead=2;} 

                  $spo = $results[0]->spo;
                  $sit = $results[0]->sit;
                  $revision = $results[0]->revision;
                  $issued = $results[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }  


   if ($destination == 'stress'){        
        
        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/stress/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/stress/attach/".$afilename[0].".zip");
        
        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/stress/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/stress/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

            if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,//STRESS
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          }else{

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,//STRESS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          }

  }elseif ($destination == 'ldgstress'){        
        
        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/stress/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/stress/attach/".$afilename[0].".zip");
        
        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/stress/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/stress/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Design',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Design',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

              $progress = env('APP_PROGRESS');

            if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,//STRESS
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          }else{

               Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,//STRESS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          }
  
  }elseif ($destination =='supports') {
    
        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/supports/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/supports/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/supports/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/supports/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

           $progress = env('APP_PROGRESS');

            if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>3,//SUPPORTS
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

              }else{

                Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>3,//SUPPORTS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

              }

    }elseif ($destination =='ldgsupports') {
    
        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/supports/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf");
         rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/supports/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/supports/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/supports/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Design',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Design',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

            if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");


               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>3,//SUPPORTS
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>3,//SUPPORTS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          }

    }elseif ($destination =='ldgmaterials') {
    
        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/materials/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/materials/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/materials/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/materials/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Design',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Design',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]); 

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

            $progress = env('APP_PROGRESS');

            if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);
  
          }else{

             Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          }

      }elseif($destination=='ldgdesign'){  
  
            $requested = DB::select("SELECT max(id) as id FROM hisoctrls WHERE filename='".$filename."'");

                DB::table('hisoctrls')->where('id', $requested[0]->id)->update(array(

                  'from' => 'Design',
                  'verifydesign' => 1));

      }elseif ($destination='download') {
        

             $filepath = "../public/storage/isoctrl/design/".$filename;
              header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Lenght: '.filesize($filepath));
            header('Content-Transfer-Encoding: binary');
            readfile($filepath);
            exit;



      }else{

        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/materials/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/materials/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/materials/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/materials/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }


               // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

            if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          }else{

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          }

  }

              }//ENDFOREACH
                    
         return redirect('design')->with('success','SUCCESS! The selected IsoFiles have been sent to '.$destination.'!');
             //return $quien;

       }else{

          return redirect('design')->with('danger','ERROR! You must select at least one IsoFile!');
       }
                

    }

    public function sendtosupportsfromdesign(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;

        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 

        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo=$check[0]->spo;
         $sit=$check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/supports/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/supports/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/supports/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/supports/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

            $progress = env('APP_PROGRESS');

            if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

                }else{

                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>3,//SUPPORTS
              //'revision' =>$revision,
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'insupports' =>$currentdate
                ]);

          }else{

             Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>3,//SUPPORTS
              'ddesign' =>$currentdate,
              'insupports' =>$currentdate
                ]);

          }


        return redirect('design')->with('success','SUCCESS! '.$filename.' has been sent to Supports!');

    }

    public function sendtomaterialsfromdesign(Request $request)
    {

        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/materials/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/materials/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/materials/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/materials/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);


         // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);



        return redirect('design')->with('success','SUCCESS! '.$filename.' has been sent to Materials!');

    }

    public function sendtoleadfromdesign(Request $request)
    {

        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/lead/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/materials/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/lead/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/lead/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/lead/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Issuer',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
               'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'Issuer',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>14,//LEAD
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);



        return redirect('design')->with('success','SUCCESS! '.$filename.' has been sent to Issuer!');

    }

    public function sendtoleadfromstress(Request $request)
    {

        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        rename ("../public/storage/isoctrl/stress/".$filename,"../public/storage/isoctrl/lead/".$filename);
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".zip","../public/storage/isoctrl/lead/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/lead/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".b","../public/storage/isoctrl/lead/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".cii","../public/storage/isoctrl/lead/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Stress',
            'to' =>'Issuer',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Stress',
            'to' =>'Issuer',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);


         // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>14,//LEAD
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);



        return redirect('stress')->with('success','SUCCESS! '.$filename.' has been sent to Issuer!');

    }

    public function sendtoisofromdesign(Request $request)
    {

        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/iso/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-".$revision."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-".$revision."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-".$revision."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/iso/attach/".$afilename[0]."-".$revision.".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/iso/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/iso/attach/".$afilename[0]."-".$revision.".b");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'To Issue',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Design',
            'to' =>'To Issue',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);



        return redirect('design')->with('success','SUCCESS! The Isofile '.$filename.' is prepared to Issue and sent to IsoController!');

    }

    public function sendtoisofromlead(Request $request)
    {

        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 

        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if (is_null($revision)){

            $revision = 0;

         }

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        rename ("../public/storage/isoctrl/lead/".$filename,"../public/storage/isoctrl/iso/".$filename);
        
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].".zip","../public/storage/isoctrl/iso/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/iso/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].".b","../public/storage/isoctrl/iso/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].".cii","../public/storage/isoctrl/iso/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'issued' => 1,
            'from' =>'Issuer',
            'to' =>'To Issue',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'issued' => 1,
            'from' =>'Issuer',
            'to' =>'To Issue',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA
        
            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>12,//TO ISSUE
              'ddesign' =>$currentdate,
              'dlead' =>$currentdate,
              'iniso' =>$currentdate
                ]);


        return redirect('lead')->with('success','SUCCESS! The Isofile '.$filename.' is prepared to Issue and sent to IsoController!');

    }

     public function sendfromleadbulk(Request $request)
    {

              $destination = $_POST['destination'];
              $comments=$request->comments;

       if (!is_null($request->filenames)){       

              foreach ($request->filenames as $filename) {

                $afilename=explode(".", $filename);
                $results = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

                  $requestbydesign=$results[0]->requestbydesign;
                  $requestbylead=$results[0]->requestbylead;

                  //para mantener el request pero no bloquear
                  if ($requestbydesign==1){$requestbydesign=2;}
                  if ($requestbylead==1){$requestbylead=2;} 

                  $spo = $results[0]->spo;
                  $sit = $results[0]->sit; 
                  $revision = $results[0]->revision;
                  $issued = $results[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }  


   if ($destination == 'isoctrl'){        
        
        rename ("../public/storage/isoctrl/lead/".$filename,"../public/storage/isoctrl/iso/".$filename);
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].".zip","../public/storage/isoctrl/iso/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/iso/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].".b","../public/storage/isoctrl/iso/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].".cii","../public/storage/isoctrl/iso/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>0,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'issued' =>1,
            'from' =>'Issuer',
            'to' =>'To Issue',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>0,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'issued' =>1,
            'from' =>'Issuer',
            'to' =>'To Issue',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

            if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Issuer' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Issuer' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>12,//TO ISSUE
              //'revision' =>$revision,
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

              }else{

                Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>12,//TO ISSUE
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

              }


  }elseif ($destination =='comments') {
    
        rename ("../public/storage/isoctrl/lead/".$filename,"../public/storage/isoctrl/design/".$filename);
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF

        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Issuer',
            'to' =>'Design',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Issuer',
            'to' =>'Design',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

            if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Design' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Design' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//DESIGN
              //'revision' =>$revision,
              //'progress' =>$progress[0]->value, REGRESA
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          }else{

             Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//DESIGN
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          }


  }

              }//ENDFOREACH
                    
         return redirect('lead')->with('success','SUCCESS! The selected IsoFiles have been sent to '.$destination.'!');
             //return $quien;

       }else{

          return redirect('lead')->with('danger','ERROR! You must select at least one IsoFile!');
       }
                

    }

     public function sendtoissuefromiso(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $issuedate=$request->issuedatem;
        $trn=$request->trn;

        $path = "../public/storage/isoctrl/iso/transmittals/";
        $trndir  = scandir($path);

        $trname=$trndir[$trn[0]];
        
        mkdir("../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/", 0700);



        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."-%')"); //PARA EMITIDOS -XX

        if (is_null($check[0]->filename)){ // SI NO ESTÁ EMITIDO SE BUSCA EL ÚLTIMO SIN -XX

            $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

        }

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }

         $newfilename = $afilename[0]."-".$revision;  
        
        copy ("../public/storage/isoctrl/iso/".$afilename[0].".pdf","../public/storage/isoctrl/iso/history/".$newfilename.".pdf");
        rename ("../public/storage/isoctrl/iso/".$filename,"../public/storage/isoctrl/iso/".$newfilename.".pdf");
        copy ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/iso/history/".$newfilename."-CL.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/iso/attach/".$newfilename."-CL.pdf");
        copy ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/iso/history/".$newfilename."-INST.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/iso/attach/".$newfilename."-INST.pdf");
        copy ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/iso/history/".$newfilename."-PROC.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/iso/attach/".$newfilename."-PROC.pdf");
        copy ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/iso/history/".$newfilename.".zip");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/iso/attach/".$newfilename.".zip");


         //FOR TRANSMITTALS

        rename ("../public/storage/isoctrl/iso/attach/".$newfilename."-CL.pdf","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename.".pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$newfilename."-INST.pdf","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename."-INST.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$newfilename."-PROC.pdf","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename."-PROC.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$newfilename.".zip","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename.".zip");



         Hisoctrl::create([
            'filename' =>$newfilename.".pdf",
            'revision' =>$revision, 
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'issued' => 2,
            'from' =>'IsoController',
            'to' =>'Issued '.$trname,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$newfilename.".pdf",
            'revision' =>$revision, 
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'issued' => 2,
            'from' =>'IsoController',
            'to' =>'Issued '.$trname,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

          // PARA ASIGNAR PROGRESO

           $progress = env('APP_PROGRESS');

            if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$newfilename.".pdf'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Transmittal' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

                }else{

                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Transmittal' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO
        
            Disoctrl::where('filename',$filename)->update([
              'filename' => $newfilename.".pdf",
              'isostatus_id' =>13,//ISO,
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'issuedfolder' =>$trname, //folder de emisión
              'revision' => $revision, 
              'issuedate' =>$issuedate, //fecha de emisión
              'ddesign' =>$currentdate,
              'diso' =>$currentdate
                ]);

             }else{

               Disoctrl::where('filename',$filename)->update([
              'filename' => $newfilename.".pdf",
              'isostatus_id' =>13,//ISO,
              'issuedfolder' =>$trname, //folder de emisión
              'revision' => $revision, 
              'issuedate' =>$issuedate, //fecha de emisión
              'ddesign' =>$currentdate,
              'diso' =>$currentdate
                ]);

              }

        return redirect('iso')->with('success','SUCCESS! The Isofile '.$filename.' has been Issued!');

    }

    public function sendfromisobulk(Request $request)
    {


        $destination = $_POST['destination'];
        $issuedate=$request->issuedate;
        $comments=$request->comments;
        $trn=$request->trn;

        $path = "../public/storage/isoctrl/iso/transmittals/";
        $trndir  = scandir($path);



        $trname=$trndir[$trn[0]];

        mkdir("../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/", 0700);


              if (!is_null($request->filenames)){  
        
        
              foreach ($request->filenames as $filename) {

                  $afilename=explode(".", $filename);

                if ($destination == 'toissue'){

                  if (empty($trname)){

                     return redirect('iso')->with('danger','ERROR! You must select Transmittal!');
                  
                  }

                  $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."-%')"); //PARA EMITIDOS -XX

                  if (is_null($check[0]->filename)){ // SI NO ESTÁ EMITIDO SE BUSCA EL ÚLTIMO SIN -XX

                      $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

                  }

                   $spo = $check[0]->spo;
                   $sit = $check[0]->sit;
                   $revision = $check[0]->revision;
                   $issued = $check[0]->issued;


                   if ($issued==2){ //PARA COMPROBAR REVISIONES

                      $revision = $revision+1;

                   }

                   $newfilename = $afilename[0]."-".$revision;  
                  
                  copy ("../public/storage/isoctrl/iso/".$afilename[0].".pdf","../public/storage/isoctrl/iso/history/".$newfilename.".pdf");
                  rename ("../public/storage/isoctrl/iso/".$afilename[0].".pdf","../public/storage/isoctrl/iso/".$newfilename.".pdf");
                  copy ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/iso/history/".$newfilename."-CL.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/iso/attach/".$newfilename."-CL.pdf");
                  copy ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/iso/history/".$newfilename."-INST.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/iso/attach/".$newfilename."-INST.pdf");
                  copy ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/iso/history/".$newfilename."-PROC.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/iso/attach/".$newfilename."-PROC.pdf");
                  copy ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/iso/history/".$newfilename.".zip");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/iso/attach/".$newfilename.".zip");


                  //FOR TRANSMITTAL

                  rename ("../public/storage/isoctrl/iso/attach/".$newfilename."-CL.pdf","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename.".pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$newfilename."-INST.pdf","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename."-INST.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$newfilename."-PROC.pdf","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename."-PROC.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$newfilename.".zip","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename.".zip");

                

                   Hisoctrl::create([
                      'filename' =>$newfilename.".pdf",
                      'revision' =>$revision,
                      'spo' =>$spo,
                      'sit' =>$sit,
                      'requested' =>$requestbydesign,
                      'requestedlead' =>$requestbylead,
                      'issued' => 2,
                      'from' =>'IsoController',
                      'to' =>'Issued '.$trname,
                      'comments' =>$comments,
                      'user' =>Auth::user()->name,
                       ]);


                    //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$newfilename.".pdf",
                      'revision' =>$revision,
                      'spo' =>$spo,
                      'sit' =>$sit,
                      'requested' =>$requestbydesign,
                      'requestedlead' =>$requestbylead,
                      'issued' => 2,
                      'from' =>'IsoController',
                      'to' =>'Issued '.$trname,
                      'comments' =>$comments,
                      'user' =>Auth::user()->name,
                       ]);

                    $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

                         // PARA ASIGNAR PROGRESO

                        $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$newfilename.".pdf'"); 


                        $progress = env('APP_PROGRESS');

                          if ($progress==1){

                            $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$newfilename.".pdf'"); 
                            $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

                        //$tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

                         if ($ifc==1){

                            $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Transmittal' AND tpipes_id=".$tpipes[0]->tpipes_id);
                            $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                                  
                          }else{                                                          
                                                  
                            $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Transmittal' AND tpipes_id=".$tpipes[0]->tpipes_id);
                            $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                 
                          }
                      // FIN PARA ASIGNAR PROGRESO

                  
                      Disoctrl::where('filename',$filename)->update([
                        'filename' => $newfilename.".pdf",
                        'isostatus_id' =>13,//ISO
                        'issuedfolder' =>$trname, //folder de emisión
                        'revision' => $revision, //revision de la emitida
                        'progress' =>$progress[0]->value,
                        'progressreal' =>$progress[0]->value,
                        'progressmax' =>$progressmax[0]->max,
                        'issuedate' =>$issuedate, //fecha de emisión
                        'ddesign' =>$currentdate,
                        'diso' =>$currentdate
                          ]);

                        }else{

                       Disoctrl::where('filename',$filename)->update([
                       'filename' => $newfilename.".pdf",
                        'isostatus_id' =>13,//ISO
                        'issuedfolder' =>$trname, //folder de emisión
                        'revision' => $revision, //revision de la emitida
                        'issuedate' =>$issuedate, //fecha de emisión
                        'ddesign' =>$currentdate,
                        'diso' =>$currentdate
                        ]);

                      }

                  }elseif ($destination =='comments') {

                          rename ("../public/storage/isoctrl/iso/".$filename,"../public/storage/isoctrl/design/".$filename);
                          rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
                          rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
                          rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
                          rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");

                          
                          Hisoctrl::create([
                          'filename' =>$filename,
                          'revision' =>$revision,
                          'spo' =>$spo,
                          'sit' =>$sit,
                          'requested' =>$requestbydesign,
                          'requestedlead' =>$requestbylead,
                          'from' =>'IsoController',
                          'to' =>'With Comments',
                          'comments' =>$comments,
                          'user' =>Auth::user()->name,
                           ]);

                           //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

                     Misoctrl::where('filename',$filename)->update([
                           'filename' =>$filename,
                          'revision' =>$revision,
                          'spo' =>$spo,
                          'sit' =>$sit,
                          'requested' =>$requestbydesign,
                          'requestedlead' =>$requestbylead,
                          'from' =>'IsoController',
                          'to' =>'With Comments',
                          'comments' =>$comments,
                          'user' =>Auth::user()->name,
                           ]);

                             // PARA ASIGNAR PROGRESO

                            $progress = env('APP_PROGRESS');

                          if ($progress==1){

                            $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
                            $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

                             if ($ifc==1){

                                $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Design' AND tpipes_id=".$tpipes[0]->tpipes_id);
                                $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                                      
                              }else{                                                          
                                                      
                                $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Design' AND tpipes_id=".$tpipes[0]->tpipes_id);
                                $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                     
                              }
                          // FIN PARA ASIGNAR PROGRESO

                          Disoctrl::where('filename',$filename)->update([
                          'isostatus_id' =>16,//RETURN BY ISO 
                          'progress' =>$progress[0]->value, //REGRESO
                          'progressreal' =>$progress[0]->value,
                          'progressmax' =>$progressmax[0]->max,            
                           ]);

                             }else{

                             Disoctrl::where('filename',$filename)->update([
                             'isostatus_id' =>16,//RETURN BY ISO 
                              ]);

                         }

                      }


                      }//END FOREACH

          return redirect('iso')->with('success','SUCCESS! The selected IsoFiles have been sent to '.$destination.'!');

       }else{

          return redirect('iso')->with('danger','ERROR! You must select at least one IsoFile!');
       }

    }

    public function sendfromisobulk_bak(Request $request)
    {

              $destination = $_POST['destination'];
              $trn=$request->trn;
              $issuedate=$request->issuedate;
              $filename=$request->filename;
              $comments=$request->comments;

              $path = "../public/storage/isoctrl/iso/transmittals/";
              $trndir  = scandir($path);

              $trname=$trndir[$trn[0]];


       if (!is_null($request->filenames)){       

              foreach ($request->filenames as $filename) {

                $afilename=explode(".", $filename);
                $results = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

                  $requestbydesign=$results[0]->requestbydesign;
                  $requestbylead=$results[0]->requestbylead;

                  //para mantener el request pero no bloquear
                  if ($requestbydesign==1){$requestbydesign=2;}
                  if ($requestbylead==1){$requestbylead=2;} 

                  $revision = $results[0]->revision;
                  $issued = $results[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }  


   if ($destination == 'toissue'){

    if (empty($trname)){


      return redirect('iso')->with('danger','ERROR! You must select Transmittal!');

    }
        
         $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if (is_null($revision)){

            $revision = 0;

         }

         if ($issued!=0){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        copy ("../public/storage/isoctrl/iso/".$filename,"../public/storage/isoctrl/iso/history/".$afilename[0]."-".$revision.".".$afilename[1]);
        rename ("../public/storage/isoctrl/iso/".$filename,"../public/storage/isoctrl/iso/".$afilename[0]."-".$revision.".".$afilename[1]);
        copy ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/iso/history/".$afilename[0]."-".$revision."-CL.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-".$revision."-CL.pdf");
        copy ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/iso/history/".$afilename[0]."-".$revision."-INST.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-".$revision."-INST.pdf");
        copy ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/iso/history/".$afilename[0]."-".$revision."-PROC.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/iso/attach/".$afilename[0]."-".$revision."-PROC.pdf");
        copy ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/iso/history/".$afilename[0]."-".$revision.".zip");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/iso/attach/".$afilename[0]."-".$revision.".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}


               copy ("../public/storage/isoctrl/iso/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/iso/history/".$afilename[0]."-".$revision.$correlative.".dxf");
              rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$afilename[0]."-".$revision.$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


          copy ("../public/storage/isoctrl/iso/attach/".$afilename[0].".b","../public/storage/isoctrl/iso/history/".$afilename[0]."-".$revision.".b");  
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".b","../public/storage/isoctrl/iso/attach/".$afilename[0]."-".$revision.".b");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".cii","../public/storage/isoctrl/iso/attach/".$afilename[0]."-".$revision.".cii");

        $newfilename = $afilename[0]."-".$revision;

        rename ("../public/storage/isoctrl/iso/attach/".$newfilename."-CL.pdf","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename.".pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$newfilename."-PROC.pdf","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename."-PROC.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$newfilename."-INST.pdf","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename."-INST.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$newfilename.".zip","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename.".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}


              rename ("../public/storage/isoctrl/iso/attach/".$newfilename.$correlative.".dxf","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename.$correlative.".dxf");


          }
        
        // FIN VARIOS DXF

        
         rename ("../public/storage/isoctrl/iso/attach/".$newfilename.".b","../public/storage/isoctrl/iso/transmittals/".$trname."/".$issuedate."/".$newfilename.".b");

         Hisoctrl::create([
            'filename' =>$afilename[0]."-".$revision.".".$afilename[1],
            'revision' =>$revision,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'issued' => 2,
            'from' =>'IsoController',
            'to' =>'Issued '.$trname,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$afilename[0]."-".$revision.".".$afilename[1],
            'revision' =>$revision,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'issued' => 2,
            'from' =>'IsoController',
            'to' =>'Issued '.$trname,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA
        
            Disoctrl::where('filename',$filename)->update([
              'filename' => $afilename[0]."-".$revision.".".$afilename[1],
              'isostatus_id' =>13,//ISO
              'ddesign' =>$currentdate,
              'diso' =>$currentdate
                ]);
      

  }elseif ($destination =='comments') {
    
        rename ("../public/storage/isoctrl/iso/".$filename,"../public/storage/isoctrl/design/".$filename);
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");

       // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}


                rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF



        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'IsoController',
            'to' =>'Design',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'IsoController',
            'to' =>'Design',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//DESIGN
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


  }

              }//ENDFOREACH
                    
         return redirect('iso')->with('success','SUCCESS! The selected IsoFiles have been sent to '.$destination.'!');
             //return $quien;

       }else{

          return redirect('iso')->with('danger','ERROR! You must select at least one IsoFile!');
       }
                

    }



    public function sendtosupportsfromstress(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
      
        rename ("../public/storage/isoctrl/stress/".$filename,"../public/storage/isoctrl/supports/".$filename);
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf");
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf");
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf");
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".zip","../public/storage/isoctrl/supports/attach/".$afilename[0].".zip");

      // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}


                rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".b","../public/storage/isoctrl/supports/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".cii","../public/storage/isoctrl/supports/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Stress',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Stress',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // PARA ASIGNAR PROGRESO

                $progress = env('APP_PROGRESS');

                  if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

                }else{

                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO

        $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA
        
            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>3,//SUPPORTS
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'dstress' =>$currentdate,
              'insupports' =>$currentdate,
              'instress' =>''
                ]);


               }else{

                Disoctrl::where('filename',$filename)->update([
                 'isostatus_id' =>3,//SUPPORTS
                'progress' =>$progress[0]->value,
                'progressreal' =>$progress[0]->value,
                'progressmax' =>$progressmax[0]->max,
                'ddesign' =>$currentdate,
                'dstress' =>$currentdate,
                'insupports' =>$currentdate,
                'instress' =>''
                 ]);

              }



      
      
        return redirect('stress')->with('success','SUCCESS! '.$filename.' has been sent to Supports!');

    }


     public function sendfromstressbulk(Request $request)
    {

              $ifc = env('APP_IFC');
              $destination = $_POST['destination'];
              $comments=$request->comments;

       if (!is_null($request->filenames)){       

              foreach ($request->filenames as $filename) {

                $afilename=explode(".", $filename);
                $results = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

                  $requestbydesign=$results[0]->requestbydesign;
                  $requestbylead=$results[0]->requestbylead;

                  //para mantener el request pero no bloquear
                  if ($requestbydesign==1){$requestbydesign=2;}
                  if ($requestbylead==1){$requestbylead=2;} 

                  $spo = $results[0]->spo;
                  $sit = $results[0]->sit;
                  $revision = $results[0]->revision;
                  $issued = $results[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }  


   if ($destination == 'supports'){        
        
        rename ("../public/storage/isoctrl/stress/".$filename,"../public/storage/isoctrl/supports/".$filename);
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".zip","../public/storage/isoctrl/supports/attach/".$afilename[0].".zip");

      // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}


                rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".b","../public/storage/isoctrl/supports/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".cii","../public/storage/isoctrl/supports/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Stress',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Stress',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

              $progress = env('APP_PROGRESS');

             if ($progress==1){

               $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>3,//SUPPORTS
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


             }else{

                Disoctrl::where('filename',$filename)->update([
               'isostatus_id' =>3,//SUPPORTS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                 ]);

              }

  }elseif ($destination == 'ldgmaterials'){        
        
        rename ("../public/storage/isoctrl/stress/".$filename,"../public/storage/isoctrl/materials/".$filename);
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".zip","../public/storage/isoctrl/materials/attach/".$afilename[0].".zip");

      // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}


                rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".b","../public/storage/isoctrl/materials/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".cii","../public/storage/isoctrl/materials/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Stress',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Stress',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO
            $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


            }else{

               Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

              }

  }elseif($destination=='ldgstress'){  
  
            $requested = DB::select("SELECT max(id) as id FROM hisoctrls WHERE filename='".$filename."'");

                DB::table('hisoctrls')->where('id', $requested[0]->id)->update(array(

                  'from' => 'Stress',
                  'verifystress' => 1));
  

  }elseif ($destination =='comments') {
    
        rename ("../public/storage/isoctrl/stress/".$filename,"../public/storage/isoctrl/design/".$filename);
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");
        
    // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF

        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Stress',
            'to' =>'Design',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Stress',
            'to' =>'Design',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

            $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Design' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Design' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//DESIGN
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          
            }else{

               Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//DESIGN
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

              }




  }

              }//ENDFOREACH
                    
         return redirect('stress')->with('success','SUCCESS! The selected IsoFiles have been sent to '.$destination.'!');
             //return $quien;

       }else{

          return redirect('stress')->with('danger','ERROR! You must select at least one IsoFile!');
       }
                

    }

    public function sendtomaterialsfromsupports(Request $request)
    {

        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        rename ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/materials/".$filename);
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".zip","../public/storage/isoctrl/materials/attach/".$afilename[0].".zip");

      // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

                rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".b","../public/storage/isoctrl/materials/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".cii","../public/storage/isoctrl/materials/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Supports',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Supports',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);
 

            $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA
        
            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'ddesign' =>$currentdate,
              'dsupports' =>$currentdate,
              'inmaterials' =>$currentdate,
              'insupports' =>''
                ]);

        return redirect('supports')->with('success','SUCCESS! '.$filename.' has been sent to Materials!');

    }

    public function sendfromsupportsbulk(Request $request)
    {

              $ifc = env('APP_IFC');
              $destination = $_POST['destination'];
              $comments=$request->comments;

       if (!is_null($request->filenames)){       

              foreach ($request->filenames as $filename) {

                $afilename=explode(".", $filename);
                $results = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

                  $requestbydesign=$results[0]->requestbydesign;
                  $requestbylead=$results[0]->requestbylead;

                  //para mantener el request pero no bloquear
                  if ($requestbydesign==1){$requestbydesign=2;}
                  if ($requestbylead==1){$requestbylead=2;} 

                  $spo = $results[0]->spo;
                  $sit = $results[0]->sit; 
                  $revision = $results[0]->revision;
                  $issued = $results[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }  


   if ($destination == 'materials'){        
        
        rename ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/materials/".$filename);
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".zip","../public/storage/isoctrl/materials/attach/".$afilename[0].".zip");

      // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

                      rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".b","../public/storage/isoctrl/materials/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".cii","../public/storage/isoctrl/materials/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Supports',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Supports',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

               // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              //'revision' =>$revision,
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

          }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


              }

   }elseif ($destination == 'ldgmaterials'){        
        
        rename ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/materials/".$filename);
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".zip","../public/storage/isoctrl/materials/attach/".$afilename[0].".zip");

      // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

                      rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".b","../public/storage/isoctrl/materials/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".cii","../public/storage/isoctrl/materials/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Supports',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
               'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Supports',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO


              $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

           }else{

               Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


              }


    }elseif ($destination == 'stress'){        
        
        rename ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/stress/".$filename);
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".zip","../public/storage/isoctrl/stress/attach/".$afilename[0].".zip");
        
        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".b","../public/storage/isoctrl/stress/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".cii","../public/storage/isoctrl/stress/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Supports',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);


              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Supports',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);
        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

            $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,//STRESS
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

            }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,//STRESS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


              }

    }elseif ($destination == 'ldgstress'){        
        
        rename ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/stress/".$filename);
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".zip","../public/storage/isoctrl/stress/attach/".$afilename[0].".zip");
        
        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".b","../public/storage/isoctrl/stress/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".cii","../public/storage/isoctrl/stress/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifystress' =>1,
            'verifysupports' =>1,
            'fromldgsupports' =>1,
            'from' =>'LDG Supports',
            'to' =>'LDG Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
               'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifystress' =>1,
            'verifysupports' =>1,
            'fromldgsupports' =>1,
            'from' =>'LDG Supports',
            'to' =>'LDG Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

              //  PARA ASIGNAR PROGRESO

            $progress = env('APP_PROGRESS');

             if ($progress==1){
              
              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>18,//LDG STRESS
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


            }else{

               Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>18,//LDG STRESS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


              }

  }elseif($destination=='ldgsupports'){  
  
            $requested = DB::select("SELECT max(id) as id FROM hisoctrls WHERE filename='".$filename."'");

                DB::table('hisoctrls')->where('id', $requested[0]->id)->update(array(

                  'from' => 'Supports',
                  'verifysupports' => 1));

  }elseif ($destination =='comments') {
    
        rename ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/design/".$filename);
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");

      // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

                      rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF

        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Supports',
            'to' =>'Design',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Supports',
            'to' =>'Design',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

            $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Design' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Design' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//DESIGN
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

             }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//DESIGN
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


              }


  }

              }//ENDFOREACH
                    
         return redirect('supports')->with('success','SUCCESS! The selected IsoFiles have been sent to '.$destination.'!');
             //return $quien;

       }else{

          return redirect('supports')->with('danger','ERROR! You must select at least one IsoFile!');
       }
                

    }


    public function sendtoleadfrommaterials(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        rename ("../public/storage/isoctrl/materials/".$filename,"../public/storage/isoctrl/lead/".$filename);
       rename ("../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-CL.pdf");
       rename ("../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-INST.pdf");
       rename ("../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-PROC.pdf");
       rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].".zip","../public/storage/isoctrl/lead/attach/".$afilename[0].".zip");

     // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

                rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/lead/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].".b","../public/storage/isoctrl/lead/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].".cii","../public/storage/isoctrl/lead/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Materials',
            'to' =>'Issuer',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Materials',
            'to' =>'Issuer',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

         // PARA ASIGNAR PROGRESO

         $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Issuer' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

                }else{

                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Issuer' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO
        
            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>14,//LEAD
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'dmaterials' =>$currentdate,
              'inlead' =>$currentdate,
              'inmaterials' =>''
                ]);

              }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>14,//LEAD
              'ddesign' =>$currentdate,
              'dmaterials' =>$currentdate,
              'inlead' =>$currentdate,
              'inmaterials' =>''
                ]);


              }


        return redirect('materials')->with('success','SUCCESS! The Isofile '.$filename.' is prepared to Issue and sent to Issuer!');

    }

      public function sendfrommaterialsbulk(Request $request)
    {

              $ifc = env('APP_IFC');
              $destination = $_POST['destination'];
              $comments=$request->comments;

       if (!is_null($request->filenames)){       

              foreach ($request->filenames as $filename) {

                $afilename=explode(".", $filename);
                $results = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

                  $requestbydesign=$results[0]->requestbydesign;
                  $requestbylead=$results[0]->requestbylead;

                  //para mantener el request pero no bloquear
                  if ($requestbydesign==1){$requestbydesign=2;}
                  if ($requestbylead==1){$requestbylead=2;} 

                  $spo = $results[0]->spo;
                  $sit = $results[0]->sit;
                  $revision = $results[0]->revision;
                  $issued = $results[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }  


   if ($destination == 'lead'){        
        
        rename ("../public/storage/isoctrl/materials/".$filename,"../public/storage/isoctrl/lead/".$filename);
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].".zip","../public/storage/isoctrl/lead/attach/".$afilename[0].".zip");

     // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

                rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/lead/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF

        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].".b","../public/storage/isoctrl/lead/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].".cii","../public/storage/isoctrl/lead/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Materials',
            'to' =>'Issuer',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
               'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Materials',
            'to' =>'Issuer',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

               // PARA ASIGNAR PROGRESO

            $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Issuer' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Issuer' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>14,//LEAD
              //'revision' =>$revision,
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

             }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>14,//LEAD
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


              }


  }elseif ($destination =='comments') {
    
        rename ("../public/storage/isoctrl/materials/".$filename,"../public/storage/isoctrl/design/".$filename);
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");

     // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

                rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF

        
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Materials',
            'to' =>'Design',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Materials',
            'to' =>'Design',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

        // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

            $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Design' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Design' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//DESIGN
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

              }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//DESIGN
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


              }


  }

              }//ENDFOREACH
                    
         return redirect('materials')->with('success','SUCCESS! The selected IsoFiles have been sent to '.$destination.'!');
             //return $quien;

       }else{

          return redirect('materials')->with('danger','ERROR! You must select at least one IsoFile!');
       }
                

    }

    public function rejectfromstress(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


       $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;

         // SI ESTÁ REQUERIDA POR DISEÑO, SPO Y SIT SE COLOCAN NUEVAMENTE EN 1 AL RETORNO SI TIENEN ALGÚN CAMBIO

        if ($check[0]->requested!=0){

            if ($check[0]->spo!=0){

             $spo=1;
             unlink ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf");     

            } 

            if ($check[0]->sit!=0){

             $sit=1;
             unlink ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf");     

            } 

         }

         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
    
        
        rename ("../public/storage/isoctrl/stress/".$filename,"../public/storage/isoctrl/design/".$filename);
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");


         // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Stress',
            'to' =>'With Comments',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Stress',
            'to' =>'With Comments',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

            $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

            // PARA ASIGNAR PROGRESO

            $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

                }else{

                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,// 7 RETURN BY STRESS
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''

                ]);

             }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,// 7 RETURN BY STRESS
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''
              ]);

              }



        return redirect('stress')->with('success','SUCCESS! '.$filename.' has been sent to Design with comments!');

    }

    public function rejectfromsupports(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

        $spo = $check[0]->spo;
        $sit = $check[0]->sit;

        // SI ESTÁ REQUERIDA POR DISEÑO, SPO Y SIT SE COLOCAN NUEVAMENTE EN 1 AL RETORNO SI TIENEN ALGÚN CAMBIO

        if ($check[0]->requested!=0){

            if ($check[0]->spo!=0){

             $spo=1;
             unlink ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf");     

            } 

            if ($check[0]->sit!=0){

             $sit=1;
             unlink ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf");     

            } 

         }

         
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
         rename ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/design/".$filename);
         rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
         rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
         rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
         rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");

     // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

                rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF

        
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Supports',
            'to' =>'With Comments',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Supports',
            'to' =>'With Comments',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

         // PARA ASIGNAR PROGRESO

         $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO

          Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//8 RETURN BY SUPPORTS
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''
                ]);

           }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//8 RETURN BY SUPPORTS
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''
                ]);


              }



        return redirect('supports')->with('success','SUCCESS! '.$filename.' has been sent to Design with comments!');

    }

    public function rejectfrommaterials(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;

// SI ESTÁ REQUERIDA POR DISEÑO, SPO Y SIT SE COLOCAN NUEVAMENTE EN 1 AL RETORNO SI TIENEN ALGÚN CAMBIO

        if ($check[0]->requested!=0){

            if ($check[0]->spo!=0){

             $spo=1;
             unlink ("../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf");     

            } 

            if ($check[0]->sit!=0){

             $sit=1;
             unlink ("../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf");     

            } 

         }

         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        rename ("../public/storage/isoctrl/materials/".$filename,"../public/storage/isoctrl/design/".$filename);
         rename ("../public/storage/isoctrl/materials//attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
         rename ("../public/storage/isoctrl/materials//attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
         rename ("../public/storage/isoctrl/materials//attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
         rename ("../public/storage/isoctrl/materials//attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");

     // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

                rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF

        
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/materials/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Materials',
            'to' =>'With Comments',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Materials',
            'to' =>'With Comments',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

         // PARA ASIGNAR PROGRESO

         $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO

          Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//9 RETURN BY MATERIAL
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''
                ]);

           }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//9 RETURN BY MATERIAL
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''
                ]);


              }



        return redirect('materials')->with('success','SUCCESS! '.$filename.' has been sent to Design with comments!');

    }

    public function rejectfromlead(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;

         // SI ESTÁ REQUERIDA POR DISEÑO, SPO Y SIT SE COLOCAN NUEVAMENTE EN 1 AL RETORNO SI TIENEN ALGÚN CAMBIO

        if ($check[0]->requested!=0){

            if ($check[0]->spo!=0){

             $spo=1;
             unlink ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-PROC.pdf");     

            } 

            if ($check[0]->sit!=0){

             $sit=1;
             unlink ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-INST.pdf");     

            } 

         }

         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
        rename ("../public/storage/isoctrl/lead/".$filename,"../public/storage/isoctrl/design/".$filename);
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");

     // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

                rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf");

          }
        
        // FIN VARIOS DXF

        
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/lead/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Issuer',
            'to' =>'With Comments',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'Issuer',
            'to' =>'With Comments',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

         // PARA ASIGNAR PROGRESO

         $progress = env('APP_PROGRESS');

             if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO

         Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//10 RETURN BY LEAD
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''
                ]);

           }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//10 RETURN BY LEAD
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''
                ]);


              }



        return redirect('lead')->with('success','SUCCESS! '.$filename.' has been sent to Design with comments!');

    }

    public function rejectfromiso(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;
        //$issued=$request->issued;
        $trname=$request->to;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;

         // SI ESTÁ REQUERIDA POR DISEÑO, SPO Y SIT SE COLOCAN NUEVAMENTE EN 1 AL RETORNO SI TIENEN ALGÚN CAMBIO

        if ($check[0]->requested!=0){

            if ($check[0]->spo!=0){

             $spo=1;
             unlink ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf");     

            } 

            if ($check[0]->sit!=0){

             $sit=1;
             unlink ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf");     

            } 

         }

         $revision = $check[0]->revision;
         $issued = $check[0]->issued;



         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
                if ($issued==2){

                  //$issuedfilename=explode("-", $filename);
                  $issuedfilename=substr($filename, 0, -6);

                  copy ("../public/storage/isoctrl/iso/history/".$filename,"../public/storage/isoctrl/design/".$issuedfilename.".pdf");  
                  copy ("../public/storage/isoctrl/iso/history/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$issuedfilename."-CL.pdf");
                  copy ("../public/storage/isoctrl/iso/history/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$issuedfilename."-INST.pdf");
                  copy ("../public/storage/isoctrl/iso/history/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$issuedfilename."-PROC.pdf");
                  copy ("../public/storage/isoctrl/iso/history/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$issuedfilename.".zip");
                  copy ("../public/storage/isoctrl/iso/history/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$issuedfilename.".b");

                      // PARA DXF (VARIOS POR ISO)

                        for ($i=1; $i<99; $i++) 
                          {   

                              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

                                copy ("../public/storage/isoctrl/iso/history/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$issuedfilename.$correlative.".dxf");

                          }
                        
                        // FIN VARIOS DXF    

                         // PARA ASIGNAR PROGRESO

                            $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$issuedfilename."'");

                             if ($ifc==1){

                                $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                                $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                                      
                              }else{                                                          
                                                      
                                $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                                $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                     
                              }
                          // FIN PARA ASIGNAR PROGRESO 

                         Disoctrl::create([
                                'filename' =>$issuedfilename.".pdf",
                                'isostatus_id' =>1, //NEW
                                'progress' =>$progress[0]->value,
                                'progressreal' =>$progress[0]->value,
                                'progressmax' =>$progressmax[0]->max,
                                 ]);

                         Hisoctrl::create([
                                'filename' =>$issuedfilename.".pdf",
                                'comments' =>'From IsoController', //NEW
                                'spo' =>$spo,
                                'sit' =>$sit,
                                 ]);

                         Hisoctrl::where('filename',$filename)->update([
                           'requested' =>0, //YA NO ES REQUERIDA
                           'spo' =>$spo,
                           'sit' =>$sit,
                           'from' =>'IsoController',
                           'to' => $trname.' (D)',
                           'comments' =>$comments,
                           'user' =>Auth::user()->name,            
                           ]);

                          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

                          Misoctrl::where('filename',$filename)->update([
                           'requested' =>0, //YA NO ES REQUERIDA
                           'spo' =>$spo,
                           'sit' =>$sit,
                           'from' =>'IsoController',
                           'to' => $trname.' (D)',
                           'comments' =>$comments,
                           'user' =>Auth::user()->name,            
                           ]);

                          $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'"); 

                         Misoctrl::create([
                                'filename' =>$issuedfilename.".pdf",
                                'isoid' =>$isoid[0]->isoid,
                                'comments' =>'From IsoController', //NEW
                                'spo' =>$spo,
                                'sit' =>$sit,
                                 ]);



                      
                }else{

                  rename ("../public/storage/isoctrl/iso/".$filename,"../public/storage/isoctrl/design/".$filename);
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");

               // PARA DXF (VARIOS POR ISO)

                  for ($i=1; $i<99; $i++) 
                    {   

                        if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

                          rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf");

                    }
                  
                  // FIN VARIOS DXF                  
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");

                  
                  Hisoctrl::create([
                  'filename' =>$filename,
                  'revision' =>$revision,
                  'spo' =>$spo,
                  'sit' =>$sit,
                  'requested' =>$requestbydesign,
                  'requestedlead' =>$requestbylead,
                  'from' =>'IsoController',
                  'to' =>'With Comments',
                  'comments' =>$comments,
                  'user' =>Auth::user()->name,
                   ]);

                   //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
                  'revision' =>$revision,
                  'spo' =>$spo,
                  'sit' =>$sit,
                  'requested' =>$requestbydesign,
                  'requestedlead' =>$requestbylead,
                  'from' =>'IsoController',
                  'to' =>'With Comments',
                  'comments' =>$comments,
                  'user' =>Auth::user()->name,
                   ]);

                  // PARA ASIGNAR PROGRESO

         $progress = env('APP_PROGRESS');

             if ($progress==1){

                    $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
                    $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

                     if ($ifc==1){

                        $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                        $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                              
                      }else{                                                          
                                              
                        $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                        $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);

             
                      }
                  // FIN PARA ASIGNAR PROGRESO

                  Disoctrl::where('filename',$filename)->update([
                  'isostatus_id' =>16,//RETURN BY ISO
                  'progressreal' =>$progress[0]->value,
                  'progressmax' =>$progressmax[0]->max,             
                   ]);

                  }else{

                 Disoctrl::where('filename',$filename)->update([
                  'isostatus_id' =>16,//RETURN BY ISO           
                   ]);


                  }
                      //*************//

        

         $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

         //Disoctrl::where('filename',$filename)->update([
              //'isostatus_id' =>16,//RETURN BY ISO
              //'ddesign' =>$currentdate,
              //'instress' =>'',
              //'insupports' =>'',
              //'inmaterials' =>'',
              //'inlead' =>'',
              //'iniso' =>'',
              //'dstress' =>'',
              //'dsupports' =>'',
              //'dmaterials' =>'',
              //'dlead' =>'',
              //'diso' =>''
               // ]);



        return redirect('iso')->with('success','SUCCESS! '.$filename.' has been sent to Design with comments!');

    }
  }

    public function rejectfromiso2(Request $request) //SOLO PARA MIDOR
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $tray=$request->tray;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;
        //$issued=$request->issued;
        $trname=$request->to;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;

         // SI ESTÁ REQUERIDA POR DISEÑO, SPO Y SIT SE COLOCAN NUEVAMENTE EN 1 AL RETORNO SI TIENEN ALGÚN CAMBIO

        if ($check[0]->requested!=0){

            if ($check[0]->spo!=0){

             $spo=1;
             unlink ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf");     

            } 

            if ($check[0]->sit!=0){

             $sit=1;
             unlink ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf");     

            } 

         }

         $revision = $check[0]->revision;
         $issued = $check[0]->issued;



         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
        
                if ($issued==2){

                  //$issuedfilename=explode("-", $filename);
                  $issuedfilename=substr($filename, 0, -6);

                  copy ("../public/storage/isoctrl/iso/history/".$filename,"../public/storage/isoctrl/design/".$issuedfilename.".pdf");  
                  copy ("../public/storage/isoctrl/iso/history/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$issuedfilename."-CL.pdf");
                  copy ("../public/storage/isoctrl/iso/history/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$issuedfilename."-INST.pdf");
                  copy ("../public/storage/isoctrl/iso/history/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$issuedfilename."-PROC.pdf");
                  copy ("../public/storage/isoctrl/iso/history/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$issuedfilename.".zip");
                  copy ("../public/storage/isoctrl/iso/history/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$issuedfilename.".b");
 

                         // PARA ASIGNAR PROGRESO

                          /*  $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$issuedfilename."'");

                             if ($ifc==1){

                                $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                                $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                                      
                              }else{                                                          
                                                      
                                $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                                $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                     
                              }*/
                          // FIN PARA ASIGNAR PROGRESO 

                         Disoctrl::create([
                                'filename' =>$issuedfilename.".pdf",
                                'isostatus_id' =>1, //NEW
                               /* 'progress' =>$progress[0]->value,
                                'progressreal' =>$progress[0]->value,
                                'progressmax' =>$progressmax[0]->max,*/
                                 ]);

                         Hisoctrl::create([
                                'filename' =>$issuedfilename.".pdf",
                                'comments' =>'From IsoController', //NEW
                                'spo' =>$spo,
                                'sit' =>$sit,
                                 ]);

                         Hisoctrl::where('filename',$filename)->update([
                           'requested' =>0, //YA NO ES REQUERIDA
                           'spo' =>$spo,
                           'sit' =>$sit,
                           'from' =>'IsoController',
                           'to' => $trname.' (D)',
                           'comments' =>$comments,
                           'user' =>Auth::user()->name,            
                           ]);

                         //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

                         Misoctrl::where('filename',$filename)->update([
                                      'filename' =>$issuedfilename.".pdf",
                                      'requested' =>0, //YA NO ES REQUERIDA
                                       'spo' =>$spo,
                                       'sit' =>$sit,
                                       'from' =>'IsoController',
                                       'to' => $trname.' (D)',
                                       'comments' =>$comments,
                                       'user' =>Auth::user()->name,            
                                       ]);

                      
                }elseif ($tray==0){

                  rename ("../public/storage/isoctrl/iso/".$filename,"../public/storage/isoctrl/design/".$filename);
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");

                
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");



                  // PARA ASIGNAR PROGRESO

                    // $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

                    //  if ($ifc==1){

                    //     $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                    //     $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                              
                    //   }else{                                                          
                                              
                    //     $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                    //     $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);

             
                    //   }

                       $nametray = 'Design';
                  // FIN PARA ASIGNAR PROGRESO

                  Disoctrl::where('filename',$filename)->update([
                  'isostatus_id' =>16,//DESIGN RETURN BY ISO
                  // 'progressreal' =>$progress[0]->value,
                  // 'progressmax' =>$progressmax[0]->max,             
                   ]);
                  //*************//

                  }elseif ($tray==1){

                  rename ("../public/storage/isoctrl/iso/".$filename,"../public/storage/isoctrl/stress/".$filename);
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/stress/attach/".$afilename[0].".zip");
                 
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".b","../public/storage/isoctrl/stress/attach/".$afilename[0].".b");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".cii","../public/storage/isoctrl/stress/attach/".$afilename[0].".cii");


                  // PARA ASIGNAR PROGRESO

                    // $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

                    //  if ($ifc==1){

                    //     $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                    //     $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                              
                    //   }else{                                                          
                                              
                    //     $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                    //     $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);

             
                    //   }

                      $nametray = 'Stress';
                  // FIN PARA ASIGNAR PROGRESO

                  Disoctrl::where('filename',$filename)->update([
                  'isostatus_id' =>2,//STRESS RETURN BY ISO
                  // 'progressreal' =>$progress[0]->value,
                  // 'progressmax' =>$progressmax[0]->max,             
                   ]);
                  //*************//

                  }elseif ($tray==2){

                  rename ("../public/storage/isoctrl/iso/".$filename,"../public/storage/isoctrl/supports/".$filename);
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/supports/attach/".$afilename[0].".zip");
                 
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".b","../public/storage/isoctrl/supports/attach/".$afilename[0].".b");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".cii","../public/storage/isoctrl/supports/attach/".$afilename[0].".cii");



                  // PARA ASIGNAR PROGRESO

                    // $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

                    //  if ($ifc==1){

                    //     $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                    //     $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                              
                    //   }else{                                                          
                                              
                    //     $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                    //     $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);

             
                    //   }

                      $nametray = 'Supports';
                  // FIN PARA ASIGNAR PROGRESO

                  Disoctrl::where('filename',$filename)->update([
                  'isostatus_id' =>3,//SUPPORTS RETURN BY ISO
                  // 'progressreal' =>$progress[0]->value,
                  // 'progressmax' =>$progressmax[0]->max,             
                   ]);
                  //*************//

                  }elseif ($tray==3){

                  rename ("../public/storage/isoctrl/iso/".$filename,"../public/storage/isoctrl/materials/".$filename);
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/materials/attach/".$afilename[0].".zip");
                 
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".b","../public/storage/isoctrl/materials/attach/".$afilename[0].".b");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".cii","../public/storage/isoctrl/materials/attach/".$afilename[0].".cii");

                  
                  

                  // PARA ASIGNAR PROGRESO

                    // $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

                    //  if ($ifc==1){

                    //     $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                    //     $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                              
                    //   }else{                                                          
                                              
                    //     $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                    //     $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);

             
                    //   }

                      $nametray = 'Spool';
                  // FIN PARA ASIGNAR PROGRESO

                  Disoctrl::where('filename',$filename)->update([
                  'isostatus_id' =>4,//SPOOL RETURN BY ISO
                  // 'progressreal' =>$progress[0]->value,
                  // 'progressmax' =>$progressmax[0]->max,             
                   ]);
                  //*************//

                  }elseif ($tray==4){

                  rename ("../public/storage/isoctrl/iso/".$filename,"../public/storage/isoctrl/lead/".$filename);
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-CL.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-INST.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/lead/attach/".$afilename[0]."-PROC.pdf");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".zip","../public/storage/isoctrl/lead/attach/".$afilename[0].".zip");
                 
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".b","../public/storage/isoctrl/lead/attach/".$afilename[0].".b");
                  rename ("../public/storage/isoctrl/iso/attach/".$afilename[0].".cii","../public/storage/isoctrl/lead/attach/".$afilename[0].".cii");

                  
                  

                  // PARA ASIGNAR PROGRESO

                    // $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

                    //  if ($ifc==1){

                    //     $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Issuer' AND tpipes_id=".$tpipes[0]->tpipes_id);
                    //     $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                              
                    //   }else{                                                          
                                              
                    //     $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Issuer' AND tpipes_id=".$tpipes[0]->tpipes_id);
                    //     $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);

             
                    //   }

                      $nametray = 'Issuer';

                  // FIN PARA ASIGNAR PROGRESO

                  Disoctrl::where('filename',$filename)->update([
                  'isostatus_id' =>14,//Issuer RETURN BY ISO
                  // 'progressreal' =>$progress[0]->value,
                  // 'progressmax' =>$progressmax[0]->max,             
                   ]);
                  //*************//

                  }
                  
                Hisoctrl::create([
                  'filename' =>$filename,
                  'revision' =>$revision,
                  'spo' =>$spo,
                  'sit' =>$sit,
                  'requested' =>$requestbydesign,
                  'requestedlead' =>$requestbylead,
                  'from' =>'IsoController',
                  'to' =>$nametray,
                  'comments' =>$comments,
                  'user' =>Auth::user()->name,
                   ]);  

                    //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
               'filename' =>$filename,
                  'revision' =>$revision,
                  'spo' =>$spo,
                  'sit' =>$sit,
                  'requested' =>$requestbydesign,
                  'requestedlead' =>$requestbylead,
                  'from' =>'IsoController',
                  'to' =>$nametray,
                  'comments' =>$comments,
                  'user' =>Auth::user()->name,
                   ]);         

        return redirect('iso')->with('success','SUCCESS! '.$filename.' has been sent to '.$nametray.' with comments!');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Check item by TIE.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function chktie($filename,$req)
    {

            // $requested = DB::select("SELECT max(id) as id FROM hisoctrls WHERE filename='".$filename."'");
            
            // DB::table('hisoctrls')->where('id', $requested[0]->id)->update(array('tie' => $req));

            // return back();

            $requested = DB::select("SELECT * FROM hisoctrls WHERE filename='".$filename."'"." ORDER BY id DESC LIMIT 1");
            
          
            if ($req == 1){$from=Auth::user()->name;$to='Check by TIE';$comments='Check by TIE';}else{$from=Auth::user()->name;$to='Cancel Check';$comments='Cancel Check';} 

             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$req,
            'spo' =>$requested[0]->spo,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$verify,
            'verifysupports' =>$requested[0]->verifysupports,
            'from' =>$from,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

            // $isostatus = DB::select("SELECT id FROM disoctrls WHERE filename='".$filename."'");

            // DB::table('disoctrls')->where('id', $isostatus[0]->id)->update(array('isostatus_id' => $isostatusid));

            return back();
    }

    /**
     * Check item by SPO.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function chkspo($filename,$req)
    {

            $requested = DB::select("SELECT * FROM hisoctrls WHERE filename='".$filename."'"." ORDER BY id DESC LIMIT 1");
            
          
            if ($req == 1){$from=Auth::user()->name;$to='Check by Process';$comments='Check by Process';}else{$from=Auth::user()->name;$to='Cancel Check';$comments='Cancel Check';} 

             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$req,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$requested[0]->verifystress,
            'verifysupports' =>$requested[0]->verifysupports,
            'from' =>$from,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

             //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

            Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$req,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$requested[0]->verifystress,
            'verifysupports' =>$requested[0]->verifysupports,
            'from' =>$from,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);


            return back();
    }

    /**
     * Check item by SIT.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function chksit($filename,$req)
    {

            //$ifc = env('APP_IFC');

            $requested = DB::select("SELECT * FROM hisoctrls WHERE filename='".$filename."'"." ORDER BY id DESC LIMIT 1");
            
          
            if ($req == 1){$from=Auth::user()->name;$to='Check by Instrumentation';$comments='Check by Instrumentation';}else{$from=Auth::user()->name;$to='Cancel Check';$comments='Cancel Check';} 

             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$requested[0]->spo,
            'sit' =>$req,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$requested[0]->verifystress,
            'verifysupports' =>$requested[0]->verifysupports,
            'from' =>$from,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

            Misoctrl::where('filename',$filename)->update([
            'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$requested[0]->spo,
            'sit' =>$req,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$requested[0]->verifystress,
            'verifysupports' =>$requested[0]->verifysupports,
            'from' =>$from,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);



             // PARA ASIGNAR PROGRESO

              // $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

              //  if ($ifc==1){

              //     $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
              //     $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

              //   }else{

              //     $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
              //     $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
              //   }
            // FIN PARA ASIGNAR PROGRESO


            // Disoctrl::where('filename',$filename)->update([
            //   'isostatus_id' =>4,//MATERIALS
            //   //'revision' =>$revision,
            //   'progress' =>$progress[0]->value,
            //   'progressreal' =>$progress[0]->value,
            //   'progressmax' =>$progressmax[0]->max,
            //   'ddesign' =>$currentdate,
            //   'inmaterials' =>$currentdate
            //     ]);


            return back();
    }

    /**
     * Requested item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reqfromdesign($filename,$req)
    {

            $requested = DB::select("SELECT max(id) as id FROM hisoctrls WHERE filename='".$filename."'");
            
            DB::table('hisoctrls')->where('id', $requested[0]->id)->update(array('requested' => $req));
            DB::table('misoctrls')->where('filename', $filename)->update(array('requested' => $req));

            return back();
    }

    /**
     * Requested item from lead.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reqfromlead($filename,$req)
    {

            $requested = DB::select("SELECT max(id) as id FROM hisoctrls WHERE filename='".$filename."'");
            
            DB::table('hisoctrls')->where('id', $requested[0]->id)->update(array('requestedlead' => $req));

            //return redirect('stress');

            return back();
    }

    /**
     * Requested item from lead.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delfromleadoriso($filename,$del)
    {

            $requested = DB::select("SELECT * FROM hisoctrls WHERE filename='".$filename."'"." ORDER BY id DESC LIMIT 1");
            
            if ($del==1){$comments='DeletedLE';}else{$comments='Cancel Delete';}
            Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$requested[0]->spo,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$del,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$requested[0]->verifystress,
            'verifysupports' =>$requested[0]->verifysupports,
            'from' =>$requested[0]->from,
            'to' =>$requested[0]->to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

             //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

            Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$requested[0]->spo,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$del,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$requested[0]->verifystress,
            'verifysupports' =>$requested[0]->verifysupports,
            'from' =>$requested[0]->from,
            'to' =>$requested[0]->to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

            $isostatus = DB::select("SELECT id FROM disoctrls WHERE filename='".$filename."'");

            DB::table('disoctrls')->where('id', $isostatus[0]->id)->update(array('deleted' => $del));

            //return redirect('stress');

            return back();
    }

    /**
      * VERIFICATION
     */
   

    public function verifyfordesignlead($filename,$verify)
    {

            $ifc = env('APP_IFC');
            $afilename=explode(".", $filename);

            

            $requested = DB::select("SELECT * FROM hisoctrls WHERE filename='".$filename."'"." ORDER BY id DESC LIMIT 1");
            
          
            if ($verify == 1){$isostatusid=17;$from='Design';$to='LDG Design';$comments='VerifyD';}else{$isostatusid=16;$from='Design';$to='Design';$comments='Cancel Verify';} // Isostatus entre LDG Design y Design

             // DB::table('hisoctrls')->where('id', $requested[0]->id)->update(array(

             //  'from' => $from,
             //  'to' => $to,
             //  'verifydesign' => $verify));


             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$requested[0]->spo,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$verify,
            'verifystress' =>$requested[0]->verifystress,
            'verifysupports' =>$requested[0]->verifysupports,
            'from' =>$from,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

            Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$requested[0]->spo,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$verify,
            'verifystress' =>$requested[0]->verifystress,
            'verifysupports' =>$requested[0]->verifysupports,
            'from' =>$from,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

            $isostatus = DB::select("SELECT id FROM disoctrls WHERE filename='".$filename."'");

            
            if ($verify == 1){

                    // PARA ASIGNAR PROGRESO

                    $progress = env('APP_PROGRESS');

                     if ($progress==1){

                        $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
                        $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

                         if ($ifc==1){

                            $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Design' AND tpipes_id=".$tpipes[0]->tpipes_id);
                            $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                                  
                          }else{                                                          
                                                  
                            $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Design' AND tpipes_id=".$tpipes[0]->tpipes_id);
                            $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                 
                          }
                      // FIN PARA ASIGNAR PROGRESO

                    DB::table('disoctrls')->where('id', $isostatus[0]->id)->update(array('isostatus_id' => $isostatusid,'progress' =>$progress[0]->value,'progressreal' =>$progress[0]->value,'progressmax' =>$progressmax[0]->max));

                      }else{

                       DB::table('disoctrls')->where('id', $isostatus[0]->id)->update(array('isostatus_id' => $isostatusid));


                      }

            }elseif ($verify == 0){

                    // PARA ASIGNAR PROGRESO

               $progress = env('APP_PROGRESS');

                     if ($progress==1){

                        $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
                        $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

                         if ($ifc==1){

                            $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                            $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                                  
                          }else{                                                          
                                                  
                            $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='New' AND tpipes_id=".$tpipes[0]->tpipes_id);
                            $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                 
                          }
                      // FIN PARA ASIGNAR PROGRESO

                    DB::table('disoctrls')->where('id', $isostatus[0]->id)->update(array('isostatus_id' => $isostatusid,'progressreal' =>$progress[0]->value,'progressmax' =>$progressmax[0]->max));

                     }else{

                       DB::table('disoctrls')->where('id', $isostatus[0]->id)->update(array('isostatus_id' => $isostatusid));


                      }
            }

            return back();
    }

    public function verifyforstresslead($filename,$verify)
    {

             $requested = DB::select("SELECT * FROM hisoctrls WHERE filename='".$filename."'"." ORDER BY id DESC LIMIT 1");
            
          
            if ($verify == 1){$isostatusid=18;$from='Stress';$to='LDG Stress';$comments='VerifyST';}else{$isostatusid=2;$from='Stress';$to='Stress';$comments='Cancel Verify';} // Isostatus entre LDG Stress y Stress

             Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$requested[0]->spo,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$verify,
            'verifysupports' =>$requested[0]->verifysupports,
            'from' =>$from,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

              //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

            Misoctrl::where('filename',$filename)->update([
            'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$requested[0]->spo,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$verify,
            'verifysupports' =>$requested[0]->verifysupports,
            'from' =>$from,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

            $isostatus = DB::select("SELECT id FROM disoctrls WHERE filename='".$filename."'");

            DB::table('disoctrls')->where('id', $isostatus[0]->id)->update(array('isostatus_id' => $isostatusid));

            return back();
    }

    public function verifyforsupportslead($filename,$verify)
    {

              $requested = DB::select("SELECT * FROM hisoctrls WHERE filename='".$filename."'"." ORDER BY id DESC LIMIT 1");
            
          
            if ($verify == 1){$isostatusid=19;$from='Supports';$to='LDG Supports';$comments='VerifySP';}else{$isostatusid=3;$from='Supports';$to='Supports';$comments='Cancel Verify';} // Isostatus entre LDG Supports y Supports

              Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$requested[0]->spo,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$requested[0]->verifystress,
            'verifysupports' =>$verify,
            'from' =>$from,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

                //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

            Misoctrl::where('filename',$filename)->update([
             'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$requested[0]->spo,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$requested[0]->claimed,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$requested[0]->verifystress,
            'verifysupports' =>$verify,
            'from' =>$from,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

            $isostatus = DB::select("SELECT id FROM disoctrls WHERE filename='".$filename."'");

            DB::table('disoctrls')->where('id', $isostatus[0]->id)->update(array('isostatus_id' => $isostatusid));

            return back();
    }

     /**END VERIFICATION*/

     public function claimiso($filename,$claim)
    {

            $requested = DB::select("SELECT * FROM hisoctrls WHERE filename='".$filename."'"." ORDER BY id DESC LIMIT 1");
            
          
            if ($claim == 1){$comments='CLAIMED';$to='Claimed';}else{$comments='UNCLAIM';$to='Unclaimed';} 

              Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$requested[0]->spo,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$claim,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$requested[0]->verifystress,
            'verifysupports' =>$requested[0]->verifysupports,
            'fromldgsupports' =>$requested[0]->fromldgsupports,
            'from' =>Auth::user()->name,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

                //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

            Misoctrl::where('filename',$filename)->update([
            'filename' =>$filename,
            'revision' =>$requested[0]->revision,
            'tie' =>$requested[0]->tie,
            'spo' =>$requested[0]->spo,
            'sit' =>$requested[0]->sit,
            'requested' =>$requested[0]->requestbydesign,
            'requestedlead' =>$requested[0]->requestbylead,
            'issued' =>$requested[0]->issued,
            'deleted' =>$requested[0]->deleted,
            'claimed' =>$claim,
            'verifydesign' =>$requested[0]->verifydesign,
            'verifystress' =>$requested[0]->verifystress,
            'verifysupports' =>$requested[0]->verifysupports,
            'fromldgsupports' =>$requested[0]->fromldgsupports,
            'from' =>Auth::user()->name,
            'to' =>$to,
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]); 

            return back();
    }


     /**CLAIM*/



     /**END CLAIM*/

    public function sendtomaterialsfromldgdesign(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;
        $verifydesign=$request->verifydesign;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         } 

        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/materials/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/materials/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/materials/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/materials/attach/".$afilename[0].".cii");  
        
        
         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>$verifysupports,
            'from' =>'LDG Design',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>$verifysupports,
            'from' =>'LDG Design',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         


         // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

                     if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

                }else{

                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              //'revision' =>$revision,
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);

             }else{

               Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);


            }



        return redirect('design')->with('success','SUCCESS! '.$filename.' has been sent to Materials!');

    }

    public function sendtostressfromldgdesign(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;
        $verifydesign=$request->verifydesign;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }

        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/stress/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/stress/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF

        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/stress/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/stress/attach/".$afilename[0].".cii");   
        
        
         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>$verifysupports,
            'from' =>'LDG Design',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>$verifysupports,
            'from' =>'LDG Design',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);


         // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

                     if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

                }else{

                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,//STRESS
              //'revision' =>$revision,
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);

             }else{

               Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,//STRESS
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);


            }



        return redirect('design')->with('success','SUCCESS! '.$filename.' has been sent to Materials!');

    }

     public function sendtosupportsfromldgdesign(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;
        $verifydesign=$request->verifydesign;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }

        rename ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/supports/".$filename);
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".zip","../public/storage/isoctrl/supports/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF

        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".b","../public/storage/isoctrl/supports/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/design/attach/".$afilename[0].".cii","../public/storage/isoctrl/supports/attach/".$afilename[0].".cii");   
        
        
         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>$verifysupports,
            'from' =>'LDG Design',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
              'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>$verifysupports,
            'from' =>'LDG Design',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);


         // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

                     if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

                }else{

                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>3,//SUPPORTS
              //'revision' =>$revision,
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);

             }else{

                Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>3,//SUPPORTS
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);


            }



        return redirect('design')->with('success','SUCCESS! '.$filename.' has been sent to Materials!');

    }

    public function rejectfromldgdesign(Request $request)
    {

        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


       $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
    


         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Design',
            'to' =>'Design',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS

         Misoctrl::where('filename',$filename)->update([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Design',
            'to' =>'Design',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

            $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>1,// DESIGN
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''

                ]);



        return redirect('design')->with('success','SUCCESS! '.$filename.' has been sent to Design with comments!');

    }

    public function sendtomaterialsfromldgstress(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;
        $verifydesign=$request->verifystress;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         } 

        rename ("../public/storage/isoctrl/stress/".$filename,"../public/storage/isoctrl/materials/".$filename);
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".zip","../public/storage/isoctrl/materials/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".b","../public/storage/isoctrl/materials/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".cii","../public/storage/isoctrl/materials/attach/".$afilename[0].".cii");  
        
        
         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>$verifysupports,
            'from' =>'LDG Stress',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
          Misoctrl::where('filename',$filename)->update([
           'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>$verifysupports,
            'from' =>'LDG Stress',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);


         // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

                     if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

                }else{

                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              //'revision' =>$revision,
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);

                 }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);


            }



        return redirect('stress')->with('success','SUCCESS! '.$filename.' has been sent to Materials!');

    }

    public function rejectfromldgstress(Request $request) 
    {

        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


       $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
    


         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Stress',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
          Misoctrl::where('filename',$filename)->update([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Stress',
            'to' =>'Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

            $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>2,// STRESS
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''

                ]);



        return redirect('stress')->with('success','SUCCESS! '.$filename.' has been sent to Stress with comments!');

    }

    public function rejectfromldgstresstodesign(Request $request) // NUEVO
    {

        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;
        $verifystress=$request->verifystress;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


       $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
    
        
        rename ("../public/storage/isoctrl/stress/".$filename,"../public/storage/isoctrl/design/".$filename);
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");


         // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>1, // Directo de LDG Stress LDG Supports
            'from' =>'LDG Stress',
            'to' =>'With Comments',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
         Misoctrl::where('filename',$filename)->update([
           'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>1, // Directo de LDG Stress LDG Supports
            'from' =>'LDG Stress',
            'to' =>'With Comments',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

            $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//RETURN BY LDGSTRESS TO DESIGN
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''

                ]);



        return redirect('stress')->with('success','SUCCESS! '.$filename.' has been sent to Design with comments!');

    }

    public function rejectfromldgstresstoldgsupports(Request $request) // NUEVO
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;
        $verifystress=$request->verifystress;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


       $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;

         // SI ESTÁ REQUERIDA POR DISEÑO, SPO Y SIT SE COLOCAN NUEVAMENTE EN 1 AL RETORNO SI TIENEN ALGÚN CAMBIO

        if ($check[0]->requested!=0){

            if ($check[0]->spo!=0){

             $spo=1;
             unlink ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf");     

            } 

            if ($check[0]->sit!=0){

             $sit=1;
             unlink ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf");     

            } 

         }

         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
    
        
        rename ("../public/storage/isoctrl/stress/".$filename,"../public/storage/isoctrl/supports/".$filename);
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf");
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf");
         rename ("../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf");
          rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".zip","../public/storage/isoctrl/supports/attach/".$afilename[0].".zip");

         // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".b","../public/storage/isoctrl/supports/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/stress/attach/".$afilename[0].".cii","../public/storage/isoctrl/supports/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>1, // Directo de LDG Stress LDG Supports
            'from' =>'LDG Stress',
            'to' =>'LDG Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

         //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
         Misoctrl::where('filename',$filename)->update([
           'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>1, // Directo de LDG Stress LDG Supports
            'from' =>'LDG Stress',
            'to' =>'LDG Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

            $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

            // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

                     if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Supports' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>19,// LDG Supports
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''

                ]);

                }else{

               Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>19,// LDG Supports
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''
              ]);

            }



        return redirect('stress')->with('success','SUCCESS! '.$filename.' has been sent to LDG Supports with comments!');

    }

    public function sendtomaterialsfromldgsupports(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;
        $verifydesign=$request->verifystress;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         } 

        rename ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/materials/".$filename);
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/materials/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".zip","../public/storage/isoctrl/materials/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/materials/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".b","../public/storage/isoctrl/materials/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".cii","../public/storage/isoctrl/materials/attach/".$afilename[0].".cii");  
        
        
         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>$verifysupports,
            'from' =>'LDG Supports',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
         Misoctrl::where('filename',$filename)->update([
           'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>$verifysupports,
            'from' =>'LDG Supports',
            'to' =>'Materials',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);


         // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'"); 

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

                     if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);

                }else{

                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Materials' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO


            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              //'revision' =>$revision,
              'progress' =>$progress[0]->value,
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);

               }else{

               Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>4,//MATERIALS
              'ddesign' =>$currentdate,
              'inmaterials' =>$currentdate
                ]);


            }



        return redirect('supports')->with('success','SUCCESS! '.$filename.' has been sent to Materials!');

    }

    public function sendtoldgstressfromldgsupports(Request $request)
    {

        $ifc = env('APP_IFC');
        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;
        $verifysupports=$request->verifysupports;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


        $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         } 

        rename ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/stress/".$filename);
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-CL.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-INST.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/stress/attach/".$afilename[0]."-PROC.pdf");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".zip","../public/storage/isoctrl/stress/attach/".$afilename[0].".zip");

        // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/stress/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".b","../public/storage/isoctrl/stress/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".cii","../public/storage/isoctrl/stress/attach/".$afilename[0].".cii");  
        
        
         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' => $verifydesign,
            'verifystress' => 1, // Directo de LDG Supports a LDG Stress
            'verifysupports' =>$verifysupports,
            'issued' =>$verifysupports,
            'fromldgsupports' =>1,
            'from' =>'LDG Supports',
            'to' =>'LDG Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
         Misoctrl::where('filename',$filename)->update([
          'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' => $verifydesign,
            'verifystress' => 1, // Directo de LDG Supports a LDG Stress
            'verifysupports' =>$verifysupports,
            'issued' =>$verifysupports,
            'fromldgsupports' =>1,
            'from' =>'LDG Supports',
            'to' =>'LDG Stress',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);


         // SE CREA REGISTRO DE FECHA

        $currentdate = date('d-m-Y');
      

            $revision = 'A';
            $revision_qry = DB::select("SELECT revision FROM disoctrls WHERE filename LIKE '".$filename."'");

            if (is_null($revision_qry[0]->revision)){
              $revision = 'A';
            }else{
              $revision = ++$revision_qry[0]->revision;
            }

            // PARA ASIGNAR PROGRESO

             $progress = env('APP_PROGRESS');

                     if ($progress==1){

              $isoid = DB::select("SELECT isoid FROM misoctrls WHERE filename='".$filename."'");
              $tpipes = DB::select("SELECT tpipes_id FROM dpipesfullview WHERE isoid='".$isoid[0]->isoid."'");

               if ($ifc==1){

                  $progress = DB::select("SELECT * FROM ppipes_ifc WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifc WHERE tpipes_id=".$tpipes[0]->tpipes_id);
                                        
                }else{                                                          
                                        
                  $progress = DB::select("SELECT * FROM ppipes_ifd WHERE level='Stress' AND tpipes_id=".$tpipes[0]->tpipes_id);
                  $progressmax = DB::select("SELECT MAX(value) as max FROM ppipes_ifd WHERE tpipes_id=".$tpipes[0]->tpipes_id);
       
                }
            // FIN PARA ASIGNAR PROGRESO

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>18,//LDG STRESS
              'progressreal' =>$progress[0]->value,
              'progressmax' =>$progressmax[0]->max,
              //'revision' =>$revision,
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);

              }else{

              Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>18,//LDG STRESS
              'ddesign' =>$currentdate,
              'instress' =>$currentdate
                ]);


            }



        return redirect('supports')->with('success','SUCCESS! '.$filename.' has been sent to LDG Stress!'.$verifysupports);

    }

    public function rejectfromldgsupports(Request $request) 
    {

        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


       $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;
         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
    


         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Supports',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
         Misoctrl::where('filename',$filename)->update([
          'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'from' =>'LDG Supports',
            'to' =>'Supports',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);



            $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>3,// SUPPORTS
              'ddesign' =>$currentdate,
              'insupports' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dsupports' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''

                ]);



        return redirect('supports')->with('success','SUCCESS! '.$filename.' has been sent to Stress with comments!');

    }

   

    public function rejectfromldgsupportstodesign(Request $request) // NUEVO
    {

        $filename=$request->filename;
        $comments=$request->comments;
        $requestbydesign=$request->requestbydesign;
        $requestbylead=$request->requestbylead;
        $verifystress=$request->verifystress;

        //para mantener el request pero no bloquear
        if ($requestbydesign==1){$requestbydesign=2;}
        if ($requestbylead==1){$requestbylead=2;} 


       $afilename=explode(".", $filename);

        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

         $spo = $check[0]->spo;
         $sit = $check[0]->sit;

         // SI ESTÁ REQUERIDA POR DISEÑO, SPO Y SIT SE COLOCAN NUEVAMENTE EN 1 AL RETORNO SI TIENEN ALGÚN CAMBIO

        if ($check[0]->requested!=0){

            if ($check[0]->spo!=0){

             $spo=1;
             unlink ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf");     

            } 

            if ($check[0]->sit!=0){

             $sit=1;
             unlink ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf");     

            } 

         }

         $revision = $check[0]->revision;
         $issued = $check[0]->issued;

         if ($issued==2){ //PARA COMPROBAR REVISIONES

            $revision = $revision+1;

         }else{

            $revision = $revision;
         }   
    
        
        rename ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/design/".$filename);
         rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-CL.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-CL.pdf");
         rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-INST.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-INST.pdf");
         rename ("../public/storage/isoctrl/supports/attach/".$afilename[0]."-PROC.pdf","../public/storage/isoctrl/design/attach/".$afilename[0]."-PROC.pdf");
         rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".zip","../public/storage/isoctrl/design/attach/".$afilename[0].".zip");


         // PARA DXF (VARIOS POR ISO)

        for ($i=1; $i<99; $i++) 
          {   

              if ($i<10){$correlative = "-0".$i;}else{$correlative = "-".$i;}

              rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].$correlative.".dxf","../public/storage/isoctrl/design/attach/".$afilename[0].$correlative.".dxf");


          }
        
        // FIN VARIOS DXF


        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".b","../public/storage/isoctrl/design/attach/".$afilename[0].".b");
        rename ("../public/storage/isoctrl/supports/attach/".$afilename[0].".cii","../public/storage/isoctrl/design/attach/".$afilename[0].".cii");

         Hisoctrl::create([
            'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>1, // Directo de LDG Stress LDG Supports
            'from' =>'LDG Supports',
            'to' =>'With Comments',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
         Misoctrl::where('filename',$filename)->update([
           'filename' =>$filename,
            'revision' =>$revision,
            'spo' =>$spo,
            'sit' =>$sit,
            'requested' =>$requestbydesign,
            'requestedlead' =>$requestbylead,
            'verifydesign' =>$verifydesign,
            'verifystress' =>$verifystress,
            'verifysupports' =>1, // Directo de LDG Stress LDG Supports
            'from' =>'LDG Supports',
            'to' =>'With Comments',
            'comments' =>$comments,
            'user' =>Auth::user()->name,
             ]);

            $currentdate = date('d-m-Y'); // SE CREA REGISTRO DE FECHA

            Disoctrl::where('filename',$filename)->update([
              'isostatus_id' =>16,//RETURN BY LDGSTRESS TO DESIGN
              'ddesign' =>$currentdate,
              'instress' =>'',
              'insupports' =>'',
              'inmaterials' =>'',
              'inlead' =>'',
              'iniso' =>'',
              'dstress' =>'',
              'dsupports' =>'',
              'dmaterials' =>'',
              'dlead' =>'',
              'diso' =>''

                ]);



        return redirect('stress')->with('success','SUCCESS! '.$filename.' has been sent to Design with comments!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($filename)
    {



        $design = is_file( "../public/storage/isoctrl/design/".$filename );
        $stress = is_file( "../public/storage/isoctrl/stress/".$filename );
        $supports = is_file( "../public/storage/isoctrl/supports/".$filename );
        $materials = is_file( "../public/storage/isoctrl/materials/".$filename );
        $lead = is_file( "../public/storage/isoctrl/lead/".$filename );
        $iso = is_file( "../public/storage/isoctrl/iso/".$filename );


        header('Content-type: application/pdf');  
        header('Content-Disposition: inline; filename="' . $filename . '"');          
        header('Content-Transfer-Encoding: binary');          
        header('Accept-Ranges: bytes');


         if ($design==true){

            
            //readfile("../public/storage/isoctrl/design/");
            //$path = "../public/storage/isoctrl/design/";
            //$path = "C:XAMPP\HTDOCS\MASTERAPP\ISOCTRL\DESIGN".\$filename;
            //exec('start acrobat.exe"" "'.$path.'"');
            
            //$path = "//es001vs0100/400616/";
            // if (auth()->user()->hasRole('DesignAdmin')){

            //     $path = "..\isoctrl\design/";           
            //     exec('start acrobat.exe  /A zoom=100 '.$path.$filename);
            //     return redirect('design');

            // }else{

                readfile("../public/storage/isoctrl/design/".$filename);

            // };
     

        }elseif ($stress==true){

                readfile("../public/storage/isoctrl/stress/".$filename);

        }elseif ($supports==true){

                readfile("../public/storage/isoctrl/supports/".$filename);

        }elseif ($materials==true){

                readfile("../public/storage/isoctrl/materials/".$filename);

        }elseif ($lead==true){

                readfile("../public/storage/isoctrl/lead/".$filename);

        }else{

                readfile("../public/storage/isoctrl/iso/".$filename);

        }
       
    }

    public function showattach($filename)
    {


        $adesign = is_file( "../public/storage/isoctrl/design/attach/".$filename );
        $astress = is_file( "../public/storage/isoctrl/stress/attach/".$filename );
        $asupports = is_file( "../public/storage/isoctrl/supports/attach/".$filename );
        $amaterials = is_file( "../public/storage/isoctrl/materials/attach/".$filename );
        $alead = is_file( "../public/storage/isoctrl/lead/attach/".$filename );
        $aiso = is_file( "../public/storage/isoctrl/iso/attach/".$filename );

        header('Content-type: application/pdf');  
        header('Content-Disposition: inline; filename="' . $filename . '"');          
        header('Content-Transfer-Encoding: binary');          
        header('Accept-Ranges: bytes');

         if ($adesign==true){

                readfile("../public/storage/isoctrl/design/attach/".$filename);     

        }elseif ($astress==true){

                readfile("../public/storage/isoctrl/stress/attach/".$filename);

        }elseif ($asupports==true){

                readfile("../public/storage/isoctrl/supports/attach/".$filename);

        }elseif ($amaterials==true){

                readfile("../public/storage/isoctrl/materials/attach/".$filename);

        }elseif ($alead==true){

                readfile("../public/storage/isoctrl/lead/attach/".$filename);

        }else{

                readfile("../public/storage/isoctrl/iso/attach/".$filename);

        }
       
    }

    public function download($filename)
    {

        $afilename=explode(".", $filename);

        $adesign = is_file( "../public/storage/isoctrl/design/attach/".$afilename[0].".cii" );

    }

     public function subirArchivoRev(Request $request){


            $tie=$request->tiechk;
            $pathfrom=$request->pathfrom;
            $tray=$request->tray;

            $filename=$request->filename;
            $afilename=explode(".", $filename);

            if (!is_null($request->file('tie'))){ 

              $requested = DB::select("SELECT max(id) as id FROM hisoctrls WHERE filename='".$filename."'");
            
              DB::table('hisoctrls')->where('id', $requested[0]->id)->update(array('tie' => $tie));

              $request->file('tie')->storeAS('public/isoctrl/'.$tray.'/attach/',$afilename[0]."-TIE.pdf"); 

            }

            if (!is_null($request->file('spo'))){ 

              $requested = DB::select("SELECT max(id) as id FROM hisoctrls WHERE filename='".$filename."'");
            
              DB::table('hisoctrls')->where('id', $requested[0]->id)->update(array('spo' => $spo));

              $request->file('spo')->storeAS('public/isoctrl/'.$tray.'/attach/',$afilename[0]."-SPO.pdf"); 

            }

            if (!is_null($request->file('sit'))){ 

              $requested = DB::select("SELECT max(id) as id FROM hisoctrls WHERE filename='".$filename."'");
            
              DB::table('hisoctrls')->where('id', $requested[0]->id)->update(array('sit' => $sit));

              $request->file('sit')->storeAS('public/isoctrl/'.$tray.'/attach/',$afilename[0]."-SIT.pdf"); 

            }

            return back()->with('success','SUCCESS! '.$filename.' has been updated!'.$tie);

     }

        public function subirArchivoCommon(Request $request) // PARA SIT Y SPO
             {  

                    $filename=$request->filename;

                    $pathfrom=$request->pathfrom;

                    $requestbydesign=$request->requestbydesign;
                    $requestbylead=$request->requestbylead; 
                    $revision=$request->revision;
                    $tie=$request->tie; 
                    $spo=$request->procapprej; // si aprueba o no aprueba procesos
                    $sit=$request->instapprej; // si aprueba o no aprueba instrumentación

                    $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$filename."%')");

                    if (is_null($spo)){ //para mantener status de proceso e instrumentación y actualizar from

                      $from = 'Instrumentation';
                      $spo = $check[0]->spo;

                    }elseif (is_null($sit)){

                      $from = 'Process';
                      $sit = $check[0]->sit;

                    }

                    $issued=$check[0]->issued;
                    $deleted=$check[0]->deleted; 
                    $verifydesign=$check[0]->verifydesign;
                    $verifystress=$check[0]->verifystress; 
                    $verifysupports=$check[0]->verifysupports;



                    //para mantener el request pero no bloquear
                    if ($requestbydesign==1){$requestbydesign=2;}
                    if ($requestbylead==1){$requestbylead=2;} 

                    $afilename=explode(".", $filename);

                        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

                        $datetime=$check[0]->created_at;
                        $datetmp=explode(" ", $datetime);
                        $date=explode("-", $datetmp[0]);
                        $time=explode(":", $datetmp[1]);
                        $id=$check[0]->id;

                         
                         $revision = $check[0]->revision;
                         $issued = $check[0]->issued;

                         if ($issued==2){ //PARA COMPROBAR REVISIONES

                            $revision = $revision+1;

                         }else{

                            $revision = $revision;
                         }   
                    

                    //$rules = array(
                       // 'archivo' => 'required|mimes:application/pdf'
                        //); 

                    //$validator = Validator::make(Input::all(), $rules);
                    // $validator = Validator::make(Input::all(), array( 'archivo' => 'mimes:pdf' ) );

                    // Process and Instrumentation

                    $newfile_pdf=$_FILES['pdfspo']['name'];
                    $newfilepart_pdf=explode(".", $newfile_pdf);
                    $newfile_pdf=$_FILES['pdfsit']['name'];
                    $newfilepart_pdf=explode(".", $newfile_pdf);




                  //if($newfilepart[1]=='pdf'){  

                  //if (!$validator->fails()){  

                            if ($pathfrom == 'design'){

                                if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/design/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/design/attach',$afilename[0]."-INST.pdf"); }

                                    Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                                     //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                         'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                            }elseif ($pathfrom == 'ldgdesign'){


                                if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/design/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/design/attach',$afilename[0]."-INST.pdf"); }

                                    Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                                      //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                         'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                            }elseif ($pathfrom == 'stress'){


                                 if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/stress/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/stress/attach',$afilename[0]."-INST.pdf"); }

                              
                                    Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                                    //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                         'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                            }elseif ($pathfrom == 'ldgstress'){

                              
                                 if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/stress/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/stress/attach',$afilename[0]."-INST.pdf"); }


                                    Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                                         //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                         'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);        

                            }elseif ($pathfrom == 'supports'){


                                 if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/supports/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/supports/attach',$afilename[0]."-INST.pdf"); }

                                
                                        Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                                        //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                         'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                            }elseif ($pathfrom == 'ldgsupports'){


                                 if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/supports/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/supports/attach',$afilename[0]."-INST.pdf"); }


                                        Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                                        //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                         'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                            }elseif ($pathfrom == 'lead'){


                                if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/lead/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/lead/attach',$afilename[0]."-INST.pdf"); }

                                    Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]); 

                                         //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                         'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);           
                                
                            }elseif ($pathfrom == 'materials'){


                                if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/materials/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/materials/attach',$afilename[0]."-INST.pdf"); }


                                        Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                                        //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                         'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                            }else{


                                if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/iso/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/iso/attach',$afilename[0]."-INST.pdf"); }

                                        Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead'=>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>1,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                                        //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                         'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>$from,
                                        'to' =>'Checked',
                                        'comments' =>'Checked by '.$from,
                                        'user' =>Auth::user()->name,
                                         ]);

                            }
                    
                    return back()->with('success','SUCCESS! '.$filename.' has been updated!'.$newfilepart[1]);
                                    
                

                 } 
     

    public function subirArchivo(Request $request)
             {  

              //$zip = new ZipArchive;

                    $filename=$request->filename;

                    $pathfrom=$request->pathfrom;

                    $requestbydesign=$request->requestbydesign;
                    $requestbylead=$request->requestbylead; 
                    $revision=$request->revision;
                    $tie=$request->tie; 
                    $spo=$request->spo;
                    $sit=$request->sit; 
                    $issued=$request->issued;
                    $deleted=$request->deleted; 
                    $verifydesign=$request->verifydesign;
                    $verifystress=$request->verifystress; 
                    $verifysupports=$request->verifysupports;



                    //para mantener el request pero no bloquear
                    if ($requestbydesign==1){$requestbydesign=2;}
                    if ($requestbylead==1){$requestbylead=2;} 

                    $afilename=explode(".", $filename);

                        $check = DB::select("SELECT * FROM hisoctrls WHERE id=(SELECT max(id) FROM hisoctrls WHERE  filename LIKE '%".$afilename[0]."%')");

                        $datetime=$check[0]->created_at;
                        $datetmp=explode(" ", $datetime);
                        $date=explode("-", $datetmp[0]);
                        $time=explode(":", $datetmp[1]);
                        $id=$check[0]->id;

                         $spo = $check[0]->spo;
                         $sit = $check[0]->sit;
                         $revision = $check[0]->revision;
                         $issued = $check[0]->issued;

                         if ($issued==2){ //PARA COMPROBAR REVISIONES

                            $revision = $revision+1;

                         }else{

                            $revision = $revision;
                         }   
                    

                    //$rules = array(
                       // 'archivo' => 'required|mimes:application/pdf'
                        //); 

                    //$validator = Validator::make(Input::all(), $rules);
                    // $validator = Validator::make(Input::all(), array( 'archivo' => 'mimes:pdf' ) );
                
                    $newfile=$_FILES['archivo']['name'];
                    $newfilepart=explode(".", $newfile);

                    // Process and Instrumentation

                    $newfile_pdf=$_FILES['pdfspo']['name'];
                    $newfilepart_pdf=explode(".", $newfile_pdf);
                    $newfile_pdf=$_FILES['pdfsit']['name'];
                    $newfilepart_pdf=explode(".", $newfile_pdf);

                    //Attachments
                    $newfile_pdf=$_FILES['pdf']['name'];
                    $newfilepart_pdf=explode(".", $newfile_pdf);

                    $newfile_zip=$_FILES['zip']['name'];
                    $newfilepart_zip=explode(".", $newfile_zip);

                    $newfile_dxf=$_FILES['dxf']['name'];
                    $newfilepart_dxf=explode(".", $newfile_dxf);

                    $newfile_bfl=$_FILES['bfl']['name'];
                    $newfilepart_bfl=explode(".", $newfile_bfl);

                    $newfile_cii=$_FILES['cii']['name'];
                    $newfilepart_cii=explode(".", $newfile_cii);

                   
                    //


                  //if($newfilepart[1]=='pdf'){  

                  //if (!$validator->fails()){  

                            if ($pathfrom == 'design'){

                                copy ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/design/".$filename."_".$date[0].$date[1].$date[2]."_".$time[0].$time[1].$time[2]);

                                if (!is_null($request->file('archivo'))){ $request->file('archivo')->storeAS('public/isoctrl/design',$filename); }

                                if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/design/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/design/attach',$afilename[0]."-INST.pdf"); }

                                if (!is_null($request->file('pdf'))){ $request->file('pdf')->storeAS('public/isoctrl/design/attach',$afilename[0]."-CL.pdf"); }

                                if (!is_null($request->file('zip'))){ $request->file('zip')->storeAS('public/isoctrl/design/attach',$afilename[0].".zip"); }

                                if (!is_null($request->file('dxf'))){ $request->file('dxf')->storeAS('public/isoctrl/design/attach',$newfile_dxf); }

                                if (!is_null($request->file('bfl'))){ $request->file('bfl')->storeAS('public/isoctrl/design/attach',$afilename[0].".b"); }

                                if (!is_null($request->file('cii'))){ $request->file('cii')->storeAS('public/isoctrl/design/attach',$afilename[0].".cii"); }


                                    Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'Design',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                                    //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                         'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'Design',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                            }elseif ($pathfrom == 'ldgdesign'){

                                copy ("../public/storage/isoctrl/design/".$filename,"../public/storage/isoctrl/design/".$filename."_".$date[0].$date[1].$date[2]."_".$time[0].$time[1].$time[2]);

                                if (!is_null($request->file('archivo'))){ $request->file('archivo')->storeAS('public/isoctrl/design',$filename); }

                                if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/design/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/design/attach',$afilename[0]."-INST.pdf"); }

                                if (!is_null($request->file('pdf'))){ $request->file('pdf')->storeAS('public/isoctrl/design/attach',$afilename[0]."-CL.pdf"); }

                                if (!is_null($request->file('zip'))){ $request->file('zip')->storeAS('public/isoctrl/design/attach',$afilename[0].".zip"); }

                                if (!is_null($request->file('dxf'))){ $request->file('dxf')->storeAS('public/isoctrl/design/attach',$newfile_dxf); }

                                if (!is_null($request->file('bfl'))){ $request->file('bfl')->storeAS('public/isoctrl/design/attach',$afilename[0].".b"); }

                                if (!is_null($request->file('cii'))){ $request->file('cii')->storeAS('public/isoctrl/design/attach',$afilename[0].".cii"); }


                                    Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'LDG Design',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                                    //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested' =>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'LDG Design',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                            }elseif ($pathfrom == 'stress'){

                                copy ("../public/storage/isoctrl/stress/".$filename,"../public/storage/isoctrl/stress/".$filename."_".$date[0].$date[1].$date[2]."_".$time[0].$time[1].$time[2]);

                                 if (!is_null($request->file('archivo'))){ $request->file('archivo')->storeAS('public/isoctrl/stress',$filename); }

                                 if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/stress/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/stress/attach',$afilename[0]."-INST.pdf"); }

                                if (!is_null($request->file('pdf'))){ $request->file('pdf')->storeAS('public/isoctrl/stress/attach',$afilename[0]."-CL.pdf"); }

                                if (!is_null($request->file('zip'))){ $request->file('zip')->storeAS('public/isoctrl/stress/attach',$afilename[0].".zip"); }

                                if (!is_null($request->file('dxf'))){ $request->file('dxf')->storeAS('public/isoctrl/stress/attach',$newfile_dxf); }

                                if (!is_null($request->file('bfl'))){ $request->file('bfl')->storeAS('public/isoctrl/stress/attach',$afilename[0].".b"); }

                                if (!is_null($request->file('cii'))){ $request->file('cii')->storeAS('public/isoctrl/stress/attach',$afilename[0].".cii"); }

                                    Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'Stress',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                                     //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'Stress',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);



                            }elseif ($pathfrom == 'ldgstress'){

                                copy ("../public/storage/isoctrl/stress/".$filename,"../public/storage/isoctrl/stress/".$filename."_".$date[0].$date[1].$date[2]."_".$time[0].$time[1].$time[2]);

                                 if (!is_null($request->file('archivo'))){ $request->file('archivo')->storeAS('public/isoctrl/stress',$filename); }

                                 if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/stress/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/stress/attach',$afilename[0]."-INST.pdf"); }

                                if (!is_null($request->file('pdf'))){ $request->file('pdf')->storeAS('public/isoctrl/stress/attach',$afilename[0]."-CL.pdf"); }

                                if (!is_null($request->file('zip'))){ $request->file('zip')->storeAS('public/isoctrl/stress/attach',$afilename[0].".zip"); }

                                if (!is_null($request->file('dxf'))){ $request->file('dxf')->storeAS('public/isoctrl/stress/attach',$newfile_dxf); }

                                if (!is_null($request->file('bfl'))){ $request->file('bfl')->storeAS('public/isoctrl/stress/attach',$afilename[0].".b"); }

                                if (!is_null($request->file('cii'))){ $request->file('cii')->storeAS('public/isoctrl/stress/attach',$afilename[0].".cii"); }

                                    Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'fromldgsupports' =>$check[0]->fromldgsupports,
                                        'from' =>'LDG Stress',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]); 

                                          //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                         'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'fromldgsupports' =>$check[0]->fromldgsupports,
                                        'from' =>'LDG Stress',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);



                            }elseif ($pathfrom == 'supports'){

                                copy ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/supports/".$filename."_".$date[0].$date[1].$date[2]."_".$time[0].$time[1].$time[2]);

                                 if (!is_null($request->file('archivo'))){ $request->file('archivo')->storeAS('public/isoctrl/supports',$filename); }

                                 if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/supports/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/supports/attach',$afilename[0]."-INST.pdf"); }

                                if (!is_null($request->file('pdf'))){ $request->file('pdf')->storeAS('public/isoctrl/supports/attach',$afilename[0]."-CL.pdf"); }

                                if (!is_null($request->file('zip'))){ $request->file('zip')->storeAS('public/isoctrl/supports/attach',$afilename[0].".zip"); }

                                if (!is_null($request->file('dxf'))){ $request->file('dxf')->storeAS('public/isoctrl/supports/attach',$newfile_dxf); }

                                if (!is_null($request->file('bfl'))){ $request->file('bfl')->storeAS('public/isoctrl/supports/attach',$afilename[0].".b"); }

                                if (!is_null($request->file('cii'))){ $request->file('cii')->storeAS('public/isoctrl/supports/attach',$afilename[0].".cii"); }

                                        Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'Supports',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                                           //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'Supports',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                            }elseif ($pathfrom == 'ldgsupports'){

                                copy ("../public/storage/isoctrl/supports/".$filename,"../public/storage/isoctrl/supports/".$filename."_".$date[0].$date[1].$date[2]."_".$time[0].$time[1].$time[2]);

                                 if (!is_null($request->file('archivo'))){ $request->file('archivo')->storeAS('public/isoctrl/supports',$filename); }

                                 if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/supports/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/supports/attach',$afilename[0]."-INST.pdf"); }

                                if (!is_null($request->file('pdf'))){ $request->file('pdf')->storeAS('public/isoctrl/supports/attach',$afilename[0]."-CL.pdf"); }

                                if (!is_null($request->file('zip'))){ $request->file('zip')->storeAS('public/isoctrl/supports/attach',$afilename[0].".zip"); }

                                if (!is_null($request->file('dxf'))){ $request->file('dxf')->storeAS('public/isoctrl/supports/attach',$newfile_dxf); }

                                if (!is_null($request->file('bfl'))){ $request->file('bfl')->storeAS('public/isoctrl/supports/attach',$afilename[0].".b"); }

                                if (!is_null($request->file('cii'))){ $request->file('cii')->storeAS('public/isoctrl/supports/attach',$afilename[0].".cii"); }

                                        Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'LDG Supports',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                                           //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'LDG Supports',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                            }elseif ($pathfrom == 'lead'){

                                copy ("../public/storage/isoctrl/lead/".$filename,"../public/storage/isoctrl/lead/".$filename."_".$date[0].$date[1].$date[2]."_".$time[0].$time[1].$time[2]);

                                if (!is_null($request->file('archivo'))){ $request->file('archivo')->storeAS('public/isoctrl/lead',$filename); }

                                if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/lead/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/lead/attach',$afilename[0]."-INST.pdf"); }

                                if (!is_null($request->file('pdf'))){ $request->file('pdf')->storeAS('public/isoctrl/lead/attach',$afilename[0]."-CL.pdf"); }

                                if (!is_null($request->file('zip'))){ $request->file('zip')->storeAS('public/isoctrl/lead/attach',$afilename[0].".zip"); }

                                if (!is_null($request->file('dxf'))){ $request->file('dxf')->storeAS('public/isoctrl/lead/attach',$newfile_dxf); }

                                if (!is_null($request->file('bfl'))){ $request->file('bfl')->storeAS('public/isoctrl/lead/attach',$afilename[0].".b"); }

                                if (!is_null($request->file('cii'))){ $request->file('cii')->storeAS('public/isoctrl/lead/attach',$afilename[0].".cii"); }

                                    Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'Issuer',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]); 

                                            //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                          'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'Issuer',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);          
                                
                            }elseif ($pathfrom == 'materials'){

                                copy ("../public/storage/isoctrl/materials/".$filename,"../public/storage/isoctrl/materials/".$filename."_".$date[0].$date[1].$date[2]."_".$time[0].$time[1].$time[2]);

                                if (!is_null($request->file('archivo'))){ $request->file('archivo')->storeAS('public/isoctrl/materials',$filename); }

                                if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/materials/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/materials/attach',$afilename[0]."-INST.pdf"); }

                                if (!is_null($request->file('pdf'))){ $request->file('pdf')->storeAS('public/isoctrl/materials/attach',$afilename[0]."-CL.pdf"); }

                                if (!is_null($request->file('zip'))){ $request->file('zip')->storeAS('public/isoctrl/materials/attach',$afilename[0].".zip"); }

                                if (!is_null($request->file('dxf'))){ $request->file('dxf')->storeAS('public/isoctrl/materials/attach',$newfile_dxf); }

                                if (!is_null($request->file('bfl'))){ $request->file('bfl')->storeAS('public/isoctrl/materials/attach',$afilename[0].".b"); }

                                if (!is_null($request->file('cii'))){ $request->file('cii')->storeAS('public/isoctrl/materials/attach',$afilename[0].".cii"); }

                                        Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'Materials',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                                           //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                         'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead' =>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>$issued,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'Materials',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                            }else{

                                copy ("../public/storage/isoctrl/iso/".$filename,"../public/storage/isoctrl/iso/".$filename."_".$date[0].$date[1].$date[2]."_".$time[0].$time[1].$time[2]);

                                if (!is_null($request->file('archivo'))){ $request->file('archivo')->storeAS('public/isoctrl/iso',$filename); }

                                if (!is_null($request->file('pdfspo'))){ $request->file('pdfspo')->storeAS('public/isoctrl/iso/attach',$afilename[0]."-PROC.pdf"); }

                                if (!is_null($request->file('pdfsit'))){ $request->file('pdfsit')->storeAS('public/isoctrl/iso/attach',$afilename[0]."-INST.pdf"); }

                                if (!is_null($request->file('pdf'))){ $request->file('pdf')->storeAS('public/isoctrl/iso/attach',$afilename[0]."-CL.pdf"); }

                                if (!is_null($request->file('zip'))){ $request->file('zip')->storeAS('public/isoctrl/iso/attach',$afilename[0].".zip"); }

                                if (!is_null($request->file('dxf'))){ $request->file('dxf')->storeAS('public/isoctrl/iso/attach',$newfile_dxf); }

                                if (!is_null($request->file('bfl'))){ $request->file('bfl')->storeAS('public/isoctrl/iso/attach',$afilename[0].".b"); }

                                if (!is_null($request->file('cii'))){ $request->file('cii')->storeAS('public/isoctrl/iso/attach',$afilename[0].".cii"); }

                                        Hisoctrl::create([
                                        'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead'=>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>1,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'Iso',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                                           //REGISTRO PARA LECTURA DE ULTIMO MOVIMIENTO DE ISOS
                                       Misoctrl::where('filename',$filename)->update([
                                       'filename' =>$filename,
                                        'revision' =>$revision,
                                        'requested'=>$requestbydesign,
                                        'requestedlead'=>$requestbylead,
                                        'tie' =>$tie,
                                        'spo' =>$spo,
                                        'sit' =>$sit,
                                        'issued' =>1,
                                        'deleted' =>$deleted,
                                        'verifydesign' =>$verifydesign,
                                        'verifystress' =>$verifystress,
                                        'verifysupports' =>$verifysupports,
                                        'from' =>'Iso',
                                        'to' =>'Updated',
                                        'comments' =>'Updated',
                                        'user' =>Auth::user()->name,
                                         ]);

                            }
                    
                    return back()->with('success','SUCCESS! '.$filename.' has been updated!'.$newfilepart[1]);
                                    
                

                 } 
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
