<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Registration Page</title>
        <script src="https://kit.fontawesome.com/5daa8eb347.js" crossorigin="anonymous"></script>
        <link href="{{asset('public/res/style.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    </head>
    <body>
        <!-- Header section for the page. -->
        <header>

            <span class="material-symbols-outlined" id="menuBar">menu</span>
            <a href="home" class="logo"><span>Hotel</span> Pranisha</a>\
            

        </header>

        <!-- Registration section for the page. -->
        <section class="register" id="register">
            <div class="register-form-container">
                <form action="{{url('admin/customer')}}" method="post">
                    <h3>Register In</h3>
                    @if(Session::has('success'))
                    <div class="alert-success" id="alert-success">{{Session::get('success')}}</div>
                    @endif

                    @if(Session::has('fail'))
                    <div class="alert-fail" id="alert-fail">{{Session::get('fail')}}</div>
                    @endif

                    @csrf
                    <div class="inputBox">
                        <input type="text" class="box" placeholder="Enter your first name..." name="fname" value="{{old('fname')}}">
                        <span class="danger">@error('fname') {{$message}} @enderror</span>

                        <input type="text" class="box" placeholder="Enter your last name..." name="lname" value="{{old('lname')}}">
                        <span class="danger">@error('lname') {{$message}} @enderror</span>
                    </div>

                    <div class="inputBox">
                        <input type="number" class="box" placeholder="Enter your phone number.." name="number" value="{{old('number')}}">
                        <span class="danger">@error('number') {{$message}} @enderror</span>

                        <input type="email" class="box" placeholder="Enter your email..." name="email" value="{{old('email')}}">
                        <span class="danger">@error('email') {{$message}} @enderror</span>
                    </div>

                    <div class="inputBox">
                        <input type="password" class="box" placeholder="Set your password..." name="password" value="">
                        <span class="danger">@error('password') {{$message}} @enderror</span>
                    </div>
                    <input type="hidden" name="reg_ref" value="frontRegister" />
                    <input type="submit" value="Create Account" class="btn">
                    <p>Already have an account? <a href="{{url('home')}}">Login Here</a></p>
                </form>
            </div>
        </section>
    </body>
</html> 
