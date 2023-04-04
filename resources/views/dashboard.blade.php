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
        }

        .main h3 {
            padding-top: 20px;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 10px;
            font-size: 1.1rem;
            border-bottom: 1px solid #dddd;
            /* background: #fbfbfb; */
            display: flex;
            justify-content: space-between;
        }

        .content-table {
            border-collapse: collapse;
            margin: 30px;
            font-size: 1rem;
            min-width: 400px;
            border-radius: 5px 5px 0 0;
            width: -webkit-fill-available;
        }

        .content-table thead tr {
            background-color: #ee1d1d;
            color: #ffffff;
            text-align: left;
            font-weight: bold;

        }

        .content-table th,
        .content-table td {
            padding: 12px 15px;
            text-align: left;
        }

        .content-table tbody tr {
            border-bottom: 1px solid #dddd;
        }

        .content-table tbody tr:nth-of-type(even) {
            background-color: #f7f7f7fa !important;
        }

        /* .content-table tbody:last-of-type tr {
                                      border-bottom: 2px solid #ee1d1d;
                                     } */

        .content-table tbody tr td a #view {
            background: #e08422;
            color: white;
            padding: 3px;
            border-radius: 7px;
            font-size: 1.3rem;
        }

        .content-table tbody tr td a #view:hover {
            background: #c4731d;
            font-size: 1.25rem;
        }

        .content-table tbody tr td a #edit {
            background: #225be0;
            color: white;
            padding: 3px;
            border-radius: 7px;
            font-size: 1.3rem;
        }

        .content-table tbody tr td a #edit:hover {
            background: #1e50c5;
            font-size: 1.25rem;
        }

        .content-table tbody tr td a #delete {
            background: #e02222;
            color: white;
            padding: 3px;
            border-radius: 7px;
            font-size: 1.3rem;
        }

        .content-table tbody tr td a #delete:hover {
            background: #b91c1c;
            font-size: 1.25rem;
        }

        .add-rooms {
            display: flex;
            font-size: 1rem;
            margin-left: auto;
            color: black;
            border: 2px solid rgba(27, 27, 27, 0.677);
            padding: 5px;
            border-radius: 5px;
        }

        .add-rooms:hover {
            display: flex;
            font-size: 1rem;
            margin-left: auto;
            color: #fff;
            background: #e2411d;
            border: 2px solid #e2411d;
            padding: 5px;
            border-radius: 5px;
        }

        .main .alert-success {
            background-color: rgb(66, 110, 66);
            color: #fff;
            padding: 1rem;
        }

        .main .alert-fail {
            background-color: rgb(110, 66, 66);
            color: #fff;
            padding: 1rem;
        }


        /* --------------- Design for the dashboard --------------- */

        nav {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .subnavbar .container>ul>li.active>a {
            border-bottom: 3px solid #0098ba;
            color: #383838;
            background: #fff;
        }

        .content-table {
            display: flex;
            flex-direction: row;
            gap: 2%;
            background-color: white;
        }

        .content-table .dash-customer {
            width: 100%;
            border-left: 5px solid #0098ba;
            background: #0098ba1c;
        }

        .content-table .dash-booking {
            width: 100%;
            border-left: 5px solid #ba0000;
            background: #ba000023;
        }

        .content-table .dash-rooms {
            width: 100%;
            border-left: 5px solid #00ba06;
            background: #00ba061e;
        }

        .content-table .dash-services {
            width: 100%;
            border-left: 5px solid #5100ba;
            background: #5100ba1f;
        }

        #dash-numbers {
            font-size: 26px;
            font-weight: bold;
            color: black;
            margin-right: 30px;
            float: right;
        }

        .dash-chart {
            /* width: 100%; */
			width: 100%;
            height: 100%;
            display: flex;
            flex-direction: row;
            gap: 2%;
            background: rgb(255, 255, 255);
			padding: 2%;
			padding-top: 0%;
        }

        .dash-chart #booking-chart {
            border-left: 5px solid #ee184a;
            background: #ee184a12;
            width: 80%;
            height: 480px;
        }

		.dash-chart .dash-pie{
			background: rgba(23, 186, 178, 0.097);
			color: black;
			
		}

		.dash-chart .dash-pie #booking-pie{
			padding-left: 0;
			margin-top: 50px;
		}

		.dash-chart .dash-pie h3{
			font-weight: bold;
			font-size: 20px;
			border-top: 5px solid #19b5d0;
		}
    </style>

    <div class="main">
        <h3>Admin Dashboard
            <a href="{{ url('admin/booking/create') }}" class="add-rooms">Add Booking</a>
        </h3>

        @if (Session::has('success'))
            <div class="alert-success" id="alert-success">{{ Session::get('success') }}</div>
        @endif

        @if (Session::has('fail'))
            <div class="alert-fail" id="alert-fail">{{ Session::get('fail') }}</div>
        @endif

        <div class="content-table">
            <div class="dash-customer">
                <h3 class="material-symbols-outlined">group <span>Total Customers:</span></h3>
                <a id="dash-numbers">100</a>
            </div>
            <div class="dash-booking">
                <h3 class="material-symbols-outlined">book <span>Total Bookings:</span></h3>
                <a id="dash-numbers"></a>
            </div>
            <div class="dash-rooms">
                <h3 class="material-symbols-outlined">bed <span>Total Rooms:</span></h3>
                <a id="dash-numbers"></a>
            </div>
            <div class="dash-services">
                <h3 class="material-symbols-outlined">wb_iridescent <span>Total Services:</span></h3>
                <a id="dash-numbers"></a>
            </div>
        </div>

        <div class="dash-chart">
            <canvas id="booking-chart"></canvas>

            <div class="dash-pie">
                <h3>RoomType Overview</h3>
                <canvas id="booking-pie"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		var _lables = {!! json_encode($labels) !!}
        var _data = {!! json_encode($data) !!}

		var _plabels = {!! json_encode($plabels) !!}
        var _pdata = {!! json_encode($pdata) !!}
	</script>
    <script src="{{ asset('public/js/dashChart.js') }}"></script>
    <script src="{{ asset('public/js/dashPie.js') }}"></script>
@endsection
