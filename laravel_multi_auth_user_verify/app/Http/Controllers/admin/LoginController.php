<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserVerify;
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

            $token = Str::random(64);
            
            UserVerify::create(['user_id' => $user->id,'token' => $token]);
              Mail::send('emails.adminemailVerificationEmail', ['token' => $token], function($message) use($request){
                  $message->to($request->email);
                  $message->subject('Admin Email Verification Mail');
              });

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
    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        $message = 'Sorry your email cannot be identified.';
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
        return redirect()->route('admin.login')->with('message', $message);

    }
}
