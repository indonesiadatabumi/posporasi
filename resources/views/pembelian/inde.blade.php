@extends('layouts.default', [
    'paceTop' => true, 
    'appContentFullHeight' => true, 
    'appContentClass' => 'p-0',
    'appSidebarHide' => true,
    'appHeaderHide' => true
])

@section('title', 'Pembelian')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/pembelian.css') }}">
    
    <style>
        .product .card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product .card-img-top {
            object-fit: cover;
            height: 200px;
            width: 100%;
        }

        .product .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product .card-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .product .card-text {
            font-size: 0.9rem;
            flex-grow: 1;
            margin-bottom: 15px;
        }

        .add-to-cart {
            margin-top: 10px;
        }

        .cart-item {
    display: flex;
    flex-direction: column;
}

    </style>

@push('scripts')
    <script src="{{ asset('assets/js/pembelian.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartItemsContainer = document.getElementById('cart-items');
            const totalPriceElement = document.getElementById('total-price');
            const taxPriceElement = document.getElementById('tax-price');
            const finalPriceElement = document.getElementById('final-price');

            let totalPrice = 0;
            let taxPrice = 0;
            let finalPrice = 0;
            let cartItems = []; 

            function addToCart(productId, productName, productPrice, productDescription) {
                const existingItem = cartItems.find(item => item.id === productId);
                if (existingItem) {
                    existingItem.quantity += 1; 
                } else {
                    cartItems.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        description: productDescription,
                        quantity: 1
                    });
                }
                updateCartDisplay();
            }

            function updateCartDisplay() {
    cartItemsContainer.innerHTML = '';
    totalPrice = 0; 

    cartItems.forEach((item) => {
        const itemTotalPrice = item.price * item.quantity; 
        totalPrice += itemTotalPrice; 

        const itemElement = document.createElement('div');
        itemElement.className = 'cart-item mb-2';

        itemElement.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <span>${item.name}</span>
                <span class="item-price">Rp ${numberWithCommas(itemTotalPrice)}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <span class="item-price">Rp ${numberWithCommas(item.price)}</span>
            </div>
            <div class="quantity-controls mt-1">
                <button class="btn btn-sm adjust-quantity" data-id="${item.id}" data-action="decrease">-</button>
                <span class="item-quantity mx-2">${item.quantity}</span>
                <button class="btn btn-sm adjust-quantity" data-id="${item.id}" data-action="increase">+</button>
            </div>
        `;
        cartItemsContainer.appendChild(itemElement);
    });

    taxPrice = Math.max(totalPrice * 0.1, 0); 
    finalPrice = totalPrice + taxPrice;

    totalPriceElement.textContent = numberWithCommas(totalPrice);
    taxPriceElement.textContent = numberWithCommas(taxPrice);
    finalPriceElement.textContent = numberWithCommas(finalPrice);

    cartItems = cartItems.filter(item => item.quantity > 0);
}

document.getElementById('checkout-btn').addEventListener('click', function () {
    const customerName = document.getElementById('customer-name').value;
    const products = cartItems.map(item => ({
        id: item.id,
        quantity: item.quantity,
    }));

    if (customerName === '') {
        alert('Nama pembeli harus diisi.');
        return;
    }

    // Mengirim data ke server
    fetch('/pembelian/checkout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Token CSRF untuk Laravel
        },
        body: JSON.stringify({
            pembeli: customerName,
            produk: products,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Pembelian berhasil.');
            // Kosongkan keranjang dan tampilkan pembelian baru
            cartItems = [];
            updateCartDisplay();
            document.getElementById('customer-name').value = '';
        } else {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    });
});
 


            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.dataset.produkId;
                    const productName = this.dataset.produkName;
                    const productPrice = parseFloat(this.dataset.produkPrice);
                    const productDescription = this.dataset.produkDescription;

                    addToCart(productId, productName, productPrice, productDescription);
                });
            });

            cartItemsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('adjust-quantity')) {
                    const action = event.target.dataset.action;
                    const productId = event.target.dataset.id;
                    const item = cartItems.find(item => item.id === productId);

                    if (action === 'increase') {
                        item.quantity += 1; 
                    } else if (action === 'decrease') {
                        if (item.quantity > 1) {
                            item.quantity -= 1; 
                        } else {
                            cartItems = cartItems.filter(cartItem => cartItem.id !== productId);
                        }
                    }

                    updateCartDisplay(); 
                }
            });

            document.querySelectorAll('.nav-link[data-filter]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const filterValue = this.getAttribute('data-filter');
                    const products = document.querySelectorAll('.product');

                    products.forEach(product => {
                        const productCategory = product.getAttribute('data-kategori');
                        product.style.display = (filterValue === 'all' || productCategory == filterValue) ? 'block' : 'none';
                    });
                });
            });
        });
    </script>
@endpush

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/pembelian.css') }}">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/dashboard">
            <img src="/assets/img/pos/logo.svg" width="30" height="30" alt="Pine & Dine">
            Pine & Dine
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="/pos/customer-order" class="nav-link">
                        <i class="fa fa-shopping-cart"></i> Order
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/pembelian/detail" class="nav-link">
                        <i class="fa fa-cash-register"></i> Checkout
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/pos/kitchen-order" class="nav-link">
                        <i class="fa fa-list-check"></i> Kitchen
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Kategori Menu -->
            <div class="col-md-1">
                <div class="sticky-navbar">
                    <ul class="nav flex-column nav-pills">
                        <li class="nav-item">
                            <button class="nav-link active" data-filter="all">Semua Menu</button>
                        </li>
                        @foreach($kategori as $item)
                        <li class="nav-item">
                            <button class="nav-link" data-filter="{{ $item->id }}">
                                {{ $item->nama_kategori }}
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- Produk dan Keranjang -->
            <div class="col-md-8">
                <div class="row">
                    @foreach ($produks as $produk)
                        <div class="col-6 col-md-4 col-lg-3 mb-4 product" data-kategori="{{ $produk->id_kategori }}">
                            <div class="card custom-card">
                                <img src="{{ asset('storage/' . $produk->foto) }}" class="card-img-top" alt="Produk">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                                    <p class="card-text">{{ $produk->deskripsi }}</p>
                                    <p class="card-text">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                                    <button class="btn btn-primary add-to-cart" 
                                            data-produk-id="{{ $produk->id }}" 
                                            data-produk-name="{{ $produk->nama_produk }}" 
                                            data-produk-price="{{ $produk->harga_jual }}" 
                                            data-produk-description="{{ $produk->deskripsi }}">
                                        Tambah ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-3">
                <div class="cart border rounded p-3">
                    <h4 class="mb-3">Keranjang Pembelian</h4>
                    
                    <!-- Tempat menampilkan item keranjang -->
                    <div id="cart-items" class="mb-3"></div>

                    <!-- Ringkasan keranjang -->
                    <div class="cart-summary mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Total:</span>
                            <span id="total-price">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Pajak:</span>
                            <span id="tax-price">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between font-weight-bold">
                            <span>Total Akhir:</span>
                            <span id="final-price">Rp 0</span>
                        </div>
                    </div>
                    <!-- Input nama pembeli -->
                    <div class="mb-3">
                        <label for="customer-name" class="form-label">Nama Pembeli:</label>
                        <input type="text" class="form-control" id="customer-name" placeholder="Masukkan nama pembeli">
                    </div>
                    <button id="checkout-btn" class="btn btn-success w-100">Tambah</button>
                </div>
            </div>
            
            
        </div>
    </div>
@endsection
