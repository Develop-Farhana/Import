<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include Bootstrap CSS for better styling (optional) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>@yield('title', ' Dashboard')</title>
    <style>
        body {
            display: flex;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 200px;
            height: 100vh;
            background-color: #343a40;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            color: #fff;
            transition: all 0.3s ease;
            z-index: 1;
            position: fixed;
            overflow-x: hidden;
        }
        .sidebar h2 {
            color: #fff;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .sidebar a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            text-decoration: none;
            color: #fff;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #6c757d;
        }
        .content {
            flex: 1;
            padding: 20px;
            margin-left: 200px; /* Adjust for sidebar width */
            transition: margin-left 0.3s;
        }
        .content h2 {
            margin-bottom: 20px;
        }
        .sidebar-toggle {
            display: none;
            cursor: pointer;
            position: fixed;
            top: 20px;
            left: 10px;
            z-index: 2;
            background-color: #343a40;
            color: #fff;
            padding: 10px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        .sidebar-toggle i {
            font-size: 1.5rem;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                overflow-x: hidden;
            }
            .sidebar h2 {
                display: none;
            }
            .sidebar a span {
                display: none;
            }
            .content {
                margin-left: 60px;
            }
            .sidebar:hover {
                width: 200px;
                overflow-x: visible;
            }
            .sidebar:hover .sidebar-toggle {
                display: block;
            }
            .sidebar-toggle {
                display: block;
            }
        }
    </style>
    @yield('style') <!-- Yield section for additional styles -->
</head>
<body>
    <div class="sidebar" id="sidebar">
        <h2> Dashboard</h2>
        <a href="{{ url('categories') }}"><span>Categories</span></a>
        <a href="{{ url('products') }}"><span>Products</span></a>
        <form action="{{ url('logout') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <button type="submit" style="width: 100%; padding: 10px; border: none; background-color: #ff4c4c; color: white; border-radius: 4px; cursor: pointer;">Logout</button>
        </form>
    </div>
    <div class="content">
        <div class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </div>
        @yield('content')
    </div>

    <!-- Include jQuery (optional if already included for other scripts) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#sidebarToggle').click(function() {
                $('.sidebar').toggleClass('active');
                $('.content').toggleClass('active');
            });
        });
    </script>

    @yield('script') <!-- Yield section for additional scripts -->
</body>
</html>
