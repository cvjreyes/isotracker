@extends('layouts.datatable')
@section('content')
<br><br><br><br><br><br><br>
 <center><h2><b>Change Password</b></h2></center>
@if (Session::has('message'))
 <center><div class="text-danger">
 {{Session::get('message')}}
 </div></center>
@endif

 <div class="col-md-4 col-md-offset-4" >
<div class="row">

        <div class="container-fluid" style="height: 60%;width: 80%">
            <br>
            <div class="panel panel-default">
   
               <div class="panel-body">

                <form method="post" action="{{url('user/updatepassword')}}">
					 {{csrf_field()}}
					 <div class="form-group">
					  <label for="mypassword">Current Password:</label>
					  <input type="password" name="mypassword" class="form-control">
					  <div class="text-danger">{{$errors->first('mypassword')}}</div>
					 </div>
					 <div class="form-group">
					  <label for="password">New Password:</label>
					  <input type="password" name="password" class="form-control">
					  <div class="text-danger">{{$errors->first('password')}}</div>
					 </div>
					 <div class="form-group">
					  <label for="mypassword">Confirm new Password:</label>
					  <input type="password" name="password_confirmation" class="form-control">
					  <div class="text-danger">{{$errors->first('password')}}</div>
					 </div>
					 <br>
					 <center><button type="submit" class="btn btn-primary">Change Password</button></center>
					 
					</form>

                    
                </div>
            </div>
        </div>
    </div>
</div>

@stop