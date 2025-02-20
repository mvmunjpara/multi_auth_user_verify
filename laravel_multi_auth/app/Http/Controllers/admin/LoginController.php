<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class LoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),['email'=>'required','password'=>'required']);

        if($validator->passes()){
            if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password])){
                if(Auth::guard('admin')->user()->role !=='admin'){
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error','Either Email or Passwrd incorrect');
                }
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('admin.login')->with('error','Either Email or Passwrd incorrect ');
            }
        }else{
                return redirect()->route('admin.login')->withInput()->withErrors($validator);
            }
    }
    public function register(){
        return view('admin.register');
    }
    public function processRegister(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'password'=>'required|confirmed'
        ]);
        if($validator->passes()){
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('admin.login')->with('success','Admin register successfully!');
        }else{
            return redirect()->route('admin.register')->withInput()->withErrors($validator);
        }
    }
    public function logout(){
        // dd('admin');
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success','Admin logout successfully!');
    }
}
