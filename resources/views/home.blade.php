<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Page</title>
    <script src="https://kit.fontawesome.com/5daa8eb347.js" crossorigin="anonymous"></script>
    <link href="{{ asset('public/res/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <!-- Header section for the page. -->
    <header>
        <div class="ham">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>

        <a href="home" class="logo"><span>Hotel</span> Pranisha</a>
        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#book">Book</a>
            <a href="#services">Services</a>
            <a href="#contact">Contact</a>
        </nav>

        @if (Session::has('loginId'))
            <div class="logout">
                <a id="logout-btn" href="{{ url('logout') }}">Logout</a>
            </div>
        @else
            <div class="signIn">
                <button id="login-btn">SignIn</button>
            </div>
        @endif
    </header>

    <!-- Login section for the page. -->
    <div class="signin-form-container">
        <span class="material-symbols-outlined" id="close-form">close</span>
        <form action="{{ url('customer/login') }}" method="post">
            @csrf
            <h3>Sign In</h3>
            @if (Session::has('success'))
                <div class="alert-success" id="alert-success">{{ Session::get('success') }}</div>
            @endif

            @if (Session::has('fail'))
                <div class="alert-fail" id="alert-fail">{{ Session::get('fail') }}</div>
            @endif

            <input type="email" class="box" placeholder="Enter your email" name="email"
                value="{{ old('email') }}">
            <span class="danger">
                @error('email')
                    {{ $message }}
                @enderror
            </span>

            <input type="password" class="box" placeholder="Enter your password" name="password" value="">
            <span class="danger">
                @error('password')
                    {{ $message }}
                @enderror
            </span>

            <button type="submit" value="" class="log-btn">Sign In</button>
            <input type="checkbox" id="remember">
            <label for="remember">Remember me</label>
            <p>Don't have an account? <a href="registration">Register now!</a></p>
        </form>
    </div>

    <!-- Home section for the page. -->
    <section class="home" id="home">
        <div class="infos">
            <h3>Welcome to Hotel Pranisha Inn</h3>
            <p>Place made for the Experience and Taste.</p>
            <a href="#footer" class="learn-btn">Learn More</a>
        </div>

        <div class="navigator">
            <span class="image-btn active" data-src="{{ asset('public/images/pic1.jpg') }}"></span>
            <span class="image-btn" data-src="{{ asset('public/images/pic2.jpg') }}"></span>
            <span class="image-btn" data-src="{{ asset('public/images/pic3.jpg') }}"></span>
        </div>

        <div class="switch-container">
            <img src="{{ asset('public/images/pic1.jpg') }}" id="image-slider">
        </div>
    </section>

    <!-- Book section for the page. -->
    <section class="book" id="book">
        <h1 class="heading">Book
            <span> Rooms</span>
        </h1>
        <div class="box-container">
            <div class="box">
                <img src="{{ asset('public/images/room1.jpg') }}">
                <h3>Single Suite</h3>
                <p>A comfortable and affordable option for solo travelers, offering a cozy
                    and private space with a single bed, a private bathroom, and essential amenities.</p>

                @if (Session::has('loginId'))
                    <a href="{{ url('booking') }}" class="btn">Book Now</a>
                @else
                    <a href="#" class="btn notbookbutton">Book Now</a>
                @endif
            </div>

            <div class="box">
                <img src="{{ asset('public/images/room2.jpg') }}">
                <h3>Double Suite</h3>
                <p>A perfect choice for couples or friends, providing a spacious and inviting
                    space with a large double bed or two twin beds, private bathroom, and modern amenities.</p>

                @if (Session::has('loginId'))
                    <a href="{{ url('booking') }}" class="btn">Book Now</a>
                @else
                    <a href="#" class="btn notbookbutton">Book Now</a>
                @endif
            </div>

            <div class="box">
                <img src="{{ asset('public/images/room3.jpg') }}">
                <h3>Deluxe Suite</h3>
                <p>A luxurious and upscale option for travelers who seek an exceptional experience,
                    offering a spacious and elegantly decorated room with a king-size bed.</p>

                @if (Session::has('loginId'))
                    <a href="{{ url('booking') }}" class="btn">Book Now</a>
                @else
                    <a href="#" class="btn notbookbutton">Book Now</a>
                @endif
            </div>
        </div>
        </div>

        <div class="row">
            <div class="img">
                <img src="" alt="">
            </div>
        </div>
    </section>

    <!-- Services section for the page. -->
    <section class="services" id="services">
        <h1 class="heading2">Available
            <span> Services</span>
        </h1>

        <div class="box-container">
            <div class="box">
                <span class="material-symbols-outlined">wifi</span>
                <h3>Free high-speed Wi-Fi</h3>
                <p>Stay connected with our complimentary high-speed Wi-Fi, available throughout the hotel.</p>
            </div>

            <div class="box">
                <span class="material-symbols-outlined">restaurant</span>
                <h3>Food and Drinks</h3>
                <p>Savor delicious meals and refreshing drinks at our on-site restaurant and bar.</p>
            </div>

            <div class="box">
                <span class="material-symbols-outlined">medical_services</span>
                <h3>Medical Help</h3>
                <p>Rest easy knowing that medical assistance is just a phone call away with our 24-hour on-call doctor
                    service.</p>
            </div>

            <div class="box">
                <span class="material-symbols-outlined">local_laundry_service</span>
                <h3>Laundry</h3>
                <p>Let us take care of your laundry needs with our reliable and efficient laundry service.</p>
            </div>

            <div class="box">
                <span class="material-symbols-outlined">schedule</span>
                <h3>24-hour front desk</h3>
                <p>Our friendly and attentive staff are available round the clock to assist with any queries or requests
                    you may have.</p>
            </div>
        </div>
    </section>

    <!-- Contact section for the page. -->
    <section class="contact" id="contact">
        <h1 class="heading">
            <span>Contact Us</span>
        </h1>

        <div class="contact-container">
            <div class="img">
                <img src="{{ asset('public/images/contact.png') }}" alt="">
            </div>
            <form action="">
                <div class="inputBox">
                    <input type="text" placeholder="Full Name">
                    <input type="email" placeholder="Email">
                </div>

                <div class="inputBox">
                    <input type="number" placeholder="Phone Number">
                    <input type="text" placeholder="subject">
                </div>

                <textarea placeholder="Type your message here..." name="" cols="35" rows="10"></textarea>
                <input type="submit" class="btn" value="Send Message">
            </form>
        </div>
    </section>

    <!-- Footer section for the page. -->
    <section class="footer" id="footer">
        <div class="box-container">

            <div class="box">
                <h3>About Us <span class="fa-solid fa-address-card"></span></h3>
                <p>Hotel Pranisha Inn is a premier hotel that was established in 2018, offering guests a comfortable
                    and convenient stay in the heart of the city. With our prime location and superior amenities, we are
                    the ideal choice for business and leisure travelers alike.</p>
            </div>

            <div class="box">
                <h3>Contact Info <span class="fa-solid fa-phone"></span></h3>
                <a href="#" class="c-info"> +977 9851191180</a>
                <a href="#" class="c-info"> +977 9823434650</a>
                <a href="#" class="c-info"> pranishainn@gmail.com</a>
                <a href="#" class="c-info"> Shambhu Marg, Kathmandu 44621</a>
            </div>

            <div class="box">
                <h3>Shortcuts <span class="fa-solid fa-clipboard"></span></h3>
                <a href="#home" class="c-info"> Home</a>
                <a href="#book" class="c-info"> Rooms</a>
                <a href="#services" class="c-info"> Services</a>
                <a href="#contact" class="c-info"> Contact</a>
            </div>

            <div class="box">
                <h3>Follow Us <span class="fa-solid fa-pen"></span></h3>
                <a href="https://www.facebook.com/pranishahotel" class="c-info">Facebook</a>
                <a href="https://www.instagram.com/hotelpranisha/" class="c-info">Instagram</a>
            </div>
        </div>
    </section>
</body>
<!-- Linking custom js file. -->
<script>
    let formBtn = document.querySelector("#login-btn");
    let formSignin = document.querySelector(".signin-form-container");
    let formClose = document.querySelector("#close-form");

    formBtn.addEventListener("click", () => {
        formSignin.classList.add("active");
        console.log('a');
    });

    formClose.addEventListener("click", () => {
        formSignin.classList.remove("active");
    });

    let notbook = document.querySelector('.notbookbutton')
    notbook.addEventListener('click', () => {
        formBtn.click()
    })
    
</script>

<script src="{{ asset('public/js/main.js') }}"></script>

</html>
