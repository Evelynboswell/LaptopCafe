<!-- resources/views/warranties/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warranties</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <style>
        .main-container {
            display: flex;
            background-color: #067D40;
        }

        .sidebar {
            width: 260px;
            /* Adjust width as needed */
            background-color: #067D40;
        }

        .content {
            flex: 1;
            padding: 20px;
            margin: 30px 30px 30px 0;
            background-color: #F8F9FA;
            /* Light background for the main content area */
            border-radius: 20px;
            /* Rounded corners for the white box */
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
            <h3>Warranties</h3>
            <hr>
            <div class="d-flex align-items-center justify-content-between">
                <h1 class="mb-0">List of Warranties</h1>
                <a href="{{ route('warranties.create') }}" class="btn btn-primary">Add Warranty</a>
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
                        <th>Warranty Number</th>
                        <th>Service ID</th>
                        <th>Start Date</th>
                        <th>Warranty Duration (years)</th>
                        <th>End Date</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($warranties as $warranty)
                    <tr>
                        <td class="align-middle">{{ $warranty->warranty_number }}</td>
                        <td class="align-middle">{{ $warranty->id_service }}</td>
                        <td class="align-middle">{{ $warranty->start_date }}</td>
                        <td class="align-middle">{{ $warranty->warranty_duration }}</td>
                        <td class="align-middle">{{ $warranty->end_date }}</td>
                        <td class="align-middle">{{ $warranty->created_at }}</td>
                        <td class="align-middle">{{ $warranty->updated_at }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group">
                                <a href="{{ route('warranties.edit', ['warranty' => $warranty->warranty_number]) }}"
                                    class="btn btn-secondary">Edit</a>
                                <form action="{{ route('warranties.destroy', ['warranty' => $warranty->warranty_number]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="8">No warranties found</td>
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
