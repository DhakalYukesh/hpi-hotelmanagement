<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Request;
use App\Models\User;
use Hash;
use Session;


class CustomAuthController extends Controller{
    
    public function login(){
        return view("home");
    }

    public function registration(){
        return view("registration");
    }

    public function registerUser(Request $request){
        $request->validate([
            'fname'=>'required|string',
            'lname'=>'required|string',
            'number'=>'required|max:10',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|max:12',
        ]);
        
        $user = new User();
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->number = $request->number;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $res = $user->save();

        if($res){
            return back()->with('success', 'You have registered successfully!');
        }else{
            return back()->with('fail', 'Something wrong occured! Try again.');
        }
    }

    public function loginUser(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12',
        ]);

        $user = User::where('email','=',$request->email)->first();
        if ($user){
            if(Hash::check($request->password,$user->password)){
                $request->session()->put('loginId', $user->id);
                return redirect('home');
            }else{
                return back()->with('fail', 'The password was not correct! Try again.');
            }
        }else{
            return back()->with('fail', 'The email was not correct! Try again.');
        }   
    }

    public function home(Request $request){
        $data = array();
        if(Session::has('loginId')){
            $data = User::where('id','=', Session::get('loginId'))->first();
        }
        return view('home',compact('data'));
    }

    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('/');
        }
    }
}