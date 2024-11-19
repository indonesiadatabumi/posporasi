@extends('layouts.default')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endpush

@section('title', 'Rekap Kasir')

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Rekap Kasir</li>
        </ol>
        <h1 class="page-header mb-0">Rekap Kasir</h1>
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
        <i class="fa fa-list fa-lg fa-fw text-dark text-opacity-50 me-1"></i>Rekap Kasir
    </div>
    <div class="card-body">
        <!-- Filter Tanggal -->
        <div class="mb-3">
            <label for="start_date" class="form-label">Pilih Rentang Tanggal</label>
            <div class="d-flex align-items-center gap-2">
                <input type="date" class="form-control" id="start_date" name="start_date" style="max-width: 150px;">
                <span class="mx-1">Sampai</span>
                <input type="date" class="form-control" id="end_date" name="end_date" style="max-width: 150px;">
            </div>
        </div>

        <div class="card-header h6 mb-0 bg-none p-0 d-flex justify-content-between align-items-center">
            <a href="#" id="export-pdf" class="btn btn-danger">Export PDF</a>
        </div>
        
        <div class="table-responsive mt-3">
            <table class="table table-hover table-striped table-bordered text-nowrap align-middle" id="rekap-kasir-table">
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
                    <!-- Data akan dimuat otomatis -->
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
        let table = $('#rekap-kasir-table').DataTable({
            responsive: true,
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('rekapkasir.data') }}', 
                type: 'GET',
                data: function (d) {
                    d.start_date = $('#start_date').val() || null;  
                    d.end_date = $('#end_date').val() || null; 
                }
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false, className: 'text-center'},
                {data: 'tanggal_transaksi'},
                {data: 'nomor_struk'},
                { 
                    data: 'subtotal', 
                    render: function(data) {
                        return data === 0 ? 'Rp. 0' : $.fn.dataTable.render.number('.', ',', 0, 'Rp. ').display(data);
                    }
                },   
                { 
                    data: 'pajak', 
                    render: function(data) {
                        return data === 0 ? 'Rp. 0' : $.fn.dataTable.render.number('.', ',', 0, 'Rp. ').display(data);
                    }
                },    
                { 
                    data: 'total_pembayaran', 
                    render: function(data) {
                        return data === 0 ? 'Rp. 0' : $.fn.dataTable.render.number('.', ',', 0, 'Rp. ').display(data);
                    }
                },  
            ]
        });

        $('#export-pdf').on('click', function (e) {
            e.preventDefault();
            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();
            let url = '{{ route('rekapkasir.exportPDF') }}' + '?start_date=' + startDate + '&end_date=' + endDate;
            window.location.href = url; 
        });

        $('#start_date, #end_date').on('change', function () {
            table.ajax.reload();  
        });

        table.ajax.reload();
    });
</script>

@endpush
