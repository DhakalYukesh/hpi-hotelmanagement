<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Verification Page</title>
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

        <!-- Verification section for the page. -->
        <section class="register" id="register">
            <div class="register-form-container">
                <form action="{{ url('registration/verify/' . $verification_code) }}" method="post">
                    @csrf
                    <h3>Verify Your Account</h3>

                    @if(Session::has('success'))
                    <div class="alert-success" id="alert-success">{{Session::get('success')}}</div>
                    @endif

                    @if(Session::has('fail'))
                    <div class="alert-fail" id="alert-fail">{{Session::get('fail')}}</div>
                    @endif

                    @csrf
                    <div class="inputBox">
                        <input type="text" class="box" placeholder="Enter the verification code..." name="verification_code" value="{{old('verification_code')}}">
                        <span class="danger">@error('verification_code') {{$message}} @enderror</span>
                    </div>
                    {{-- <input type="hidden" name="email" value="{{$email}}" /> --}}
                    <input type="hidden" name="reg_ref" value="frontRegister" />
                    <input type="submit" value="Verify Account" class="btn">
                </form>
            </div>
        </section>
    </body>
</html>
