<?php

namespace App\Http\Controllers;

use App\Models\ArchivedBooking;
use Illuminate\Http\Request;

class ArchivedController extends Controller
{
    public function archiveIndex()
    {
        $booking = ArchivedBooking::all();
        return view('booking.archiveindex', ['data' => $booking]);
    }

    public function destroy($id)
    {
        ArchivedBooking::where('id', $id)->delete();

        return redirect('admin/booking/archive')->with('success', 'The archived booking has been deleted successfully!');
    }
}
