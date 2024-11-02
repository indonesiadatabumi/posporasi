@extends('layouts.default', [
    'paceTop' => true, 
    'appContentFullHeight' => true, 
    'appContentClass' => 'p-0',
    'appSidebarHide' => true,
    'appHeaderHide' => true
])

@section('title', 'POS - Kitchen Order System')

@push('scripts')
    <script src="/assets/js/demo/pos-kitchen-order.demo.js"></script>
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

    <div class="pos pos-kitchen" id="pos-kitchen">
        <div class="container mt-4">
            <div class="row">
                @if($orders->isEmpty())
                    <div class="col-md-12 mb-4 text-center">
                        <div class="alert alert-info">
                            <h5>Tidak ada pesanan saat ini.</h5>
                        </div>
                    </div>
                @else
                @foreach ($orders as $order)
                @if ($order->completed_count < $order->detail->count())
                    <div class="col-md-12 mb-4">
                        <!-- Card Order -->
                        <div class="card shadow-sm pos-task border-secondary">
                            <!-- Card Header -->
                            <div class="card-header bg-secondary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 custom-title">{{ $order->id_meja ? 'Meja ' . $order->id_meja : 'Take Away' }}</h5>
                                    <span class="badge bg-light text-dark custom-badge">
                                        {{ $order->jenis_pesanan === 'dine-in' ? 'Dine In' : ($order->jenis_pesanan === 'take-away' ? 'Take Away' : $order->jenis_pesanan) }}
                                    </span>
                                </div>
                                <div class="mt-1"><strong>Order No:</strong> {{ $order->no_order }}</div>
                            </div>
                            <!-- End Card Header -->
            
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="pos-task-completed my-2 custom-text">
                                    <strong>Completed:</strong> <b>{{ $order->completed_count }}/{{ $order->detail->count() }}</b>
                                </div>
                                <div class="customer-info my-2">
                                    <div class="custom-text"><strong>Customer:</strong> {{ $order->pembeli ?? 'Unknown' }}</div>
                                    <div class="custom-text"><strong>Order Time:</strong> {{ $order->created_at->format('H:i') }}</div>
                                </div>
            
                                <!-- Product Row -->
                                <div class="pos-task-product-row">
                                    <div class="row">
                                        @foreach ($order->detail ?? [] as $item)
                                            <div class="col-md-4 mb-3">
                                                <!-- Product Card -->
                                                <div class="card border-secondary {{ $item->status === 'complete' ? 'bg-light' : '' }}">
                                                    <div class="card-body d-flex align-items-center justify-content-between">
                                                        <!-- Product Image -->
                                                        <div class="pos-task-product-img me-2">
                                                            <div class="cover" style="background-image: url({{ asset('storage/' . $item->produk->foto) }}); width: 60px; height: 60px; background-size: cover; background-position: center;"></div>
                                                        </div>
                                                        <!-- Product Info -->
                                                        <div class="pos-task-product-info flex-grow-1">
                                                            <div class="info">
                                                                <div class="title fw-bold custom-text {{ $item->status === 'complete' ? 'text-muted' : '' }}">
                                                                    {{ $item->produk->nama_produk ?? 'Unknown' }}
                                                                </div>
                                                                <div class="desc custom-text">
                                                                    Jumlah: x{{ $item->jumlah }}<br/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Complete Button -->
                                                    <div class="text-center mt-3">
                                                        @if ($item->status !== 'complete')
                                                            <a href="#" class="btn btn-success complete-btn custom-button mb-2" data-id="{{ $item->id }}">Complete</a>
                                                        @else
                                                            <button class="btn btn-success custom-button mb-2" disabled>Completed</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- End Product Card -->
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- End Product Row -->
                            </div>
                            <!-- End Card Body -->
                        </div>
                        <!-- End Card Order -->
                    </div>
                @endif
            @endforeach
                        
                    @if ($orders->every(fn($order) => $order->completed_count === $order->detail->count()))
                        <div class="col-md-12 mb-4 text-center">
                            <div class="alert alert-success">
                                <h5>Semua pesanan telah selesai!</h5>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.complete-btn').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const itemId = this.getAttribute('data-id');

                    fetch(`/kitchenorder/update-status/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated',
                                text: 'Item status updated to complete'
                            }).then(() => {
                                location.reload(); 
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update item status'
                        });
                    });
                });
            });

            setInterval(function() {
                location.reload();
            }, 10000);
        });
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <style>
        body {
            padding-top: 20px;
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
@endsection
