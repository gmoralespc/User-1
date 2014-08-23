									<section class="container">
										<div class="row">
											<div class="col-md-8">
												<h2></h2>
												<h2>Profile</h2>
												<form class="white-row" method="post" action="shop-cc-pay.html">
													
													<p>
														Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt.
													</p>

													<h5>YOUR PROFILE</h5>

													<!-- BILLING ADDRESS -->
													<div class="row">
														<div class="col-md-12">
														
															{{ $user->first_name}} {{ $user->last_name}}
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
													
															{{ $user->sex}}
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															{{ $user->date_of_birth}}
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															{{ $user->mobile}}
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															{{ $user->phone}}
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															{{ $user->address}}
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															{{ $user->street}}
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															{{ $user->city}}
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															{{ $user->district}}
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															{{ $user->state}}
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															{{ $user->country }}
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															{{ $user->web}}
														</div>
													</div>

												</form>

											</div>

											<div class="col-md-4">

												<h2></h2>
												<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pellentesque neque eget diam porta.</p>
												<p>
													@include("user::partials.menu")
												</p>
												

											</div>
										</div></section>