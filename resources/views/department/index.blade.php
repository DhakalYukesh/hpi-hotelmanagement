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

        .content-table tbody tr td a #view:hover{
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

        .content-table tbody tr td a #edit:hover{
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

        .content-table tbody tr td a #delete:hover{
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

    </style>

    <div class="main">
        <h3>Available Departments
            <a href="{{ url('admin/department/create') }}" class="add-rooms">Add Department</a>
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
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data)
                    @foreach ($data as $dt)
                    <tr>
                        <td>{{$dt->id}}</td>
                        <td>{{$dt->title}}</td>
                        <td>
                            <a href="{{url('admin/department/'.$dt->id)}}"><span class="material-symbols-outlined" id="view">visibility</span></a>
                            <a href="{{url('admin/department/'.$dt->id).'/edit'}}"><span class="material-symbols-outlined" id="edit">edit</span></a>
                            <a onclick="return confirm('(!) Are you sure you want to delete this department?')" href="{{url('admin/department/'.$dt->id).'/delete'}}" class="delete"><span class="material-symbols-outlined"
                                    id="delete">delete</span></a>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
