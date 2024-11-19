<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembayaran</title>
    <style>
        /* Pengaturan umum */
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 20px;
        }

        /* Pengaturan tampilan potret */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
            body {
                margin: 0;
            }
        }

        /* Judul dan teks */
        h1 {
            text-align: center;
            color: #444;
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            font-size: 14px;
            text-align: center;
            color: #555;
        }

        /* Tabel */
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
            font-size: 14px;
            text-align: center;
        }
        td {
            padding: 8px;
            font-size: 13px;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }

        /* Baris total */
        .total-row td {
            font-weight: bold;
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Laporan Pembayaran</h1>
    <p>Tanggal Cetak: {{ $current_date }}</p>
    @if($start_date && $end_date)
        <p>Periode: {{ $start_date }} sampai {{ $end_date }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Transaksi</th>
                <th>Nomor Struk</th>
                <th>Subtotal</th>
                <th>Pajak</th>
                <th>Total Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayaran as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d-m-Y') }}</td>
                    <td>{{ $row->nomor_struk }}</td>
                    <td>{{ 'Rp. ' . number_format((float)$row->subtotal, 0, ',', '.') }}</td>
                    <td>{{ 'Rp. ' . number_format((float)$row->pajak, 0, ',', '.') }}</td>
                    <td>{{ 'Rp. ' . number_format((float)$row->total_pembayaran, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">Total</td>
                <td>{{ 'Rp. ' . number_format((float)$totalSubtotal, 0, ',', '.') }}</td>
                <td>{{ 'Rp. ' . number_format((float)$totalPajak, 0, ',', '.') }}</td>
                <td>{{ 'Rp. ' . number_format((float)$totalPembayaran, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
