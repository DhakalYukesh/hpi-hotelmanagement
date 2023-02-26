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

        .danger {
            color: #ee1d1d;
            font-size: 14px;
        }

        .content-table td .select-form {
            width: 100%;
            background: #e9e9e9d3;
            padding: .8rem;
            margin-bottom: 1px;
            font-size: 15px;
        }

        .content-table td .select-form option {
            background: #fff;
        }
    </style>

    <div class="main">
        <form method="post" action="{{ url('admin/room') }}">
            <h3>Add Room
                <a href="{{ url('admin/room/') }}" class="view-rooms">View Rooms</a>
            </h3>
            @if (Session::has('success'))
                <div class="alert-success" id="alert-success">{{ Session::get('success') }}</div>
            @endif

            @if (Session::has('fail'))
                <div class="alert-fail" id="alert-fail">{{ Session::get('fail') }}</div>
            @endif

            @csrf
            <table class="content-table">
                <tr>
                    <th>Room Types</th>
                    <td>
                        <span class="danger">
                            @error('title')
                                {{ $message }}
                            @enderror
                        </span>
                        <select class="select-form" name="room_type_id" value="{{ old('title') }}">
                            <option value="0">Select the room type</option>
                            @foreach ($roomtype as $roomt)
                                <option value="{{$roomt->id}}">
                                    {{ $roomt->title }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td>
                        <span class="danger">
                            @error('title')
                                {{ $message }}
                            @enderror
                        </span>
                        <input type="text" class="room-form" name="title" value="{{ old('title') }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn">Add Room</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
@endsection
