<!DOCTYPE html>
<html>
<head>
    <title>Payment Page</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <h2>Bayar Sekarang</h2>
    <button id="pay-button">Bayar</button>

    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            fetch('/payment/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        alert("Pembayaran sukses!");
                        console.log(result);
                    },
                    onPending: function(result) {
                        alert("Menunggu pembayaran");
                        console.log(result);
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal");
                        console.log(result);
                    }
                });
            });
        });
    </script>
</body>
</html>
