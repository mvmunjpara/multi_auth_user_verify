<?php

namespace App\Http\Controllers;

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
            $user->role = 'customer';
            $user->save();

            $token = Str::random(64);
            
            UserVerify::create(['user_id' => $user->id,'token' => $token]);
              Mail::send('emails.emailVerificationEmail', ['token' => $token], function($message) use($request){
                  $message->to($request->email);
                  $message->subject('Email Verification Mail');
              });

            return redirect()->route('account.login')->with('success','User register successfully!');
        }else{
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('account.login')->with('success','User logout successfully !');
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
        return redirect()->route('account.login')->with('message', $message);

    }


}
