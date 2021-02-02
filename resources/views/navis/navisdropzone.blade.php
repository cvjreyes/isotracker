@extends('layouts.datatable')

@section('content')

<script type="text/javascript">
                                
                                 window.onload = function() {

                                     document.getElementById("s5").style.fontWeight='bold';
                                     document.getElementById("s5").style.fontSize=10 + "pt";
                                     document.getElementById("s5").style.fontStyle="italic";;


                                 }

                            </script> 

 <div class="container">
        <div class="row" >
            <center><h2 style="padding-top: 7%"><b><i>Naviswork</i></b></h2>
            
      <h3>Upload Configuration</h3></center><br>
       
       
            <div style="margin-top: 2%" class="panel panel-default">
                <div class="panel-heading">
                    <!-- <h3>Dropzone</h3> -->
                    <button type="submit" class="btn btn-info btn-lg" id="submit" style="width:100%">Click here to Upload</button>
                </div>
                <div class="panel-body"  style="width:100%">

                    {!! Form::open(['route'=> 'filenavis.store', 'method' => 'POST', 'files'=>'true', 'id' => 'my-dropzone' , 'class' => 'dropzone']) !!}
                    <div class="dz-message" style="height:200px;">
                        <h3 style="vertical-align: middle">Drop your Excel for Naviswork Configuration</h3>
                    </div>
                    <div class="dropzone-previews"></div>
                    
                    {!! Form::close() !!}
                </div>

            </div>
            <center><h4><b>NOTE: Supported files (.xlsx)</b><h4>
                 <a target='_blank' href="{{ asset('../public/storage/navis/navis.xml') }}">DOWNLOAD LAST XML</a></center>

        </div>
    </div>
    
     <script>
        Dropzone.options.myDropzone = {
            addRemoveLinks: true,
            acceptedFiles: ".xlsx",
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFilezise: 50,
            maxFiles: 1,
            //parallelUploads:100,

            
            init: function() {
                var submitBtn = document.querySelector("#submit");
                myDropzone = this;
                submitBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                //this.on("addedfile", function(file) {
               //     alert("file uploaded");
               //

                this.on("complete", function(file) {
                    myDropzone.removeFile(file);
                });
 
                this.on("success",
                    myDropzone.processQueue.bind(myDropzone)
                );
            }
        }; 
    </script>


@endsection

