<!-- sidebar start -->
<aside class="sidebar">
	<div class="logo"><img src="{{asset('assets/superadmin/images/logo.png')}}"></div>
	<div class="navigation">
		<ul>
			<li class="{{  (Request::path() ==  'superadmin/dashboard') ? 'active_nav' : '' }}"><a href="{{route('superadminDashboard')}}"><i class="fa fa-th-large"></i>  <span>Dashboard</span></a></li>
			<!--li class="{{  (Request::path() ==  'superadmin/remove-user') ? 'active_nav' : '' }}"><a href="{{route('superadminDashboardGetUser')}}"><i class="fa fa-th-large"></i>  <span>Delete Users</span></a></li-->
			<!--li class="{{  (Request::path() ==  'superadmin/datafinder') ? 'active_nav' : '' }}"><a href="{{route('superadminDashboardDatafinder')}}"><i class="fa fa-th-large"></i>  <span>Data Finder</span></a></li-->
			<!--li class="{{  (Request::path() ==  'superadmin/member') ? 'active_nav' : '' }}"><a href="{{route('superadminMember')}}"><i class="fa fa-user"></i> <span>Customer</span></a></li-->
			<li class="has_dropdown {{  (Request::is('superadmin/member/*')) ? 'active_nav' : '' }}"><a href="#"><i class="fa fa-user"></i> <span>Customer</span></a>
				<div class="sub_menu">
					<ul>
					    <li class="{{  (Request::path() ==  'superadmin/member/customers') ? 'active_subnav' : '' }}">
						<a href="{{route('superadminCustomers')}}">
						Customers</a></li>
						<li class="{{  (Request::path() ==  'superadmin/member/prospects') ? 'active_subnav' : '' }}">
						<a href="{{route('superadminProspects')}}">
						Prospects</a></li>
						<li class="{{  (Request::path() ==  'superadmin/member/all') ? 'active_subnav' : '' }}">
						<a href="{{route('superadminAllMembers')}}">
						View All</a></li>

					</ul>
				</div>
			</li>
			<li class="has_dropdown {{  (Request::is('superadmin/sale/*')) ? 'active_nav' : '' }}"><a href="#"><i class="fa fa-line-chart"></i> <span>Sale</span></a>
				<div class="sub_menu">
					<ul>
					    <li class="{{  (Request::path() ==  'superadmin/sale/property/reports') ? 'active_subnav' : '' }}"><a href="{{route('SuperadminDashboard.sale.salePropertyReport')}}">Property Report</a></li>
						<li class="{{  (Request::path() ==  'superadmin/sale/records/reports') ? 'active_subnav' : '' }}"><a href="{{route('SuperadminDashboard.sale.purchasedRecordsReport')}}">Purchase Records Report</a></li>
						<li class="{{  (Request::path() ==  'superadmin/sale/membership/reports') ? 'active_subnav' : '' }}"><a href="{{route('SuperadminDashboard.sale.saleMembershipReport')}}">membership Report</a></li>
						<li class="{{  (Request::path() ==  'superadmin/sale/vouchers') ? 'active_subnav' : '' }}"><a href="{{route('SuperadminDashboard.sale.vouchers')}}">Vouchers</a></li>
						<!--<li class="{{  (Request::path() ==  'superadmin/sale/invoices') ? 'active_nav' : '' }}"><a href="{{route('AccountDashboardSaleInvoices')}}">Invoices</a></li> -->
						<li class="{{  (Request::path() ==  'superadmin/sale/total/sale/reports') ? 'active_subnav' : '' }}"><a href="{{route('SuperadminDashboard.sale.totalSaleReport')}}">Total Sale Report</a></li>
					</ul>
				</div>
			</li>

			<li class="has_dropdown {{  (Request::is('superadmin/purchase/*')) ? 'active_nav' : '' }}"><a href="#"><i class="fa fa-shopping-basket"></i> <span>Purchase</span></a>
				<div class="sub_menu">
					<ul>
						<li class="{{  (Request::path() ==  'superadmin/purchase/datatrees') ? 'active_subnav' : '' }}"><a href="{{route('SuperadminDashboard.purchase.purchaseDatatree')}}">Datatree</a></li>
						<li class="{{  (Request::path() ==  'superadmin/purchase/datafinders') ? 'active_subnav' : '' }}"><a href="{{route('SuperadminDashboard.purchase.purchaseDatafinder')}}">Datafinder</a></li>
						<li class="{{  (Request::path() ==  'superadmin/purchase/vouchers') ? 'active_subnav' : '' }}"><a href="{{route('SuperadminDashboard.purchase.vouchers')}}">Vouchers</a></li>
					<!--	<li class="{{  (Request::path() ==  'superadmin/purchase/invoices') ? 'active_nav' : '' }}"><a href="{{route('SuperadminDashboard.purchase.invoices')}}">Invoices</a></li>-->
						<li class="{{  (Request::path() ==  'superadmin/purchase/totalReports') ? 'active_subnav' : '' }}"><a href="{{route('SuperadminDashboard.purchase.totalPurchasedReports')}}">Total Purchased Reports</a></li>
					</ul>
				</div>
			</li>


			<li class="has_dropdown {{  (Request::is('superadmin/accountBooks/*')) ? 'active_nav' : '' }}"><a href="#"><i class="fa fa-book"></i> <span>Account Books</span></a>
				<div class="sub_menu">
					<ul>
						<li class="{{  (Request::path() ==  'superadmin/accountBooks/chart-of-account/list') ? 'active_subnav' : '' }}"><a href="{{route('SuperadminDashboard.accountBooks.chartAccount')}}">Chart Of Accounts</a></li>
						<li class="{{  request()->segment(4) == 'ledgers' ? 'active_subnav' : '' }}"><a href="{{route('SuperadminDashboard.accountBooks.journalGeneralLedger')}}">General Ledger</a></li>
						<li class="{{  request()->segment(4) == 'balance-sheet' ? 'active_subnav' : '' }}"><a href="{{route('SuperadminDashboard.accountBooks.incomeBalanceSheet')}}">Balance Sheet</a></li>
					</ul>
				</div>
			</li>

			<?php /* <li class="has_dropdown {{  (Request::is('superadmin/employee/*')) ? 'active_nav' : '' }}"><a href="javascript:void()"><i class="fa fa-users"></i> <span>Contractors</span></a>
				<div class="sub_menu">
					<ul>
						<li class="{{  (Request::path() ==  'superadmin/employee/all') ? 'active_subnav' : '' }}"><a href="{{route('superadminEmployee')}}">All Contractors</a></li>
						<li class="{{  (Request::path() ==  'superadmin/employee/holiday') ? 'active_subnav' : '' }}"><a href="{{route('superadminEmployeeHoliday')}}">Holidays</a></li>
						<!--li class="{{  (Request::path() ==  'superadmin/employee/leave/request') ? 'active_subnav' : '' }}"><a href="{{route('superadminLeaveRequest')}}">Leave Request</a></li>
						<li class="{{  (Request::path() ==  'superadmin/employee/attendance') ? 'active_subnav' : '' }}"><a href="{{route('superadminEmployeeAttendance')}}">Attendance</a></li>
						<li class="{{  (Request::path() ==  'superadmin/employee/department') ? 'active_subnav' : '' }}"><a href="{{route('superadminEmployee.department')}}">Departments</a></li>
						<li class="{{  (Request::path() ==  'superadmin/employee/designation') ? 'active_subnav' : '' }}"><a href="{{route('superadminEmployee.designation')}}">Designations</a></li>
						<!--li class="{{  (Request::path() ==  'superadmin/employee/salary') ? 'active_subnav' : '' }}"><a href="{{route('superadminEmployee.salary')}}">Contractor Salary</a></li-->
					</ul>
				</div>
			</li> */ ?>

			 <li class="has_dropdown {{  (Request::is('superadmin/affiliate/*')) ? 'active_nav' : '' }}"><a href="javascript:void()"><i class="fa fa-users"></i> <span>Affiliate</span></a>
				<div class="sub_menu">
					<ul>
						<li class="{{  (Request::path() ==  'superadmin/affiliate/all') ? 'active_subnav' : '' }}"><a href="{{route('superadminEmployeeAffiliateUsers')}}">Affiliate Users</a></li>
						<li class="{{  (Request::path() ==  'superadmin/affiliate/payments') ? 'active_subnav' : '' }}"><a href="{{route('superadminAffiliatePayment')}}">Affiliates Payments</a></li>
					</ul>
				</div>
			</li>
			<li class="{{  (Request::path() ==  'superadmin/switch-mode') ? 'active_nav' : '' }}"><a href="{{route('superadminSwitchMode')}}"><i class="fa fa-toggle-off"></i> <span>Switch Mode</span></a></li>
			<li class="has_dropdown  {{  (Request::is('superadmin/news/*')) ? 'active_nav' : '' }}"><a href="javascript:void()"><i class="fa fa-file-text-o"></i> <span>News & Insight</span></a>
				<div class="sub_menu">
				<?php  $categories =  DB::table('tbl_category')->orderBy('id','desc')->get(); ?>
					<ul>
						@foreach($categories as $category)
							<li class=" {{  request()->segment(4) == $category->category_url ? 'active_subnav' : '' }}">
								<a href="/superadmin/news/category/{{$category->category_url}}">{{ $category->name }}</a>
							</li>
						@endforeach

						<li class="{{  (Request::path() ==  'superadmin/news/category') ? 'active_nav' : '' }}"><a href="{{route('superadminNewsCategory')}}"><span>Add Category</span></a></li>

					</ul>
				</div>
			</li>

			<li class="has_dropdown {{  (Request::is('superadmin/marketing/*')) ? 'active_nav' : '' }}"><a href="javascript:void()"><i class="fa fa-comments"></i> <span>Marketing</span></a>
				<div class="sub_menu">
					<ul>
						<li class="has_dropdown">
							<span style="color: #fff;">Postcard Design Service</span>
							<div class="sub_menu">
								<ul>
									<li class="{{ request()->segment(4) ==  'requests' ? 'active_subnav' : '' }}"><a href="{{route('superadminPostcardDesignRequested')}}">Requested Designs</a></li>
									<li class="{{ request()->segment(4) ==  'progress' ? 'active_subnav' : '' }}"><a href="{{route('superadminPostcardDesignInProgress')}}">In Progress Designs</a></li>
									<li class="{{ request()->segment(4) ==  'completed' ? 'active_subnav' : '' }}"><a href="{{route('superadminPostcardDesignCompleted')}}">Completed Designs</a></li>
								</ul>
							</div>
						</li>
						<li class="<?=(isset($_GET['active']) && ($_GET['active']=='mrkchat'))? 'active_subnav': '' ?>"><a href="mrkchat.php?active=mrkchat">Marketing Chat</a></li>
					</ul>
				</div>
			</li>

			<li class="has_dropdown {{ (Request::is('superadmin/membership-ticket/*')) ? 'active_nav' : '' }}"><a href="javascript:void()"><i class="fa fa-users"></i> <span>Membership Ticket</span></a>
				<div class="sub_menu">
					<ul>
						<li class="has_dropdown">
							<div class="sub_menu">
								<ul>
									<li class="{{ (Request::path() ==  'superadmin/membership-ticket/open') ? 'active_subnav' : '' }}"><a href="{{route('superadminOpenTicket')}}">Open</a></li>
									<li class="{{ (Request::path() ==  'superadmin/membership-ticket/closed') ? 'active_subnav' : '' }}"><a href="{{route('superadminClosedTicket')}}">Closed</a></li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</li>

			<li class="{{  (Request::path() ==  'superadmin/wallet') ? 'active_nav' : '' }}"><a href="{{route('superadminWallet')}}"><i class="fa fa-suitcase"></i> <span>Wallet</span></a></li>

			<li class="has_dropdown {{  (Request::is('superadmin/cms/*')) ? 'active_nav' : '' }}"><a href="javascript:void()"><i class="fa fa-cog"></i> <span>CMS</span></a>
				<div class="sub_menu">
					<ul>
						<li class="{{  request()->segment(3) == 'popup' ? 'active_subnav' : '' }}"><a href="{{route('superadminCmsPopup')}}"> <span>Popups</span></a></li>
						<li class="has_dropdown {{  request()->segment(3) == 'home' ? 'active_nav_sub2' : '' }}"><a href="{{route('superadminCms.home')}}">Home</a>

							<div class="sub_menu">
								<ul>
									<li class="{{  request()->segment(4) == 'playstore' ? 'active_subnav' : '' }}"><a href="{{route('superadminCms.home.listPlayStoreContent')}}">Play Store Section</a></li>
								</ul>
							</div>
						</li>
						<li class="has_dropdown {{  request()->segment(3) == 'about' ? 'active_nav_sub2' : '' }}"><a href="{{route('superadminCms.about')}}">About</a>
							<div class="sub_menu">
								<ul>
									<li class="{{  request()->segment(4) == 'team' ? 'active_subnav' : '' }}"><a href="{{route('superadminCms.about.team')}}">Teams</a></li>
								</ul>
							</div>
						</li>
						<li class="has_dropdown {{  request()->segment(3) == 'affiliate' ? 'active_nav_sub2' : '' }}"><a href="{{route('superadminCmsAffiliate')}}">Affiliates</a>
							<div class="sub_menu">
								<ul>
									<li class="{{  (Request::path() ==  'superadmin/cms/affiliate/faq') ? 'active_subnav' : '' }}"><a href="{{route('superadminCmsFaq')}}">FAQ</a></li>
								</ul>
							</div>
						</li>

						<li class="{{  (Request::path() ==  'superadmin/cms/sign-up') ? 'active_subnav' : '' }}"><a href="{{route('superadminCms.signup')}}">Sign Up</a></li>
						<li class="{{  (Request::path() ==  'superadmin/cms/login') ? 'active_subnav' : '' }}"><a href="{{route('superadminCms.login')}}">Login </a></li>
						<li class="{{  (Request::path() ==  'superadmin/cms/membership') ? 'active_subnav' : '' }}"><a href="{{route('superadminCms.membership')}}">Membership</a></li>
						<li class="{{  (Request::path() ==  'superadmin/cms/contact') ? 'active_subnav' : '' }}"><a href="{{route('superadminCms.contact')}}">Contact Us</a></li>
						<li class="{{  (Request::path() ==  'superadmin/cms/terms') ? 'active_subnav' : '' }}"><a href="{{route('superadminCms.terms')}}">Terms</a></li>
						<li class="{{  (Request::path() ==  'superadmin/cms/privacy') ? 'active_subnav' : '' }}"><a href="{{route('superadminCms.privacy')}}">Privacy</a></li>
						<li class="{{  (Request::path() ==  'superadmin/cms/faq') ? 'active_subnav' : '' }}"><a href="{{route('superadminCms.faq')}}">FAQ</a></li>
						<li class="{{  (Request::path() ==  'superadmin/cms/career') ? 'active_subnav' : '' }}"><a href="{{route('superadminCms.career')}}">Career</a></li>
					</ul>
				</div>
			</li>
			<li class="has_dropdown {{  (Request::is('superadmin/kickstarter/*')) ? 'active_nav' : '' }}"><a href="javascript:void()"><i class="fa fa-user"></i> <span>Kickstarter</span></a>
				<div class="sub_menu">
					<ul>
						<li class="{{  (Request::path() ==  'superadmin/kickstarter/new') ? 'active_subnav' : '' }}"><a href="{{route('superadminNewKickstarter')}}"> <span>Add Kickstarter</span></a></li>
						<li class="{{  (Request::path() ==  'superadmin/kickstarter/search') ? 'active_subnav' : '' }}"><a href="{{route('superadminKickstarterSearch')}}"> <span>Search Kickstarter</span></a></li>
						<li class="{{  (Request::path() ==  'superadmin/kickstarter/marketing') ? 'active_subnav' : '' }}"><a href="{{route('superadminKickstarterMarket')}}"> <span>Marketing Kickstarter</span></a></li>

					</ul>
				</div>
			</li>
			<li class="has_dropdown {{  (Request::is('superadmin/configuration/*')) ? 'active_nav' : '' }}"><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i>Configuration</a>
				<div class="sub_menu">
					<ul>
						<li class="{{  (Request::path() ==  'superadmin/configuration/maintenance-banner') ? 'active_subnav' : '' }}"><a href="{{route('superadminConfigMaintenanceBanner')}}">Maintenance Banner</a></li>
						<li class="{{  (Request::path() ==  'superadmin/configuration/targets') ? 'active_subnav' : '' }}"><a href="{{route('superadminConfigSetTargets')}}">Targets</a></li>
						<li class="{{  (Request::path() ==  'superadmin/configuration/rates') ? 'active_subnav' : '' }}"><a href="{{route('superadminConfigSetRates')}}">Rates</a></li>
					</ul>
				</div>
			</li>
			<!--li class="{{  (Request::path() ==  'superadmin/message') ? 'active_nav' : '' }}"><a href="{{route('superadminMessage')}}"><i class="fa fa-comments"></i> <span>Message</span></a></li>
			<li class="{{  (Request::path() ==  'superadmin/contact') ? 'active_subnav' : '' }}"><a href="#"><i class="fa fa-phone"></i> <span>Contacts</span></a></li>
			<li class="{{  (Request::path() ==  'superadmin/dashboard') ? 'active_subnav' : '' }}"><a href="#"><i class="fa fa-file-text-o"></i> <span>Reports</span></a></li-->
		</ul>
	</div>
</aside>
<!-- sidebar end -->
