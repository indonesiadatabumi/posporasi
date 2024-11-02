@extends('layouts.default')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endpush

@section('title', 'Laporan Pembayaran')

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Laporan Pembayaran</li>
        </ol>
        <h1 class="page-header mb-0">Laporan Pembayaran</h1>
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
        <i class="fa fa-list fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Laporan Pembayaran
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered text-nowrap align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Nomor Struk</th>
                        <th>Subtotal</th>
                        <th>Pajak</th>
                        <th>Total Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan dimuat menggunakan DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>

@includeIf('lpembayaran.form')
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('lpembayaran.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false, className: 'text-center'},
                {data: 'tanggal_transaksi'}, // Tanggal Transaksi
                {data: 'nomor_struk'}, // Nomor Struk
                {data: 'subtotal', render: $.fn.dataTable.render.number('.', ',', 0, 'Rp. ')}, // Subtotal
                {data: 'pajak', render: $.fn.dataTable.render.number('.', ',', 0, 'Rp. ')}, // Pajak
                {data: 'total_pembayaran', render: $.fn.dataTable.render.number('.', ',', 0, 'Rp. ')}, // Total Pembayaran
            ]
        });
    });

</script>
@endpush
