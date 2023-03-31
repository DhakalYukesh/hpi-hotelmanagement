@extends('layout')
@section('content')
    <!-- Main content for the page. -->
    <style>
        .tables {
            width: 100%;
            right: 0;
        }

        .main {
            width: -webkit-fill-available;
            background: rgb(255, 255, 255);
            margin: 30px;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            padding-bottom: 1px;
        }

        .main h3 {
            padding-top: 20px;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 10px;
            font-size: 1.1rem;
            border-bottom: 1px solid #dddd;
            background: #fbfbfb;
            display: flex;
            justify-content: space-between;
        }

        .content-table {
            border-collapse: collapse;
            margin: 35px;
            font-size: 1rem;
            min-width: 400px;
            border-radius: 5px 5px 0 0;
            width: -webkit-fill-available;
        }

        .content-table thead tr {
            background-color: #cb1919;
            color: #ffffff;
            text-align: left;
            font-weight: bold;

        }

        .content-table th {
            text-align: left;
            padding: 10px;
        }

        .content-table tbody tr {
            border-bottom: 1px solid #dddd;
        }

        .content-table input {
            background: #e9e9e9d3;
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        .content-table textarea {
            background: #e9e9e9d3;
            width: 100%;
            padding-top: 20px;
            height: 110px;
            text-align: center;
            font-size: 16px;
        }

        .content-table button {
            background: #ee1d1d;
            color: #fffffff5;
            width: 100%;
            padding: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .content-table button:hover {
            background: #cb1919;
            color: white;
        }

        .view-rooms {
            display: flex;
            font-size: 1rem;
            margin-left: auto;
            color: black;
            border: 2px solid rgba(27, 27, 27, 0.677);
            padding: 5px;
            border-radius: 5px;
        }

        .view-rooms:hover {
            display: flex;
            font-size: 1rem;
            margin-left: auto;
            color: #fff;
            background: #1d79e2;
            border: 2px solid #1d79e2;
            padding: 5px;
            border-radius: 5px;

        }

        /* Invoice Styles */
        .invoice {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #e2e2e2;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }

        .invoice-title {
            font-size: 28px;
            margin-bottom: 20px;
            padding: 20px;
            background: #cb1919;
            color: white;
        }

        .invoice-generate span {
            display: block;
            float: right;
            background-color: #167deb;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 8px;
            margin-right: 30px;
        }

        .invoice-generate span:hover {
            background-color: #0062cc;
        }

        #booking-info {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
        }

        #booking-info td {
            padding: 10px;
            border: 1px solid #e2e2e2;
            vertical-align: middle;
        }

        #booking-info td:first-child {
            width: 180px;
            font-weight: bold;
        }

        #booking-info .booking-id {
            font-weight: bold;
        }

        #booking-info .services ul {
            margin: 0;
            padding-left: 20px;
        }

        #booking-info .food-order ul {
            margin: 0;
            padding-left: 20px;
        }

        #booking-info .total-amount {
            font-weight: bold;
        }

        #booking-info .amount-left-to-pay {
            font-weight: bold;
            color: #ff0000;
        }

        #booking-info .invoice-button {
            text-align: right;
        }

        @media print {
            .invoice-generate {
                display: none;
            }
        }
    </style>

    <div class="main">
        <h3>Booking Invoice
            <a href="{{ url('admin/booking') }}" class="view-rooms">View Bookings</a>
        </h3>
        <a href="" class="invoice-generate"><span class="material-symbols-outlined">download</span> </a>

        <div class="invoice">
            <h1 class="invoice-title">Final Invoice</h1>

        <table>
            <tr>
                <td>Booking ID:</td>
                <td>{{ $booking->id }}</td>
            </tr>
            <tr>
                <td>Customer:</td>
                <td>{{ $booking->customer->id }}</td>
            </tr>
            <tr>
                <td>Room:</td>
                <td>{{ $booking->room->title }}</td>
            </tr>
            <tr>
                <td>Room Type:</td>
                <td>{{ $booking->room->roomtype->title }}</td>
            </tr>
            <tr>
                <td>Check In:</td>
                <td>{{ $booking->check_in }}</td>
            </tr>
            <tr>
                <td>Check Out:</td>
                <td>{{ $booking->check_out }}</td>
            </tr>
            <tr>
                <td>Adults:</td>
                <td>{{ $booking->cus_adult }}</td>
            </tr>
            <tr>
                <td>Children:</td>
                <td>{{ $booking->cus_children }}</td>
            </tr>
            <tr>
                <td>Services:</td>
                <td>
                    <ul>
                        @foreach ($booking->services as $service)
                            <li>{{ $service->title }} (${{ $service->price }})</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            <tr>
                <td>Total Amount:</td>
                <td> {{ $payment->amount }}</td>

                @if($payment->payment_status == 'paid')
                <td>Amount left to pay:</td>
                <td> $0</td>
                @else
                <td>test</td>
                @endif
            </tr>
        </table>
    </div>
@endsection
