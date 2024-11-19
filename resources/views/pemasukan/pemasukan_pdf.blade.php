<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemasukan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #444;
        }
        p {
            font-size: 14px;
            text-align: center;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
            padding: 10px;
            text-align: center;
        }
        td {
            padding: 8px;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .total-row td {
            font-weight: bold;
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Laporan Pemasukan</h1>
    <p>Tanggal Cetak: {{ $current_date }}</p>
    @if($start_date && $end_date)
        <p>Periode: {{ $start_date }} sampai {{ $end_date }}</p>
    @endif
    <table>
        <thead>
            <tr>
                <th>No</th> <!-- Tambahkan kolom No -->
                <th>Tanggal Transaksi</th>
                <th>Subtotal</th>
                <th>Pajak</th>
                <th>Total Pemasukan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayaran as $index => $item) <!-- Menambahkan nomor urut -->
                <tr>
                    <td>{{ $index + 1 }}</td> <!-- Menampilkan nomor urut -->
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d-m-Y') }}</td>
                    <td>Rp. {{ number_format($item->total_subtotal, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->total_pajak, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->total_pemasukan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2">Total</td>
                <td>Rp. {{ number_format($grandTotalSubtotal, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($grandTotalPajak, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($grandTotalPemasukan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
