<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk</title>
    <style>
        @page {
            margin: 0;
            size: 58mm auto;  
        }

        body.struk {
            width: 58mm;    
            margin: 0;    
            padding: 0;    
            font-size: 10px;  
            font-family: monospace;  
        }

        body.struk .sheet {
            padding: 2mm;   
            box-sizing: border-box;  
            overflow: hidden;  
        }

        .txt-left { text-align: left; }
        .txt-center { text-align: center; }
        .txt-right { text-align: right; }

        @media screen {
            body { background: #e0e0e0; font-family: monospace; }
            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
                margin: 5mm;
            }
        }

        @media print {
            body { font-family: monospace; }
            body.struk { width: 58mm; text-align: left; }
            body.struk .sheet { padding: 2mm; }
            .txt-left { text-align: left; }
            .txt-center { text-align: center; }
            .txt-right { text-align: right; }
        }

        table {
            width: 100%;
            table-layout: fixed;  
        }

        td, th {
            font-size: 9px;  
        }
    </style>
</head>
<body class="struk">
    <div class="sheet">
        <div class="txt-center">
            <h2>{{ $restoran->nama_resto }}</h2>
            <p>{{ $restoran->alamat }}</p>
            <p>Telp: {{ $restoran->nomor_telepon }}</p>
            <hr>
        </div>

        <p>Customer: {{ $pembelian->pembeli }}</p>
        <p>No. Struk: {{ $nomor_struk }}</p>
        <p>Jenis Pesanan: {{ $jenisPesanan }}</p>
        <p>Tanggal: {{ now()->format('d-m-Y') }}</p>
        <hr>

        <table>
            @foreach ($pembelian->detail as $detail)
                <tr>
                    <td class="txt-left">{{ $detail->jumlah }} x {{ $detail->produk->nama_produk }}</td>
                    <td class="txt-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
        <hr>
        <table>
            <tr>
                <td class="txt-left">Subtotal:</td>
                <td class="txt-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="txt-left">Pajak:</td>
                <td class="txt-right">Rp {{ number_format($pajak, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="txt-left">Total Bayar:</td>
                <td class="txt-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="txt-left">Tunai:</td>
                <td class="txt-right">Rp {{ number_format($tunai, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="txt-left">Kembalian:</td>
                <td class="txt-right">Rp {{ number_format($kembalian, 0, ',', '.') }}</td>
            </tr>
            
        </table>
        <hr>
        <div class="txt-center">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Mohon simpan struk ini sebagai bukti pembayaran</p>
        </div>
    </div>
</body>
</html>

<script>
    window.onload = function() {
        window.print();
        window.onafterprint = function() {
            window.close();  
        }
    };
</script>
