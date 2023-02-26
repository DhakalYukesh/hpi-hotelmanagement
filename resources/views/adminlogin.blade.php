<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
    <link href="{{asset('public/res/adminloginStyle.css')}}" rel="stylesheet" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
	<header class="header">
		<div class="logo">
			<span class="brand-name">HPI</span>-Management
		</div>
	
	</header>

	<div class="signin-form-container">
            
            <form action="{{url('admin')}}" method="post">
                @csrf
                <h3>Admin Sign-In</h3>
                @if(Session::has('success'))
                <div class="alert-success" id="alert-success">{{Session::get('success')}}</div>
                @endif

                @if(Session::has('fail'))
                <div class="alert-fail" id="alert-fail">{{Session::get('fail')}}</div>
                @endif

                <input type="text" id="username" class="box" placeholder="Enter your username..." name="username" value="{{old('email')}}">
                <span class="danger">@error('text') {{$message}} @enderror</span>

                <input type="password" id="password" class="box" placeholder="Enter your password..." name="password" value="">
                <span class="danger">@error('password') {{$message}} @enderror</span>

                <button type="submit" value="Login" class="log-btn">Sign In</button>
                <input type="checkbox" id="remember">
                <label for="remember">Remember me</label>
            </form>
        </div>