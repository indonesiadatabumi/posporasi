<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        /* Pengaturan umum */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        /* Pengaturan orientasi potret */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
            body {
                margin: 0;
            }
        }

        /* Judul */
        h1 {
            text-align: center;
            color: #444;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Informasi tanggal dan periode */
        .date-info {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }
        .date-info strong {
            font-weight: bold;
        }

        /* Pengaturan tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
    </style>
</head>
<body>
    <h1>Laporan Penjualan</h1>
    <div class="date-info">
        <strong>Tanggal Cetak:</strong> {{ $tanggalCetak }}
        @if($start_date && $end_date)
            <br><strong>Periode:</strong> {{ $start_date }} sampai {{ $end_date }}
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Produk</th>
                <th>Kode Produk</th>
                <th>Terjual</th>
                <th>Harga Jual</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row['tanggal_transaksi'] }}</td>
                    <td>{{ $row['nama_produk'] }}</td>
                    <td>{{ $row['kode_produk'] }}</td>
                    <td>{{ $row['terjual'] }}</td>
                    <td>{{ $row['harga_jual'] }}</td>
                    <td>{{ $row['pendapatan'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
