<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $restoran->nama_resto }}</h2>
        <p>{{ $restoran->alamat }}</p>
        <p>Telp: {{ $restoran->nomor_telepon }}</p>
    </div>

    <p>No. Struk: {{ $nomor_struk }}</p>
    <p>Tanggal: {{ now()->format('d-m-Y H:i:s') }}</p>
    <p>Customer: {{ $pembelian->pembeli }}</p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembelian->detail as $detail)
                <tr>
                    <td>{{ $detail->produk->nama_produk }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ number_format($detail->jumlah * $detail->harga_satuan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Subtotal</th>
                <td>{{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th colspan="3">Pajak</th>
                <td>{{ number_format($pajak, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th colspan="3">Total</th>
                <td>{{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Terima kasih atas kunjungan Anda!</p>
    </div>
</body>
</html>
