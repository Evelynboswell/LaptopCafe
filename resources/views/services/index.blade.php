<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .main-container {
            display: flex;
            background-color: #067D40;
        }
        .sidebar {
            width: 260px; /* Adjust width as needed */
            background-color: #067D40;
        }
        .content {
            flex: 1;
            padding: 20px;
            margin: 30px 30px 30px 0;
            background-color: #F8F9FA; /* Light background for the main content area */
            border-radius: 20px; /* Rounded corners for the white box */
        }
        .table {
            background-color: white;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar text-white">
            @include('components.sidebar')
        </div>

        <!-- Main Content -->
        <main class="content">
            <h3>Services</h3>
            <hr>
            <div class="d-flex align-items-center justify-content-between">
                <h1 class="mb-0">List of Services</h1>
                <a href="{{ route('services.create') }}" class="btn btn-primary">Add Service</a>
            </div>
            <hr />
            @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Service ID</th>
                        <th>Service Name</th>
                        <th>Service Price</th>
                        <th>Warranty Range (years)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td class="align-middle">{{ $service->id_service }}</td>
                            <td class="align-middle">{{ $service->service_name }}</td>
                            <td class="align-middle">{{ $service->service_price }}</td>
                            <td class="align-middle">{{ $service->warranty_range }}</td>
                            <td class="align-middle">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('services.edit', ['service' => $service->id_service]) }}" class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('services.destroy', ['service' => $service->id_service]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="5">No services found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </main>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
