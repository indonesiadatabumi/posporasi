@extends('layouts.default')

@section('title', 'Pengaturan Printer')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const koneksiSelect = document.querySelector('select[name="koneksi"]');
            const ipInput = document.querySelector('input[name="ip_printer"]');
            const portInput = document.querySelector('input[name="port_printer"]');
            
            function toggleNetworkInputs() {
                if (koneksiSelect.value === 'network') {
                    ipInput.closest('.col-6').style.display = 'block';  
                    portInput.closest('.col-6').style.display = 'block';  
                } else {
                    ipInput.closest('.col-6').style.display = 'none'; 
                    portInput.closest('.col-6').style.display = 'none';  
                }
            }

            koneksiSelect.addEventListener('change', toggleNetworkInputs);
            
            toggleNetworkInputs();
        });
    </script>
@endpush

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="/printer">Printer</a></li>
        </ol>
        <h1 class="page-header mb-0">Pengaturan Printer</h1>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card border-0 mb-4">
    <div class="card-header h6 mb-0 bg-none p-3">
        <i class="fa fa-print fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Pengaturan Printer
    </div>
    <div class="card-body">
        <form action="{{ route('printer.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label">Nama Printer</label>
                    <input type="text" class="form-control" name="nama_printer" placeholder="Masukkan nama printer" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Device</label>
                    <input type="text" class="form-control" name="device" placeholder="Contoh: Printer T1">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label">Tipe Koneksi</label>
                    <select class="form-select" name="koneksi" required>
                        <option value="" disabled selected>Pilih Tipe Koneksi</option> <!-- Default option -->
                        <option value="network">Network</option>
                        <option value="usb">USB</option>
                        <option value="smb">SMB</option>
                    </select>
                </div>
                <div class="col-6" style="display:none;">
                    <label class="form-label">IP Printer</label>
                    <input type="text" class="form-control" name="ip_printer" placeholder="Masukkan IP printer (jika koneksi network)">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label">Nama Share Printer</label>
                    <input type="text" class="form-control" name="share_name" placeholder="Contoh: PRINTER-SHARED">
                </div>
                <div class="col-6" style="display:none;">
                    <label class="form-label">Port</label>
                    <input type="number" class="form-control" name="port_printer" placeholder="9100 (default)">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label">Lokasi Printer</label>
                    <input type="text" class="form-control" name="lokasi_printer" placeholder="Contoh: Kasir Utama">
                </div>
            </div>

            <input type="hidden" name="id_resto" value="{{ auth()->user()->restoran->id }}">

            <div class="row">
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>

        <h3 class="mt-5">Daftar Printer yang Terdaftar</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Printer</th>
                    <th>Tipe Koneksi</th>
                    <th>IP Printer</th>
                    <th>Share Printer</th>
                    <th>Lokasi Printer</th>
                    <th>Device</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($printer as $printer)
                    <tr>
                        <td>{{ $printer->nama_printer }}</td>
                        <td>{{ $printer->koneksi }}</td>
                        <td>{{ $printer->ip_printer }}</td>
                        <td>{{ $printer->share_name ?? '-' }}</td>
                        <td>{{ $printer->lokasi_printer }}</td>
                        <td>{{ $printer->device ?? '-' }}</td>
                        <td>
                            @if(!$printer->is_default)
                            <form action="{{ route('printer.setDefault', $printer->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" id="setDefaultButton-{{ $printer->id }}">
                                    Set Default
                                </button>
                            </form>
                            @else
                            <button class="btn btn-secondary btn-sm" disabled>Default</button>
                            @endif
                            <form action="{{ route('printer.destroy', $printer->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
