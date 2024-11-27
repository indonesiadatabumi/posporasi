<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk</title>
    <style>
        /* Pengaturan halaman untuk mencetak */
        @page {
            margin: 0;
            size: 58mm auto; /* Ukuran lebar kertas thermal */
        }

        /* Mengatur body untuk struk */
        body.struk {
            width: 58mm;   /* Set lebar body sesuai dengan lebar kertas */
            margin: 0;     /* Hapus margin */
            padding: 0;    /* Hapus padding tambahan */
            font-size: 10px; /* Sesuaikan ukuran font untuk menghindari teks yang terlalu besar */
            font-family: monospace; /* Menggunakan font monospace untuk tampilan struk */
        }

        /* Mengatur elemen-elemen di dalam struk */
        body.struk .sheet {
            padding: 2mm;  /* Padding kecil agar tidak terlalu banyak ruang kosong */
            box-sizing: border-box; /* Pastikan ukuran box sesuai dengan halaman */
            overflow: hidden; /* Menghindari elemen yang meluap */
        }

        /* Pengaturan teks dalam struk */
        .txt-left { text-align: left; }
        .txt-center { text-align: center; }
        .txt-right { text-align: right; }

        /* Pengaturan elemen pada layar (untuk preview) */
        @media screen {
            body { background: #e0e0e0; font-family: monospace; }
            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
                margin: 5mm;
            }
        }

        /* Pengaturan saat mencetak */
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
            table-layout: fixed; /* Pastikan lebar tabel tidak melebihi batas */
        }

        td, th {
            font-size: 9px; /* Ukuran font kecil untuk menyesuaikan ruang */
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
