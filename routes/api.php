<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function(){

	Route::get('/test-email', 'MembershipController@testEmail');

	Route::get('/session-cookie', 'ExtraController@sessionCookieContent');

	Route::get('/maintenance-banner', 'ExtraController@maintenanceBanner');

	Route::post('/register-one', 'AuthController@register_one');

	Route::post('/receive-data-sendgrid', 'WebhookController@handleSendgridRequest'); // route for webhooks to post

	Route::post('/prospects-email', 'ExtraController@getProspectsEmail');

	Route::post('/receiveData', 'WebhookController@handleSms'); // webhook route


	Route::get('/test', 'AuthController@testEmail');

	Route::get('/test-delete', 'ExtraController@testDelete');

	Route::post('/test-delete', 'ExtraController@testDelete');

	Route::post('/recurring-payment-save-data', 'PaymentController@recurringPaymentRecord');

	Route::post('/login', 'AuthController@login');
	// punch
		Route::get('/get-postcards-new', 'PostcardController@getUserPostcardNew');//punch
		Route::post('/sendPhone', 'AuthController@sendPhone');
	// punch
	Route::post('/affiliate-register', 'AffiliateController@affiliate_register');

	Route::post('/affiliate-login', 'AffiliateController@login');

	Route::post('/affiliateAddTaxPaypal','AffiliateController@affiliateSaveTaxPaypal');

	//Route::get('/reset/password', 'AuthController@resetPassword');

	Route::get('/authentication/forgot-password', 'AuthController@resetPassword');

	Route::post('/reset/password', 'AuthController@resetPassword');

	Route::post('/forgot-password', 'AuthController@forgotPassword');

	//Route::post('/forgot_password', 'AuthController@forgot_password');state

	Route::get('/list', 'KickStarterController@listKick');

	Route::get('/kick-list', 'KickStarterController@fullList');

	Route::get('/states','ExtraController@UsState');

	Route::get('/list/{id}', 'KickStarterController@listDetail');

	Route::post('/subscribe', 'AuthController@subscribe');

	Route::post('/contact', 'ExtraController@contact');

	Route::get('/query-list','ExtraController@getQueries');

	Route::get('/about','ExtraController@about');

	Route::get('/career','ExtraController@career');

	Route::get('/terms','ExtraController@terms');

	Route::get('/privacy','ExtraController@privacy');

	Route::get('/faq','ExtraController@faq');

	Route::get('/state','ExtraController@state');

	Route::get('/county/{name}','ExtraController@county');

	Route::get('/state-county/{id}','ExtraController@countybyStateId');

	Route::get('/city/{id}','ExtraController@UsCity');


	Route::get('/countycity/{state},{county}','ExtraController@CityByCounty');

	Route::get('/footer-news','ExtraController@getFooterContent');

	Route::get('/news/{url}','ExtraController@newsDetail');

	Route::get('/news','ExtraController@newsList');

	Route::get('/newsbycategory/{category_id}','ExtraController@newsListCatgory');

	Route::get('/trending-property','ExtraController@trendingProperties');

	Route::get('/cms','ExtraController@cms');

	Route::get('/home/{type}','ExtraController@home');

	Route::get('/teams','ExtraController@teamList');

	Route::get('/team-detail/{id}','ExtraController@teamDetail');

	Route::get('/property-image/{id}', 'ExtraController@getPropertyImage');

	Route::group(['middleware' => 'auth:api-affiliates'], function(){

		Route::get('/customer-detail/{id}','AffiliateController@customerDetail');

		Route::get('/payment-detail','AffiliateController@paymentDetail');

		Route::get('/payment-report-detail/{order_id}/{id}','AffiliateController@paymentReportDetail');

		Route::get('/commission-report','AffiliateController@commissionReport');

		Route::get('/customer-report','AffiliateController@customerReport');

		Route::get('/payment-report','AffiliateController@paymentReport');

		Route::get('/affiliate/dashboard','AffiliateController@dashboard');

		Route::get('/mapped-customers','AffiliateController@prospectCustomerList');

		Route::get('/affiliate-profile','AffiliateController@profile');

		Route::post('/affiliate-profile','AffiliateController@updateProfile');

	});


	Route::group(['middleware' => 'auth:api'], function(){

        Route::get('/past-active-reminders','PropertiesController@pastActiveReminders');

        Route::post('/reminder-detail','PropertiesController@reminderDetail');

        Route::post('/remindersbypid','PropertiesController@remindersByPropertyId');

        Route::post('/edit-reminder','PropertiesController@updateReminders');

        Route::post('/delete-reminder','PropertiesController@deleteReminders');

        Route::post('/dismiss-reminder','PropertiesController@dismissReminders');

		Route::post('/reminder','PropertiesController@saveReminders');

		Route::get('/reminders-list','PropertiesController@listReminders');

		Route::post('/datafinder-property-detail-data','DataFinderController@getDatafinderData');

		Route::post('/update-market-data','PropertiesController@PropertiesUpdateMarketData');

		Route::get('/get-imported-record-demograph-data/{id}','UserUplodedDataController@getRecordsDemographData');

		Route::post('/get-record-detail','UserUplodedDataController@RecordDetail');

		Route::post('/rename-group-name','UserUplodedDataController@RenameGroupName');

		Route::post('/get-uploaded-data-by-group','UserUplodedDataController@DataByGroupId');

		Route::get('/default-excel-template','UserUplodedDataController@defaultExcelTemplate');

		Route::get('/get-users-uploaded-group','UserUplodedDataController@UplodedGroupList');

		Route::post('/get-users-uploaded-group-records','UserUplodedDataController@UplodedDataByGroup');

		Route::post('/users-uploaded-records','UserUplodedDataController@UplodedDataList');

		Route::post('/upload-user-data','UserUplodedDataController@ImportUserData');

		Route::get('/demograph-data/{PropertyId}','DataFinderController@getDemographData');

		Route::post('/all-group-properties','PropertiesController@allGroupUserProperties');

		Route::post('/pending-properties','PropertiesController@pendingGroupProperties');

		Route::post('/marketing-found-data','MarketingController@marketingDataFound');

		Route::get('/postcard-designs-detail/{id}','PostcardController@usersPostcardDesignsDetail');

		Route::get('/users-postcard-designs','PostcardController@listUsersPostcardDesigns');

		Route::post('/save-postcard-design','PostcardController@addPostcardDesign');

		Route::post('/properties-addresses','PostcardController@getAddresses');

		Route::get('/postcard-steps-data','PostcardController@getPostcardStepsData');

		Route::post('/check-purchasegroupname-duplicate','ExtraController@duplicatePurchasegroup');

		Route::post('/batch-payment', 'BatchProcessing@batchPayment');

		Route::post('/batch-payment-details', 'BatchProcessing@batchPaymentDetails');

		Route::post('/batch-process-email', 'BatchProcessing@massGetEmail');

		Route::post('/batch-process-phone', 'BatchProcessing@massGetPhone');

		Route::post('/batch-properties', 'BatchProcessing@viewBatchProperties');

		Route::get('/batch-progress', 'BatchProcessing@batchProgress');

		Route::post('/accept-terms', 'ExtraController@updateUserTermsStatus');

		Route::post('/accept-privacy-policy', 'ExtraController@updateUserPrivacyPolicyStatus');

		Route::get('/terms-updated-popup', 'ExtraController@termsUpdatedNotification');

		Route::get('/privacy-policy-updated-popup', 'ExtraController@privacyPolicyUpdatedNotification');

		Route::post('/add-property-opportunity-status', 'PropertiesController@SaveOpportunityStatus');

		Route::get('/all-cards', 'CustomerCardController@getAllCards');

		Route::post('/create-card', 'CustomerCardController@createNewCard');

		Route::post('/set-default-card', 'CustomerCardController@setDefaultcard');

		Route::post('/delete-card', 'CustomerCardController@deleteCard');

		Route::post('/wallet-recharge', 'CustomerCardController@walletRecharge');

		Route::get('/postcard-prospects', 'PostcardController@postcardProspectsList');

		Route::post('/test-email', 'SendGridEmailController@depositFunds');

		Route::get('/postcard-prospects', 'PostcardController@postcardProspectsList');

		Route::post('/test-email', 'SendGridEmailController@sendTestEmail');

		Route::post('/send-postcard-old', 'PostcardController@sendPostcardOld');

		Route::get('/get-postcards', 'PostcardController@getUserPostcard');

		Route::post('/save-postcard', 'PostcardController@savePostcard');

		Route::post('/send-postcard', 'PostcardController@sendPostcard');

		Route::post('/postcard-preview', 'PostcardController@postcardPreview');

		Route::get('/handwriting-styles', 'PostcardController@getHandWritingStyles');

		Route::get('/image-templates', 'PostcardController@getImageTemplates');

		Route::post('/sendgrid-test', 'SendGridEmailController@helloEmail');

		Route::post('/save-postcard-template', 'PostcardController@saveUserPostcardTemplate');

		Route::get('/list-postcard-templates', 'PostcardController@getUserPostcardTemplate');

		Route::post('/save-email-template', 'EmailTemplateController@saveUserEmailTemplate');

		Route::get('/list-email-templates', 'EmailTemplateController@getUserEmailTemplate');

		Route::post('/send-sms', 'WebhookController@sendSms');

		Route::get('/sms-list', 'WebhookController@getSms');

		Route::post('/send-email', 'SendGridEmailController@sendEmailProspects');

		Route::post('/get-prospects-email', 'DataFinderController@getProspectsEmail');

		Route::post('/get-prospects-phone', 'DataFinderController@getProspectsPhone');

		Route::get('/get-email-content', 'SendGridEmailController@getUserEmailContent');

		Route::get('/email-content-detail/{id}', 'SendGridEmailController@getUserEmailContentDetail');

		Route::get('/saved-prospects-email', 'ExtraController@prospectsWithEmailData');

		Route::get('/saved-prospects-phone', 'ExtraController@prospectsWithPhoneData');


		Route::post('/grid-save-hot-prospects', 'PropertiesController@hotProspectsSaveGrid');

		Route::post('/grid-save-warm-prospects', 'PropertiesController@warmProspectsSaveGrid');

		Route::get('/grid-list/{type}', 'PropertiesController@propertiesGridList');

		Route::post('/save_grid', 'PropertiesController@saveGridLog');


		Route::get('/contact-logs/{property_id}', 'ExtraController@contactLogList');

		Route::post('/add-contact-logs', 'ExtraController@saveContactLog');

		Route::post('/customer-reset-password', 'AuthController@customerResetPassword');

		Route::get('/list-login/{id}', 'KickStarterController@listDetail');

		Route::get('/list-login', 'KickStarterController@listKick');

		Route::get('/kick-list-login', 'KickStarterController@fullList');

		Route::get('/kick-map-savesearch', 'KickStarterController@mapKickSavedSearch');

		Route::post('/register', 'AuthController@register');

		Route::post('/deposite', 'PaymentController@deposite');

		Route::post('/property-deposite', 'PaymentController@depositeProperty');

		Route::post('/report-deposite', 'PaymentController@depositeReport');

		Route::get('/wallet', 'PaymentController@wallet');

		Route::post('/update-wallet', 'PaymentController@walletUpdate');

		Route::get('/search-page', 'PaymentController@search');

		Route::post('/search', 'AdvanceSearchController@search');

		Route::post('/action', 'ExtraController@action');

		Route::get('/search-detail/{uid}', 'ExtraController@detail');

		Route::post('/get-count','AdvanceSearchController@getCount');

		Route::post('/get-result','AdvanceSearchController@getResult');

		Route::get('/get-purchase-group','ExtraController@getPurchaseGroup');

		Route::post('/rename-purchase-group','ExtraController@renamePurchaseGroup');

		Route::post('/rename-saved-search-title','ExtraController@renameSavedSearchTitle');

		Route::get('/get-leads','ExtraController@getLeads');

		Route::post('/get-purchase-leads','ExtraController@getLeadsByGroupname');

		Route::get('/get-all-purchase-leads/{groupname}','ExtraController@getAllLeadsByGroupname');

		Route::post('/push-trash','ExtraController@pushTrash');


		Route::post('/delete-permanent','ExtraController@deletePermanent');

		Route::get('/get-trash','ExtraController@getTrash');

		Route::post('/pull-trash','ExtraController@pullTrash');

		Route::get('/profile','ExtraController@profile');

		Route::post('/profile','ExtraController@updateProfile');

		Route::post('/cancel-membership-request','MembershipController@SaveCancelMembershipRequest');

		Route::get('/cancel-membership','MembershipController@CancelMembership');

		Route::get('/payment-page','PaymentController@paymentPage');

		Route::post('/buy-membership','PaymentController@buyMembership');

		Route::get('/membership-page','PaymentController@membershipPage');

		Route::post('/interested-property','ExtraController@interestedProperty');
		Route::get('/all-interested-property','ExtraController@interestedPropertyAll');

		Route::post('/highly-interested-property','ExtraController@highlyInterestedProperty');
		Route::get('/all-highly-interested-property','ExtraController@highlyInterestedPropertyAll');

		Route::post('/interested-remove','ExtraController@removeIntrested');

		Route::post('/save-search','ExtraController@saveSearch');

		Route::get('/saved-search','ExtraController@savedSearch');

		Route::get('/saved-search/{id}','ExtraController@savedSearchUser');

		Route::post('/report','ReportController@reportDown');

		Route::post('/report-status', 'ReportController@checkReportStatus');

		Route::get('/property-detail/{id}','ReportController@propertyDetail');

		Route::get('/records','ReportController@getReports');

		Route::post('/note','ExtraController@note');

		Route::get('/dashboard','ExtraController@dashboard');

		Route::post('/save-like','KickStarterController@like');

		Route::get('/purchased-records', 'ExtraController@getPurchaseRecords');
	});

});
