<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptops</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .main-container {
            display: flex;
            background-color: #067D40;
        }

        .sidebar {
            width: 260px;
            background-color: #067D40;
        }

        .content {
            flex: 1;
            padding: 20px;
            margin: 30px 30px 30px 0;
            background-color: #F8F9FA;
            border-radius: 20px;
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
            <h3><span style="color: black;">Laptops</span></h3>
            <hr>
            <a href="{{ route('laptops.create') }}" class="btn btn-primary mb-3">Add Laptop</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Laptop ID</th>
                        <th>Customer</th>
                        <th>Brand</th>
                        <th>Problem Description</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laptops as $laptop)
                    <tr data-laptop-id="{{ $laptop->id_laptop }}">
                        <td>{{ $laptop->id_laptop }}</td>
                        <td>{{ $laptop->customer->customer_name }}</td>
                        <td>{{ $laptop->laptop_brand }}</td>
                        <td>{{ $laptop->problem_description }}</td>
                        <td>{{ $laptop->created_at }}</td>
                        <td>{{ $laptop->updated_at }}</td>
                        <td class="actions-column">
                            <a href="{{ route('laptops.edit', ['laptop' => $laptop->id_laptop]) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('laptops.destroy', ['laptop' => $laptop->id_laptop]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="7">No laptops found</td>
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
