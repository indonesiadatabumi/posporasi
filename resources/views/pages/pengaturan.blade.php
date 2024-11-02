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
				<li class="breadcrumb-item"><a href="/extra/products">Pengaturan</a></li>
			</ol>
			<h1 class="page-header mb-0">Pengaturan</h1>
		</div>
	</div>
    <div class="card border-0 mb-4">
        <div class="card-header h6 mb-0 bg-none p-3">
            <i class="fa fa-print fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Pengaturan Printer & Kasir
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label">Tipe OS</label>
                    <select class="form-select" name="os_type">
                        <option value="">Pilih OS</option>
                        <option value="windows">Windows</option>
                        <option value="mac">MAC</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label">Ukuran</label>
                    <select class="form-select" name="discount">
                        <option value="10%" selected>Default</option>
                        <option value="20%">56</option>
                        <option value="20%">70</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label">Model</label>
                    <select class="form-select" name="discount">
                        <option value="10%" selected>Default</option>
                        <option value="20%">56</option>
                        <option value="20%">70</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label">Driver</label>
                    <select class="form-select" name="discount">
                        <option value="10%" selected>Default</option>
                        <option value="20%">56</option>
                        <option value="20%">70</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label">Footer Struk</label>
                    <textarea class="form-control" name="footer_receipt" rows="3" placeholder="Isi footer struk"></textarea>
                </div>
                <div class="col-6">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Pajak (%)</label>
                            <select class="form-select" name="discount">
                                <option value="10%" selected>Disable</option>
                                <option value="20%">10%</option>
                                <option value="20%">20%</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pajak (%)</label>
                            <select class="form-select" name="tax">
                                <option value="6%" selected>Disable</option>
                                <option value="10%">6%</option>
                                <option value="10%">10%</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
				</div>
			</div>
@endsection
