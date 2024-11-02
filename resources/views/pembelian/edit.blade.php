@extends('layouts.default', [
    'paceTop' => true,
    'appContentFullHeight' => true,
    'appContentClass' => 'p-0',
    'appSidebarHide' => true,
    'appHeaderHide' => true,
])

@section('title', 'Pembelian')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/pembelian.css') }}">
    <style>

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
    <!-- Navbar -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 py-3">
        <a class="navbar-brand d-flex align-items-center" href="/dashboard" style="font-size: 1.5rem;">
            <img src="/assets/img/pos/logo.svg" width="30" height="30" alt="Pine & Dine" class="me-2">
            Pine & Dine
        </a>
        <div class="navbar-collapse collapse">
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

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Kategori Menu -->
            <div class="col-md-1">
                <div class="col-md-1">
                    <div class="sticky-navbar">
                        <ul class="nav flex-column nav-pills">
                            <li class="nav-item">
                                <button class="nav-link active" data-filter="all">Semua Menu</button>
                            </li>
                            @foreach ($kategori as $item)
                                <li class="nav-item">
                                    <button class="nav-link" data-filter="{{ $item->id }}">
                                        {{ $item->nama_kategori }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Produk dan Keranjang -->
            <div class="col-md-8">
                <div class="row">
                    @foreach ($produk as $item)
                        <div class="col-md-4 mb-4 product" data-kategori="{{ $item->id_kategori }}">
                            <div class="card shadow-sm">
                                <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top"
                                    alt="{{ $item->nama_produk }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->nama_produk }}</h5>
                                    <p class="card-description text-muted"><em>{{ $item->deskripsi }}</em></p>
                                    <p class="card-text fw-bold">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</p>
                                    <button class="btn btn-primary add-to-cart" data-produk-id="{{ $item->id }}"
                                        data-produk-name="{{ $item->nama_produk }}"
                                        data-produk-description="{{ $item->deskripsi }}"
                                        data-produk-price="{{ $item->harga_jual }}"
                                        data-produk-stock="{{ $item->stok }}"
                                        @if ($item->stok < 1) disabled style="background-color: #d9534f; border-color: #d9534f;" @endif>
                                        @if ($item->stok < 1)
                                            Stok Habis
                                        @else
                                            Tambah ke Keranjang
                                        @endif
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
                    <div id="cart-items" class="mb-3"></div>
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
                            <b><span>Total Akhir:</span></b>
                            <b><span id="final-price">Rp 0</span></b>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="customer-name" class="form-label">Nama Pembeli:</label>
                        <input type="text" class="form-control" id="customer-name" placeholder="Masukkan nama pembeli"
                            required>
                    </div>

                    @if ($pembelian->id_meja)
                        <div class="mb-3" id="meja-container">
                            <label for="meja" class="form-label">Pilih Meja:</label>
                            <select class="form-control" id="meja-select" required>
                                <option value="">Pilih Meja</option>
                                @foreach ($meja as $item)
                                    @if ($item->status == 'tersedia')
                                        <option value="{{ $item->id }}">
                                            Meja {{ $item->nomor_meja }} ({{ $item->kapasitas }})
                                        </option>
                                    @endif
                                    @if ($item->id == $pembelian->id_meja)
                                        <option value="{{ $item->id }}" selected>
                                            Meja {{ $item->nomor_meja }} ({{ $item->kapasitas }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="mb-3">
                            <label for="order-type" class="form-label">Pilih Tipe Pesanan:</label>
                            <select class="form-control" id="order-type" required>
                                <option value="">Pilih Tipe Pesanan</option>
                                <option value="dine-in">Dine In</option>
                                <option value="take-away">Take Away</option>
                            </select>
                        </div>
                    @endif

                    <button id="checkout-btn" class="btn btn-success w-100">Checkout</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cartItemsContainer = document.getElementById('cart-items');
                const totalPriceElement = document.getElementById('total-price');
                const taxPriceElement = document.getElementById('tax-price');
                const finalPriceElement = document.getElementById('final-price');

                let totalPrice = 0;
                let taxPrice = 0;
                let finalPrice = 0;
                let encodedData = "{{ $pembelian }}";
                let jsonString = encodedData.replace(/&quot;/g, '"');
                let decodedData = JSON.parse(jsonString);
                let purchases = decodedData;
                let cartItems = [];
                taxPrice = purchases.pajak;
                const pembelianID = purchases.id
                let jenis_pesanan = purchases.jenis_pesanan
                let selectedMeja = purchases.id_meja;

                purchases.detail.forEach(detail => {
                    const existingItem = cartItems.find(item => item.id === detail.produk.id);
                    if (existingItem) {
                        existingItem.quantity += detail.jumlah;
                    } else {
                        cartItems.push({
                            id: detail.produk.id,
                            name: detail.produk.nama_produk,
                            price: detail.harga_satuan,
                            description: detail.produk.deskripsi ||
                                `Description for Product ${detail.produk.id}`,
                            quantity: detail.jumlah
                        });
                    }
                });

                const mejaContainer = document.getElementById('meja-container');
                const orderType = document.getElementById('order-type');

                if (orderType) {
                    var options = orderType.options;
                    for (var i = 0; i < options.length; i++) {
                        if (options[i].value == jenis_pesanan) {
                            options[i].selected = true;
                            break;
                        }
                    }
                }
                document.getElementById('customer-name').value = purchases.pembeli;

                updateCartDisplay();

                function addToCart(productId, productName, productPrice, productDescription, stock) {
                    const existingItem = cartItems.find(item => item.id == productId);
                    if (existingItem) {
                        if (existingItem.quantity < stock) {
                            existingItem.quantity += 1;
                        } else {
                            alert('Stok tidak cukup untuk menambah produk ini.');
                        }
                    } else {
                        if (stock > 0) {
                            cartItems.push({
                                id: productId,
                                name: productName,
                                price: productPrice,
                                description: productDescription,
                                quantity: 1
                            });
                        } else {
                            alert('Stok tidak tersedia untuk produk ini.');
                        }
                    }
                    updateAddToCartButton(productId, stock);
                    updateCartDisplay();
                }

                function updateAddToCartButton(productId, stock) {
                    const button = document.querySelector(`.add-to-cart[data-produk-id="${productId}"]`);
                    const item = cartItems.find(item => item.id === productId);

                    if (item) {
                        button.textContent = 'Sudah ada di keranjang (' + item.quantity + ')';
                        button.disabled = false;
                    } else {
                        if (stock > 0) {
                            button.textContent = 'Tambah ke Keranjang';
                            button.disabled = false;
                        } else {
                            button.textContent = 'Stok Habis';
                            button.disabled = true;
                        }
                    }
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

                        // Memperbarui tombol tambah ke keranjang setiap item di-update
                        updateAddToCartButton(item.id, item.stock ||
                            0); // Tambahkan stock jika datanya tersedia
                    });

                    taxPrice = totalPrice * 0.1; // Misalkan pajak adalah 10%
                    finalPrice = totalPrice + taxPrice;

                    totalPriceElement.innerText = `Rp ${numberWithCommas(totalPrice)}`;
                    taxPriceElement.innerText = `Rp ${numberWithCommas(taxPrice)}`;
                    finalPriceElement.innerText = `Rp ${numberWithCommas(finalPrice)}`;
                }


                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                document.addEventListener('click', function(event) {
                    if (event.target.matches('.adjust-quantity')) {
                        const productId = event.target.getAttribute('data-id');
                        const action = event.target.getAttribute('data-action');
                        const item = cartItems.find(item => item.id == productId);
                        const productStock = parseInt(document.querySelector(
                            `.add-to-cart[data-produk-id="${productId}"]`).getAttribute(
                            'data-produk-stock'));
                        console.log(cartItems);
                        if (action === 'increase') {
                            if (item.quantity < productStock) {
                                item.quantity += 1;
                            } else {
                                alert('Stok tidak cukup untuk menambah produk ini.');
                            }
                        } else if (action === 'decrease') {
                            if (item.quantity > 1) {
                                item.quantity -= 1;
                            } else {
                                cartItems = cartItems.filter(item => item.id != productId);
                            }
                        }

                        updateCartDisplay();
                        updateAddToCartButton(productId, productStock);
                    }
                });

                document.querySelectorAll('.add-to-cart').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.getAttribute('data-produk-id');
                        const productName = this.getAttribute('data-produk-name');
                        const productPrice = parseFloat(this.getAttribute('data-produk-price'));
                        const productDescription = this.getAttribute('data-produk-description');
                        const stock = parseInt(this.getAttribute('data-produk-stock'));

                        addToCart(productId, productName, productPrice, productDescription, stock);
                    });
                });

                document.getElementById('checkout-btn').addEventListener('click', function() {
                    const customerName = document.getElementById('customer-name').value;

                    if (mejaContainer) {
                        selectedMeja = document.getElementById('meja-select').value;
                    } else {
                        jenis_pesanan = orderType.value;
                    }

                    if (customerName === '') {
                        alert('Silakan masukkan nama pembeli.');
                        return;
                    }
                    if (selectedMeja === '' && mejaContainer) {
                        alert('Silakan pilih meja.');
                        return;
                    }
                    if (cartItems.length === 0) {
                        alert('Keranjang pembelian kosong.');
                        return;
                    }

                    const checkoutButton = this;
                    checkoutButton.disabled = true;

                    const cartData = {
                        customer_name: customerName,
                        meja_id: selectedMeja,
                        jenis_pesanan: jenis_pesanan,
                        items: cartItems.map(item => ({
                            id: item.id,
                            quantity: item.quantity,
                            price: item.price
                        })),
                        total_price: finalPrice,
                        status: 'pending'
                    };

                    fetch('/pembelian/' + purchases.id, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(cartData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            checkoutButton.disabled = false;

                            if (data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Checkout Berhasil',
                                    footer: '<a href="/pembayaran">Lanjut ke pembayaran?</a>'
                                }).then(() => {
                                    window.location.href = '/pembelian';
                                });

                                cartItems = [];
                                updateCartDisplay();
                                document.getElementById('customer-name').value = '';
                                if (mejaContainer) {
                                    document.getElementById('meja-select').value = '';
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            checkoutButton.disabled = false;
                        });
                });

                document.querySelectorAll('.nav-link[data-filter]').forEach(button => {
                    button.addEventListener('click', function() {
                        const filter = this.getAttribute('data-filter');
                        document.querySelectorAll('.product').forEach(product => {
                            const kategoriId = product.getAttribute('data-kategori');
                            if (filter === 'all' || filter === kategoriId) {
                                product.style.display = 'block';
                            } else {
                                product.style.display = 'none';
                            }
                        });
                        document.querySelectorAll('.nav-link').forEach(btn => btn.classList.remove(
                            'active'));
                        this.classList.add('active');
                    });
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush



@endsection
