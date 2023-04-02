<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Room::all();
        return view('room.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $roomtype = RoomType::all();
        return view('room.create',['roomtype'=>$roomtype]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Room;
        $data->room_type_id = $request->room_type_id;
        $data->title = $request->title;
        $data->save();

        if($data){
            return redirect('admin/room/create')->with('success', 'The room has been added successfully!');
        } else {
            return redirect('admin/room/create')->with('fail', 'Something went wrong! Try again.');
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
        $data=Room::find($id);
        return view('room.show',['data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roomtype = RoomType::all();
        $data=Room::find($id);
        return view('room.edit',['data'=>$data,'roomtype'=>$roomtype]);

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
        $data = Room::find($id);
        $data->room_type_id = $request->room_type_id;
        $data->title = $request->title;
        $data->save();

        if($data){
            return redirect('admin/room/'.$id.'/edit')->with('success', 'The room has been updated successfully!');
        } else {
            return redirect('admin/room/'.$id.'/edit')->with('fail', 'Something went wrong! Try again.');
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
        Room::where('id',$id)->delete();

        return redirect('admin/room')->with('success', 'The room has been deleted successfully!');
    }
}
