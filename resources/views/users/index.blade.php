@extends('layouts.default')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Manajemen Pengguna</li>
        </ol>
        <h1 class="page-header mb-0">Daftar Users</h1>
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
        <i class="fa fa-users fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Daftar Users
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetForm()">Tambah User</button>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width='15%'>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ ucfirst($data->role) }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editUser({{ $data }})">Edit</button>
                            <form action="{{ route('users.destroy', $data->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada user yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('users.form') <!-- Memanggil modal dari form.blade.php -->

<script>
    function editUser(data) {
        document.getElementById('userId').value = data.id;
        document.getElementById('userName').value = data.nama;
        document.getElementById('userEmail').value = data.email;
        document.getElementById('userIdentity').value = data.nomor_identitas;
        document.getElementById('userRole').value = data.role;
        
        const form = document.getElementById('userForm');
        form.action = `/users/${data.id}`;
        form.querySelector('input[name="_method"]').value = 'PUT';

        const modal = new bootstrap.Modal(document.getElementById('userModal'));
        modal.show();
    }

    function resetForm() {
        // Reset form ketika menambah user
        const form = document.getElementById('userForm');
        form.reset();
        form.action = "{{ route('users.store') }}";
        form.querySelector('input[name="_method"]').value = 'POST';
    }
</script>
@endsection
