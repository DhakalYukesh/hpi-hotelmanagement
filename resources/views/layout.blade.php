<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>

    @if (!session()->has('admin_type') || (session('admin_type') != 'admin' && session('admin_type') != 'staff'))
        <script type="text/javascript">
            window.location.href = "{{ url('admin') }}";
        </script>
    @endif


    <link href="{{ asset('public/res/adminStyle.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/res/navigationStyle.css') }}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <header class="header">
        <div class="logo">
            <span class="brand-name">HPI </span>-Management
        </div>
        <div class="account_circle">
            <div class="circle"></div>
            <span class="material-symbols-outlined">account_circle  </span>
            @if(Session::has('admin_data'))
                {{ Session::get('admin_data')->username }}
                ({{ Session::get('admin_data')->type }})
            @endif
        </div>        
    </header>
    <div class="main-container">
        <div class="nav-container">
            <nav class="nav">
                <a href="{{ url('admin/dashboard') }}">
                    <div class="nav-option option1" id="active">
                        <span class="material-symbols-outlined">tune</span>
                        <h3 href="">Dashboard</h3>
                    </div>
                </a>

                <div class="nav-option option1 room" id="rooms-button">
                    <span class="material-symbols-outlined">bed</span>
                    <h3>Rooms</h3>
                </div>
                <div class="child-options" id="rooms-child-options">
                    <a href="{{ url('admin/room') }}">
                        <div class="room-options">Rooms</div>
                    </a>
                    <a href="{{ url('admin/roomtype') }}">
                        <div class="room-options">Room Types</div>
                    </a>
                </div>


                <a href="{{ url('admin/customer') }}">
                    <div class="nav-option option1">
                        <span class="material-symbols-outlined">group</span>
                        <h3>Customers</h3>
                    </div>
                </a>

                <a href="{{ url('admin/booking/') }}">
                    <div class="nav-option option1">
                        <span class="material-symbols-outlined">book</span>
                        <h3>Bookings</h3>
                    </div>
                </a>

                @if (session()->has('admin_type'))
                    @if (session('admin_type') == 'admin')
                        <a href="{{ url('admin/staff') }}">
                            <div class="nav-option option1">
                                <span class="material-symbols-outlined">badge</span>
                                <h3>Staffs</h3>
                            </div>
                        </a>
                    @endif
                @endif

            
                <a href="{{ url('admin/department') }}">
                    <div class="nav-option option1">
                        <span class="material-symbols-outlined">local_fire_department</span>
                        <h3>Departments</h3>
                    </div>
                </a>

                <a href="{{ url('admin/food') }}">
                    <div class="nav-option option1">
                        <span class="material-symbols-outlined">restaurant</span>
                        <h3>Foods</h3>
                    </div>
                </a>

                <a href="{{ url('admin/service') }}">
                    <div class="nav-option option1">
                        <span class="material-symbols-outlined">wb_iridescent</span>
                        <h3>Services</h3>
                    </div>
                </a>

                @if (session()->has('admin_type'))
                    @if (session('admin_type') == 'admin')
                        <a href="{{ url('admin/finance') }}">
                            <div class="nav-option option1">
                                <span class="material-symbols-outlined">account_balance</span>
                                <h3>Finance</h3>
                            </div>
                        </a>
                    @endif
                @endif


                <a href="{{ url('admin/logout') }}">
                    <div class="nav-option logout">
                        <span class="material-symbols-outlined">logout</span>
                        <h3>Log out</h3>
                    </div>
                </a>
            </nav>
        </div>

        <!-- Main content for the page. -->
        <div class="right-main-container">
            @yield('content')
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    @yield('scripts')
    <script>
        $(document).ready(function() {
            $('#Table_ID').DataTable();
        });

        // Get all the nav-options
        const navOptions = document.querySelectorAll('.nav-option');

        // Loop through each nav-option
        navOptions.forEach(function(navOption) {
            // Add a click event listener to the nav-option
            navOption.addEventListener('click', function() {
                // Toggle the show class on the child options div
                const childOptions = navOption.nextElementSibling;
                childOptions.classList.toggle('show');

                // Toggle the active class on the nav-option
                navOption.classList.toggle('active');
            });
        });
    </script>
</body>

</html>
