<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;
class AdminController extends Controller
{
    public function Lpage()
    {
        return view('dashboard.admin.login');
    }

    public function dologin(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6',
        ]);
        $check=$request->only('email','password');
        if(Auth::guard('admin')->attempt($check)){
            return redirect()->route('admin.home')->with('success','Welcome To Dashboard');
        }else{
            return back()->with('fail','Login Failed');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');

    }


}
