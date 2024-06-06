<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5>Pembayaran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('service_transactions.processPayment', $transaction->transaction_id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Harus Dibayar</label>
                        <p class="form-control-static">Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    </div>
                    <div class="mb-3">
                        <label for="payment_amount" class="form-label">Pembayaran</label>
                        <input type="text" class="form-control" id="payment_amount" name="payment_amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="change_amount" class="form-label">Kembalian</label>
                        <p class="form-control-static" id="change_amount">Rp. 0</p>
                    </div>
                    <button type="submit" class="btn btn-primary" id="pay_button">Bayar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#payment_amount').on('input', function() {
                var total = {{ $transaction->total_price }};
                var payment = $(this).val().replace(/[^0-9]/g, '');
                var change = payment - total;

                if (change >= 0) {
                    $('#change_amount').text('Rp. ' + change.toLocaleString('id-ID'));
                } else {
                    $('#change_amount').text('Rp. 0');
                }
            });
        });
    </script>
</body>

</html>
