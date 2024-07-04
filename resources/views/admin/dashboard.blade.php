<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 200px;
            height: 100vh;
            background-color: #f8f9fa;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="{{ route('categories.index') }}">Categories</a>
        <a href="{{ route('products.index') }}">Products</a>
        <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <button type="submit" style="width: 100%; padding: 10px; border: none; background-color: #ff4c4c; color: white; border-radius: 4px; cursor: pointer;">Logout</button>
        </form>
    </div>
    <div class="content">
        <h1>Welcome to the Admin Dashboard</h1>
    </div>
</body>
</html>
