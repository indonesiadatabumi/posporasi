@extends('layouts.default')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endpush

@section('title', 'Daftar Restoran')

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Daftar Restoran</li>
        </ol>
        <h1 class="page-header mb-0">Daftar Restoran</h1>
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
        <i class="fa fa-utensils fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Daftar Restoran
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered text-nowrap align-middle" id="restoran-table">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th>Nama Restoran</th>
                        <th>Nomor Identitas</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Nomor Telepon</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data restoran akan diambil menggunakan DataTables -->
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
            var table = $('#restoran-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('restoran.data') }}', // URL untuk mendapatkan data restoran
                columns: [
                    { data: 'DT_RowIndex', searchable: false, sortable: false, className: 'text-center' },
                    { data: 'nama_resto' },
                    { data: 'nomor_identitas' },
                    { data: 'email' },
                    { data: 'alamat' },
                    { data: 'nomor_telepon' },
                    { data: 'action', orderable: false, searchable: false } // Kolom action untuk tombol hapus
                ]
            });

            $('#restoran-table').on('submit', '.delete-form', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.find('input[name="_method"]').val();

                $.ajax({
                    url: url,
                    method: method,
                    data: form.serialize(),
                    success: function(response) {
                        if(response.success) {
                            // Mengupdate data tabel setelah penghapusan
                            table.ajax.reload();
                            alert(response.success);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Terjadi kesalahan, coba lagi.");
                    }
                });
            });
        });
    </script>
@endpush
