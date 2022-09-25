<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
class UserController extends Controller
{
    public function Lpage()
    {
        return view('dashboard.user.login');
    }

    public function Rpage()
    {
        return view('dashboard.user.register');
    }

    public function create(Request $request)
    {
        $request->validate([
           'name'=>'required',
           'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6',
            'cpassword'=>'required|same:password'
        ],
        [
            'cpassword.required'=>'The Confirm field Is Required',
            'cpassword.same'=>'The Confirm Password And Password Should Match'
        ]);

        $data=new User();
        $data->name=$request->get('name');
        $data->email=$request->get('email');
        $data->password=hash::make($request->get('password'));
        $res=$data->save();
        if($res){
            return back()->with('success','You Have Been Registered');
        }else{
            return back()->with('fail','Something Wrong');
        }
    }

    public function dologin(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6',
        ]);
        $check=$request->only('email','password');
        if(Auth::guard('web')->attempt($check)){
            return redirect()->route('user.home')->with('success','Welcome To Dashboard');
        }else{
            return back()->with('fail','Login Failed');
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('user.login');

    }


}
