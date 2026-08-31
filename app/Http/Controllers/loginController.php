<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function Login(Request $request){
        // validation
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);
// getting form data
    $email=$request->email;
    $password=$request->password;

    $user = user::where('email',$email)->first();
// checking user

if(Auth::attempt([
    'email'=>$email,
    'password'=>$password,
])){
          return redirect()->route('dashboard');

}
    return back()->with('error','invalid email or password');

}
public function Logout(Request $request){
    Auth::logout();
    $request->session()->regenerateToken();
    
    return redirect()->route('login');
}
}

