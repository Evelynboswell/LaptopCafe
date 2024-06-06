<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Service Transaction</title>
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

        #content-frame {
            width: 100%;
            height: 85%;
            background-color: #F8F9FA;
        }

        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .bordered-table td,
        .bordered-table th {
            border: 1px solid black;
            padding: 8px;
            vertical-align: top;
        }

        .bordered-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .no-border td {
            border: none;
        }

        textarea {
            resize: none;
        }

        .form-control,
        select {
            margin-bottom: 10px;
        }

        .form-control:focus,
        select:focus {
            box-shadow: none;
        }

        .total-transaksi-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .total-transaksi-container label {
            margin-right: 10px;
            font-size: 20px;
        }

        .total-transaksi-wrapper {
            display: flex;
            justify-content: flex-end;
        }

        .align-right {
            text-align: right;
        }

        .total-price-input {
            font-size: 20px;
        }

        .align-end {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .align-end label {
            margin-right: 10px;
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
            <h3><span style="color: black;">View Service Transaction</span></h3>
            <hr>
            <div id="content-frame" class="container">
                <form>
                    <table class="bordered-table">
                        <tr class="no-border">
                            <td colspan="9">
                                <table class="no-border">
                                    <tr>
                                        <td>No Faktur</td>
                                        <td>:</td>
                                        <td><input type="text" name="invoice_number" class="form-control" value="{{ $serviceTransaction->invoice_number }}" readonly></td>
                                        <td width="600 px"></td>
                                        <td class="align-right total-transaksi-container">
                                            <label for="total_price">Total Transaksi</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Teknisi</td>
                                        <td>:</td>
                                        <td>
                                            <select name="technician_id" class="form-control" disabled>
                                                <option value="">Select Technician</option>
                                                @foreach($technicians as $technician)
                                                <option value="{{ $technician->id }}" {{ $serviceTransaction->technician_id == $technician->id ? 'selected' : '' }}>{{ $technician->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td width="600 px"></td>
                                        <td><input type="text" name="total_price" id="total_price" class="form-control total-price-input" value="Rp {{ number_format($serviceTransaction->total_price, 0, ',', '.') }},-" readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl Masuk</td>
                                        <td>:</td>
                                        <td><input type="date" name="entry_date" class="form-control" value="{{ $serviceTransaction->entry_date }}" readonly></td>
                                        <td width="600 px"></td>
                                        <td colspan="3" class="align-end">
                                            <label for="status">Status:</label>
                                            <select name="status" class="form-control" disabled>
                                                <option value="pending" {{ $serviceTransaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="completed" {{ $serviceTransaction->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl Keluar</td>
                                        <td>:</td>
                                        <td><input type="date" name="takeout_date" class="form-control" value="{{ $serviceTransaction->takeout_date }}" readonly></td>
                                        <td colspan="6"></td>
                                    </tr>
                                </table>
                                <br><br>
                            </td>
                        </tr>
                        <tr>
                            <td>Pelanggan & Laptop <br><br>
                                <table class="no-border">
                                    <tr>
                                        <td>Pelanggan</td>
                                        <td>:</td>
                                        <td>
                                            <select name="customer_id" id="customer_id" class="form-control" disabled>
                                                <option value="">Select Customer</option>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->customer_id }}" {{ $serviceTransaction->customer_id == $customer->customer_id ? 'selected' : '' }}>{{ $customer->customer_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Laptop</td>
                                        <td>:</td>
                                        <td>
                                            <select name="laptop_id" id="laptop_id" class="form-control" disabled>
                                                <option value="">Select Laptop</option>
                                                @foreach($customers as $customer)
                                                    @foreach($customer->laptops as $laptop)
                                                    <option value="{{ $laptop->id_laptop }}" data-customer-id="{{ $customer->customer_id }}" {{ $serviceTransaction->laptop_id == $laptop->id_laptop ? 'selected' : '' }}>{{ $laptop->laptop_brand }}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Deskripsi Masalah</td>
                                        <td>:</td>
                                        <td><textarea rows="4" cols="50" name="problem_description" id="problem_description" class="form-control" readonly>{{ $serviceTransaction->problem_description }}</textarea></td>
                                    </tr>
                                </table>
                            </td>
                            <td>Jasa Servis <br><br>
                                <table class="no-border">
                                    <tr>
                                        <td>Service</td>
                                        <td>
                                           <div id="services-container">
                                                @foreach(json_decode($serviceTransaction->service_ids) as $serviceId)
                                                <div class="service-item">
                                                    <select name="service_id[]" class="form-control service-select" disabled>
                                                        <option value="">Select Service</option>
                                                        @foreach($services as $service)
                                                        <option value="{{ $service->id_service }}" data-price="{{ $service->service_price }}" data-warranty="{{ $service->warranty_range }}" {{ $serviceId == $service->id_service ? 'selected' : '' }}>{{ $service->service_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>Garansi <br><br>
                                <table class="no-border">
                                    <tr>
                                        <td>No. Garansi</td>
                                        <td>:</td>
                                        <td><input type="text" name="warranty_id" class="form-control" value="{{ $serviceTransaction->warranty_id }}" readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl. Mulai</td>
                                        <td>:</td>
                                        <td><input type="date" name="warranty_start_date" id="warranty_start_date" class="form-control" value="{{ $serviceTransaction->warranty->start_date }}" readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl. Akhir</td>
                                        <td>:</td>
                                        <td><input type="date" name="warranty_end_date" id="warranty_end_date" class="form-control" value="{{ $serviceTransaction->warranty->end_date }}" readonly></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9">
                                <div class="buttons">
                                    <a href="{{ route('service_transactions.index') }}" class="btn btn-secondary">Back</a>
                                    <a href="{{ route('service_transactions.print', $serviceTransaction->transaction_id) }}" target="_blank" class="btn btn-primary">Print</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
