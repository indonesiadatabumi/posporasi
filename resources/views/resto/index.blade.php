@extends('layouts.default')

@section('title', 'Profil Restoran')

@section('content')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Profil Restoran</li>
            </ol>
            <h1 class="page-header mb-0">Profil Restoran</h1>
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
            <i class="fa fa-store fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Informasi Restoran
        </div>
        <div class="card-body">
            <form action="{{ route('resto.update') }}" method="POST" id="resto-form">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_resto" class="form-label">Nama Restoran</label>
                    <input type="text" class="form-control" id="nama_resto" name="nama_resto"
                        value="{{ $resto->nama_resto }}">
                </div>
                <div class="mb-3">
                    <label for="nomor_identitas" class="form-label">Nomor Identitas</label>
                    <input type="text" class="form-control" id="nomor_identitas" value="{{ $resto->nomor_identitas }}"
                        disabled>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $resto->email }}">
                </div>
                <div class="mb-3">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon"
                        value="{{ $resto->nomor_telepon }}">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $resto->alamat }}">
                </div>
                <button type="submit" class="btn btn-primary">Update Profil</button>
            </form>
        </div>
    </div>
@endsection
