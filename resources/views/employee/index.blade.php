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
            <h1 class="page-header mb-0">Manage Pengguna</h1>
        </div>
        <div class="ms-auto">
            <button onclick="addForm('{{ route('user.store') }}')" class="btn btn-success btn-rounded px-4 rounded-pill">
                <i class="fa fa-plus fa-lg me-2 ms-n2 text-success-900"></i> Tambah Pengguna
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
            <i class="fa fa-list fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Daftar Pengguna
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered text-nowrap align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center" style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @includeIf('user.form') <!-- Include modal untuk form -->
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script>
        let table;

        $(function() {
            table = $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('user.data') }}',
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false,
                        className: 'text-center'
                    },
                    { data: 'name' },
                    { data: 'email' },
                    { 
                        data: 'role',
                        render: function(data, type, row) {
                            return `<span class="badge bg-primary">${data}</span>`;
                        },
                        className: 'text-center'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false,
                        className: 'text-center'
                    },
                ]
            });

            $('#modal-form').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            alert('Tidak dapat menyimpan data');
                            return;
                        });
                }
            });

        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Pengguna');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=name]').focus();
        }

        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Pengguna');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=name]').val(response.name);
                    $('#modal-form [name=email]').val(response.email);
                    $('#modal-form [name=role]').val(response.role);
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data');
                    return;
                });
        }

        function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': `{{ csrf_token() }}`,
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }
    </script>
@endpush
