<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::prefix('customer')->group(function(){
    // Route::group(['middleware'=>'guest'],function(){
        Route::get('', 'UserController@loginPage')->name('login.show');
        Route::post('login','UserController@login')->name('login');
		Route::get('login','UserController@loginHome')->name('login');


    Route::group(['prefix' => 'reports'], function () {
        Route::group(['prefix' => 'sales-comparables'], function () {
            Route::get('pdf/{propertyId}','DownloadReportController@salesComparables')->name('sales-comparables.pdf');
            Route::get('header/{headerData}','DownloadReportController@salesComparablesHeader')->name('sales-comparables.pdf-header');
            Route::get('footer','DownloadReportController@salesComparablesFooter')->name('sales-comparables.pdf-footer');
        });
        Route::group(['prefix' => 'property-detail-report'], function () {
            Route::get('pdf/{propertyId}','DownloadReportController@propertyDetailReport')->name('property-detail-report.pdf');
            Route::get('header/{propertyId}','DownloadReportController@propertyDetailReportHeader')->name('property-detail-report.pdf-header');
            Route::get('footer','DownloadReportController@propertyDetailReportFooter')->name('property-detail-report.pdf-footer');
        });
    });

    // });
// });


// Route::prefix('customer')->group(function(){
//     Route::group(['middleware'=>'auth'],function(){
//         Route::get('logout','UserController@logout')->name('logout');
//         Route::get('/dashboard','ViewController@dashboard')->name('customerDashboard');
//         Route::get('/advance-search','ViewController@advanceSearch')->name('customerAdvanceSearch');
//         Route::get('/properties/interested','ViewController@interestedProperties')->name('customerInterestedProperties');
//         Route::get('/properties/highly/interested','ViewController@highlyInterestedProperties')->name('customerHighlyInterestedProperties');
//         Route::get('/contact','ViewController@contact')->name('customerContact');
//         Route::get('/message','ViewController@message')->name('customerMessage');
//         Route::get('/message/send','ViewController@sendMessage')->name('customerSendMessage');
//         Route::get('/message/view','ViewController@viewMessage')->name('customerViewMessage');
//         Route::get('/saved-search','ViewController@savedSearch')->name('customerSavedSearch');
//         Route::get('/wallet','ViewController@wallet')->name('customerWallet');
//         Route::get('/payment','ViewController@payment')->name('customerPayment');
//         Route::get('/transaction/history','ViewController@transactionHistory')->name('customerTransactionHistory');
//         Route::get('/membership','ViewController@membership')->name('customerMembership');
//         Route::get('/profile','ViewController@profile')->name('customerProfile');
//         Route::get('/profile/edit','ViewController@editProfile')->name('customerEditProfile');
//         Route::get('/trash','ViewController@trash')->name('customerTrash');
//         Route::match(['GET','POST'],'/purchase/record','CustomerDashboard\PurchaseRecordController@purchaseRecord')->name('customerPurchaseRecord');
//     });
// });

Route::prefix('superadmin')->group(function(){
    Route::group(['middleware'=>'auth'],function(){

        Route::get('logout','UserController@logout')->name('logout');
        Route::get('/dashboard','SuperadminDashboard\DashboardController@dashboard')->name('superadminDashboard');

		Route::get('/membership-ticket/closed','SuperadminDashboard\CustomerController@ClosedTicket')->name('superadminClosedTicket');
		Route::get('/membership-ticket/open','SuperadminDashboard\CustomerController@OpenTicket')->name('superadminOpenTicket');
		Route::get('/membership-ticket/detail/{id}','SuperadminDashboard\CustomerController@cancelMembershipTicketDetail')->name('superadminCancelMembershipTicketDetail');

		Route::get('/export/', 'SuperadminDashboard\AffiliateController@export')->name('export');

        Route::get('/datafinder','SuperadminDashboard\AffiliateController@datafinderapi')->name('superadminDashboardDatafinder');

		Route::post('/marketing/postcard/ajaxHandlingPostcard','SuperadminDashboard\PostcardController@ajaxHandlingPostcard')->name('superadminPostcardAjaxRequest');
		Route::get('/marketing/postcard/requested','SuperadminDashboard\PostcardController@requestedPostcardDesigns')->name('superadminPostcardDesignRequested');
		Route::get('/marketing/postcard/inprogress','SuperadminDashboard\PostcardController@inProgressPostcardDesigns')->name('superadminPostcardDesignInProgress');
		Route::get('/marketing/postcard/completed','SuperadminDashboard\PostcardController@completedPostcardDesigns')->name('superadminPostcardDesignCompleted');
		Route::get('/marketing/postcard/detail/{id}','SuperadminDashboard\PostcardController@postcardDesignDetail')->name('superadminPostcardDesignDetail');

		Route::get('/ajaxHandling','SuperadminDashboard\ConfigurationController@ajaxHandlingConfig')->name('superadminConfigAjaxRequest');
		Route::get('/switch-mode','SuperadminDashboard\ConfigurationController@switchModeDetail')->name('superadminSwitchMode');

		Route::get('/user-list','SuperadminDashboard\UserController@getUser')->name('superadminDashboardGetUser');
        Route::get('/remove-user','SuperadminDashboard\UserController@trashUser')->name('superadminDashboardTrashUser');
        Route::post('/remove-user','SuperadminDashboard\UserController@trashUser')->name('superadminDashboardTrashUser');

		Route::get('/configuration/maintenance-banner','SuperadminDashboard\ConfigurationController@maintenanceBannerContent')->name('superadminConfigMaintenanceBanner');
		Route::post('/configuration/maintenance-banner', 'SuperadminDashboard\ConfigurationController@saveMaintenanceContent')->name('superadminConfigMaintenanceBannerSave');
		Route::get('/configuration/targets','SuperadminDashboard\ConfigurationController@targetsList')->name('superadminConfigSetTargets');
        Route::post('/configuration/targets', 'SuperadminDashboard\ConfigurationController@saveTarget')->name('superadminConfigAddtargets');

		Route::get('/configuration/rates','SuperadminDashboard\ConfigurationController@ratesList')->name('superadminConfigSetRates');
        Route::post('/configuration/rates', 'SuperadminDashboard\ConfigurationController@saveRates')->name('superadminConfigAddRates');

		Route::get('/configuration/packages','SuperadminDashboard\ConfigurationController@packagesAddForm')->name('superadminConfigShowForm');
        Route::post('/configuration/packages', 'SuperadminDashboard\ConfigurationController@savePackages')->name('superadminConfigAddPackages');

		Route::get('/configuration/features','SuperadminDashboard\ConfigurationController@featuresList')->name('superadminConfigGetFeatures');
        Route::post('/configuration/features', 'SuperadminDashboard\ConfigurationController@saveFeatures')->name('superadminConfigAddFeatures');

        Route::get('/member','SuperadminDashboard\CustomerController@member')->name('superadminMember');
	    Route::get('/member/customers','SuperadminDashboard\CustomerController@CustomersList')->name('superadminCustomers');
		Route::get('/member/prospects','SuperadminDashboard\CustomerController@ProspectsList')->name('superadminProspects');
		Route::get('/member/prospects/detail/{id}','SuperadminDashboard\CustomerController@MemberDetail')->name('superadmin.prospect.detail');
		Route::get('/member/customer/detail/{id}','SuperadminDashboard\CustomerController@MemberDetail')->name('superadmin.customer.detail');
		Route::get('/member/all','SuperadminDashboard\CustomerController@AllMembers')->name('superadminAllMembers');

        Route::post('/memberSearch', 'SuperadminDashboard\CustomerController@memberSearch')->name('superadminMemberSearch');
        Route::get('/memberSearch', 'SuperadminDashboard\CustomerController@memberSearch')->name('superadminMemberSearch');
		Route::get('/member/detail/{id}/{type}','SuperadminDashboard\CustomerController@MemberDetail')->name('superadmin.member.detail');
		Route::get('/member/detail/savedSearch','SuperadminDashboard\CustomerController@savedSearchList')->name('superadminSavedSearchList');
		Route::get('/send/','SuperadminDashboard\KickStarterController@send')->name('emailSend');

		Route::get('/member/detail/purchasedetail/{id}/{name}/{member}','SuperadminDashboard\CustomerController@PurchaseRecordDetail')->name('superadminPurchaseRecordDetail');


       Route::get('/kickstarter/marketing','SuperadminDashboard\KickStarterController@kickstarter')->name('superadminKickstarterMarket');
        Route::get('/kickstarter/search','SuperadminDashboard\KickStarterController@kickstarter')->name('superadminKickstarterSearch');
        Route::get('/kickstarter/new','SuperadminDashboard\KickStarterController@kickstarterAddNew')->name('superadminNewKickstarter');
        Route::get('/kickstarter/getCities/{id}','SuperadminDashboard\KickStarterController@getCities')->name('superadmingetCities');
        Route::get('/kickstarter/getCounties/{id}','SuperadminDashboard\KickStarterController@getCounties')->name('superadmingetCounties');
        Route::get('/kickstarter/getCityByCounty/{countyname}/{stateid}','SuperadminDashboard\KickStarterController@CityByCounty')->name('superadmingetCityByCounty');

        Route::get('kickstarter/list','SuperadminDashboard\KickStarterController@kickstarterList')->name('kickstarter.list');
        Route::get('/cms/kickstarter/detail/{id}','SuperadminDashboard\KickStarterController@kickstarterDetail')->name('kickstarter.detail');
        Route::post('/kickstarter', 'SuperadminDashboard\KickStarterController@store')->name('superadminKickstarter.store');
        Route::post('/kickstarter/SaveSearch', 'SuperadminDashboard\KickStarterController@SaveSearch')->name('superadminKickstarterSaveSearch');
        Route::post('/kickstarter/{id}', 'SuperadminDashboard\KickStarterController@update')->name('superadminKickstarterUpdate');
        Route::post('/kickstarter/delete/{id}', 'SuperadminDashboard\KickStarterController@destroy')->name('superadminKickstarterDelete');
        Route::get('/kickstarter/varifyemail/','SuperadminDashboard\KickStarterController@varifyemail')->name('superadminKickstarterVarifyemail');

        /* Route::get('/sale/total/sale/report','SuperadminDashboard\SaleController@saleTotalSaleList')->name('superadminSale');
		Route::get('/sale/membership/report','SuperadminDashboard\SaleController@saleMembershipReport')->name('superadminSaleMembership');
		Route::get('/sale/membership/report/search','SuperadminDashboard\SaleController@saleMembershipReport')->name('superadminSaleMembershipSearch');
		Route::get('/sale/property/report','SuperadminDashboard\SaleController@salePropertyList')->name('superadminSalePropertyReport');
        Route::get('/sale/purchased/report','SuperadminDashboard\SaleController@salePurchasedRecords')->name('superadminPurchasedRecordsReport');
		Route::get('/sale/totalsale/report','SuperadminDashboard\SaleController@totalSaleReport')->name('superadminTotalSaleReport');

		Route::get('/purchase/datatree','SuperadminDashboard\PurchaseController@purchaseDataTree')->name('superadminPurchaseDataTree');
		Route::get('/purchase/datafinder','SuperadminDashboard\PurchaseController@purchaseDataFinder')->name('superadminPurchaseDataFinder');
		Route::get('/purchase/totalpurchasedreport','SuperadminDashboard\PurchaseController@totalPurchasedReport')->name('superadminTotalPurchasedReport');
		Route::post('purchase/save','SuperadminDashboard\PurchaseController@store')->name('saveDataTreeFinderData');

		Route::get('/accountBooks/account-chart','SuperadminDashboard\AccountBooksController@accountChart')->name('superadminAccountChart');
		Route::get('/accountBooks/general-ledger','SuperadminDashboard\AccountBooksController@generalLedger')->name('superadminGeneralLedger');
		Route::get('/accountBooks/balance-sheet','SuperadminDashboard\AccountBooksController@balanceSheet')->name('superadminBalanceSheet');
		Route::post('/accountBooks/save','SuperadminDashboard\AccountBooksController@store')->name('superadminAccountBooksSave');
		Route::get('/accountBooks/delete/{id}','SuperadminDashboard\AccountBooksController@destroy')->name('superadminAccountBooksDeleteAccChart');
		Route::get('/purchase','SuperadminDashboard\ViewController@purchase')->name('superadminPurchase'); */


		Route::get('/sale/property/reports','SuperadminDashboard\account\saleController@datatable')->name('SuperadminDashboard.sale.salePropertyReport');
		Route::get('/sale/property/report','SuperadminDashboard\account\saleController@saleReportList')->name('SuperadminDashboardSalePropertyReportList');

		Route::get('/sale/records/reports','SuperadminDashboard\PurchaseRecordsController@purchasedRecordsList')->name('SuperadminDashboard.sale.purchasedRecordsReport');
		Route::get('/purchased/records/report','SuperadminDashboard\PurchaseRecordsController@purchasedRecords')->name('superadminPurchasedRecordsReport');
		Route::get('/sale/membership/reports','SuperadminDashboard\account\saleController@saleMembership')->name('SuperadminDashboard.sale.saleMembershipReport');

		Route::get('/sale/membership/report','SuperadminDashboard\account\saleController@saleMembershipReport')->name('saleMembershipReport');
		Route::get('/sale/total/sale/reports','SuperadminDashboard\TotalSaleController@TotalSaleView')->name('SuperadminDashboard.sale.totalSaleReport');
		Route::get('/sale/total/sale/report','SuperadminDashboard\TotalSaleController@TotalSaleList')->name('SuperadmintotalSaleReport');
		Route::post('/Add/voucher','SuperadminDashboard\account\VouchersController@addVouchers')->name('vouchers.add');
		Route::get('/sale/vouchers','SuperadminDashboard\account\VouchersController@SalevoucherView')->name('SuperadminDashboard.sale.vouchers');
		Route::get('/sale/voucher','SuperadminDashboard\account\VouchersController@SalevoucherList')->name('SuperadminSalevouchers');
		Route::post('invoicess','invoiceController@addInvoice')->name('invoice.add');
		Route::get('/sale/invoices','invoiceController@invoiceView')->name('AccountDashboardSaleInvoices');
		Route::get('/invoice','invoiceController@invoiceList')->name('invoices');

		Route::post('Add/datatree/entry','SuperadminDashboard\account\purchaseController@AddDatatree')->name('adddata.add');
		Route::post('Add/datatree/entries','SuperadminDashboard\account\purchaseController@AddBulkReport')->name('addBulkdata.add');
		Route::get('/purchase/datatrees','SuperadminDashboard\account\purchaseController@purdatatree')->name('SuperadminDashboard.purchase.purchaseDatatree');
		Route::get('/purchase/datatree','SuperadminDashboard\account\purchaseController@purchaseDataTree')->name('SuperadminDashboardpurchaseDatatree');
		Route::post('Add/Finder/entry','SuperadminDashboard\account\purchaseController@AddDataFinder')->name('adddataFin.add');
		Route::post('Add/Finder/entries','SuperadminDashboard\account\purchaseController@AddDataFinderBulk')->name('adddataFinBulk.add');
		Route::get('/purchase/datafinders','SuperadminDashboard\account\purchaseController@purdatafinlder')->name('SuperadminDashboard.purchase.purchaseDatafinder');
		Route::get('/purchase/datafinder','SuperadminDashboard\account\purchaseController@purchaseDataFinder')->name('SuperadminPurchaseDatafinder');
		Route::get('/purchase/totalReports','SuperadminDashboard\account\purchaseController@PurchaseReportList')->name('SuperadminDashboard.purchase.totalPurchasedReports');
		Route::get('/purchase/purchased/totalReport','SuperadminDashboard\account\purchaseController@purchasedRecord')->name('SuperadminPurchaseReportList');
		Route::post('/Add/Purchase/voucher','SuperadminDashboard\account\VouchersController@addPurchaseVouchers')->name('Purchasevouchers.add');
		Route::get('/purchase/vouchers','SuperadminDashboard\account\VouchersController@PurchasevoucherView')->name('SuperadminDashboard.purchase.vouchers');
		Route::get('/purchase/voucher','SuperadminDashboard\account\VouchersController@PurchasevoucherList')->name('Purchasevouchers');
		Route::post('vouchar/update','SuperadminDashboard\account\VouchersController@updateVoucher')->name('Purchasevouchers.update');
		Route::get('vouchar/delete/{id}','SuperadminDashboard\account\VouchersController@deleteAoc')->name('vouchar.DeletAoc');
		Route::post('purchase/invoicess','invoiceController@addInvoice')->name('PurchaseInvoice.add');
		Route::get('/purchase/invoices','invoiceController@invoiceView')->name('SuperadminDashboard.purchase.invoices');
		Route::get('/purchase/invoice','invoiceController@invoiceList')->name('invoices');

		Route::post('/report/Add/Account/Chart','SuperadminDashboard\AccountChartController@Addchart')->name('AccountChart.add');
		Route::post('/report/Add/Account/Chart/Purchase','SuperadminDashboard\AccountChartController@AddchartPurchase')->name('AccountChartPurchase.add');
		Route::get('/accountBooks/chart-of-account/list','SuperadminDashboard\AccountChartController@AccountChartList')->name('SuperadminDashboard.accountBooks.chartAccount');
		Route::post('report/update','SuperadminDashboard\AccountChartController@updateAccountChart')->name('chartAccount.updateAccountChart');
		Route::get('report/delete/{id}','SuperadminDashboard\AccountChartController@deleteAoc')->name('chartAccount.DeletAoc');
		Route::get('/report/chart-of-account','SuperadminDashboard\AccountChartController@AccountChart')->name('chartAccount');
		Route::get('/report/chart-of-accounts','SuperadminDashboard\AccountChartController@AccountChartPurchase')->name('chartAccountP');
		Route::get('/accountBooks/general/ledgers','SuperadminDashboard\JournalLeadgerController@JournalLeadgerView')->name('SuperadminDashboard.accountBooks.journalGeneralLedger');
		Route::get('/journal/general/ledger','SuperadminDashboard\JournalLeadgerController@JournalLeadgerList')->name('journalGeneralLedger');
		Route::get('/accountBooks/balance-sheet','SuperadminDashboard\TotalIncExpController@IncomeBalanceSheet')->name('SuperadminDashboard.accountBooks.incomeBalanceSheet');


        Route::get('/employee/all','SuperadminDashboard\UserController@employee')->name('superadminEmployee');
        Route::get('employee/list','SuperadminDashboard\UserController@EmployeeList')->name('employee.list');
        Route::post('/employee', 'SuperadminDashboard\UserController@store')->name('superadminEmployeeAdd');
        Route::post('/employee/{id}', 'SuperadminDashboard\UserController@update')->name('superadminEmployeeEdit');
        Route::post('/employee/delete/{id}', 'SuperadminDashboard\UserController@destroy')->name('superadminEmployeeDelete');
		Route::get('/employee/detail/{id}','SuperadminDashboard\UserController@EmployeeDetail')->name('superadminEmployee.detail');
        Route::get('/employee/varifyemail/','SuperadminDashboard\UserController@varifyemail')->name('superadminEmployeeVarifyemail');
        Route::get('/employee/ajaxHandling/','SuperadminDashboard\UserController@ajaxHandling')->name('superadminEmployeeAjaxRequest');

		Route::post('/affiliate/ajaxHandling/','SuperadminDashboard\AffiliateController@affiliateAjaxHandling')->name('superadminAffiliateAjaxRequest');
		Route::post('/affiliate/commission','SuperadminDashboard\AffiliateController@SaveCommission')->name('superadminSaveAffiliateCommission');
		Route::get('/affiliate/all','SuperadminDashboard\AffiliateController@affiliateUsers')->name('superadminEmployeeAffiliateUsers');
		Route::get('affiliate/list','SuperadminDashboard\AffiliateController@affiliateList')->name('affiliate.list');
		Route::get('/affiliate/payments','SuperadminDashboard\AffiliateController@affiliateListPayments')->name('superadminAffiliatePayment');
		Route::get('/affiliate/mass-payment-detail','SuperadminDashboard\AffiliateController@affiliateMassPayDetail')->name('superadminAffiliateMassPayDetail');
		Route::get('/affiliate/order-detail/{orderid}/{affiliate}','SuperadminDashboard\AffiliateController@paymentDetail')->name('superadminAffiliatePaymentDetail');

        Route::get('/employee/holiday','SuperadminDashboard\HolidayController@holiday')->name('superadminEmployeeHoliday');
        Route::get('/employee/holiday/list','SuperadminDashboard\HolidayController@holidayList')->name('superadminHolidayList');
        Route::post('/holiday', 'SuperadminDashboard\HolidayController@store')->name('superadminEmployeeHolidayAdd');
        Route::post('/holiday/{id}', 'SuperadminDashboard\HolidayController@update')->name('superadminEmployeeHolidayEdit');
        Route::post('/holiday/delete/{id}', 'SuperadminDashboard\HolidayController@destroy')->name('superadminEmployeeHolidayDelete');
        Route::get('/employee/department','SuperadminDashboard\DepartmentController@department')->name('superadminEmployee.department');
        Route::get('/employee/department/list','SuperadminDashboard\DepartmentController@departmentList')->name('superadminEmployee.departmentList');


        Route::post('/department', 'SuperadminDashboard\DepartmentController@store')->name('superadminEmployee.saveDepartment');
        Route::post('/department/{id}', 'SuperadminDashboard\DepartmentController@update')->name('superadminEmployee.edit');
        Route::post('/department/delete/{id}', 'SuperadminDashboard\DepartmentController@destroy')->name('superadminEmployee.delete');
        Route::get('/employee/leave/request','SuperadminDashboard\ViewController@leaveRequest')->name('superadminLeaveRequest');
        Route::get('/employee/attendance','SuperadminDashboard\ViewController@employeeAttendance')->name('superadminEmployeeAttendance');
        Route::get('/employee/designation','SuperadminDashboard\RoleController@designation')->name('superadminEmployee.designation');
        Route::get('/employee/designation/list','SuperadminDashboard\RoleController@designationList')->name('superadminEmployee.designationList');

        Route::post('/designation', 'SuperadminDashboard\RoleController@store')->name('superadminEmployee.saveDesignation');
        Route::post('/designation/{id}', 'SuperadminDashboard\RoleController@update')->name('superadminEmployeeDesignationEdit');
        Route::post('/designation/delete/{id}', 'SuperadminDashboard\RoleController@destroy')->name('superadminEmployeeDesignationDelete');
        Route::get('/employee/salary','SuperadminDashboard\ViewController@salary')->name('superadminEmployee.salary');
        Route::get('/wallet','SuperadminDashboard\ViewController@wallet')->name('superadminWallet');

		Route::get('/cms/affiliate','SuperadminDashboard\CmsController@affiliate')->name('superadminCmsAffiliate');
		Route::get('/cms/affiliate/faq','SuperadminDashboard\CmsController@listFaq')->name('superadminCmsFaq');
		Route::post('/cms/affiliate/faq', 'SuperadminDashboard\CmsController@saveFaq')->name('superadminCmsAddAffiliateFaq');
		Route::post('/cms/affiliate/faq/{id}', 'SuperadminDashboard\CmsController@updateFaq')->name('superadminCmsAffiliateFaqEdit');
		Route::get('/cms/popup','SuperadminDashboard\CmsController@popup')->name('superadminCmsPopup');
		Route::get('/cms/login','SuperadminDashboard\CmsController@login')->name('superadminCms.login');
		Route::get('/cms/contact','SuperadminDashboard\CmsController@contact')->name('superadminCms.contact');

		Route::get('/news/category/{slug}','SuperadminDashboard\ViewController@newsByCategoryId')->name('superadminNewsByCategoryId');
		Route::get('/news/role','SuperadminDashboard\CmsController@newsRoleList')->name('superadminNewsRole');
		Route::post('/news/role/add', 'SuperadminDashboard\CmsController@saveNewsRole')->name('superadminAddnewsRole');
        Route::post('/news/role/update/{id}', 'SuperadminDashboard\CmsController@updateNewsRole')->name('superadminViewNewsRoleEdit');
		Route::get('/news/list','SuperadminDashboard\ViewController@newsList')->name('superadminCms.news');
        Route::post('/news/list', 'SuperadminDashboard\ViewController@saveNews')->name('superadminCmsAddnews');
        Route::post('/news/{id}', 'SuperadminDashboard\ViewController@updateNews')->name('superadminViewNewsEdit');
		Route::get('/news/category','SuperadminDashboard\ViewController@newsCategoryList')->name('superadminNewsCategory');
        Route::post('/news/category/add', 'SuperadminDashboard\ViewController@saveNewsCategory')->name('superadminAddnewsCategory');
        Route::post('/news/category/update/{id}', 'SuperadminDashboard\ViewController@updateNewsCategory')->name('superadminViewNewsCategoryEdit');
        Route::get('/news/ajaxHandling/','SuperadminDashboard\ViewController@ajaxHandling')->name('superadminViewAjaxRequest');

		Route::get('/cms/sign-up','SuperadminDashboard\CmsController@signUp')->name('superadminCms.signup');
		Route::get('/cms/membership','SuperadminDashboard\CmsController@membershipPage')->name('superadminCms.membership');
        Route::get('/cms/faq','SuperadminDashboard\CmsController@faq')->name('superadminCms.faq');
        Route::get('/cms/about','SuperadminDashboard\CmsController@about')->name('superadminCms.about');
		Route::get('/cms/about/ajaxHandling/','SuperadminDashboard\CmsController@ajaxHandling')->name('superadminCmsAjaxRequest');
		Route::post('/cms/about/upload-image','SuperadminDashboard\CmsController@uploadImages')->name('image.upload');
		Route::get('/cms/about/team','SuperadminDashboard\CmsController@aboutTeamList')->name('superadminCms.about.team');
		Route::post('/cms/about/team', 'SuperadminDashboard\CmsController@store')->name('superadminCmsAddteam');
		Route::post('/cms/about/team/{id}', 'SuperadminDashboard\CmsController@updateTeam')->name('superadminCmsTeamEdit');
        Route::get('/cms/terms','SuperadminDashboard\CmsController@terms')->name('superadminCms.terms');
        Route::get('/cms/privacy','SuperadminDashboard\CmsController@privacy')->name('superadminCms.privacy');
        Route::get('/cms/career','SuperadminDashboard\CmsController@career')->name('superadminCms.career');
        Route::post('/cms','SuperadminDashboard\CmsController@update')->name('superadminCms.updateCms');
		Route::get('/cms/home','SuperadminDashboard\CmsController@home')->name('superadminCms.home');
		Route::post('/cms/home/update', 'SuperadminDashboard\CmsController@updateHomeContent')->name('superadminCmsHomeEdit');
		Route::get('/cms/home/playstore','SuperadminDashboard\CmsController@homePlayStoreList')->name('superadminCms.home.listPlayStoreContent');
		Route::post('/cms/membership/update', 'SuperadminDashboard\CmsController@updateMembershipContent')->name('superadminCmsMembershipEdit');

		Route::get('/message','SuperadminDashboard\ViewController@message')->name('superadminMessage');
        Route::get('/message/view','SuperadminDashboard\ViewController@viewMessage')->name('superadminViewMessage');
        Route::get('/message/send','SuperadminDashboard\ViewController@sendMessage')->name('superadminSendMessage');
        Route::get('/contact','SuperadminDashboard\ViewController@contact')->name('superadminContact');

		//Route::resource('kickstarter', 'SuperadminDashboard\KickStarterController', ['only' => ['index']]);
        Route::resource('employee', 'SuperadminDashboard\UserController',['only' => ['index']]);
        // Route::resource('holiday', 'SuperadminDashboard\HolidayController',['only' => ['index']]);
        Route::resource('department', 'SuperadminDashboard\DepartmentController',['only' => ['index']]);
        Route::resource('designation', 'SuperadminDashboard\RoleController',['only' => ['index']]);
    });
});


Route::prefix('salemanager')->group(function(){
    Route::group(['middleware'=>'auth'],function(){
        Route::get('logout','UserController@logout')->name('logout');
        Route::get('/dashboard','SalemanagerDashboard\ViewController@dashboard')->name('salemanagerDashboard');
        Route::get('/properties','SalemanagerDashboard\ViewController@properties')->name('salemanagerProperties');
        Route::get('/sale','SalemanagerDashboard\ViewController@sale')->name('salemanagerSale');
        Route::get('/member','SalemanagerDashboard\ViewController@customer')->name('salemanagerCustomer');
        Route::get('/team','SalemanagerDashboard\ViewController@team')->name('salemanagerTeam');
        Route::get('/team/add','SalemanagerDashboard\ViewController@addTeam')->name('salemanagerAddTeam');
        Route::get('member/list','SalemanagerDashboard\CustomerController@customerList')->name('sale_manager.customerList');
        Route::get('team/list','SalemanagerDashboard\TeamController@teamList')->name('sale_manager.teamList');
        Route::post('member/add','SalemanagerDashboard\CustomerController@addCustomer')->name('sale_manager.addCustomer');
        Route::post('add/team','SalemanagerDashboard\TeamController@addTeam')->name('sale_manager.addTeam');
        Route::get('member/delete/{id}','SalemanagerDashboard\CustomerController@deleteCustomer')->name('sale_manager.deleteTeam');
        Route::get('team/delete/{id}','SalemanagerDashboard\TeamController@deleteTeam')->name('sale_manager.teamDelete');
        Route::post('member/update','SalemanagerDashboard\CustomerController@updateCustomer')->name('sale_manager.updateCustomer');
        Route::post('team/update','SalemanagerDashboard\TeamController@updateTeam')->name('sale_manager.updateTeam');
        Route::get('property/active/list','SalemanagerDashboard\PropertyController@activePropertyList')->name('sale_manager.activeProperty');
        Route::get('property/expired/list','SalemanagerDashboard\PropertyController@expiredPropertyList')->name('sale_manager.expiredProperty');
        Route::get('property/draft/list','SalemanagerDashboard\PropertyController@draftPropertyList')->name('sale_manager.draftProperty');
        Route::get('property/active/delete/{id}','SalemanagerDashboard\PropertyController@deleteActiveProperty')->name('sale_manager.deleteProperty');
        Route::get('/member/getCities/{id}','SalemanagerDashboard\CustomerController@getCities')->name('salemanagerGetCities');
        Route::post('/memberSearch', 'SalemanagerDashboard\CustomerController@memberSearch')->name('superadminMemberSearch');
        Route::get('/memberSearch', 'SalemanagerDashboard\CustomerController@memberSearch')->name('superadminMemberSearch');
        Route::get('member/detail/{id}/{type}','SalemanagerDashboard\CustomerController@MemberDetail')->name('salemanagerMember.detail');
        Route::get('interested','SalemanagerDashboard\PropertyController@interestedProperty')->name('interestedProperty');
        Route::get('property/detail/{id}','SalemanagerDashboard\ViewController@propertyDetail')->name('propertyDetail');
        Route::get('member/detail/savedSearch','SalemanagerDashboard\CustomerController@savedSearchList')->name('salemanagerSavedSearchList');
        Route::get('/members','SalemanagerDashboard\ViewController@memberList')->name('sale_manager.memberList');
        Route::get('member/list/table','SalemanagerDashboard\ViewController@memberListTable')->name('memberList');
        Route::get('non-member/list','SalemanagerDashboard\ViewController@nonMemberList')->name('nonMemberList.show');
		Route::get('non-member/list/table','SalemanagerDashboard\ViewController@nonMemberListTable')->name('nonMemberList');
		Route::get('member/detail/{id}','SalemanagerDashboard\ViewController@membersDetail')->name('sale_manager_members');
		Route::get('non-member/detail/{id}','SalemanagerDashboard\ViewController@nonMemberDetail')->name('sale_manager_nonMembers');
		Route::get('message','SalemanagerDashboard\ViewController@messages')->name('sale_manager.message');
        Route::get('message/send','SalemanagerDashboard\ViewController@sendMessage')->name('sale_manager.sendMessage');
        Route::get('message/view','SalemanagerDashboard\ViewController@viewMessage')->name('sale_manager.viewMessage');
		Route::get('profile','SalemanagerDashboard\ViewController@profile')->name('profile');
    });
});


    Route::prefix('sale-executive')->group(function(){
        Route::group(['middleware'=>'auth'],function(){
            Route::get('logout','UserController@logout')->name('logout');
            Route::get('/dashboard','SaleExecutiveDashboard\ViewController@dashboard')->name('saleExecutiveDashboard');
            Route::get('/properties','SaleExecutiveDashboard\ViewController@properties')->name('saleExecutiveProperties');
            Route::get('/sale','SaleExecutiveDashboard\ViewController@sale')->name('saleExecutiveSale');
            Route::get('/customer','SaleExecutiveDashboard\ViewController@customer')->name('saleExecutiveCustomer');
            Route::get('/customer/profile/{id}','SaleExecutiveDashboard\ViewController@customerProfile')->name('saleExecutiveCustomerProfile');
            Route::get('/contact','SaleExecutiveDashboard\ViewController@contact')->name('saleExecutiveContact');
            Route::get('/message','SaleExecutiveDashboard\ViewController@message')->name('saleExecutiveMessage');
            Route::get('/message/send','SaleExecutiveDashboard\ViewController@sendMessage')->name('saleExecutiveSendMessage');
            Route::get('/team','SaleExecutiveDashboard\ViewController@team')->name('saleExecutiveTeam');
            Route::get('/team/add','SaleExecutiveDashboard\ViewController@addTeam')->name('saleExecutiveAddTeam');
            Route::get('/message/view','SaleExecutiveDashboard\ViewController@viewMessage')->name('saleExecutiveViewMessage');
            Route::get('/message/reply','SaleExecutiveDashboard\ViewController@replyMessage')->name('saleExecutiveReplyMessage');
            Route::post('add/customer','SaleExecutiveDashboard\CustomerController@addCustomer')->name('customer.add');
            Route::get('member/list','SaleExecutiveDashboard\CustomerController@memberList')->name('member.list');
            Route::get('non/member/list','SaleExecutiveDashboard\CustomerController@nonMemberList')->name('non_member.list');
            Route::post('add/contact','SaleExecutiveDashboard\CustomerController@addContact')->name('contact.add');
            Route::get('sale/manager/list','SaleExecutiveDashboard\CustomerController@saleManagerList')->name('saleManager.list');
            Route::get('sale/executive/list','SaleExecutiveDashboard\CustomerController@saleExecutiveList')->name('saleExecutive.list');
            Route::post('add/team','SaleExecutiveDashboard\TeamController@addTeam')->name('sale_executive.addTeam');
            Route::get('team/list','SaleExecutiveDashboard\TeamController@teamList')->name('team.list');
            Route::post('send/message','SaleExecutiveDashboard\MessageController@sendMessage')->name('sale_executive.sendMessage');
            Route::post('reply/message','SaleExecutiveDashboard\MessageController@replyMessage')->name('sale_executive.replyMessage');
            Route::get('/customer/edit/profile','SaleExecutiveDashboard\ViewController@editProfile')->name('saleExecutiveEditProfile');
            Route::get('team/delete/{id}','SaleExecutiveDashboard\TeamController@deleteTeam')->name('saleExecutive.teamDelete');
            Route::get('team/list/edit/{id}', 'SaleExecutiveDashboard\TeamController@editTeam')->name('saleExecutive.teamEdit');
            Route::post('team/update','SaleExecutiveDashboard\TeamController@update')->name('saleExecutive.updateTeam');
            Route::get('/non-member/profile/{id}','SaleExecutiveDashboard\ViewController@nonMemberProfile')->name('saleExecutiveNonMemberProfile');
            Route::get('property/active/list','SaleExecutiveDashboard\PropertyController@activePropertyList')->name('saleExecutive.activeProperty');
            Route::get('property/expired/list','SaleExecutiveDashboard\PropertyController@expiredPropertyList')->name('saleExecutive.expiredProperty');
            Route::get('property/draft/list','SaleExecutiveDashboard\PropertyController@draftPropertyList')->name('saleExecutive.draftProperty');
            Route::get('property/active/delete/{id}','SaleExecutiveDashboard\PropertyController@deleteActiveProperty')->name('saleExecutive.deleteProperty');

        });
    });

         Route::prefix('account')->group(function(){
		 Route::group(['middleware'=>'auth'],function(){
			Route::get('profile','AccountDashboard\ViewController@profile')->name('profile');
            Route::get('logout','UserController@logout')->name('logout');
            Route::get('/dashboard','AccountDashboard\ViewController@dashboard')->name('accountDashboard');
            Route::get('/sale/property/reports','saleController@datatable')->name('AccountDashboard.sale.salePropertyReport');
            Route::get('/sale/property/report','saleController@saleReportList')->name('salePropertyReport');
            Route::get('/sale/records/reports','AccountDashboard\PurchaseRecordsController@purchasedRecordsList')->name('AccountDashboard.sale.purchasedRecordsReport');
            Route::get('/purchased/records/report','AccountDashboard\PurchaseRecordsController@purchasedRecords')->name('purchasedRecordsReport');
            Route::get('/daterange','DateRangeController@index');
            Route::post('/daterange/fetch_data', 'DateRangeController@fetch_data')->name('salePropertyReport.fetch_data');
            Route::get('/sale/membership/reports','saleController@saleMembership')->name('AccountDashboard.sale.saleMembershipReport');
            Route::get('member/detail/{id}/{type}','saleController@MemberDetail')->name('member.detail');
            Route::get('/sale/membership/report','saleController@saleMembershipReport')->name('saleMembershipReport');
            Route::get('/sale/total/sale/reports','AccountDashboard\TotalSaleController@TotalSaleView')->name('AccountDashboard.sale.totalSaleReport');
            Route::get('/sale/total/sale/report','AccountDashboard\TotalSaleController@TotalSaleList')->name('totalSaleReport');
			Route::post('/Add/voucher','VouchersController@addVouchers')->name('vouchers.add');
            Route::get('/sale/vouchers','VouchersController@SalevoucherView')->name('AccountDashboardSaleVouchers');
            Route::get('/sale/voucher','VouchersController@SalevoucherList')->name('Salevouchers');
            Route::post('invoicess','invoiceController@addInvoice')->name('invoice.add');
            Route::get('/sale/invoices','invoiceController@invoiceView')->name('AccountDashboardSaleInvoices');
            Route::get('/invoice','invoiceController@invoiceList')->name('invoices');

            Route::post('Add/datatree/entry','purchaseController@AddDatatree')->name('adddata.add');
            Route::post('Add/datatree/entries','purchaseController@AddBulkReport')->name('addBulkdata.add');
            Route::get('/purchase/datatrees','purchaseController@purdatatree')->name('AccountDashboard.purchase.purchaseDatatree');
            Route::get('/purchase/datatree','purchaseController@purchaseDataTree')->name('purchaseDatatree');
            Route::post('Add/Finder/entry','purchaseController@AddDataFinder')->name('adddataFin.add');
            Route::post('Add/Finder/entries','purchaseController@AddDataFinderBulk')->name('adddataFinBulk.add');
            Route::get('/purchase/datafinders','purchaseController@purdatafinlder')->name('AccountDashboard.purchase.purchaseDatafinder');
            Route::get('/purchase/datafinder','purchaseController@purchaseDataFinder')->name('purchaseDatafinder');
            Route::get('/purchase/purchased/reports','purchaseController@PurchaseReportList')->name('AccountDashboard.purchase.totalPurchasedReports');
            Route::get('/purchase/purchased/report','purchaseController@purchasedRecord')->name('PurchaseReportList');
            Route::post('/Add/Purchase/voucher','VouchersController@addPurchaseVouchers')->name('Purchasevouchers.add');
            Route::get('/purchase/vouchers','VouchersController@PurchasevoucherView')->name('AccountDashboard.purchase.vouchers');
            Route::get('/purchase/voucher','VouchersController@PurchasevoucherList')->name('Purchasevouchers');
			Route::post('vouchar/update','VouchersController@updateVoucher')->name('Purchasevouchers.update');
            Route::get('vouchar/delete/{id}','VouchersController@deleteAoc')->name('vouchar.DeletAoc');
            Route::post('purchase/invoicess','invoiceController@addPurchaseInvoice')->name('purchaseinvoice.add');
            Route::get('/purchase/invoices','invoiceController@PurchaseinvoiceView')->name('AccountDashboard.purchase.invoices');
            Route::get('/purchase/invoice','invoiceController@PurchaseinvoiceList')->name('Purchaseinvoices');

            Route::post('/report/Add/Account/Chart','AccountDashboard\AccountChartController@Addchart')->name('AccountChart.add');
            Route::post('/report/Add/Account/Chart/Purchase','AccountDashboard\AccountChartController@AddchartPurchase')->name('AccountChartPurchase.add');
            Route::get('/accountBooks/chart-of-account/list','AccountDashboard\AccountChartController@AccountChartList')->name('AccountDashboard.accountBooks.chartAccount');
            Route::post('report/update','AccountDashboard\AccountChartController@updateAccountChart')->name('chartAccount.updateAccountChart');
            Route::get('report/delete/{id}','AccountDashboard\AccountChartController@deleteAoc')->name('chartAccount.DeletAoc');
            Route::get('/report/chart-of-account','AccountDashboard\AccountChartController@AccountChart')->name('chartAccount');
            Route::get('/report/chart-of-accounts','AccountDashboard\AccountChartController@AccountChartPurchase')->name('chartAccountP');
            Route::get('/accountBooks/general/ledgers','AccountDashboard\JournalLeadgerController@JournalLeadgerView')->name('AccountDashboard.accountBooks.journalGeneralLedger');
            Route::get('/journal/general/ledger','AccountDashboard\JournalLeadgerController@JournalLeadgerList')->name('journalGeneralLedger');
            Route::get('/accountBooks/balance-sheet','AccountDashboard\TotalIncExpController@IncomeBalanceSheet')->name('AccountDashboard.accountBooks.incomeBalanceSheet');

            Route::get('/wallets','walletController@walletview')->name('AccountDashboard.wallet');
            Route::get('/wallet','walletController@walletList')->name('wallet');
            Route::get('/employee', 'AccountDashboard\UserController@index')->name('employee');
            Route::post('/employee/add','AccountDashboard\UserController@store')->name('employeeadd');
            Route::post('/employee/{id}', 'AccountDashboard\UserController@update')->name('accountEmployeeEdit');
            Route::get('/employee/delete/{id}', 'AccountDashboard\UserController@destroy')->name('accountEmployeeDelete');
            Route::get('/employee/holiday/list','AccountDashboard\HolidayController@HolidayView')->name('AccountDashboard.employee.holiday');
            Route::get('/employee/holiday','AccountDashboard\HolidayController@HolidayList')->name('employeeHoliday');
            Route::post('/Add/Holiday','AccountDashboard\HolidayController@AddHoliday')->name('Holiday.add');
            Route::post('account/employee/leave/request','AccountDashboard\LeaveRequest@AddLeaveRequest')->name('leaveRequest.add');
            Route::get('/employee/leave/requests','AccountDashboard\LeaveRequest@LeaveRequestView')->name('AccountDashboard.employee.leaveRequest');
            Route::get('/employee/leave/request','AccountDashboard\LeaveRequest@LeaveRequestList')->name('employee.leaveRequestlist');
            Route::get('/employee/attendance','AccountDashboard\ViewController@attendance')->name('employeeAttendance');
            Route::post('/employee/Add/Department','AccountDashboard\DepartmentController@AddDepartment')->name('department.add');
            Route::get('/employee/Departments','AccountDashboard\DepartmentController@DepartmentView')->name('AccountDashboard.employee.department');
            Route::get('/employee/department','AccountDashboard\DepartmentController@DepartmentList')->name('employeeDepartment');
            Route::post('/employee/Add/Designations','AccountDashboard\DesignationController@AddDesignation')->name('designation.add');
            Route::get('/employee/Designations','AccountDashboard\DesignationController@DesignationView')->name('AccountDashboard.employee.designation');
            Route::get('/employee/Designation','AccountDashboard\DesignationController@DesignationList')->name('employeeDesignation');
            Route::get('/employee/salary','AccountDashboard\ViewController@employeeSalary')->name('employeeSalary');
            Route::get('/customers/Account','AccountDashboard\AccountController@AccountView')->name('AccountDashboard.customer');
            Route::get('/customer','AccountDashboard\AccountController@AccountList')->name('customer');
            Route::get('/report/product/list','AccountDashboard\ViewController@productList')->name('productList');
            Route::get('/report/split-transaction','AccountDashboard\ViewController@splitTransaction')->name('splitTransaction');
            Route::get('/report/standard/data-lead','AccountDashboard\ViewController@standardDataLead')->name('standardDataLead');
            Route::get('/report/automated/gl/entry','AccountDashboard\ViewController@automatedGlEntry')->name('automatedGlEntry');
            Route::get('/report/data/tree/report','AccountDashboard\ViewController@dataTreeReport')->name('dataTreeReport');
            Route::get('/report/product/table','AccountDashboard\ViewController@productTable')->name('productTable');
        });
    });
