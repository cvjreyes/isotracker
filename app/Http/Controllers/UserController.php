<?php 

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use DB;
use Validator;
use App\User;
use App\Role;
use Auth;
use Hash;



class UserController extends Controller
{

    public function index(){


        $roles = Role::pluck('name')->all();
        return view('user.indexusers')->with('roles', $roles);


    }

    public function indexUsers()
    {

         $indexusers = DB::select("SELECT * FROM users");
                     return Datatables::of($indexusers)
                     ->addColumn('action', function ($indexusers) {
                return '<a onclick "" href="editusers/'.$indexusers->id.'" class="edit-indexusers-modal btn btn-xs btn-primary" data-id ="'.$indexusers->id.'" data-name ="'.$indexusers->name.'" data-email ="'.$indexusers->email.'" data-toggle="modal" data-target="#editindexusersModal"> Modify</a>&nbsp;

                 <a onclick "" href="editusers/'.$indexusers->id.'" class="edit-createuroles-modal btn btn-xs btn-info" data-id ="'.$indexusers->id.'" data-name ="'.$indexusers->name.'" data-email ="'.$indexusers->email.'"  data-toggle="modal" data-target="#createurolesModal">Add Role</a>&nbsp;

                    <a onclick="uroles('."'".$indexusers->name."'".')" href="editusers/'.$indexusers->id.'" class="edit-indexusers-modal btn btn-xs btn-default" data-id ="'.$indexusers->id.'" data-name ="'.$indexusers->name.'" data-email ="'.$indexusers->email.'"  data-toggle="modal" data-target="#showcnotesModa">View Role</a>&nbsp;

                <a href="delindexusers/'.$indexusers->id.'" class="del-indexusers-modal btn btn-xs btn-danger" data-id ="'.$indexusers->id.'" data-name ="'.$indexusers->name.'" data-email ="'.$indexusers->email.'" data-toggle="modal" data-target="#delindexusersModal"> Remove</a>';
            })
                         ->make(true);

    }

    public function jsuroles(){


        return view('user.jsuroles');


    }

    public function user(){

        return View('user.user');
    }

    public function password(){

        return View('user.password');
    }

    public function updatePassword(Request $request){

        
        $rules = [
            'mypassword' => 'required',
            'password' => 'required|confirmed|min:6|max:18',
        ];
        
        $messages = [
            'mypassword.required' => 'Required',
            'password.required' => 'Required',
            'password.confirmed' => 'Password do not match',
            'password.min' => 'Min 6 characters',
            'password.max' => 'Max 18 characters',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()){
            return redirect('user/password')->withErrors($validator);
        }
        else{
            if (Hash::check($request->mypassword, Auth::user()->password)){
                $user = new User;
                $user->where('email', '=', Auth::user()->email)
                     ->update(['password' => bcrypt($request->password)]);
                return redirect('user')->with('status', 'Your password has been changed successfully!');
            }
            else
            {
                return redirect('user/password')->with('message', 'Incorrect credentials');
            }
        }
    }

  
}