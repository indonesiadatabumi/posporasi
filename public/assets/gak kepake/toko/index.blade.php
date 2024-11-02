@extends('layouts.default')
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endpush

@section('title', 'Daftar Toko')

@section('content')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Daftar Toko</li>
            </ol>
            <h1 class="page-header mb-0">Manage Toko</h1>
        </div>
        <div class="ms-auto">
            <button onclick="addForm('{{ route('toko.store') }}')" class="btn btn-success btn-rounded px-4 rounded-pill">
                <i class="fa fa-plus fa-lg me-2 ms-n2 text-success-900"></i> Tambah Toko
            </button>
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
            <i class="fa fa-list fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Daftar Toko
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered text-nowrap align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Nama Toko</th>
                            <th>Alamat</th>
                            <th class="text-center" style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @includeIf('toko.form') <!-- Sertakan modal -->
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
                url: '{{ route('toko.data') }}', // Mengambil data untuk tabel toko
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false, className: 'text-center'},
                {data: 'nama_toko'}, // Field untuk nama toko
                {data: 'alamat'},    // Field untuk alamat toko
                {data: 'aksi', searchable: false, sortable: false, className: 'text-center'},
            ]
        });

        $('#modal-form').on('submit', function (e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let method = $(this).find('[name=_method]').val() || 'post'; // Ambil method dari form

            $.ajax({
                url: url,
                type: method,
                data: $(this).serialize(),
                success: (response) => {
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                    alert(response.message); // Menampilkan pesan dari server
                },
                error: (errors) => {
                    alert('Tidak dapat menyimpan data');
                }
            });
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Toko');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_toko]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Toko');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_toko]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_toko]').val(response.nama_toko);
                $('#modal-form [name=alamat]').val(response.alamat);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
            });
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    '_token': `{{ csrf_token() }}`
                },
                success: (response) => {
                    table.ajax.reload();
                    alert(response.message); // Menampilkan pesan dari server
                },
                error: (errors) => {
                    alert('Tidak dapat menghapus data');
                }
            });
        }
    }
</script>
@endpush
