@extends('layouts.default')

@section('title', 'Profil Pengguna')

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Profil Pengguna</li>
        </ol>
        <h1 class="page-header mb-0">Profil Saya</h1>
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
        <i class="fa fa-user fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Informasi Pengguna
    </div>
    <div class="card-body">
        <form action="{{ route('profile.update') }}" method="POST" id="profile-form">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ Auth::user()->nama }}">
            </div>
            <div class="mb-3">
                <label for="nama_resto" class="form-label">Nama Restoran</label>
                <input type="text" class="form-control" id="nama_resto" name="nama_resto" value="{{ Auth::user()->nama_resto }}">
            </div>
            <div class="mb-3">
                <label for="nomor_identitas" class="form-label">Nomor Identitas</label>
                <input type="text" class="form-control" id="nomor_identitas" value="{{ Auth::user()->nomor_identitas }}" disabled>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" disabled>
            </div>
            <div class="mb-3">
                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="{{ Auth::user()->nomor_telepon }}">
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ Auth::user()->alamat }}">
            </div>
            <button type="submit" class="btn btn-primary">Update Profil</button>
        </form>
    </div>
</div>
@endsection
