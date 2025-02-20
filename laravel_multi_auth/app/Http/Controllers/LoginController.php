<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class LoginController extends Controller
{
    public function index(){
        return view('login');
    }
    public function authenticate(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if($validator->passes()){
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                if(Auth::user()->role !=='customer')
                {
                    Auth::logout();
                    return redirect()->route('account.login')->with('error','You have not persmission!');
                }
                return redirect()->route('account.dashboard');
            }else{
                return redirect()->route('account.login')->with('error','Either Email or Passwrd incorrect ');
            }
        }else{
                return redirect()->route('account.login')->withInput()->withErrors($validator);
            }
    }
    //This method will show register user page
    public function register(){
        return view('register');
    }

    //This method will register user
    public function processRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'password'=>'required'
        ]);
        if($validator->passes()){
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'admin';
            $user->save();
            return redirect()->route('account.login')->with('success','User register successfully!');
        }else{
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('account.login')->with('success','User logout successfully !');
    }

}
