<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Staff::all();
        return view('staff.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $departments = Department::all();
        return view('staff.create',['departments'=>$departments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //Saving in staff table
        $data = new Staff;
        $data->fname = $request->fname;
        $data->lname = $request->lname;
        $data->department_id = $request->department_id;
        $data->email = $request->email;
        $data->salary_type = $request->salary_type;
        $data->salary_amount = $request->salary_amount;
        $data->save();
        
        //Saving in admin table
        $admindata = new Admin;
        $admindata->username = $request->fname;
        $admindata->email = $request->email;
        $admindata->password = sha1($request->password);
        $admindata->type = $request->type;
        $admindata->save();

        if($data){
            return redirect('admin/staff/create')->with('success', 'The staff has been added successfully!');
        } else {
            return redirect('admin/staff/create')->with('fail', 'Something went wrong! Try again.');
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
        $data=Staff::find($id);
        return view('staff.show',['data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $departments = Department::all();
        $data=Staff::find($id);
        return view('staff.edit',['data'=>$data,'departments'=>$departments]);

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
        $data = Staff::find($id);
        $data->fname = $request->fname;
        $data->lname = $request->lname;
        $data->department_id = $request->department_id;
        $data->email = $request->email;
        $data->salary_type = $request->salary_type;
        $data->salary_amount = $request->salary_amount;
        $data->save();

        if($data){
            return redirect('admin/staff/'.$id.'/edit')->with('success', 'The staff has been updated successfully!');
        } else {
            return redirect('admin/staff/'.$id.'/edit')->with('fail', 'Something went wrong! Try again.');
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
        Staff::where('id',$id)->delete();

        return redirect('admin/staff')->with('success', 'The staff has been deleted successfully!');
    }

    public function staff_account(){
        $staff = Staff::all();

        return view('staff.staffAccount', ['staff' => $staff]);
    }
}

