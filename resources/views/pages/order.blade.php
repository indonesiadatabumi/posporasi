@extends('layouts.default', [
	'paceTop' => true, 
	'appContentFullHeight' => true, 
	'appContentClass' => 'p-0',
	'appSidebarHide' => true,
	'appHeaderHide' => true
])

@section('title', 'POS - Customer Order System')

@push('scripts')
	<script src="/assets/js/demo/pos-customer-order.demo.js"></script>
@endpush

@section('content')
	<!-- BEGIN pos -->
	<div class="pos pos-counter" id="pos-counter">
		<!-- BEGIN pos-counter-header -->
		<div class="pos-counter-header">
			<div class="logo">
				<a href="/pos/customer-order">
					<div class="logo-img"><img src="/assets/img/pos/logo.svg" /></div>
					<div class="logo-text">Pine & Dine</div>
				</a>
			</div>
			<div class="time" id="time">00:00</div>
			<div class="nav">
				<div class="nav-item">
					<a href="/pos/customer-order" class="nav-link">
						<i class="fa fa-shopping-cart nav-icon" aria-hidden="true"></i>
					</a>
				</div>
				<div class="nav-item">
					<a href="/pos/counter-checkout" class="nav-link">
						<i class="fa fa-cash-register nav-icon" aria-hidden="true"></i>
					</a>
				</div>
				<div class="nav-item">
					<a href="/pos/kitchen-order" class="nav-link">
						<i class="fa fa-list-check nav-icon" aria-hidden="true"></i>
					</a>
				</div>
				<div class="nav-item">
					<a href="/pos/menu-stock" class="nav-link">
						<i class="fas fa-warehouse nav-icon" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
		<!-- END pos-counter-header -->
	<div class="pos pos-customer" id="pos-customer">
		<!-- BEGIN pos-menu -->
		<div class="pos-menu">
			<div class="nav-container d-flex flex-column h-100">
				<div data-scrollbar="true" data-height="100%" data-skip-mobile="true" class="flex-grow-1">
					<ul class="nav nav-tabs nav-justified" style="margin-bottom: 20px;">
						<li class="nav-item">
							<a class="nav-link active" href="#" data-filter="all">Semua Menu</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="#" data-filter="meat">Makanan berat</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="#" data-filter="burger">Mie</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="#" data-filter="kopi">Kopi</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="#" data-filter="nonkopi">Non-Kopi</a>
						</li>
	
						<li class="nav-item">
							<a class="nav-link" href="#" data-filter="snack">Snack</a>
						</li>
					</ul>
				</div>
		
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('dashboard-v1') }}">
							<i class="fa fa-fw fa-home me-1 ms-n2"></i> Home
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- END pos-menu -->
		
		<!-- BEGIN pos-content -->
		<div class="pos-content">
			<div class="pos-content-container" data-scrollbar="true" data-height="100%" data-skip-mobile="true">
				<div class="product-row">
					<div class="product-container" data-type="meat">
						<a href="#" class="product" data-bs-toggle="modal" data-bs-target="#modalPosItem">
							<div class="img" style="background-image: url(/assets/img/pos/product-1.jpg)"></div>
							<div class="text">
								<div class="title">Grill Chicken Chop&reg;</div>
								<div class="desc">chicken, egg, mushroom, salad</div>
								<div class="price">$10.99</div>
							</div>
						</a>
					</div>
					<div class="product-container" data-type="meat">
						<a href="#" class="product" data-bs-toggle="modal" data-bs-target="#modalPosItem">
							<div class="img" style="background-image: url(/assets/img/pos/product-3.jpg)"></div>
							<div class="text">
								<div class="title">Capellini Tomato Sauce&reg;</div>
								<div class="desc">spaghetti, tomato, mushroom </div>
								<div class="price">$11.99</div>
							</div>
						</a>
					</div>
					<div class="product-container" data-type="pizza">
						<div class="product not-available">
							<div class="img" style="background-image: url(/assets/img/pos/product-5.jpg)"></div>
							<div class="text">
								<div class="title">Hawaiian Pizza&reg;</div>
								<div class="desc">pizza, crab meat, pineapple </div>
								<div class="price">$20.99</div>
							</div>
							<div class="not-available-text">
								<div>Not Available</div>
							</div>
						</div>
					</div>
					<div class="product-container" data-type="desserts">
						<a href="#" class="product" data-bs-toggle="modal" data-bs-target="#modalPosItem">
							<div class="img" style="background-image: url(/assets/img/pos/product-14.jpg)"></div>
							<div class="text">
								<div class="title">Macarons</div>
								<div class="desc">Almond flour, egg whites, heavy cream, food coloring, powdered sugar</div>
								<div class="price">$4.99</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<!-- END pos-content -->
		
		<!-- BEGIN pos-sidebar -->
		<div class="pos-sidebar" id="pos-sidebar">
			<div class="pos-sidebar-header">
				<div class="back-btn">
					<button type="button" data-dismiss-class="pos-mobile-sidebar-toggled" data-target="#pos-customer" class="btn">
						<svg viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
						</svg>
					</button>
				</div>
				<div class="icon"><img src="/assets/img/pos/icon-table.svg" /></div>
				<div class="title">Table 01</div>
				<div class="order">Order: <b>#0056</b></div>
			</div>
			<div class="pos-sidebar-body tab-content" data-scrollbar="true" data-height="100%">
				<div class="tab-pane fade h-100 show active" id="newOrderTab">
					<div class="pos-table">
						<div class="row pos-table-row">
							<div class="col-9">
								<div class="pos-product-thumb">
									<div class="img" style="background-image: url(/assets/img/pos/product-2.jpg)"></div>
									<div class="info">
										<div class="title">Grill Pork Chop</div>
										<div class="single-price">$12.99</div>
										<div class="desc">- size: large</div>
										<div class="input-group qty">
											<div class="input-group-append">
												<a href="#" class="btn btn-default"><i class="fa fa-minus"></i></a>
											</div>
											<input type="text" class="form-control" value="01" />
											<div class="input-group-prepend">
												<a href="#" class="btn btn-default"><i class="fa fa-plus"></i></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-3 total-price">$12.99</div>
						</div>
						<div class="row pos-table-row">
							<div class="col-9">
								<div class="pos-product-thumb">
									<div class="img" style="background-image: url(/assets/img/pos/product-8.jpg)"></div>
									<div class="info">
										<div class="title">Orange Juice</div>
										<div class="single-price">$5.00</div>
										<div class="desc">
											- size: large<br />
											- less ice
										</div>
										<div class="input-group qty">
											<div class="input-group-append">
												<a href="#" class="btn btn-default"><i class="fa fa-minus"></i></a>
											</div>
											<input type="text" class="form-control" value="02" />
											<div class="input-group-prepend">
												<a href="#" class="btn btn-default"><i class="fa fa-plus"></i></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-3 total-price">$10.00</div>
							<div class="pos-remove-confirmation">
								<svg width="2em" height="2em" viewBox="0 0 16 16" class="me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
									<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
								</svg>
								Remove this item? 
								<a href="#" class="btn btn-white ms-auto me-2">No</a>
								<a href="#" class="btn btn-danger">Yes</a>
							</div>
						</div>	
						<div class="row pos-table-row">
							<div class="col-9">
								<div class="pos-product-thumb">
									<div class="img" style="background-image: url(/assets/img/pos/product-10.jpg)"></div>
									<div class="info">
										<div class="title">Mushroom Soup</div>
										<div class="single-price">$3.99</div>
										<div class="desc">
											- size: large<br />
											- more cheese
										</div>
										<div class="input-group qty">
											<div class="input-group-append">
												<a href="#" class="btn btn-default"><i class="fa fa-minus"></i></a>
											</div>
											<input type="text" class="form-control" value="01" />
											<div class="input-group-prepend">
												<a href="#" class="btn btn-default"><i class="fa fa-plus"></i></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-3 total-price">$3.99</div>
						</div>
					</div>
				</div>
			</div>
			<div class="pos-sidebar-footer">
				<div class="subtotal">
					<div class="text">Subtotal</div>
					<div class="price">$30.98</div>
				</div>
				<div class="taxes">
					<div class="text">Taxes (6%)</div>
					<div class="price">$2.12</div>
				</div>
				<div class="total">
					<div class="text">Total</div>
					<div class="price">$33.10</div>
				</div>
				
				<!-- Form Pengisian Atas Nama -->

			
				<div class="btn-row">
					<a href="#" class="btn btn-default"><i class="fa fa-bell fa-fw fa-lg"></i> Service</a>
					<a href="#" class="btn btn-default"><i class="fa fa-file-invoice-dollar fa-fw fa-lg"></i> Bill</a>
					<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw fa-lg"></i> Submit Order</a>
				</div>
			</div>
			
		</div>
		<!-- END pos-sidebar -->
	</div>
	<!-- END pos -->
	<!-- BEGIN pos-mobile-sidebar-toggler -->
	<a href="#" class="pos-mobile-sidebar-toggler" data-toggle-class="pos-mobile-sidebar-toggled" data-target="#pos-customer">
		<svg viewBox="0 0 16 16" class="img" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z"/>
			<path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z"/>
		</svg>
		<span class="badge">5</span>
	</a>
	<!-- END pos-mobile-sidebar-toggler -->
	<!-- BEGIN #modalPosItem -->
	<div class="modal modal-pos-item fade" id="modalPosItem" tabindex="-1">
		<div class="modal-dialog modal-lg" style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
			<div class="modal-content">
				<div class="modal-body p-0">
					<a href="#" data-bs-dismiss="modal" class="btn-close position-absolute top-0 end-0 m-4"></a>
					<div class="pos-product">
						<div class="pos-product-img">
							<div class="img" style="background-image: url(/assets/img/pos/product-1.jpg)"></div>
						</div>
						<div class="pos-product-info">
							<div class="title">Grill Chicken Chop</div>
							<div class="desc">
								chicken, egg, mushroom, salad
							</div>
							<div class="price">$10.99</div>
							<hr />
							<div class="option-row">
								<div class="qty">
									<div class="input-group">
										<a href="#" class="btn btn-default"><i class="fa fa-minus"></i></a>
										<input type="text" class="form-control border-0 text-center" name="" value="1" />
										<a href="#" class="btn btn-default"><i class="fa fa-plus"></i></a>
									</div>	
								</div>
							</div>
							<div class="btn-row">
								<a href="#" class="btn btn-default" data-bs-dismiss="modal">Cancel</a>
								<a href="#" class="btn btn-success">Add to cart <i class="fa fa-plus fa-fw ms-2"></i></a>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- END #modalPosItem -->
@endsection
