<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>

    @if (!Session::has('admin_data'))
        <script type="text/javascript">
            window.location.href = "{{ url('admin') }}";
        </script>
    @endif

    <link href="{{ asset('public/res/adminStyle.css') }}" rel="stylesheet" />
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
            <span class="material-symbols-outlined">account_circle</span>
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

                <div>
                    <a href="{{ url('admin/room') }}">
                        <div class="nav-option option1">
                            <span class="material-symbols-outlined">bed</span>
                            <h3>Rooms</h3>
                        </div>
                    </a>
                    <div>
                        <a href="{{ url('admin/room') }}">
                            <div class="room-options">Rooms</div>
                        </a>
                        <a href="{{ url('admin/roomtype') }}">
                            <div class="room-options">Room Types</div>
                        </a>
                    </div>
                </div>

                <a href="{{ url('admin/customer') }}">
                    <div class="nav-option option1">
                        <span class="material-symbols-outlined">group</span>
                        <h3>Customers</h3>
                    </div>
                </a>

                <a href="{{ url('admin/staff') }}">
                    <div class="nav-option option1">
                        <span class="material-symbols-outlined">badge</span>
                        <h3>Staff</h3>
                    </div>
                </a>

                <a href="{{ url('admin/department') }}">
                    <div class="nav-option option1">
                        <span class="material-symbols-outlined">local_fire_department</span>
                        <h3>Department</h3>
                    </div>
                </a>
                <div class="nav-option option1">
                    <span class="material-symbols-outlined">wb_iridescent</span>
                    <h3>Services</h3>
                </div>
                <a href="{{ url('admin/logout') }}">
                    <div class="nav-option option1">
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
</body>

</html>
