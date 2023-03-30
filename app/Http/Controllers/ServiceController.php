<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Service::all();
        return view('service.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('service.create');
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
            'title'=>'required|string',
            'detail'=>'required|string',
            'price'=>'required|string',
        ]);

        $data = new Service;
        $data->title = $request->title;
        $data->detail= $request->detail;
        $data->price = $request->price;
        $data->save();

        if($data){
            return redirect('admin/service/create')->with('success', 'The service has been added successfully!');
        } else {
            return redirect('admin/service/create')->with('fail', 'Something went wrong! Try again.');
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
        $data=Service::find($id);
        return view('service.show',['data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data=Service::find($id);
        return view('service.edit',['data'=>$data]);

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
            'title'=>'required|string',
            'detail'=>'required|string',
            'price'=>'required|string',
        ]);

        $data = Service::find($id);
        $data->title = $request->title;
        $data->detail= $request->detail;
        $data->price = $request->price;
        $data->save();

        if($data){
            return redirect('admin/service/'.$id.'/edit')->with('success', 'The service has been updated successfully!');
        } else {
            return redirect('admin/service/'.$id.'/edit')->with('fail', 'Something went wrong! Try again.');
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
        Service::where('id',$id)->delete();

        return redirect('admin/service')->with('success', 'The room type has been deleted successfully!');
    }


}
