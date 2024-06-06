<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .main-container {
            display: flex;
            background-color: #067D40;
            height: 100vh;
        }

        .sidebar {
            width: 260px;
            background-color: #067D40;
            height: 100%;
            color: white;
        }

        .content {
            flex: 1;
            padding: 20px;
            margin: 30px;
            background-color: #F8F9FA;
            border-radius: 20px;
            overflow: auto;
        }

        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            @include('components.newsidebar')
        </div>

        <!-- Main Content -->
        <main class="content">
            <h3>Welcome...</h3>
            <hr>
            <!-- Your main content here -->
            <div id="content-frame" class="center-container">
                <x-person_vector1 width="450" height="400" /> 
            </div>
        </main>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
