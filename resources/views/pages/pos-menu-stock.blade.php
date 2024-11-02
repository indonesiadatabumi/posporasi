@extends('layouts.default', [
	'paceTop' => true, 
	'appContentFullHeight' => true, 
	'appContentClass' => 'p-0',
	'appSidebarHide' => true,
	'appHeaderHide' => true
])

@section('title', 'POS - Menu Stock System')

@push('scripts')
	<script src="/assets/js/demo/pos-menu-stock.demo.js"></script>
@endpush

@section('content')
	<!-- BEGIN pos-stock -->
	<div class="pos pos-stock" id="pos-stock">
		<!-- BEGIN pos-stock-header -->
		<div class="pos-stock-header">
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
		<!-- END pos-stock-header -->
		
		<!-- BEGIN pos-stock-body -->
		<div class="pos-stock-body">
			<!-- BEGIN pos-stock-content -->
			<div class="pos-stock-content">
				<div class="pos-stock-content-container">
					<div class="row gx-0">
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-1.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Grill Chicken Chop&reg;</div>
											<div class="desc">chicken, egg, mushroom, salad</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="20" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product1" checked value="1" />
															<label class="form-check-label" for="product1"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-2.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Grill Pork Chop&reg;</div>
											<div class="desc">pork, egg, mushroom, salad</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="30" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product2" checked value="1" />
															<label class="form-check-label" for="product2"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-3.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Capellini Tomato Sauce&reg;</div>
											<div class="desc">spaghetti, tomato, mushroom</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="15" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product3" checked value="1" />
															<label class="form-check-label" for="product3"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-4.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Vegan Salad Bowl&reg;</div>
											<div class="desc">apple, carrot, tomato</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="10" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product4" checked value="1" />
															<label class="form-check-label" for="product4"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-5.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Hawaiian Pizza&reg;</div>
											<div class="desc">pizza, crab meat, pineapple</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="10" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product5" checked value="1" />
															<label class="form-check-label" for="product5"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-6.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Avocado Shake</div>
											<div class="desc">avocado, milk, vanilla</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="0" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product6" value="1" />
															<label class="form-check-label" for="product6"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-7.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Coffee Latte</div>
											<div class="desc">espresso, milk</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="50" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product7" checked value="1" />
															<label class="form-check-label" for="product7"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-8.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Vita C Detox Juice</div>
											<div class="desc">apricot, apple, carrot and ginger juice</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="50" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product8" checked value="1" />
															<label class="form-check-label" for="product8"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-9.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Pancake</div>
											<div class="desc">Non dairy, egg, baking soda, sugar, all purpose flour</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="13" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product9" checked value="1" />
															<label class="form-check-label" for="product9"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-10.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Mushroom soup</div>
											<div class="desc">Evaporated milk, marsala wine, beef cubes, chicken broth, butter</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="30" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product10" checked value="1" />
															<label class="form-check-label" for="product10"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-11.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Baked chicken wing</div>
											<div class="desc">Chicken wings, a1 steak sauce, honey, cayenne pepper</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="32" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product11" checked value="1" />
															<label class="form-check-label" for="product11"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-12.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Veggie Spaghetti</div>
											<div class="desc">Yellow squash, pasta, roasted red peppers, zucchini</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="7" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product12" checked value="1" />
															<label class="form-check-label" for="product12"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-13.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Vanilla Ice Cream</div>
											<div class="desc">Heavy whipping cream, white sugar, vanilla extract</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="50" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product13" checked value="1" />
															<label class="form-check-label" for="product13"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-14.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Perfect Yeast Doughnuts</div>
											<div class="desc">Chocolate hazelnut spread, bread flour, doughnuts, quick rise yeast, butter</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="10" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product14" checked value="1" />
															<label class="form-check-label" for="product14"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-15.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Macarons</div>
											<div class="desc">Almond flour, egg whites, heavy cream, food coloring, powdered sugar</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="20" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product15" checked value="1" />
															<label class="form-check-label" for="product15"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
							<div class="pos-stock-product">
								<div class="pos-stock-product-container">
									<div class="product">
										<div class="product-img">
											<div class="img" style="background-image: url(/assets/img/pos/product-16.jpg)"></div>
										</div>
										<div class="product-info">
											<div class="title">Perfect Vanilla Cupcake</div>
											<div class="desc">Baking powder, all purpose flour, plain kefir, vanilla extract</div>
											
											<div class="product-option">
												<div class="option">
													<div class="option-label">Stock:</div>
													<div class="option-input">
														<input type="text" class="form-control" value="16" />
													</div>
												</div>
												<div class="option">
													<div class="option-label">Availability:</div>
													<div class="option-input">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" name="" id="product16" checked value="1" />
															<label class="form-check-label" for="product16"></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="product-action">
											<a href="#" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Cancel</a>
											<a href="#" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END pos-stock-content -->
		</div>
		<!-- END pos-stock-body -->
	</div>
	<!-- END pos-stock -->
@endsection
