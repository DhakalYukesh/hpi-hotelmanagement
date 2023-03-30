<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Room;
use Dompdf\Options;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\RoomType;
use App\Models\Service;
use App\Models\Payment;
use Illuminate\View\View;
use Omnipay\Omnipay;




class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $booking = Booking::all();
        return view('booking.index', ['data' => $booking]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = Customer::all();
        return view('booking.create', ['customer' => $customer]);
    }

    public function booking()
    {
        $services = Service::all();
        return view("frontendBooking", ["services" => $services]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'customer_id' => 'required',
            'room_id' => 'required',
            'check_in' => 'required',
            'num_days' => 'required|gt:0',
            'cus_adult' => 'required',
            'cus_children' => 'required',
            'services.*' => 'nullable|exists:services,id',
        ]);

        // Calculate the check-out date
        $checkIn = Carbon::createFromFormat('Y-m-d', $request->check_in);
        $checkOut = $checkIn->copy()->addDays($request->num_days);
        $checkOutFormatted = $checkOut->format('Y-m-d');

        // Save the booking data
        $data = new Booking;
        $data->customer_id = $request->customer_id;
        $data->room_id = $request->room_id;
        $data->check_in = $request->check_in;
        $data->check_out = $checkOutFormatted;
        $data->cus_adult = $request->cus_adult;
        $data->cus_children = $request->cus_children;
        if ($request->book_ref == 'front_booking') {
            $data->book_ref = 'customer';
        } else {
            $data->book_ref = 'admin';
        }
        $data->status = 'booked';
        $data->save();

        // Add selected services to booking
        if ($request->has('services')) {
            $services = collect($request->services)
                ->map(function ($id) {
                    $service = Service::findOrFail($id);
                    return ['service_id' => $id, 'price' => $service->price];
                })
                ->toArray();

            $data->services()->attach($services);
        }


        $book_ref = $request->book_ref;

        if ($book_ref == 'front_booking') {
            if ($data) {
                return redirect()->route('payment.index', ['booking_id' => $data->id, 'total_price' => $request->total_price]);
            } else {
                return redirect('booking')->with('fail', 'Something wrong occured! Try again.');
            }
        } else {
            if ($data) {
                return redirect('admin/booking/create')->with('success', 'The booking has been added successfully!');
            } else {
                return redirect('admin/booking/create')->with('fail', 'Something wrong occured! Try again.');
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
        $data = Booking::find($id);
        return view('booking.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Booking::find($id);
        return view('booking.edit', ['data' => $data]);
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
        // Validate the form data
        $request->validate([
            'check_in' => 'required',
            'num_days' => 'required|gt:0',
            'cus_adult' => 'required',
            'cus_children' => 'required',
        ]);

        // Calculate the check-out date
        $checkIn = Carbon::createFromFormat('Y-m-d', $request->check_in);
        $checkOut = $checkIn->copy()->addDays($request->num_days);
        $checkOutFormatted = $checkOut->format('Y-m-d');

        $data = Booking::find($id);
        $data->check_in = $request->check_in;
        $data->check_out = $checkOutFormatted;
        $data->cus_adult = $request->cus_adult;
        $data->cus_children = $request->cus_children;
        $data->save();

        if ($data) {
            return redirect('admin/booking/' . $id . '/edit')->with('success', 'The booking has been updated successfully!');
        } else {
            return redirect('admin/booking/' . $id . '/edit')->with('fail', 'Something went wrong! Try again.');
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
        Booking::where('id', $id)->delete();

        return redirect('admin/booking')->with('success', 'The booking has been deleted successfully!');
    }
    public function checkedin($id)
    {
        $bookingStatus = Booking::find($id);
        $bookingStatus->status = 'checked in';
        $bookingStatus->save();

        return redirect('admin/booking')->with('success', 'The booking has been checked in successfully!');
    }
    public function checkedout($id)
    {
        $bookingStatus = Booking::find($id);
        $bookingStatus->status = 'checked out';
        $bookingStatus->save();

        return redirect('admin/booking')->with('success', 'The booking has been checked out successfully!');
    }

    public function food($id)
    {
        $booking = Booking::find($id);
        $foods = Food::all();
        return view('booking.order', ['booking' => $booking, 'foods' => $foods]);
    }

    public function invoice($id)
    {
        $booking = Booking::find($id);
        $payment = Payment::where('booking_id', $id)->first();
        return view('booking.invoice', ['booking' => $booking, 'payment' => $payment]);
    }
    

    public function generateInvoice(Booking $booking)
    {
        $options = [
            'fontDir' => storage_path('fonts/'),
            'fontCache' => storage_path('fonts/'),
            'defaultFont' => 'poppins',
        ];

        $pdf = PDF::setOptions($options)->loadView('booking.generateinvoice', compact('booking'));
        return $pdf->stream('booking_invoice.pdf');
    }

    public function available_Rooms(Request $request, $check_in, $check_out)
    {

        $query = "SELECT * FROM rooms WHERE id NOT IN (
            SELECT room_id FROM bookings WHERE ('$check_in' >= check_in AND '$check_in' < check_out) OR ('$check_out' > check_in AND '$check_out' <= check_out) OR (check_in >= '$check_in' AND check_in < '$check_out') OR (check_out > '$check_in' AND check_out <= '$check_out'));
          ";

        $availableRooms = DB::select($query);

        $data = [];
        foreach ($availableRooms as $room) {
            $roomType = RoomType::find($room->room_type_id);
            $data[] = ['room' => $room, 'roomtype' => $roomType];
        }
        return response()->json(['data' => $data]);
    }


    public function frontendBook()
    {
        if (session())
            return view('frontendBooking');
    }


}