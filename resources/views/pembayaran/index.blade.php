@extends('layouts.default', [
    'paceTop' => true, 
    'appContentFullHeight' => true, 
    'appContentClass' => 'p-0',
    'appSidebarHide' => true,
    'appHeaderHide' => true
])

@section('content')
<style>
        .nav-item .nav-link .icon-wrapper {
    display: flex;
    flex-direction: column;  
    align-items: center; 
    gap: 4px;   
}

.nav-item .nav-link .icon-wrapper i {
    font-size: 24px;  
}

.nav-item .nav-link .icon-wrapper span {
    font-size: 14px; 
    text-align: center;  
    white-space: nowrap;  
}

</style>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4 py-3">
    <a class="navbar-brand d-flex align-items-center" href="/dashboard" style="font-size: 1.5rem;">
        <img src="/assets/img/pos/logo.svg" width="30" height="30" alt="Pine & Dine" class="me-2">
        Pine & Dine
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarNav">
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
        </ul>
    </div>
</nav>


<div class="container-fluid mt-4">
    <div class="row">
        <!-- Order List Section -->
        <div class="col-lg-9 col-md-8">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                @if ($pembelian->isEmpty())
                    <div class="col-12">
                        <div class="alert alert-info text-center">Tidak ada pembayaran yang tersedia.</div>
                    </div>
                @else
                @foreach ($pembelian as $item)
                @if ($item->status === 'pending')
                <div class="col-6 col-md-4 col-lg-3 mb-3" onclick="getPembelian({{ $item->id }});">
                    <div class="card shadow-sm h-100 mb-4 border-0">
                        <div class="card-header bg-light text-center p-2">
                            <p class="m-0 fw-bold">
                                {{ optional($item->meja)->nomor_meja ? 'Meja: ' . $item->meja->nomor_meja : 'Take Away' }}
                            </p>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-uppercase">{{ $item->pembeli }}</span>
                                <span class="badge bg-{{ $item->status === 'pending' ? 'warning' : 'success' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Nomor Order:</small>
                                <small class="text-dark">{{ $item->no_order }}</small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Status:</small>
                                <small class="text-dark">{{ ucfirst($item->status) }}</small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Tagihan:</small>
                                <small class="text-dark">Rp {{ number_format($item->total_harga, 2, ',', '.') }}</small>
                            </div>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-between p-2 mt-2">
                            <a href="/pembelian/{{ $item->id }}/edit" class="btn btn-info btn-sm flex-grow-1 me-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-sm flex-grow-1 ms-1" onclick="hapusPembelian({{ $item->id }})">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
            
                @endif
            </div>

            <!-- Edit Order Form -->
            <div id="update-form" style="display: none; margin-top: 20px;"> <!-- tambahkan margin atas -->
                <h4>Edit Pembelian</h4>
                <form id="pembelian-update-form" action="{{ route('pembelian.update', 'placeholder-id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="customer-name" class="form-label">Nama Pembeli:</label>
                        <input type="text" id="update-customer-name" name="customer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="total-price" class="form-label">Total Harga:</label>
                        <input type="number" id="update-total-price" name="total_price" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" id="cancel-update-btn" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            
        </div>

        <!-- Cart Section -->
        <div class="col-lg-3 col-md-4">
            <div class="cart border rounded p-4 shadow-lg bg-white" style="padding: 20px;">
                <h4 class="mb-4 text-center text-success">Keranjang Pembelian</h4>
                <div id="cart-items" class="mb-3">
                    <!-- Item keranjang akan ditambahkan di sini -->
                </div>
                <hr>
                <div class="cart-summary mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal:</span>
                        <span id="total-price" class="fw-bold">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Pajak:</span>
                        <span id="tax-price" class="fw-bold">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold border-top pt-2">
                        <span>Total Akhir:</span>
                        <span id="final-price" class="text-success">Rp 0</span>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Nama Pembeli:</label>
                    <p id="customer-name" class="form-control-plaintext text-muted">-</p>
                </div>
                <button id="pay-btn" class="btn btn-success w-100" disabled>Bayar</button>
            </div>
        </div>
        
    </div>
</div>

@include('pembayaran.bayar')

<!-- JavaScript and CSS -->
<script src="{{ asset('assets/js/pembayaran.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/pembelian.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
$('#pay-btn').prop('disabled', true);

$('.card').on('click', function() {
    $('#pay-btn').prop('disabled', false);
});

$('#pay-btn').click(function() {
    $('#paymentModal').modal('show');
    $('#amount-paid').val('');
    $('#change-amount').text('Rp 0');
});

$('#confirm-payment').click(function() {
    $('#paymentModal').modal('hide');
});


});

    $('#pay-btn').click(function() {
        $('#paymentModal').modal('show');
        $('#amount-paid').val('');
        $('#change-amount').text('Rp 0');
    });

    $('#confirm-payment').click(function() {
        $('#paymentModal').modal('hide');
    });

    $(document).on('click', '#edit-btn', function() {
        var pembelianId = $(this).data('id');
        $.get("/pembelian/" + pembelianId, function(data) {
            $('#update-customer-name').val(data.pembeli);
            $('#update-total-price').val(data.total_harga);
            $('#pembelian-update-form').attr('action', "/pembelian/" + pembelianId);
            $('#update-form').show();
        });
    });

    $('#cancel-update-btn').click(function() {
        $('#update-form').hide();
    });

function hapusPembelian(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Pembelian ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/pembelian/' + id,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire(
                        'Terhapus!',
                        'Pembelian berhasil dihapus.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'Terjadi kesalahan, tidak bisa menghapus pembelian.',
                        'error'
                    );
                }
            });
        }
    });
}
function editPembelian(id) {
    $.get("/pembelian/" + id, function(data) {
        $('#update-customer-name').val(data.pembeli);
        $('#update-total-price').val(data.total_harga);
        $('#pembelian-update-form').attr('action', "/pembelian/" + id);
        $('#update-form').show();

        $('#edit-btn').show();
        $('.btn-danger').show();  
    });
}

$('#update-form').on('submit', function(e) {
    e.preventDefault();  
});

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
