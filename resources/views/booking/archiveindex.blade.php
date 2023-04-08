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
            background: #fbfbfb;
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

        .content-table tbody tr td a #checkedin {
            background: #28b41e;
            color: white;
            padding: 3px;
            border-radius: 7px;
            font-size: 1.3rem;
        }

        .content-table tbody tr td a #checkedin:hover {
            background: #1f9316;
            font-size: 1.25rem;
        }

        .content-table tbody tr td a #checkedout {
            background: #930404;
            color: white;
            padding: 3px;
            border-radius: 7px;
            font-size: 1.3rem;
        }

        .content-table tbody tr td a #checkedout:hover {
            background: #720404;
            font-size: 1.25rem;
        }

        .content-table tbody tr td a #invoice {
            background: #0c1194fc;
            color: white;
            padding: 3px;
            border-radius: 7px;
            font-size: 1.3rem;
        }

        .content-table tbody tr td a #invoice:hover {
            background: #080b5dfc;
            font-size: 1.25rem;
        }

        .content-table tbody tr td a #food {
            background: #5b119bf3;
            color: white;
            padding: 3px;
            border-radius: 7px;
            font-size: 1.3rem;
        }

        .content-table tbody tr td a #food:hover {
            background: #460d77f3;
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

        .archive{
            display: flex;
            width: 100%;
            color: rgb(57, 57, 57);
            padding-left: 30px;
            border-bottom: 1px solid rgba(128, 128, 128, 0.166);
            cursor: pointer;
        }
        
        .archive:hover{
            background: rgb(244, 244, 244);
        }
    </style>

    <div class="main">
        <h3>Archived Bookings
            <a href="{{ url('admin/booking') }}" class="add-rooms">View Bookings</a>
        </h3>
        
        @if (Session::has('success'))
        <div class="alert-success" id="alert-success">{{ Session::get('success') }}</div>
        @endif
        
        @if (Session::has('fail'))
        <div class="alert-fail" id="alert-fail">{{ Session::get('fail') }}</div>
        @endif
        
        <table class="content-table" id="Table_ID">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Room Number</th>
                    <th>CheckIn Date</th>
                    <th>CheckOut Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data)
                    @foreach ($data as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->customer->fname }} {{ $book->customer->lname }}</td>
                            <td>{{ $book->room->title }}</td>
                            <td>{{ $book->check_in }}</td>
                            <td>{{ $book->check_out }}</td>
                            <td
                                @if ($book->status == 'booked') style="background: #41b82925; border-bottom: 4px solid #2ec018;"
                            @elseif($book->status == 'checked in')
                                style="background: #93040429; border-bottom: 4px solid #720404;"
                            @else
                                style="background: #0c11941a; border-bottom: 4px solid #0c1194fc;" @endif>
                                {{ $book->status }}</td>

                            <td>
                                <a onclick="return confirm('(!) Are you sure you want to delete this booking?')"
                                    href="{{ url('admin/booking/archive/' . $book->id) . '/delete' }}" class="delete"><span
                                        class="material-symbols-outlined" id="delete">delete</span></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

@endsection
