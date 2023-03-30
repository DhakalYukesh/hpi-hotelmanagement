<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Invoice</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: sans-serif;
            margin: 0;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 36px;
            font-weight: normal;
        }
        .container {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Booking Invoice</h1>
</div>
<div class="container">
    <h2>Booking Information</h2>
    <table>
        <tr>
            <th>Booking ID</th>
            <td>{{ $booking->id }}</td>
        </tr>
        <tr>
            <th>Customer Name</th>
            <td>{{ $booking->customer_name }}</td>
        </tr>
        {{-- <tr>
            <th>Check-In Date</th>
            <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
        </tr>
        <tr>
            <th>Check-Out Date</th>
            <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
        </tr>
        <tr>
            <th>Room Type</th>
            <td>{{ $booking->room_type }}</td>
        </tr>
    </table>
    <h2>Services</h2>
    <table>
        <tr>
            <th>Service</th>
            <th>Price</th>
        </tr>
        @foreach($services as $service)
            <tr>
                <td>{{ $service->title }}</td>
                <td>{{ $service->price }}</td>
            </tr>
        @endforeach
    </table>
    <div class="total">
        Total: ${{ $booking->total_price }}
    </div> --}}
</div>
</body>
</html>
