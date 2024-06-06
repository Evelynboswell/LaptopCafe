<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptops</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
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
            <h3>Laptops</h3>
            <hr>
            <div class="d-flex align-items-center justify-content-between">
                <h1 class="mb-0">List of Laptops</h1>
                <a href="{{ route('laptops.create') }}" class="btn btn-primary">Add Laptop</a>
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
                        <th>Laptop ID</th>
                        <th>Customer</th>
                        <th>Brand</th>
                        <th>Problem Description</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laptops as $laptop)
                        <tr>
                            <td class="align-middle">{{ $laptop->id_laptop }}</td>
                            <td class="align-middle">{{ $laptop->customer->customer_name }}</td>
                            <td class="align-middle">{{ $laptop->laptop_brand }}</td>
                            <td class="align-middle">{{ $laptop->problem_description }}</td>
                            <td class="align-middle">{{ $laptop->created_at }}</td>
                            <td class="align-middle">{{ $laptop->updated_at }}</td>
                            <td class="align-middle">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('laptops.edit', ['laptop' => $laptop->id_laptop]) }}" class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('laptops.destroy', ['laptop' => $laptop->id_laptop]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
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
