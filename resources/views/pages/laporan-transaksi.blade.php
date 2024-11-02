@extends('layouts.default')

@section('title', 'Tabel Pemasukan')

@push('css')
	<link href="/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-autofill-bs5/css/autoFill.bootstrap5.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-colreorder-bs5/css/colReorder.bootstrap5.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-rowreorder-bs5/css/rowReorder.bootstrap5.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" />
@endpush

@push('scripts')
	<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
	<script src="/assets/plugins/datatables.net-autofill/js/dataTables.autoFill.min.js"></script>
	<script src="/assets/plugins/datatables.net-autofill-bs5/js/autoFill.bootstrap5.min.js"></script>
	<script src="/assets/plugins/datatables.net-colreorder/js/dataTables.colReorder.min.js"></script>
	<script src="/assets/plugins/datatables.net-colreorder-bs5/js/colReorder.bootstrap5.min.js"></script>
	<script src="/assets/plugins/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
	<script src="/assets/plugins/datatables.net-keytable-bs5/js/keyTable.bootstrap5.min.js"></script>
	<script src="/assets/plugins/datatables.net-rowreorder/js/dataTables.rowReorder.min.js"></script>
	<script src="/assets/plugins/datatables.net-rowreorder-bs5/js/rowReorder.bootstrap5.min.js"></script>
	<script src="/assets/plugins/datatables.net-select/js/dataTables.select.min.js"></script>
	<script src="/assets/plugins/datatables.net-select-bs5/js/select.bootstrap5.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="/assets/plugins/pdfmake/build/pdfmake.min.js"></script>
	<script src="/assets/plugins/pdfmake/build/vfs_fonts.js"></script>
	<script src="/assets/plugins/jszip/dist/jszip.min.js"></script>
	<script src="/assets/js/demo/table-manage-combine.demo.js"></script>
	<script src="/assets/plugins/@highlightjs/cdn-assets/highlight.min.js"></script>
	<script src="/assets/js/demo/render.highlight.js"></script>
@endpush

@section('content')
	<!-- BEGIN breadcrumb -->
	<div>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
			<li class="breadcrumb-item active">Transaksi</li>
		</ol>
		<h1 class="page-header mb-0">Transaksi</h1>
	</div>
	<!-- END breadcrumb -->
	<!-- BEGIN row -->
	<div class="row">
		<!-- BEGIN col-10 -->
		<div class="col-xl-100%">
			<div class="panel panel-inverse">
				<!-- BEGIN panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Tabel Transaksi</h4>
				</div>
				<!-- END panel-heading -->
				<!-- BEGIN panel-body -->	
				<div class="panel-body">
					<table id="data-table-combine" class="table table-striped table-bordered align-middle">
						<thead>
							<tr>
								<th class="text-nowrap" width="1%">No.</th>
								<th class="text-nowrap" width="1%">Nomor Faktur</th>
								<th class="text-nowrap" width="5%">Tanggal</th>
								<th class="text-nowrap" width="15%">Detail</th>
								<th class="text-nowrap" width="5%">Total</th>
								<th class="text-nowrap" width="1%">Nomor Meja</th>
								<th class="text-nowrap" width="7%">Aksi</th>
							</tr>
						</thead>
						<tbody>
                            <tr>
                                <td>1</td>
                                <td>1200453090012401</td>
                                <td>07-10-2024</td>
                                <td>
                                    <!-- Nested table for Detail -->
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Menu</th>
                                            <th>Harga Jual</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Ayam Goreng</td>
                                            <td>Rp 25,000</td>
                                            <td>2</td>
                                            <td>Rp 50,000</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Es Teh Manis</td>
                                            <td>Rp 5,000</td>
                                            <td>3</td>
                                            <td>Rp 15,000</td>
                                        </tr>
                                    </table>
                                </td>
                                <td>Rp 65,000</td>
                                <td>5</td>
                                <td>
                                    <button class="btn btn-sm btn-primary">Edit</button>
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>12004530900124002</td>
                                <td>07-10-2024</td>
                                <td>
                                    <!-- Nested table for Detail -->
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Menu</th>
                                            <th>Harga Jual</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Cumi Bakar</td>
                                            <td>Rp 30,000</td>
                                            <td>2</td>
                                            <td>Rp 60,000</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Es Teh Manis</td>
                                            <td>Rp 5,000</td>
                                            <td>3</td>
                                            <td>Rp 15,000</td>
                                        </tr>
                                    </table>
                                </td>
                                <td>Rp 75,000</td>
                                <td>4</td>
                                <td>
                                    <button class="btn btn-sm btn-primary">Edit</button>
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
						</tbody>
					</table>
				</div>
				<!-- END panel-body -->
				<!-- BEGIN hljs-wrapper -->
					<!-- END hljs-wrapper -->
			</div>
			<!-- END panel -->
		</div>
		<!-- END col-10 -->
	</div>
	<!-- END row -->
@endsection