@extends('layouts.default', [
    'paceTop' => true, 
    'appSidebarHide' => true, 
    'appHeaderHide' => true, 
    'appContentClass' => 'p-0'
])

@section('title', 'Register Page')

@section('content')
    <div class="register register-with-news-feed">
        <div class="news-feed">
            <div class="news-image" style="background-image: url(/assets/img/login-bg/login-bg-15.jpg)"></div>
            <div class="news-caption">
                <h4 class="caption-title"><b>POS</b> DBI</h4>
                <p>Solusi transaksi dan operasional bisnis yang efisien.</p>
            </div>
        </div>
        
        <div class="register-container">
            <div class="register-header mb-25px h1">
                <div class="mb-1">Daftar</div>
                <small class="d-block fs-15px lh-16">Buat akun POS DBI-mu.</small>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="register-content">
                <form action="{{ route('register') }}" method="POST" class="fs-13px">
                    @csrf 
                    <div class="mb-3">
                        <label class="mb-2">Nama<span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control fs-13px" placeholder="Nama" required />
                    </div>
                    <div class="mb-3">
                        <label class="mb-2">Nama Restoran<span class="text-danger">*</span></label>
                        <input type="text" name="nama_resto" class="form-control fs-13px" placeholder="Nama Restoran" required />
                    </div>
                    <div class="mb-3">
                        <label class="mb-2">Nomor Identitas <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_identitas" class="form-control fs-13px" placeholder="Nomor Identitas" required />
                    </div>
                    <div class="mb-3">
                        <label class="mb-2">Alamat Restoran <span class="text-danger">*</span></label>
                        <input type="text" name="alamat" class="form-control fs-13px" placeholder="Alamat Restoran" required />
                    </div>
                    <div class="mb-3">
                        <label class="mb-2">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_telepon" class="form-control fs-13px" placeholder="Nomor Telepon" required />
                    </div>
                    <div class="mb-3">
                        <label class="mb-2">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control fs-13px" placeholder="Alamat Email" required />
                    </div>
                    <div class="mb-3">
                        <label class="mb-2">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control fs-13px" placeholder="Password" required />
                    </div>
                    <div class="mb-4">
                        <label class="mb-2">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control fs-13px" placeholder="Konfirmasi Password" required />
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" value="" id="agreementCheckbox" required />
                        <label class="form-check-label" for="agreementCheckbox">
                            Dengan mengklik Daftar, Anda setuju dengan <a href="javascript:;">Syarat & Ketentuan</a> kami dan Anda telah membaca <a href="javascript:;">Kebijakan Data</a> kami, termasuk <a href="javascript:;">Penggunaan Cookie</a>.
                        </label>                            
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary d-block w-100 btn-lg h-45px fs-13px">Daftar</button>
                    </div>
                </form>
            </div>
            <div class="mb-4 pb-5">
                Sudah memiliki akun? <a href="{{ route('login') }}">klik disini</a> untuk login.
            </div>
            <hr class="bg-gray-600 opacity-2" />
            <p class="text-center text-gray-600">
                &copy; POS DBI @ {{ date('Y') }}
            </p>
        </div>
    </div>    
@endsection
