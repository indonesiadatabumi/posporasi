<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota {{ $nomor_struk }}</title>
    <style>
        @page {
            margin: 0;
            size: 80mm auto;
        }

        body {
            font-family: monospace;
            font-size: 12px; 
            margin: 0;
            padding: 0;
            width: 80mm;
        }

        .sheet {
            padding: 5mm;
            box-sizing: border-box;
        }

        .txt-center {
            text-align: center;
        }

        .txt-left {
            text-align: left;
        }

        .txt-right {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 3px 0;  
        }

        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;  
        }

        .bold {
            font-weight: bold; 
        }

        .header {
            font-size: 14px;   
            font-weight: bold;
        }
    </style>
</head>
<body onload="printOut()">
    <div class="sheet">
        <!-- Header Restoran -->
        <div class="txt-center header">
            {{ $restoran->nama_resto }}<br>
        </div>
        <div class="txt-center">
            {{ $restoran->alamat }}<br>
            Telp: {{ $restoran->nomor_telepon }}
        </div>
        <div class="line"></div>

        <!-- Informasi Transaksi -->
        <table>
            <tr>
                <td class="bold">Nota</td>
                <td>:</td>
                <td>{{ $nomor_struk }}</td>
            </tr>
            <tr>
                <td class="bold">Customer</td>
                <td>:</td>
                <td>{{ $pembelian->pembeli }}</td>
            </tr>
            <tr>
                <td class="bold">Tanggal</td>
                <td>:</td>
                <td>{{ now()->format('d-m-Y H:i:s') }}</td>
            </tr>
        </table>
        <div class="line"></div>

        <!-- Detail Item -->
        <table>
            <thead>
                <tr>
                    <td class="bold">Item</td>
                    <td class="txt-right bold">Qty</td>
                    <td class="txt-right bold">Harga</td>
                    <td class="txt-right bold">Total</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembelian->detail as $detail)
                <tr>
                    <td>{{ $detail->produk->nama_produk }}</td>
                    <td class="txt-right">{{ $detail->jumlah }}</td>
                    <td class="txt-right">{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td class="txt-right">{{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="line"></div>

        <!-- Total dan Pembayaran -->
        <table>
            <tr>
                <td class="bold">Sub Total</td>
                <td class="txt-right bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="bold">Pajak</td>
                <td class="txt-right bold">Rp {{ number_format($pajak, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="bold">Grand Total</td>
                <td class="txt-right bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="bold">Tunai</td>
                <td class="txt-right bold">Rp {{ number_format($tunai, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="bold">Kembali</td>
                <td class="txt-right bold">Rp {{ number_format($kembalian, 0, ',', '.') }}</td>
            </tr>
        </table>
        <div class="line"></div>

        <!-- Footer -->
        <div class="txt-center">
            <strong>Terima Kasih Atas Kunjungan Anda!</strong><br>
            Simpan Nota Ini Sebagai Bukti Pembayaran
        </div>
    </div>

    <!-- Script untuk Cetak -->
    <script>
        function printOut() {
            window.print();  
            window.onafterprint = function() {
                window.close();  
            };
        }
    </script>
</body>
</html>
