<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Hash;
use Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer::all();
        return view('customer.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'number' => 'required|max:10',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:12',
        ]);

        $data = new Customer;
        $data->fname = $request->fname;
        $data->lname = $request->lname;
        $data->number = $request->number;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);

        if ($data->save()) {
            $reg_ref = $request->reg_ref;
            if ($reg_ref == 'frontRegister') {
                return redirect('registration')->with('success', 'You have registered successfully!');
            } else {
                return redirect('admin/customer/create')->with('success', 'The customer has been added successfully!');
            }
        } else {
            $reg_ref = $request->reg_ref;
            if ($reg_ref == 'frontRegister') {
                return redirect('registration')->with('fail', 'Something went wrong! Try again.');
            } else {
                return redirect('admin/customer/create')->with('fail', 'Something went wrong! Try again.');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Customer::find($id);
        return view('customer.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Customer::find($id);
        return view('customer.edit', ['data' => $data]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'number' => 'required|max:10',
            'email' => 'required|email|unique:users',
        ]);

        $data = Customer::find($id);
        $data->fname = $request->fname;
        $data->lname = $request->lname;
        $data->number = $request->number;
        $data->email = $request->email;
        $data->save();

        if ($data) {
            return redirect('admin/customer/' . $id . '/edit')->with('success', 'The room type has been updated successfully!');
        } else {
            return redirect('admin/customer/' . $id . '/edit')->with('fail', 'Something went wrong! Try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::where('id', $id)->delete();

        return redirect('admin/customer')->with('success', 'The customer has been deleted successfully!');
    }

    //User login functionality
    public function login()
    {
        return view("home");
    }

    public function loginCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:12',
        ]);

        $data = Customer::where('email', '=', $request->email)->first();
        if ($data) {
            if (Hash::check($request->password, $data->password)) {
                $request->session()->put('loginId', $data->id);
                $request->session()->put('fname', $data->fname);
                return redirect('home');
            } else {
                return back()->with('fail', 'The password was not correct! Try again.');
            }
        } else {
            return back()->with('fail', 'The email was not correct! Try again.');
        }
    }

    public function registration()
    {
        return view("registration");
    }

    public function logout()
    {
        session()->forget(['loginId', 'data']);
        return redirect('home');
    }
}