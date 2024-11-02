@extends('layouts.default')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endpush

@section('title', 'Laporan Penjualan')

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Laporan Penjualan</li>
        </ol>
        <h1 class="page-header mb-0">Laporan Penjualan</h1>
    </div>
</div>

<div class="card border-0 mb-4">
    <div class="card-header h6 mb-0 bg-none p-3">
        <i class="fa fa-list fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Laporan Penjualan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered text-nowrap align-middle" id="laporanPembelianTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th>Tanggal</th>
                        <th>Nama Produk</th>
                        <th>Kode Produk</th>
                        <th>Terjual</th>
                        <th>Harga Jual</th>  
                        <th>Pendapatan</th>  
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script>
    $(function () {
        $('#laporanPembelianTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('lpenjualan.data') }}', 
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false, className: 'text-center'}, // Ganti dengan 'DT_RowIndex'
                {data: 'tanggal_transaksi', name: 'tanggal'},
                {data: 'nama_produk', name: 'nama_produk'},
                {data: 'kode_produk', name: 'kode_produk'},
                {data: 'terjual', name: 'total_terjual'},  
                {data: 'harga_jual', name: 'harga_jual'},  
                {data: 'pendapatan', name: 'pendapatan'}  
            ]
        });
    });
</script>
@endpush
