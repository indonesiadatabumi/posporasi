@extends('layouts.default')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endpush

@section('title', 'Daftar Pengguna')

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Daftar Pengguna</li>
        </ol>
        <h1 class="page-header mb-0">Daftar Pengguna</h1>
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
        <i class="fa fa-users fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Daftar Pengguna
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered text-nowrap align-middle" id="users-table">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Nomor Identitas</th>
                        <th>Restoran</th>
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
       $(document).ready(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('users.data') }}',  
        columns: [
            { data: 'DT_RowIndex', searchable: false, sortable: false, className: 'text-center' },
            { data: 'nama' },
            { data: 'email' },
            { data: 'role' },
            { data: 'nomor_identitas' },
            { data: 'restoran.nama_resto', name: 'restoran.nama_resto' },  
        ]
    });
});

    </script>
@endpush
