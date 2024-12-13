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
        <div class="news-image" style="background-image: url(/assets/img/login-bg/1.jpg)"></div>
        <div class="news-caption">
            <h4 class="caption-title"><b>POS</b> DBI</h4>
            <p>Solusi transaksi dan operasional bisnis yang efisien.</p>
        </div>
    </div>
    <div class="register-container">
        <div class="register-header mb-25px h1">
            <div class="mb-0" align="center">Daftar</div>
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
            <form action="{{ route('register') }}" method="POST" id="registerForm" class="fs-13px">
                @csrf
                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label mb-2">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control fs-13px" placeholder="Nama" required />
                </div>
            
                <!-- Nama Restoran -->
                <div class="mb-3">
                    <label for="nama_resto" class="form-label mb-2">Nama Restoran</label>
                    <input type="text" id="nama_resto" name="nama_resto" class="form-control fs-13px" placeholder="Nama Restoran" required />
                </div>
            
                <!-- NIK -->
                <div class="mb-3">
                    <label for="nik" class="form-label mb-2">NIK (Nomor Identitas Pengguna)</label>
                    <input type="text" id="nik" name="nik" class="form-control fs-13px" placeholder="Masukkan NIK" required />
                </div>
            
                <!-- NIB -->
                <div class="mb-3">
                    <label for="nib" class="form-label mb-2">NIB (Nomor Identitas Restoran)</label>
                    <input type="text" id="nib" name="nib" class="form-control fs-13px" placeholder="Masukkan NIB" required />
                </div>
            
                <!-- Alamat Restoran -->
                <div class="mb-3">
                    <label for="alamat" class="form-label mb-2">Alamat Restoran</label>
                    <input type="text" id="alamat" name="alamat" class="form-control fs-13px" placeholder="Alamat Restoran" required />
                </div>
            
                <!-- Nomor Telepon -->
                <div class="mb-3">
                    <label for="nomor_telepon" class="form-label mb-2">Nomor Telepon</label>
                    <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control fs-13px" placeholder="Nomor Telepon" required />
                </div>
            
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label mb-2">Alamat Email</label>
                    <input type="email" id="email" name="email" class="form-control fs-13px" placeholder="Alamat Email" required />
                </div>
            
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label mb-2">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control fs-13px" placeholder="Password" required />
                        <span class="input-group-text" onclick="togglePassword('password')" style="cursor: pointer;">
                            <i class="fa fa-eye" id="togglePasswordIcon"></i>
                        </span>
                    </div>
                </div>
            
                <!-- Konfirmasi Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label mb-2">Konfirmasi Password</label>
                    <div class="input-group">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control fs-13px" placeholder="Konfirmasi Password" required />
                        <span class="input-group-text" onclick="togglePassword('password_confirmation')" style="cursor: pointer;">
                            <i class="fa fa-eye" id="togglePasswordConfirmationIcon"></i>
                        </span>
                    </div>
                </div>
            
                <!-- Alert Jika Password Tidak Cocok -->
                <div id="passwordMismatchAlert" class="text-danger mb-2" style="display: none;">
                    Password dan konfirmasi password tidak cocok!
                </div>
        
                <!-- Tombol Submit -->
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

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-tC5kXx5v+M+sykFR5t0P6Q4RCcUHZjZhU3PnL0HFAlx56tgx3xvM2hqevl7p7F0gk3sBc6J/Ru8LW8GYh3E2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const alertElement = document.getElementById('passwordMismatchAlert');

        if (password !== confirmPassword) {
            event.preventDefault();
            alertElement.style.display = 'block';
        } else {
            alertElement.style.display = 'none';
        }
    });

    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const icon = fieldId === 'password' ? document.getElementById('togglePasswordIcon') : document.getElementById('togglePasswordConfirmationIcon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

<style>
    @media (max-width: 767px) {
        .register-container {
            padding: 10px;
        }
        .register-header {
            font-size: 1.5rem;
        }
        .form-control {
            font-size: 14px;
        }
        .btn {
            font-size: 14px;
        }
    }
</style>
@endsection
