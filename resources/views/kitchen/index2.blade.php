@extends('layouts.default', [
    'paceTop' => true, 
    'appContentFullHeight' => true, 
    'appContentClass' => 'p-0',
    'appSidebarHide' => true,
    'appHeaderHide' => true
])

@section('title', 'Kitchen')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
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

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ implode('\n', $errors->all()) }}",
        });
    @endif
</script>
@endpush

@section('content')

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm px-4 py-3">
    <a class="navbar-brand d-flex align-items-center" href="/dashboard" style="font-size: 1.5rem; font-weight: bold;">
        <img src="/assets/img/pos/logo.svg" width="30" height="30" alt="Pine & Dine" class="me-2">
        Pine & Dine
    </a>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a href="/pembelian" class="nav-link fs-5 text-dark">
                    <i class="fa fa-shopping-cart"></i> Order
                </a>
            </li>
            <li class="nav-item">
                <a href="/pembayaran" class="nav-link fs-5 text-dark">
                    <i class="fa fa-cash-register"></i> Checkout
                </a>
            </li>
            <li class="nav-item">
                <a href="/kitchen" class="nav-link fs-5 text-dark">
                    <i class="fa fa-list-check"></i> Kitchen
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="pos pos-stock py-4" id="pos-stock">
    <div class="pos-stock-body">
        <div class="pos-stock-content">
            <div class="pos-stock-content-container">
                <div class="row gx-4 gy-4">
                    @foreach ($produk as $item)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="pos-stock-product">
                                    <div class="pos-stock-product-container">
                                        <div class="product">
                                            <div class="product-img">
                                                <div class="img rounded-top" style="background-image: url({{ asset('storage/' . $item->foto) }}); height: 200px; background-size: cover; background-position: center;"></div>
                                            </div>
                                            <div class="product-info p-3">
                                                <h5 class="product-title">{{ $item->nama_produk }}</h5>
                                                <p class="product-desc small text-muted">{{ $item->deskripsi }}</p>

                                                <div class="product-option mt-3">
                                                    <div class="option">
                                                        <label class="option-label mb-1">Stock:</label>
                                                        <div class="option-input">
                                                            <form action="{{ route('produk.adjustStock', $item->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="text" inputmode="numeric" name="stok" class="form-control mb-2" value="{{ $item->stok }}" required id="stockInput{{ $item->id }}" disabled />

                                                                <button type="button" id="editBtn{{ $item->id }}" class="btn btn-sm btn-outline-primary" onclick="toggleEdit({{ $item->id }})">
                                                                    <i class="fa fa-edit fa-fw"></i> Edit
                                                                </button>

                                                                <button type="submit" class="btn btn-sm btn-outline-success mt-1" id="updateBtn{{ $item->id }}" style="display:none;">
                                                                    <i class="fa fa-check fa-fw"></i> Update
                                                                </button>

                                                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" id="cancelBtn{{ $item->id }}" style="display:none;" onclick="toggleEdit({{ $item->id }})">
                                                                    <i class="fa fa-times fa-fw"></i> Cancel
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
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .navbar-light .navbar-nav .nav-link {
        color: #333;
        font-weight: bold;
    }
    .navbar-light .navbar-nav .nav-link:hover {
        color: #007bff;
    }
    .product-title {
        font-size: 1.25rem;
        font-weight: bold;
    }
    .product-desc {
        font-size: 0.9rem;
    }
</style>
@endsection
