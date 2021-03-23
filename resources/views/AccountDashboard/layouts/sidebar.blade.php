<!-- sidebar start -->
<aside class="sidebar">
	<div class="logo"><img src="{{asset('assets/account/images/logo.png')}}"></div>
	<div class="navigation">
		<ul>
			<li class="{{  (Request::path() ==  'account/dashboard') ? 'active_nav' : '' }}"><a href="{{route('accountDashboard')}}"><i class="fa fa-th-large"></i>  <span>Dashboard</span></a></li>
			<li class="has_dropdown {{  (Request::is('account/sale/*')) ? 'active_nav' : '' }}"><a href="#"><i class="fa fa-line-chart"></i> <span>Sale</span></a>
				<div class="sub_menu">
					<ul>
					    <li class="{{  (Request::path() ==  'account/sale/property/reports') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.sale.salePropertyReport')}}">Property Report</a></li>
						<li class="{{  (Request::path() ==  'account/sale/records/reports') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.sale.purchasedRecordsReport')}}">Purchase Records Report</a></li>
						<li class="{{  (Request::path() ==  'account/sale/membership/reports') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.sale.saleMembershipReport')}}">membership Report</a></li>
						<li class="{{  (Request::path() ==  'account/sale/vouchers') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboardSaleVouchers')}}">Vouchers</a></li>
						<li class="{{  (Request::path() ==  'account/sale/invoices') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboardSaleInvoices')}}">Invoices</a></li>
						<li class="{{  (Request::path() ==  'account/sale/total/sale/reports') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.sale.totalSaleReport')}}">Total Sale Report</a></li>
					</ul>
				</div>
			</li>
			<li class="has_dropdown {{  (Request::is('account/purchase/*')) ? 'active_nav' : '' }}"><a href="#"><i class="fa fa-shopping-basket"></i> <span>Purchase</span></a>
				<div class="sub_menu">
					<ul>
						<li class="{{  (Request::path() ==  'account/purchase/datatrees') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.purchase.purchaseDatatree')}}">Datatree</a></li>
						<li class="{{  (Request::path() ==  'account/purchase/datafinders') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.purchase.purchaseDatafinder')}}">Datafinder</a></li>
						<li class="{{  (Request::path() ==  'account/purchase/vouchers') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.purchase.vouchers')}}">Vouchers</a></li>
					    <li class="{{  (Request::path() ==  'account/purchase/invoices') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.purchase.invoices')}}">Invoices</a></li>
						<li class="{{  (Request::path() ==  'account/purchase/purchased/reports') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.purchase.totalPurchasedReports')}}">Total Purchased Reports</a></li>
					</ul>
				</div>
			</li>
			<li class="has_dropdown {{  (Request::is('account/accountBooks/*')) ? 'active_nav' : '' }}"><a href="#"><i class="fa fa-book"></i> <span>Account Books</span></a>
				<div class="sub_menu">
					<ul>
						<li class="{{  (Request::path() ==  'account/accountBooks/chart-of-account/list') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.accountBooks.chartAccount')}}">Chart Of Accounts</a></li>
						<li class="{{  (Request::path() ==  'account/accountBooks/general/legders') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.accountBooks.journalGeneralLedger')}}">General Ledger</a></li>
						<li class="{{  (Request::path() ==  'account/accountBooks/balance-sheet') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.accountBooks.incomeBalanceSheet')}}">Balance Sheet</a></li>
					</ul>
				</div>
			</li> 
			<!-- <li class="{{  (Request::path() ==  'account/wallets') ? 'active_nav' : '' }}"><a href="{{route('AccountDashboard.wallet')}}"><i class="fa fa-suitcase"></i> <span>Wallet</span></a></li>
			<li class="has_dropdown {{  (Request::is('account/employee/*')) ? 'active_nav' : '' }}"><a href="#"><i class="fa fa-users"></i> <span>Employees</span></a>
				<div class="sub_menu">
					<ul>
				
						<li class="{{  (Request::path() ==  'account/employee/holiday/list') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.employee.holiday')}}">Holidays</a></li>
						<li class="{{  (Request::path() ==  'account/employee/leave/requests') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.employee.leaveRequest')}}">leave requests</a></li>
						<li class="{{  (Request::path() ==  'account/employee/attendance') ? 'active_subnav' : '' }}"><a href="{{route('employeeAttendance')}}">attendance</a></li>
						<li class="{{  (Request::path() ==  'account/employee/departments') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.employee.department')}}">departments</a></li>
						<li class="{{  (Request::path() ==  'account/employee/designations') ? 'active_subnav' : '' }}"><a href="{{route('AccountDashboard.employee.designation')}}">designations</a></li>
						<li class="{{  (Request::path() ==  'account/employee/salary') ? 'active_subnav' : '' }}"><a href="{{route('employeeSalary')}}">Employee Salary</a></li>
					</ul>
				</div>
			</li>
			<li class="{{  (Request::path() ==  'account/customers/Account') ? 'active_nav' : '' }}"><a href="{{route('AccountDashboard.customer')}}"><i class="fa fa-user"></i> <span>account </span></a></li>

			<li class="has_dropdown {{  (Request::is('account/report/*')) ? 'active_nav' : '' }}"><a href="#"><i class="fa fa-file"></i> <span>Reports</span></a>
				<div class="sub_menu">
					<ul>
						<li class="{{  (Request::path() ==  'account/report/product/list') ? 'active_subnav' : '' }}"><a href="{{route('productList')}}">Product List</a></li>
						<li class="{{  (Request::path() ==  'account/report/split-transaction') ? 'active_subnav' : '' }}"><a href="{{route('splitTransaction')}}">Split Transactions</a></li>
						<li class="{{  (Request::path() ==  'account/report/standard/data-lead') ? 'active_subnav' : '' }}"><a href="{{route('standardDataLead')}}">Standard Data Lead</a></li>
						<li class="{{  (Request::path() ==  'account/report/automated/gl/entry') ? 'active_subnav' : '' }}"><a href="{{route('automatedGlEntry')}}">Automated GL Entry</a></li>
						<li class="{{  (Request::path() ==  'account/report/data/tree/report') ? 'active_subnav' : '' }}"><a href="{{route('dataTreeReport')}}">Data Tree Report</a></li>
						<li class="{{  (Request::path() ==  'account/report/product/table') ? 'active_subnav' : '' }}"><a href="{{route('productTable')}}">Product Table</a></li>
					</ul>
				</div>
			</li> -->
		</ul>
	</div>
</aside>
<!-- sidebar end -->
