@extends('layouts.default', [
    'paceTop' => true,
    'appSidebarHide' => true,
    'appHeaderHide' => true,
    'appContentClass' => 'p-0'
])

@section('title', 'Login Page')

@section('content')
<div class="login-container vh-100 d-flex justify-content-center align-items-center position-relative">
    <!-- Background Image -->
    <div class="position-absolute top-0 start-0 w-100 h-100" 
        style="background-image: url('{{ asset('assets/img/login-bg/1.jpg') }}'); 
               background-size: cover; 
               background-position: center; 
               filter: blur(8px);">
    </div>
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-50"></div>
    <!-- Login Card -->
    <div class="card shadow-lg border-0 text-center position-relative" style="max-width: 400px; width: 100%;">
        <div class="card-body p-4">
            <h1 class="fw-bold text-primary mb-4">POS DBI</h1>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           id="emailAddress" placeholder="Alamat Email" value="{{ old('email') }}" required />
                    <label for="emailAddress">Alamat Email</label>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-floating mb-3 position-relative">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" placeholder="Password" required />
                    <label for="password">Password</label>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <button type="button" onclick="togglePasswordVisibility()" 
                            class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-3 p-0" style="z-index: 2;">
                        {{-- <i id="togglePasswordIcon" class="fa fa-eye"></i> --}}
                    </button>
                </div>
            
                <button type="submit" class="btn btn-primary w-100 py-2">Masuk</button>
            </form>
            
            <div class="text-center mt-3">
                <small class="text-muted">Belum punya akun? <a href="{{ url('register') }}" class="text-decoration-none">Daftar</a></small>
            </div>
        </div>        
    </div>
</div>
@endsection

@push('scripts')
<style>
    .position-relative {
    position: relative;
}

.btn-link {
    z-index: 1; 
}

</style>
<script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('.form-control');
        
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                const errorFeedback = input.parentNode.querySelector('.invalid-feedback');
                if (errorFeedback) {
                    errorFeedback.style.display = 'none'; 
                }
                input.classList.remove('is-invalid');  
            });
        });
    });
</script>
@endpush
