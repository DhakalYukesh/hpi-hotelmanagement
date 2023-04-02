<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Food::all();
        return view('food.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('food.create');
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
            'title' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|string',
            'price' => 'required|string',
        ]);

        $data = new Food;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->quantity = $request->quantity;
        $data->price = $request->price;
        $data->save();

        if ($data) {
            return redirect('admin/food/create')->with('success', 'The food has been added successfully!');
        } else {
            return redirect('admin/food/create')->with('fail', 'Something went wrong! Try again.');
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
        $data = Food::find($id);
        return view('food.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Food::find($id);
        return view('food.edit', ['data' => $data]);

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
            'title' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|string',
            'price' => 'required|string',
        ]);

        $data = Food::find($id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->quantity = $request->quantity;
        $data->price = $request->price;
        $data->save();

        if ($data) {
            return redirect('admin/food/' . $id . '/edit')->with('success', 'The food has been updated successfully!');
        } else {
            return redirect('admin/food/' . $id . '/edit')->with('fail', 'Something went wrong! Try again.');
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
        Food::where('id', $id)->delete();

        return redirect('admin/food')->with('success', 'The food has been deleted successfully!');
    }

    public function handleOrder(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer',
            'food_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $booking = Booking::findOrFail($request->input('booking_id'));
        $food = Food::findOrFail($request->input('food_id'));
        $quantity = $request->input('quantity');
        $total_price = $quantity * $food->price;

        // Ensure that the order quantity is not greater than the available food quantity
        if ($food->quantity < $quantity) {
            return redirect('admin/booking/' . $booking->id . '/food')->with('fail', 'The food is out of stock! Please choose another.');
        }

        // Update the food quantity
        $food->quantity -= $quantity;
        $food->save();

        // Attach the food to the booking with the given quantity and price
        $booking->foods()->attach($food, [
            'quantity' => $quantity,
            'price' => $total_price,
        ]);

        // Set payment_status to unpaid
        if ($booking->payment && $booking->payment->payment_status !== 'unpaid') {
            $booking->payment->fill(['payment_status' => 'unpaid'])->save();
            
            return redirect('admin/booking/' . $booking->id . '/food')->with('success', 'The food order has been added successfully!');
        }else{
            return redirect('admin/booking/' . $booking->id . '/food')->with('success', '(!) The food order has been added successfully!');
        }
    }

}