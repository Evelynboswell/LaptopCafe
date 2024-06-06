<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Service Transaction</title>
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
            <h3><span style="color: black;">Create Service Transaction</span></h3>
            <hr>
            <div id="content-frame" class="container">
                <form action="{{ route('service_transactions.store') }}" method="POST">
                    @csrf
                    <table class="bordered-table">
                        <tr class="no-border">
                            <td colspan="3">
                                <table class="no-border">
                                    <tr>
                                        <td>No Faktur</td>
                                        <td>:</td>
                                        <td><input type="text" name="invoice_number" class="form-control" value="{{ $nextInvoiceNumber }}" required readonly></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Teknisi</td>
                                        <td>:</td>
                                        <td>
                                            <select name="technician_id" class="form-control" required>
                                                @foreach($technicians as $technician)
                                                <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td rowspan="2" colspan="2">Total Transaksi: <br>
                                            <input type="text" name="total_price" id="total_price" class="form-control" placeholder="Rp 0,-" required readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tgl Masuk</td>
                                        <td>:</td>
                                        <td><input type="date" name="entry_date" class="form-control" required></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl Keluar</td>
                                        <td>:</td>
                                        <td><input type="date" name="takeout_date" class="form-control" required></td>
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
                                            <select name="customer_id" class="form-control" required>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Laptop</td>
                                        <td>:</td>
                                        <td>
                                            <select name="laptop_id" class="form-control" required>
                                                @foreach($laptops as $laptop)
                                                <option value="{{ $laptop->id_laptop }}">{{ $laptop->laptop_brand }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Deskripsi Masalah</td>
                                        <td>:</td>
                                        <td><textarea rows="4" cols="50" name="problem_description" class="form-control" required></textarea></td>
                                    </tr>
                                </table>
                            </td>
                            <td>Jasa Servis <br><br>
                                <table class="no-border">
                                    <tr>
                                        <td>Service</td>
                                        <td>
                                            <div id="services-container">
                                                <div class="service-item">
                                                    <select name="service_id[]" class="form-control service-select" required>
                                                        @foreach($services as $service)
                                                        <option value="{{ $service->id_service }}" data-price="{{ $service->service_price }}" data-warranty="{{ $service->warranty_range }}">{{ $service->service_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
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
                                        <td><input type="text" name="warranty_id" class="form-control" required></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl. Mulai</td>
                                        <td>:</td>
                                        <td><input type="date" name="start_date" class="form-control" required></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl. Berakhir</td>
                                        <td>:</td>
                                        <td><input type="date" name="end_date" class="form-control" required readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Jangka (bulan)</td>
                                        <td>:</td>
                                        <td><input type="text" name="warranty_duration" class="form-control" readonly></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="buttons">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <a href="{{ route('service_transactions.index') }}" class="btn btn-link" style="float: right;">Lihat Riwayat</a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const servicesContainer = document.getElementById('services-container');
            const addServiceBtn = document.getElementById('add-service-btn');
            const totalPriceField = document.getElementById('total_price');
            const warrantyStartDateField = document.querySelector('input[name="start_date"]');
            const warrantyEndDateField = document.querySelector('input[name="end_date"]');
            const warrantyDurationField = document.querySelector('input[name="warranty_duration"]');

            function updateWarrantyAndTotal() {
                let totalPrice = 0;
                let maxWarranty = 0;

                document.querySelectorAll('.service-select').forEach(select => {
                    const selectedOption = select.options[select.selectedIndex];
                    const servicePrice = parseFloat(selectedOption.getAttribute('data-price'));
                    const serviceWarranty = parseInt(selectedOption.getAttribute('data-warranty'));

                    totalPrice += servicePrice;
                    if (serviceWarranty > maxWarranty) {
                        maxWarranty = serviceWarranty;
                    }
                });

                totalPriceField.value = formatRupiah(totalPrice);

                if (warrantyStartDateField.value) {
                    const startDate = new Date(warrantyStartDateField.value);
                    startDate.setMonth(startDate.getMonth() + maxWarranty);

                    const year = startDate.getFullYear();
                    const month = String(startDate.getMonth() + 1).padStart(2, '0');
                    const day = String(startDate.getDate()).padStart(2, '0');
                    const endDate = `${year}-${month}-${day}`;

                    warrantyEndDateField.value = endDate;
                }

                warrantyDurationField.value = maxWarranty;
            }

            warrantyStartDateField.addEventListener('change', updateWarrantyAndTotal);

            addServiceBtn.addEventListener('click', function() {
                const newService = document.createElement('div');
                newService.classList.add('service-item', 'mt-2');
                newService.innerHTML = `
                    <select name="service_id[]" class="form-control service-select" required>
                        @foreach($services as $service)
                        <option value="{{ $service->id_service }}" data-price="{{ $service->service_price }}" data-warranty="{{ $service->warranty_range }}">{{ $service->service_name }}</option>
                        @endforeach
                    </select>
                `;
                servicesContainer.appendChild(newService);

                newService.querySelector('.service-select').addEventListener('change', updateWarrantyAndTotal);
                updateWarrantyAndTotal(); // Recalculate the total price when a new service is added
            });

            function formatRupiah(amount) {
                return 'Rp ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }

            // Initial calculation for the default selected service
            updateWarrantyAndTotal();
        });
    </script>
</body>

</html>
