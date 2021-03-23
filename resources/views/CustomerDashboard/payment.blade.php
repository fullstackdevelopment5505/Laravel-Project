@extends('CustomerDashboard.master')
@section('content')
    <!-- main div start -->
    <div class="main_area">
        @include('CustomerDashboard.layouts.sidebar');
        <!-- right area start -->
        <section class="right_section">
            @include('CustomerDashboard.layouts.header');
                <!-- inside_content_area start-->
                <div class="content_area">
                    <!-- back -->
                    <div class="col-sm-12 top_bar_area">
                        <div class="row">
                            <div class="col-sm-12 from_to_filter ">
                                <form>
                                    <div class="view_back"><a href="{{route('customerWallet')}}"><i class="fa fa-arrow-left"></i></a></div>
                                    <div class="title">Payments</div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- back -->
					<!-- main row start-->
					<div class="col-sm-12">
						<div class="row">
							<!--content start -->
                            <div class="col-sm-8 top_selling">
								<div class="inside">
                                    <div class="title">Select your Payment Method</div>
                                    <div class="methods">
                                        <ul>
                                            <li>
                                                <div class="titles">
                                                    <label>
                                                        <div class="headline">
                                                            <input type="radio" name="payment">
                                                            <span>Credit/Debit Card</span>
                                                        </div>
                                                        <div class="images">
                                                            <p><img src="{{asset('assets/customer/images/visa.png')}}"></p>
                                                            <p><img src="{{asset('assets/customer/images/master.png')}}"></p>
                                                            <p><img src="{{asset('assets/customer/images/american-express.png')}}"></p>
                                                            <p><img src="{{asset('assets/customer/images/discover.png')}}"></p>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="details">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <label>Card Number</label>
                                                            <input type="text" class="form-control" placeholder="XXXX-XXXX-XXXX-XXXX">
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="row">
                                                                <div class="col-sm-12"><label>Expiration Date</label></div>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control">
                                                                        <option disabled="disabled" selected="selected">Select Month</option>
                                                                        <optgroup>
                                                                            <option>January</option>
                                                                            <option>February</option>
                                                                            <option>March</option>
                                                                            <option>April</option>
                                                                            <option>May</option>
                                                                            <option>June</option>
                                                                            <option>July</option>
                                                                            <option>August</option>
                                                                            <option>September</option>
                                                                            <option>October</option>
                                                                            <option>November</option>
                                                                            <option>December</option>
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <select class="form-control">
                                                                        <option disabled="disabled" selected="selected">Select Year</option>
                                                                        <optgroup>
                                                                            <option>2020</option>
                                                                            <option>2019</option>
                                                                            <option>2018</option>
                                                                            <option>2017</option>
                                                                            <option>2016</option>
                                                                            <option>2015</option>
                                                                            <option>2014</option>
                                                                            <option>2013</option>
                                                                            <option>2012</option>
                                                                            <option>2011</option>
                                                                            <option>2010</option>
                                                                            <option>2009</option>
                                                                            <option>2008</option>
                                                                            <option>2007</option>
                                                                            <option>2006</option>
                                                                            <option>2005</option>
                                                                            <option>2004</option>
                                                                            <option>2003</option>
                                                                            <option>2002</option>
                                                                            <option>2001</option>
                                                                            <option>2000</option>
                                                                            <option>1999</option>
                                                                            <option>1998</option>
                                                                            <option>1997</option>
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>Security Code (CVV)</label>
                                                            <input type="text" class="form-control" placeholder="123">
                                                        </div>
                                                        <div class="col-sm-12 terms mt-0"><input type="checkbox"> Securely Save To Account</a></div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="titles">
                                                    <label>
                                                        <div class="headline">
                                                            <input type="radio" name="payment">
                                                            <span>Net Banking</span>
                                                        </div>
                                                        <div class="images"><p><img src="{{asset('assets/customer/images/net-banking.png')}}"></p></div>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="titles">
                                                    <label>
                                                        <div class="headline">
                                                            <input type="radio" name="payment">
                                                            <span>Paypal</span>
                                                        </div>
                                                        <div class="images"><p><img src="{{asset('assets/customer/images/paypal.png')}}"></p></div>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="titles">
                                                    <label>
                                                        <div class="headline">
                                                            <input type="radio" name="payment">
                                                            <span>Stripe</span>
                                                        </div>
                                                        <div class="images"><p><img src="{{asset('assets/customer/images/stripe.png')}}"></p></div>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="terms"><input type="checkbox"> By clicking the button, you agree to the <a href="#"  data-toggle="modal" data-target="#myModal">Terms and Conditions</a></div>
                                    <div class="place_order"><button class="btn btn-success" data-toggle="modal" data-target="#thanku">Continue Payment</button></div>
								</div>
							</div>
                            <!--content end-->
                            <!--content start -->
                            <div class="col-sm-4 top_selling">
								<div class="inside">
                                    <div class="title">Saved Cards</div>
                                    <div class="save_card">
                                        <label>
                                            <input type="radio" name="save"><span></span>
                                            <div class="holder_name">John Doe</div> 
                                            <div class="account_number">XXXX-XXXX-XXXX-4356</div>
                                            <div class="expire">03/20</div>
                                            <div class="trash"><i class="fa fa-trash"></i></div>
                                        </label>
                                    </div>
                                    <div class="save_card">
                                        <label>
                                            <input type="radio" name="save"><span></span>
                                            <div class="holder_name">Mike Miller</div> 
                                            <div class="account_number">XXXX-XXXX-XXXX-8979</div>
                                            <div class="expire">10/20</div>
                                            <div class="trash"><i class="fa fa-trash"></i></div>
                                        </label>
                                    </div>
								</div>
                                <div class="inside">
                                    <div class="title">Payment Summary</div>
                                    <div class="total_amount">
                                        <ul>
                                            <li><strong>Amount:</strong> <span>$100.00</span></li>
                                            <li><strong>Credits:</strong> <span>200 Points</span></li>
                                            <li><strong>Tax:</strong> <span>$20.00</span></li>
                                        </ul>
                                    </div>
                                    <div class="subtotal"><strong>Subtotal:</strong> <span>$220.00</span></div>
								</div>
							</div>
                            <!--content end-->
						</div>
					</div>
					<!-- main row end-->
                </div>
			    <!-- inside_content_area end-->
        </section>
        <!-- right area end -->
    </div>
    <!-- main div end -->

    <!-- popup start-->
    <div class="modal fade" id="myModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><b>Terms & Conditions</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body register_new_user">
					<div class="row">
						<div class="col-sm-12 terms_and_condition_text">
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
						</div>
                    </div>
				</div>

                <div class="modal-footer mt-2">
                    <div class=" text-right"> 
                        <a href="#" type="btn" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                    </div>
                </div>

			</div>
		</div>
    </div>
    <!-- popup end-->


    <!-- popup start-->
    <div class="modal fade" id="thanku">
		<div class="modal-dialog modal-md">
			<div class="modal-content">

				<div class="modal-body register_new_user">
					<div class="row">
						<div class="col-sm-12 congratulation">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="congrats_data">
                                <img src="{{asset('assets/customer/images/payment.svg')}}">
                                <h3>Payment Successful</h3>
                                <p>Your payment was successful! You can now continue using Hyphen</p>
                                <div class="all_data"><a href="dashboard.php" class="btn btn-primary">Go To Dashboard</a></div>
                            </div>
						</div>
                    </div>
				</div>

			</div>
		</div>
    </div>
    <!-- popup end-->
@endsection