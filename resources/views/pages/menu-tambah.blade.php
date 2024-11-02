@extends('layouts.default')

@section('title', 'Products')

@push('css')
	<link href="/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
	<link href="/assets/plugins/dropzone/dist/min/dropzone.min.css" rel="stylesheet" />
	<link href="/assets/plugins/tag-it/css/jquery.tagit.css" rel="stylesheet" />
@endpush

@push('scripts')
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="/assets/plugins/dropzone/dist/min/dropzone.min.js"></script>
	<script src="/assets/plugins/jquery-migrate/dist/jquery-migrate.min.js"></script>
	<script src="/assets/plugins/tag-it/js/tag-it.min.js"></script>
	<script src="/assets/js/demo/product-details.demo.js"></script>
@endpush

@section('content')
	<div class="d-flex align-items-center mb-3">
		<div>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="dashboar">Home</a></li>
				<li class="breadcrumb-item"><a href="/extra/products">Manage Menu</a></li>
				<li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i>Tambah Menu</li>
			</ol>
			<h1 class="page-header mb-0">Tambah Menu</h1>
		</div>
	</div>
			<div class="card border-0 mb-4">
				<div class="card-header h6 mb-0 bg-none p-3">
					<i class="fa fa-utensils fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Menu
				</div>
				<div class="card-body">
					<div class="mb-3">
						<label class="form-label">Nama Menu</label>
						<input type="text" class="form-control" name="title" placeholder="Nama menu">
					</div>
					<div class="mb-3">
						<label class="form-label">Deskripsi</label>
						<input type="text" class="form-control" name="title" placeholder="Deskripsi">
					</div>
					<div class="row mb-3 fw-bold text-dark">
						<div class="col-4">Kategori</div>
						<div class="col-4">Harga</div>
						<div class="col-4">Kuantitas</div>
					</div>
					<div class="row mb-3 gx-3">
						<div class="col-4">
							<select class="form-select" name="variant[0][category]">
								<option value="">Pilih kategori</option>
								<option value="meat">Meat</option>
								<option value="burger">Burger</option>
								<option value="pizza">Pizza</option>
								<option value="drinks">Drinks</option>
								<option value="desserts">Desserts</option>
								<option value="snacks">Snacks</option>
							</select>
						</div>
					
						<!-- Input untuk harga -->
						<div class="col-4">
							<input type="text" class="form-control" name="variant[0][price]" placeholder="Price" />
						</div>
					
						<!-- Input untuk kuantitas -->
						<div class="col-4">
							<input type="number" class="form-control" name="variant[0][quantity]" placeholder="Kuantitaas" min="1" />
						</div>
					</div>
					
					<!-- Upload gambar -->
					<div class="row mb-3 gx-3">
						<div class="col-4">
							<input type="file" class="form-control" name="variant[0][image]" accept="image/*" />
						</div>
					</div>
				</div>
			</div>
@endsection
