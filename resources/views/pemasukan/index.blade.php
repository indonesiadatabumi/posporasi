@extends('layouts.default')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endpush

@section('title', 'Laporan Pemasukan')

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Laporan Pemasukan</li>
        </ol>
        <h1 class="page-header mb-0">Laporan Pemasukan</h1>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card border-0 mb-4">
    <div class="card-header h6 mb-0 bg-none p-3">
        <i class="fa fa-list fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Laporan Pemasukan
    </div>
    <div class="card-body">
        <form id="form-laporan" method="POST" action="{{ route('pemasukan.data') }}">
            @csrf
<div class="mb-3">
    <label for="start_date" class="form-label">Pilih Rentang Tanggal</label>
    <div class="d-flex align-items-center gap-2">
        <input type="date" class="form-control" id="start_date" name="start_date" required style="max-width: 150px;">
        <span class="mx-1">Sampai</span>
        <input type="date" class="form-control" id="end_date" name="end_date" required style="max-width: 150px;">
    </div>
</div>

            
            
            <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
        </form>
        <div class="table-responsive mt-3">
            <table class="table table-hover table-striped table-bordered text-nowrap align-middle" id="pemasukan-table">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Subtotal</th>
                        <th>Pajak</th>
                        <th>Total Pemasukan</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan dimuat setelah form disubmit -->
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
        // DataTable untuk menampilkan laporan pemasukan
        let table = $('#pemasukan-table').DataTable({
            responsive: true,
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('pemasukan.data') }}', // URL untuk mendapatkan data
                type: 'GET',
                data: function (d) {
                    d.start_date = $('#start_date').val(); // Mengambil tanggal mulai
                    d.end_date = $('#end_date').val(); // Mengambil tanggal akhir
                }
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false, className: 'text-center'},
                {data: 'tanggal_transaksi'},
                {data: 'subtotal'},
                {data: 'pajak'},
                {data: 'total_pemasukan'},
            ]
        });

        // Submit form dan reload DataTable
        $('#form-laporan').on('submit', function (e) {
            e.preventDefault(); // Mencegah refresh halaman
            table.ajax.reload(); // Muat ulang DataTable dengan data yang sesuai
        });
    });
</script>
@endpush
