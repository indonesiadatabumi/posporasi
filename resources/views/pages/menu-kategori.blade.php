@extends('layouts.default')

@section('title', 'Kategori')

@push('scripts')
    <!-- Include Bootstrap JS (jika belum di-include) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@section('content')
	<div class="d-flex align-items-center mb-3">
		<div>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
				<li class="breadcrumb-item active">Kategori</li>
			</ol>
			<h1 class="page-header mb-0">Kategori</h1>
		</div>
		<div class="ms-auto">
			<!-- Button untuk membuka modal -->
			<button class="btn btn-success btn-rounded px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
				<i class="fa fa-plus fa-lg me-2 ms-n2 text-success-900"></i> Tambah Kategori
			</button>
		</div>
	</div>
	<div class="card border-0">
		<div class="tab-content p-3">
			<div class="tab-pane fade show active" id="allTab">
				<!-- BEGIN input-group -->			
					<div class="flex-fill position-relative">
					</div>
				</div>
				<!-- END input-group -->
				
				<!-- BEGIN table -->
				<div class="table-responsive">
					<table class="table table-hover text-nowrap">
						<thead>
							<tr>
								<th class="pt-0 pb-2">No</th>
								<th class="pt-0 pb-2">Kode Kategori</th>
								<th class="pt-0 pb-2">Nama Kategori</th>
								<th class="pt-0 pb-2" width="1%">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="align-middle">1</td>
								<td class="align-middle">K00011</td>
								<td class="align-middle">Sushi</td>
								<td class="align-middle">
                                    <button class="btn btn-warning btn-sm">Edit</button>
									<button class="btn btn-danger btn-sm">Hapus</button>
                                </td>
							</tr>
							<tr>
								<td class="align-middle">2</td>
								<td class="align-middle">K00012</td>
								<td class="align-middle">Minuman</td>
								<td class="align-middle">
                                    <button class="btn btn-warning btn-sm">Edit</button>
									<button class="btn btn-danger btn-sm">Hapus</button>
                                </td>
							</tr>
							<tr>
								<td class="align-middle">3</td>
								<td class="align-middle">K00013</td>
								<td class="align-middle">Mie</td>
								<td class="align-middle">
                                    <button class="btn btn-warning btn-sm">Edit</button>
									<button class="btn btn-danger btn-sm">Hapus</button>
                                </td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- END table -->
				
				<div class="d-md-flex align-items-center">
					<div class="me-md-auto text-md-left text-center mb-2 mb-md-0">
						Showing 1 to 10 of 57 entries
					</div>
					<ul class="pagination mb-0 justify-content-center">
						<li class="page-item disabled"><a class="page-link">Previous</a></li>
						<li class="page-item"><a class="page-link" href="#">1</a></li>
						<li class="page-item active"><a class="page-link" href="#">2</a></li>
						<li class="page-item"><a class="page-link" href="#">3</a></li>
						<li class="page-item"><a class="page-link" href="#">4</a></li>
						<li class="page-item"><a class="page-link" href="#">5</a></li>
						<li class="page-item"><a class="page-link" href="#">6</a></li>
						<li class="page-item"><a class="page-link" href="#">Next</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="card-arrow">
			<div class="card-arrow-top-left"></div>
			<div class="card-arrow-top-right"></div>
			<div class="card-arrow-bottom-left"></div>
			<div class="card-arrow-bottom-right"></div>
		</div>
	</div>

	<!-- Modal untuk Tambah Kategori -->
	<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form action="/menu/kategori/tambah" method="POST">
						@csrf
						{{-- <div class="mb-3">
							<label for="kodeKategori" class="form-label">Kode Kategori</label>
							<input type="text" class="form-control" id="kodeKategori" name="kode_kategori" required>
						</div> --}}
						<div class="mb-3">
							<label for="namaKategori" class="form-label">Nama Kategori</label>
							<input type="text" class="form-control" id="namaKategori" name="nama_kategori" required>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
