<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service Transaction</title>
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
            <h3><span style="color: black;">Edit Service Transaction</span></h3>
            <hr>
            <div id="content-frame" class="container">
                <form action="{{ route('service_transactions.update', $serviceTransaction->transaction_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <table class="bordered-table">
                        <tr class="no-border">
                            <td colspan="9">
                                <table class="no-border">
                                    <tr>
                                        <td>No Faktur</td>
                                        <td>:</td>
                                        <td><input type="text" name="invoice_number" class="form-control" value="{{ $serviceTransaction->invoice_number }}" required readonly></td>
                                        <td width="600 px"></td>
                                        <td class="align-right total-transaksi-container">
                                            <label for="total_price">Total Transaksi</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Teknisi</td>
                                        <td>:</td>
                                        <td>
                                            <select name="technician_id" class="form-control" required>
                                                <option value="">Select Technician</option>
                                                @foreach($technicians as $technician)
                                                <option value="{{ $technician->id }}" {{ $serviceTransaction->technician_id == $technician->id ? 'selected' : '' }}>{{ $technician->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td width="600 px"></td>
                                        <td><input type="text" name="total_price" id="total_price" class="form-control total-price-input" value="Rp {{ number_format($serviceTransaction->total_price, 0, ',', '.') }},-" required readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl Masuk</td>
                                        <td>:</td>
                                        <td><input type="date" name="entry_date" id="entry_date" class="form-control" value="{{ $serviceTransaction->entry_date }}" required></td>
                                        <td width="600 px"></td>
                                        <td colspan="3" class="align-end">
                                            <label for="status">Status:</label>
                                            <select name="status" class="form-control" required>
                                                <option value="pending" {{ $serviceTransaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="completed" {{ $serviceTransaction->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl Keluar</td>
                                        <td>:</td>
                                        <td><input type="date" name="takeout_date" id="takeout_date" class="form-control" value="{{ $serviceTransaction->takeout_date }}" required></td>
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
                                            <select name="customer_id" id="customer_id" class="form-control" required>
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
                                            <select name="laptop_id" id="laptop_id" class="form-control" required>
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
                                        <td><textarea rows="4" cols="50" name="problem_description" id="problem_description" class="form-control" required>{{ $serviceTransaction->problem_description }}</textarea></td>
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
                                                    <select name="service_id[]" class="form-control service-select" required>
                                                        <option value="">Select Service</option>
                                                        @foreach($services as $service)
                                                        <option value="{{ $service->id_service }}" data-price="{{ $service->service_price }}" data-warranty="{{ $service->warranty_range }}" {{ $serviceId == $service->id_service ? 'selected' : '' }}>{{ $service->service_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @endforeach
                                            </div>
                                            <button type="button" id="add-service-btn" class="btn btn-primary mt-2">Add Service</button>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>Garansi <br><br>
                                <table class="no-border">
                                    <tr>
                                        <td>No. Garansi</td>
                                        <td>:</td>
                                        <td><input type="text" name="warranty_id" class="form-control" value="{{ $serviceTransaction->warranty_id }}" required readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl. Mulai</td>
                                        <td>:</td>
                                        <td><input type="date" name="warranty_start_date" id="warranty_start_date" class="form-control" value="{{ $serviceTransaction->warranty->start_date }}" required></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl. Akhir</td>
                                        <td>:</td>
                                        <td><input type="date" name="warranty_end_date" id="warranty_end_date" class="form-control" value="{{ $serviceTransaction->warranty->end_date }}" required readonly></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9">
                                <div class="buttons">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var today = new Date().toISOString().split('T')[0];
            $('#entry_date').attr('min', today);
            $('#takeout_date').attr('min', today);
            $('#warranty_start_date').attr('min', today);

            $('#customer_id').change(function() {
                var customerId = $(this).val();
                $('#laptop_id option').each(function() {
                    var laptopCustomerId = $(this).data('customer-id');
                    if (customerId == laptopCustomerId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('#laptop_id').val('');
                $('#problem_description').val('');
            });

            $('#laptop_id').change(function() {
                var laptopId = $(this).val();
                if (laptopId) {
                    $.ajax({
                        url: '/service_transactions/getLaptopDetails/' + laptopId,
                        type: 'GET',
                        success: function(data) {
                            $('#problem_description').val(data.problem_description);
                        }
                    });
                } else {
                    $('#problem_description').val('');
                }
            });

            $('#add-service-btn').click(function() {
                var newServiceItem = $('.service-item').first().clone();
                newServiceItem.find('select').val('');
                $('#services-container').append(newServiceItem);
                updateTotalPrice();
            });

            $('#services-container').on('change', '.service-select', function() {
                updateTotalPrice();
            });

            function updateTotalPrice() {
                var totalPrice = 0;
                $('#services-container .service-select').each(function() {
                    var price = $(this).find('option:selected').data('price');
                    if (price) {
                        totalPrice += parseFloat(price);
                    }
                });
                $('#total_price').val('Rp ' + totalPrice.toLocaleString('id-ID') + ',-');
            }

            $('#warranty_start_date').change(function() {
                updateWarrantyEndDate();
            });

            $('#services-container').on('change', '.service-select', function() {
                updateWarrantyEndDate();
            });

            function updateWarrantyEndDate() {
                var startDate = new Date($('#warranty_start_date').val());
                if (isNaN(startDate.getTime())) return;

                var maxWarrantyRange = 0;
                $('#services-container .service-select').each(function() {
                    var warranty = $(this).find('option:selected').data('warranty');
                    if (warranty) {
                        maxWarrantyRange = Math.max(maxWarrantyRange, warranty);
                    }
                });

                if (maxWarrantyRange > 0) {
                    var endDate = new Date(startDate);
                    endDate.setMonth(endDate.getMonth() + maxWarrantyRange);
                    $('#warranty_end_date').val(endDate.toISOString().split('T')[0]);
                } else {
                    $('#warranty_end_date').val('');
                }
            }
        });
    </script>
</body>

</html>
