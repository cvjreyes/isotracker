@extends('layouts.datatable')
@section('content')
<br><br><br><br><br><br><br><br>

@if (Session::has('status'))



  <div class="row">
        <div class="container-fluid" style="height: 60%;width: 80%">
            <br><br><br><br><br>
            <div class="panel panel-default">
  
               <div class="panel-body">

                <center><h1>{{ Auth::user()->name }}</h1>
                <h3>{{Session::get('status')}}</h3>                
                </center>

                    
                </div>
            </div>
        </div>
    </div>
           

@endif


<!-- <h3>Opciones:</h3>
<ul>
    <li><a href="{{url('user/profile')}}">Cambiar mi imagen de perfil</a></li>
    <li><a href="{{url('user/password')}}">Cambiar mi password</a></li>
</ul>
 -->
@stop