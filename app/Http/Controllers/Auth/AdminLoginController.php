<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class AdminLoginController extends Controller
{
    //
    public function __construct(){
        $this->middleware('guest:admin',['except'=>['logout']]);
    }

    public function showLoginForm(){

        return view('auth.admin-login');
    }

    public function login(Request $request){
        // validate from data

        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|min:6',
        ]);
   
        //Attemp to log the user in
        if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password], $request->remember)){
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->back()->withinput($request->only('email','remember'));
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
