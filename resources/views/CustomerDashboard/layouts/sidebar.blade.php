<!-- sidebar start -->
<aside class="sidebar">
	<div class="logo"><img src="{{asset('assets/customer/images/logo.png')}}"></div>
	<div class="navigation">
		<ul>
			<li class="{{  (Request::path() ==  'customer/dashboard') ? 'active_nav' : '' }}"><a href="{{route('customerDashboard')}}"><i class="fa fa-th-large"></i>  <span>Dashboard</span></a></li>
			<li class="{{  (Request::path() ==  'customer/advance-search') ? 'active_nav' : '' }}"><a href="{{route('customerAdvanceSearch')}}"><i class="fa fa-search"></i> <span>Advance Search </span></a></li>
			<li class="{{  (Request::path() ==  'customer/purchase/record') ? 'active_nav' : '' }}"><a href="{{route('customerPurchaseRecord')}}"><i class="fa fa-shopping-bag"></i> <span>Purchased Records </span></a></li>
			<li class="has_dropdown {{  (Request::is('customer/properties/*')) ? 'active_nav' : '' }}"><a href="#"><i class="fa fa-building"></i> <span>Properties</span></a>
				<div class="sub_menu">
					<ul>
						<li class="{{  (Request::path() ==  'customer/properties/interested') ? 'active_subnav' : '' }}"><a href="{{route('customerInterestedProperties')}}">Interested Properties</a></li>
						<li class="{{  (Request::path() ==  'customer/properties/highly/interested') ? 'active_subnav' : '' }}"><a href="{{route('customerHighlyInterestedProperties')}}">Highly Interested Properties</a></li>
					</ul>
				</div>
			</li>
			<li class="{{  (Request::path() ==  'customer/contact') ? 'active_nav' : '' }}"><a href="{{route('customerContact')}}"><i class="fa fa-phone"></i> <span>Contacts </span></a></li>
			<li class="{{  (Request::path() ==  'customer/message') ? 'active_nav' : '' }}"><a href="{{route('customerMessage')}}"><i class="fa fa-envelope"></i> <span>Message </span></a></li>
			<li class="{{  (Request::path() ==  'customer/saved-search') ? 'active_nav' : '' }}"><a href="{{route('customerSavedSearch')}}"><i class="fa fa-heart"></i> <span>Saved Search </span></a></li>
			<li class="{{  (Request::path() ==  'customer/wallet') ? 'active_nav' : '' }}"><a href="{{route('customerWallet')}}"><i class="fa fa-suitcase"></i> <span>Wallet </span></a></li>
			<li class="{{  (Request::path() ==  'customer/membership') ? 'active_nav' : '' }}"><a href="{{route('customerMembership')}}"><i class="fa fa-users"></i> <span>Membership </span></a></li>
			<li class="{{  (Request::path() ==  'customer/profile') ? 'active_nav' : '' }}"><a href="{{route('customerProfile')}}"><i class="fa fa-user"></i> <span>Profile </span></a></li>
			<li class="{{  (Request::path() ==  'customer/trash') ? 'active_nav' : '' }}"><a href="{{route('customerTrash')}}"><i class="fa fa-trash"></i> <span>Trash </span></a></li>
		</ul>
	</div>
	<div class="bottom_link"><a href="https://www.creativebuffer.com/W-Equityfinder/Website/html/index.html" target="_blank"><i class="fa fa-globe"></i> Go To Website </a></div>
</aside>
<!-- sidebar end -->
