<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Customer::all();
        return view('customer.index',['data'=>$data]);
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
            'fname'=>'required|string',
            'lname'=>'required|string',
            'number'=>'required|max:10',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|max:12',
        ]);

        $data = new Customer;
        $data->fname = $request->fname;
        $data->lname = $request->lname;
        $data->number = $request->number;
        $data->email = $request->email;
        $data->password = sha1($request->password);
        $data->save();

        if($data){
            return redirect('admin/customer/create')->with('success', 'The room type has been added successfully!');
        } else {
            return redirect('admin/customer/create')->with('fail', 'Something went wrong! Try again.');
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
        $data=Customer::find($id);
        return view('customer.show',['data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data=Customer::find($id);
        return view('customer.edit',['data'=>$data]);

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
        $data = Customer::find($id);
        $data->title = $request->title;
        $data->detail= $request->detail;
        $data->save();

        if($data){
            return redirect('admin/customer/'.$id.'/edit')->with('success', 'The room type has been updated successfully!');
        } else {
            return redirect('admin/customer/'.$id.'/edit')->with('fail', 'Something went wrong! Try again.');
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
        Customer::where('id',$id)->delete();

        return redirect('admin/customer')->with('success', 'The room type has been deleted successfully!');
    }
}

