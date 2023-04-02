<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Page</title>
    <script src="https://kit.fontawesome.com/5daa8eb347.js" crossorigin="anonymous"></script>
    <link href="{{ asset('public/res/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/res/design.css') }}" rel="stylesheet" />
    {{-- <link href="{{ asset('public/res/frontendBooking.css') }}" rel="stylesheet" /> --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <style>
        .content-table .service-option .check-label input{
            background: #e9e9e9d3;
            width: 10% !important;
            padding: 20px;
            font-size: 16px;
        }
    </style>
    <!-- Header section for the page. -->
    <header>
        <span class="material-symbols-outlined" id="menuBar">menu</span>
        <a href="home" class="logo"><span>Hotel</span> Pranisha</a>\
    </header>

    <!-- Booking section for the page. -->
    <section class="register" id="register">
        <div class="register-form-container">
            <form method="post" action="{{ url('admin/booking') }}">
                <h3>Booking Form</h3>
                @if (Session::has('success'))
                    <div class="alert-success" id="alert-success">{{ Session::get('success') }}</div>
                @endif

                @if (Session::has('fail'))
                    <div class="alert-fail" id="alert-fail">{{ Session::get('fail') }}</div>
                @endif

                @csrf
                <table class="content-table">
                    <tr>
                        <th>CheckIn Date</th>
                        <td>
                            <span class="danger">
                                @error('check_in')
                                    {{ $message }}
                                @enderror
                            </span>
                            <input type="date" class="room-form check-in" name="check_in"
                                value="{{ old('check_in') }}">
                        </td>
                    </tr>
                    <tr>
                        <th>Days of Stay</th>
                        <td>
                            <span class="danger">
                                @error('num_days')
                                    {{ $message }}
                                @enderror
                            </span>
                            <input type="number" class="room-form" name="num_days" value="{{ old('num_days') }}"
                                min="1">
                        </td>
                    </tr>
                    <tr>
                        <th>Available Rooms</th>
                        <td>
                            <span class="danger">
                                @error('room_id')
                                    {{ $message }}
                                @enderror
                            </span>
                            <select class="select-form available-rooms" name="room_id" value="">
                                <option>No room found</option>
                            </select>
                            <p>Price: <span class="showPrice"></span></p>
                        </td>
                    </tr>
                    <tr>
                        <th>No. of Adults</th>
                        <td>
                            <span class="danger">
                                @error('cus_adult')
                                    {{ $message }}
                                @enderror
                            </span>
                            <input type="text" class="room-form" name="cus_adult" value="{{ old('cus_adult') }}">
                        </td>
                    </tr>
                    <tr>
                        <th>No. of Childrens</th>
                        <td>
                            <span class="danger">
                                @error('cus_children')
                                    {{ $message }}
                                @enderror
                            </span>
                            <input type="text" class="room-form" name="cus_children"
                                value="{{ old('cus_children') }}">
                        </td>
                    </tr>
                    <tr>
                        <th>Service</th>
                        <td>
                            <span class="danger">
                                @error('service')
                                    {{ $message }}
                                @enderror
                            </span>
                            @foreach ($services as $service)
                                <div class="service-option">
                                    <div class="check-label">
                                        <input type="checkbox" class="service-checkbox" name="services[]"
                                            value="{{ $service->id }}">
                                        <label>{{ $service->title }} - ${{ $service->price }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="customer_id" value="{{ session('loginId') }}" />
                            <input type="hidden" name="book_ref" value="front_booking" />
                            <input type="hidden" name="roomprice" class="room_price" value="" />
                            <input type="hidden" name="total_price" class="total_price" value="" />
                            <p>Total Price: $<span class="total-price" id="total-price">0</span></p>
                            <button type="submit" class="btn">Book Now</button>
                        </td>
                    </tr>
                </table>
            </form>
            {{-- <a href="{{ route('payment.index', ['booking_id' => $booking->id]) }}">Pay Now</a> --}}
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".check-in").on('blur', function() {
            var checkinDate = $(this).val();
            var numDays = $(".num-days").val();

            // Validate the check-in date
            var today = new Date().toISOString().slice(0, 10);
            if (!checkinDate || checkinDate < today) {
                alert('Please enter a valid check-in date! Dont choice older date from today.');
                return;
            }

            $.ajax({
                url: "{{ route('booking.availableRooms', ['check_in' => ':check_in', 'num_days' => ':num_days']) }}"
                    .replace(':check_in', checkinDate).replace(':num_days', numDays),
                success: function(response) {
                    // Clear the current list of options
                    $('.available-rooms').find('option').remove();

                    // Add the new list of options
                    if (response.data.length > 0) {
                        $.each(response.data, function(key, value) {
                            $('.available-rooms').append('<option data_price="' +
                                value.roomtype.price + '" value="' + value
                                .room.id + '">' + value.roomtype.title + ' - ' +
                                value.room.title + '</option>');
                        });
                    } else {
                        $('.available-rooms').append('<option>No room found</option>');
                    }

                    // Call the function to update the total price
                    calculateTotalPrice();
                }
            });

            function calculateTotalPrice() {
                var totalPrice = 0;

                // Get the room price
                var roomPrice = parseFloat($('.available-rooms').find('option:selected').attr(
                    'data_price'));
                $('.room_price').val(roomPrice);
                $('.showPrice').text(roomPrice);

                // Add the room price to the total
                totalPrice += roomPrice;

                // Loop through each checked service
                $('.service-checkbox:checked').each(function() {
                    // Get the service price from the label text
                    var servicePrice = parseFloat($(this).closest('.service-option').find(
                        'label').text().replace(/\D/g, ''));

                    // Add the service price to the total
                    totalPrice += servicePrice;
                });

                // Update the total price on the page
                $('.total-price').text(totalPrice.toFixed(2));

                // Set the value of the hidden input field to the total price
                $('input[name="total_price"]').val(totalPrice);
            }

            // Update the total price when a checkbox is clicked
            $('.service-checkbox').on('click', function() {
                calculateTotalPrice();
            });

            // Update the total price when the room price changes
            $('.room_price').on('change', function() {
                calculateTotalPrice();
                var roomPrice = parseFloat($(this).val());
                $('.total-price').text(roomPrice.toFixed(2));
            });

            // Set the total price to the room price when the available room option is changed
            $('.available-rooms').on('change', function() {
                var roomPrice = parseFloat($(this).find('option:selected').attr('data_price'));
                $('.room_price').val(roomPrice);
                $('.showPrice').text(roomPrice);
                calculateTotalPrice();
            });

        });

        // Show the price of the selected option if the user changes their option.
        $(document).on("change", ".available-rooms", function() {
            var _selectedamount = $(this).find('option:selected').attr('data_price');
            $(".room_price").val(_selectedamount);
            $(".showPrice").text(_selectedamount);
        });
    });
</script>


</html>
