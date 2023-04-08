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

        .content-table .dash-revenue {
            width: 100%;
            border-left: 5px solid #ba9e00;
            background: #ba9e001b;
        }

        .content-table .dash-booking {
            width: 100%;
            border-left: 5px solid #ba0000;
            background: #ba000023;
        }

        .content-table .dash-salary {
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

        .dash-chart #revenue-expense-chart {
            border-left: 5px solid #184aee;
            background: #184aee0e;
            width: 75%;
            height: 480px;
        }

        .dash-chart .dash-pie {
            background: #7819d01d;
            color: black;
            width: 25%;

        }

        .dash-chart .dash-pie #booking-pie {
            padding-left: 0;
            margin-top: 50px;
        }

        .dash-chart .dash-pie h3 {
            font-weight: bold;
            font-size: 20px;
            border-top: 5px solid #7819d0;
        }

        #recent-table {
            padding: 5px;
            width: 100%;
            height: 85%;
        }

        td {
            text-align: center;
        }
    </style>

    <div class="main">
        <h3>Finance Dashboard</h3>

        <div class="content-table">
            <div class="dash-revenue">
                <h3 class="material-symbols-outlined">monetization_on <span>Total Revenue:</span></h3>
                <a id="dash-numbers">${{ $totalAmount }}</a>
            </div>
            <div class="dash-salary">
                <h3 class="material-symbols-outlined">payments <span>Total Staff Salary:</span></h3>
                <a id="dash-numbers">${{ $totalSalary }}</a>
            </div>
            <div class="dash-booking">
                <h3 class="material-symbols-outlined">badge <span>Total Staffs:</span></h3>
                <a id="dash-numbers">{{ App\Models\Staff::count() }}</a>
            </div>
        </div>

        <div class="dash-chart">
            <canvas id="revenue-expense-chart"></canvas>

            <div class="dash-pie">
                <h3 class="material-symbols-outlined">credit_score <span>Recent Payments</span></h3>
                <table id="recent-table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentPayment as $payment)
                            <tr>
                                <td>{{ $payment->booking_id }}</td>
                                <td>{{ $payment->booking->customer->fname }}</td>
                                <td>{{ $payment->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('revenue-expense-chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($revenueData->pluck('currency')) !!},
                datasets: [{
                        label: 'Revenue',
                        data: {!! json_encode($revenueData->pluck('total')) !!},
                        backgroundColor: 'green'
                    },
                    {
                        label: 'Expense',
                        data: {!! json_encode(
                            $expenseData->pluck('total')->map(function ($total) {
                                return -$total;
                            }),
                        ) !!},
                        backgroundColor: 'red'
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                return '$' + value;
                            }
                        }
                    }]
                }
            }
        });
    </script>
@endsection
