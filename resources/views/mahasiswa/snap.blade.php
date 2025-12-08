<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memproses Pembayaran...</title>

    <script 
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 80px;
        }
    </style>
</head>
<body>

<h2>Sedang memproses pembayaran...</h2>
<p>Harap tunggu, jangan tutup halaman ini.</p>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        // snapToken dikirim dari controller
        const snapToken = "{{ $snapToken }}";

        snap.pay(snapToken, {

            onSuccess: function(result){
                window.location.href = "{{ route('mahasiswa.detail-pesanan', $pesanan->id) }}";
            },

            onPending: function(result){
                alert("Menunggu pembayaran...");
            },
            onError: function(result){
                alert("Pembayaran gagal!");
            },

            onClose: function() {
                alert("Kamu menutup popup pembayaran tanpa menyelesaikan transaksi.");
            }

        });

    });
</script>

</body>
</html>
