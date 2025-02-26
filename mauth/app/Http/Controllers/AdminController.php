<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Admin;
class AdminController extends Controller
{
    public function authenticate(Request $request){
        $this->validate($request,['email'=>'required|email','password'=>'required']);

        if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password],$request->get('remember'))){
            return redirect()->route('admin.dashboard');
        }else{
            session()->flash('error','Either Email or Password is incorrect');
            return back()->withInput($request->only('email'));
        }
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
    public function register(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|confirmed',
            
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }else{
            $admin = new Admin;
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->save();
            return redirect()->route('admin.login')->with('success','Admin register successfully !');

        }
    }
}
