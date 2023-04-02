<?php

namespace App\Http\Controllers;

use App\Mail\PaymentSuccessful;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Omnipay\Omnipay;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $gateway = Omnipay::create('PayPal_Rest');
        $gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $gateway->setTestMode(true);

        $bookingId = $request->input('booking_id');
        $totalPrice = $request->input('total_price');

        $booking = Booking::findOrFail($bookingId);

        $params = [
            'cancelUrl' => route('payment.cancel'),
            'returnUrl' => route('payment.success', ['booking_id' => $bookingId, 'total_price' => $totalPrice]),
            'amount' => $request->get('total_price'),
            'currency' => 'USD',
            'description' => 'Payment for Booking #' . $booking->id,
        ];

        $response = $gateway->purchase($params)->send();

        if ($response->isRedirect()) {
            $response->redirect();
        } else {
            return $response->getMessage();
        }
    }

    public function success(Request $request)
    {
        $gateway = Omnipay::create('PayPal_Rest');
        $gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $gateway->setTestMode(true);

        $bookingId = $request->input('booking_id');
        $booking = Booking::findOrFail($bookingId);
        $customerEmail = DB::table('bookings')
                    ->join('customers', 'bookings.customer_id', '=', 'customers.id')
                    ->where('bookings.id', '=', $bookingId)
                    ->select('customers.email')
                    ->first()->email;

        $params = [
            'amount' => $request->get('total_price'),
            'currency' => 'USD',
            'description' => 'Payment for Booking #' . $booking->id,
            'transactionReference' => $request->input('paymentId'),
            'payerId' => $request->input('PayerID'),
        ];

        $response = $gateway->completePurchase($params)->send();

        if ($response->isSuccessful()) {
            // Create payment record
            // Save payment record
            $payment = new Payment();
            $payment->booking_id = $bookingId;
            $payment->amount = $request->get('total_price');
            $payment->payment_id = $request->input('paymentId');
            $payment->currency = 'USD';
            $payment->payment_status = 'paid';
            $payment->save();

            // Send email
            \Mail::to($customerEmail)
                ->send(new PaymentSuccessful($booking, $payment));

            // Show success message
            return redirect('booking')->with('success', 'The payment has been successfully processed!');

        } else {
            // Show error message
            return $response->getMessage();
        }
    }


    public function cancel()
    {
        // Show cancel message
        return 'Payment cancelled!';
    }


    public function adminPayment(Request $request)
    {
        // $request->validate([
        //     'booking_id' => 'required|integer',
        //     'payment_id' => 'required|string',
        //     'amount' => 'required|numeric',
        //     'currency' => 'required|string',
        // ]);

        $bookingId = $request->input('booking_id');

        $payment = new Payment();
        $payment->booking_id = $bookingId;
        $payment->payment_id = 'PAYID-ADMIN';
        $payment->amount = $request->get('total_price');
        $payment->currency = 'USD';
        $payment->payment_status = 'paid';
        $payment->save();

        return redirect('admin/booking/create')->with('success', 'The booking has been added successfully!');
    }
}