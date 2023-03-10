<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Hash;
use Cookie;

class AdminAuthController extends Controller
{
    //Login for the management panel.

    function login(){
        return view('adminlogin');
    }

    //Login check.
    
    function loginCheck(Request $request){

        $request->validate([
            'username'=>'required',
            'password'=>'required',
        ]);

        $admin=Admin::where(['username'=>$request->username, 'password'=>sha1($request->password)])->count();
        
        if ($admin>0){
            $admin_data=Admin::where(['username'=>$request->username, 'password'=>sha1($request->password)])->get();
            session(['admin_data'=>$admin_data]);

            if($request->has('rememberme')){
                Cookie::queue('adminUser', $request->username,1440);
                Cookie::queue('adminPass', $request->password,1440);
            }

            return redirect('admin/dashboard')->with('success', 'You have successfully loged in!');

        }else{
            return redirect('admin')->with('fail','Something went wrong! Try again.');
        }
    }
    
    //Logout for the management panel.

    function logout(){
        session()->forget(['admin_data']);

        return redirect('admin');
    }
}
