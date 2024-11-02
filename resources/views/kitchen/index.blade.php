@extends('layouts.default', [
    'paceTop' => true, 
    'appContentFullHeight' => true, 
    'appContentClass' => 'p-0',
    'appSidebarHide' => true,
    'appHeaderHide' => true
])

@section('title', 'Kitchen')

@push('scripts')
<style>
    body {
        padding-top: 20px; /* Sesuaikan dengan tinggi navbar */
    }
    .custom-title {
        font-size: 1rem;  
    }
    .custom-badge {
        font-size: 1rem; 
        padding: 10px 15px; 
        min-width: 20px;  
        text-align: center;  
    }
    .custom-button {
        font-size: 1rem; 
        padding: 10px 15px; 
    }
    .custom-text {
        font-size: 1rem;  
    }
</style>
<script src="/assets/js/demo/pos-menu-stock.demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Tambahkan SweetAlert CDN -->

<script>
    function toggleEdit(id) {
        const stockInput = document.getElementById('stockInput' + id);
        const updateBtn = document.getElementById('updateBtn' + id);
        const cancelBtn = document.getElementById('cancelBtn' + id);
        const editBtn = document.getElementById('editBtn' + id);

        stockInput.disabled = !stockInput.disabled;
        updateBtn.style.display = stockInput.disabled ? 'none' : 'inline-block';
        cancelBtn.style.display = stockInput.disabled ? 'none' : 'inline-block';
        editBtn.style.display = stockInput.disabled ? 'inline-block' : 'none';
    }

    // SweetAlert for success message
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif

    // SweetAlert for errors
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ implode('\n', $errors->all()) }}",
        });
    @endif
</script>
    <script src="/assets/js/demo/pos-menu-stock.demo.js"></script>
    <script>
        function toggleEdit(id) {
            const stockInput = document.getElementById('stockInput' + id);
            const updateBtn = document.getElementById('updateBtn' + id);
            const cancelBtn = document.getElementById('cancelBtn' + id);
            const editBtn = document.getElementById('editBtn' + id);

            stockInput.disabled = !stockInput.disabled;
            updateBtn.style.display = stockInput.disabled ? 'none' : 'inline-block';
            cancelBtn.style.display = stockInput.disabled ? 'none' : 'inline-block';
            editBtn.style.display = stockInput.disabled ? 'inline-block' : 'none';
        }
    </script>
@endpush

@section('content')

<nav class="navbar navbar-expand-lg navbar-light bg-light px-4 py-3 fixed-top">
    <a class="navbar-brand d-flex align-items-center" href="/dashboard" style="font-size: 1.5rem;">
        <img src="/assets/img/pos/logo.svg" width="30" height="30" alt="Pine & Dine" class="me-2">
        Pine & Dine
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a href="/pembelian" class="nav-link fs-5">
                    <i class="fa fa-shopping-cart"></i> Order
                </a>
            </li>
            <li class="nav-item">
                <a href="/pembayaran" class="nav-link fs-5">
                    <i class="fa fa-cash-register"></i> Checkout
                </a>
            </li>
            <li class="nav-item">
                <a href="/kitchen" class="nav-link fs-5">
                    <i class="fa fa-table-list"></i> Stock
                </a>
            </li>
            <li class="nav-item">
                <a href="/kitchenorder" class="nav-link fs-5">
                    <i class="fa fa-list-check"></i> Kitchen Order
                </a>
            </li>   
        </ul>
    </div>
</nav>


<!-- BEGIN pos-stock -->
<div class="pos pos-stock" id="pos-stock">
    <!-- BEGIN pos-stock-body -->
    <div class="pos-stock-body">
        <!-- BEGIN pos-stock-content -->
        <div class="pos-stock-content">
            <div class="pos-stock-content-container">
                <div class="row gx-0">
                    @foreach ($produk as $item)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6"> <!-- Mengubah ukuran grid untuk menampilkan lebih banyak card per baris -->
                        <div class="pos-stock-product">
                            <div class="pos-stock-product-container">
                                <div class="product">
                                    <div class="product-img">
                                        <div class="img" style="background-image: url({{ asset('storage/' . $item->foto) }})"></div>
                                    </div>
                                    <div class="product-info">
                                        <div class="title">{{ $item->nama_produk }}</div>
                                        <div class="desc">{{ $item->deskripsi }}</div>
                                        <div class="product-option">
                                            <div class="option">
                                                <div class="option-label">Stock:</div>
                                                <div class="option-input">
                                                    <form action="{{ route('produk.adjustStock', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="number" name="stok" class="form-control" value="{{ $item->stok }}" required id="stockInput{{ $item->id }}" disabled />
                                                        
                                                        <!-- Tombol Edit -->
                                                        <button type="button" id="editBtn{{ $item->id }}" class="btn btn-primary btn-sm mt-1" onclick="toggleEdit({{ $item->id }})">
                                                            <i class="fa fa-edit fa-fw"></i>
                                                        </button>
                                                        
                                                        <!-- Tombol Update -->
                                                        <button type="submit" class="btn btn-success btn-sm mt-1" id="updateBtn{{ $item->id }}" style="display:none;">
                                                            <i class="fa fa-check fa-fw"></i>
                                                        </button>
                                                        
                                                        <!-- Tombol Cancel -->
                                                        <button type="button" class="btn btn-danger btn-sm mt-1" id="cancelBtn{{ $item->id }}" style="display:none;" onclick="toggleEdit({{ $item->id }})">
                                                            <i class="fa fa-times fa-fw"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
            </div>
        </div>
        <!-- END pos-stock-content -->
    </div>
    <!-- END pos-stock-body -->
</div>
<!-- END pos-stock -->
@endsection
