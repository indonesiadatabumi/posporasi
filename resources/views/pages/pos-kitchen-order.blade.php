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
	<!-- BEGIN pos-kitchen -->
	<div class="pos pos-kitchen" id="pos-kitchen">
		<div class="pos-kitchen-header">
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
				{{-- <div class="nav-item">
					<a href="/pos/table-booking" class="nav-link">
						<svg viewBox="0 0 16 16" class="nav-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
							<path d="M6.445 11.688V6.354h-.633A12.6 12.6 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23z"/>
						</svg>
					</a>
				</div> --}}
				<div class="nav-item">
					<a href="/pos/menu-stock" class="nav-link">
						<i class="fas fa-warehouse nav-icon" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="pos-kitchen-body">
			<div class="pos-task-row">
				<div class="pos-task">
					<div class="pos-task-info">
						<div class="table-no">
							Table <b>05</b>
						</div>
						<div class="order-type">
							<span class="badge bg-success">Dine-in</span>
						</div>
					</div>
					<div class="pos-task-body">
						<div class="pos-task-completed">
							Completed: <b>(1/3)</b>
						</div>
						<div class="pos-task-product-row">
							<div class="pos-task-product">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-2.jpg);"></div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Pork Burger</div>
										<div class="desc">
											- large size<br />
											- extra cheese<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success">Complete</a>
									<a href="#" class="btn btn-outline-inverse">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-14.jpg);"></div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Macarons</div>
										<div class="desc">
											- serve after dishes
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success">Complete</a>
									<a href="#" class="btn btn-outline-inverse">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-8.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Vita C Detox Juice</div>
										<div class="desc">
											- large size<br />
											- less ice<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pos-task">
					<div class="pos-task-info">
						<div class="table-no">
							Table <b>14</b>
						</div>
						<div class="order-no">
							Order No: #9047
						</div>
						<div class="order-type">
							<span class="badge bg-success">Dine-in</span>
						</div>
						<div class="time-pass" data-start-time="3">
							<span class="text-danger">12:13</span> time
						</div>
					</div>
					<div class="pos-task-body">
						<div class="pos-task-completed">
							Completed: <b>(3/4)</b>
						</div>
						<div class="pos-task-product-row">
							<div class="pos-task-product">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-11.jpg);"></div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Baked chicken wing</div>
										<div class="desc">
											- 6 pieces<br />
											- honey source<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success">Complete</a>
									<a href="#" class="btn btn-outline-inverse">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-12.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Veggie Spaghetti</div>
										<div class="desc">
											- size: large <br />
											- spicy level: light
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-7.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Coffee Latte</div>
										<div class="desc">
											- no sugar<br />
											- more cream<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-1.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Grill Chicken Chop</div>
										<div class="desc">
											- ala carte
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pos-task">
					<div class="pos-task-info">
						<div class="table-no">
							Table <b>17</b>
						</div>
						<div class="order-no">
							Order No: #9046
						</div>
						<div class="order-type">
							<span class="badge bg-gray-500">Dine-in</span>
						</div>
						<div class="time-pass" data-start-time="3">
							All dish served<br />12:30 total time
						</div>
					</div>
					<div class="pos-task-body">
						<div class="pos-task-completed">
							Completed: <b>(3/3)</b>
						</div>
						<div class="pos-task-product-row">
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-2.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Pork Burger</div>
										<div class="desc">
											- large size<br />
											- extra cheese<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-10.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Mushroom soup</div>
										<div class="desc">
											- ala carte<br />
											- more cheese<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-8.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Vita C Detox Juice</div>
										<div class="desc">
											- large size<br />
											- less ice<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pos-task">
					<div class="pos-task-info">
						<div class="table-no">
							Table <b>18</b>
						</div>
						<div class="order-no">
							Order No: #9045
						</div>
						<div class="order-type">
							<span class="badge bg-gray-500">Dine-in</span>
						</div>
						<div class="time-pass" data-start-time="3">
							All dish served<br />12:30 total time
						</div>
					</div>
					<div class="pos-task-body">
						<div class="pos-task-completed">
							Completed: <b>(2/2)</b>
						</div>
						<div class="pos-task-product-row">
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-13.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Vanilla Ice Cream</div>
										<div class="desc">
											- ala carte
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-9.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Pancake</div>
										<div class="desc">
											- ala carte
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pos-task">
					<div class="pos-task-info">
						<div class="table-no">
							Table <b>02</b>
						</div>
						<div class="order-no">
							Order No: #9045
						</div>
						<div class="order-type">
							<span class="badge bg-gray-500">Take Away</span>
						</div>
						<div class="time-pass" data-start-time="3">
							All dish served<br />22:28 total time
						</div>
					</div>
					<div class="pos-task-body">
						<div class="pos-task-completed">
							Completed: <b>(3/3)</b>
						</div>
						<div class="pos-task-product-row">
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-4.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Vegan Salad Bowl&reg;</div>
										<div class="desc">
											- ala carte
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-6.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Avocado Shake</div>
										<div class="desc">
											- ala carte
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-5.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Hawaiian Pizza&reg;</div>
										<div class="desc">
											- ala carte
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END pos-kitchen -->
@endsection
