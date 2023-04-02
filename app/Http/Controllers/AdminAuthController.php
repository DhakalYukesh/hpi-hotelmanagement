<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Booking;
use Hash;
use Cookie;

class AdminAuthController extends Controller
{
    //Login for the management panel.

    function login()
    {
        return view('adminlogin');
    }

    //Login check.

    function loginCheck(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where(['username' => $request->username, 'password' => sha1($request->password)])->count();

        if ($admin > 0) {
            $admin_data = Admin::where(['username' => $request->username, 'password' => sha1($request->password)])->get();
            session(['admin_data' => $admin_data]);

            if ($request->has('rememberme')) {
                Cookie::queue('adminUser', $request->username, 1440);
                Cookie::queue('adminPass', $request->password, 1440);
            }

            return redirect('admin/dashboard')->with('success', 'You have successfully loged in!');

        } else {
            return redirect('admin')->with('fail', 'Something went wrong! Try again.');
        }
    }

    //Logout for the management panel.

    function logout()
    {
        session()->forget(['admin_data']);

        return redirect('admin');
    }

    function dashboard()
    {
        $bookings = Booking::selectRaw('count(id) as total_bookings, check_in')->groupBy('check_in')->get();
        $room_typess = RoomType::all();

        $labels = [];
        $data = [];
        foreach ($bookings as $booking) {
            $labels[] = $booking['check_in'];
            $data[] = $booking['total_bookings'];
        }

        $rtBookings = DB::table('room_types as rt')
            ->join('rooms as room', 'room.room_type_id', '=', 'rt.id')
            ->join('bookings as book', 'book.room_id', '=', 'room.id')
            ->select('rt.*', 'room.*', 'book.*', DB::raw('count(book.id) as total_bookings'))
            ->groupBy('room.room_type_id')
            ->get();

        $pie_labels = [];
        $pie_data = [];
        foreach ($rtBookings as $pie_booking) {
            $pie_labels[] = $pie_booking->detail;
            $pie_data[] = $pie_booking->total_bookings;
        }

        return view('dashboard', ['labels' => $labels, 'data' => $data, 'plabels' => $pie_labels, 'pdata' => $pie_data]);
    }
}