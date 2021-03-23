<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\MainController;
use Illuminate\Http\Request;
use Excel;
use App\User;
use App\Model\UserProperty;
use Validator, Response, DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Model\Image;
use App\Model\Deposite;
use App\Model\Saved;
use App\Model\Points;
use App\Model\Report;
use App\PropertyDetail;
use App\Model\DataTree;
use App\Traits\SaveDataTreeReportData;
use App\Configuration;
use App\Model\PaymentMaster;
use App\Model\ApiMode;
use SnappyPDF, Storage;
use App\Model\PropertyComparable;
use Barryvdh\DomPDF\Facade as PDF;

class ReportController extends MainController
{
	use SaveDataTreeReportData;
	private $dtapi_username,$dtapi_password,$dtapi_login_url,$report_download_url;

	public function __construct()
	{
		$data = ApiMode::where('api_name','datatree')->first();
		$this->dtapi_username       = env('DTAPI_TEST_AUTHENTICATE_USERNAME');
		$this->dtapi_password       = env('DTAPI_TEST_AUTHENTICATE_PASSWORD');
		$this->dtapi_login_url      = env('DTAPI_TEST_AUTHENTICATE_URL');
		$this->report_download_url  = env('DTAPI_TEST_REPORT_DOWNLOAD_URL');
		if ( isset($data) && $data->mode == 1) {
			$this->dtapi_username       = env('DTAPI_LIVE_AUTHENTICATE_USERNAME');
			$this->dtapi_password       = env('DTAPI_LIVE_AUTHENTICATE_PASSWORD');
			$this->dtapi_login_url      = env('DTAPI_LIVE_AUTHENTICATE_URL');
			$this->report_download_url  = env('DTAPI_LIVE_REPORT_DOWNLOAD_URL');
		}
	}

	public function checkReportStatus(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'property_id'   => 'required',
			'property_type' => 'required'
		]);

		if ($validator->fails()) {
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		}
		$fileType = "";
		$viewType = "";
		switch ($request->get('property_type')) {
			case '1':
			$fileType = 'ForeclosureReport';
			$viewType = 'foreclosure';
			break;
			case '2':
			$fileType = 'OpenLienReport';
			$viewType = 'openReport';
			break;
			case '3':
			$fileType = 'PropertyDetailReport';
			$viewType = 'propertyDetail';
			break;
			case '4':
			$fileType = 'TaxStatusReport';
			$viewType = 'taxReport';
			break;
			case '5':
			$fileType = 'SalesComparableReport';
			$viewType = 'salesComparable';
			break;
			default:
			# code...
			break;
		}

		$userProperty = UserProperty::select('user_property.*')->where([['user_id',Auth::id()],['datatree.PropertyId',$request->get('property_id')]])->join('datatree','datatree.id','=','user_property.property_id')->first();
		//return $this->getResponse(200,'Response',$userProperty);
		$object = $request->get('property_type') == 1? 'for_closue_status' : ($request->get('property_type') == 2? 'open_lien_status' : ($request->get('property_type') == 3? 'property_detail_status' : ($request->get('property_type') == 4? 'tax_status_status' : 'sales_comparable_status')));
		$link 	= $request->get('property_type') == 1? 'forclosue' : ($request->get('property_type') == 2? 'openlien' : ($request->get('property_type') == 3? 'propertydetail' : ($request->get('property_type') == 4? 'taxstatus' : 'sales_comparable')));

		if (isset($userProperty->{$object}) && $userProperty->{$object} == '1') {
			$res = (Object)array(
			"url" => $userProperty->{$link}
			);
			return $this->getResponse(200,'Response',$res);
		}

		$reportType = array (
		$fileType
		);

		$data = array (
		"ProductNames" => $reportType,
		"SearchType"	 => "PROPERTY",
		"PropertyId"	 => intVal($request->get('property_id')),
		"ReferenceId"	 => "ABC"
		);

		$client = new Client([
		'headers' 		 => [
		'Content-Type' => 'application/json',
		]]);
		$auth = array(
		'Username' => $this->dtapi_username,
		'Password' => $this->dtapi_password
		);

		$response = $client->post($this->dtapi_login_url,['body' => json_encode($auth)]);
		$token = $response->getBody()->getContents();
		$token = trim($token,'"');
		// dd($request->all());
		// die();
		$clients = new Client([
		'headers' 			=> [
		'Content-Type'	=> 'application/json',
		'Authorization'	=> $token
		]
		]); //GuzzleHttp\Client

		$responses = $clients->post($this->report_download_url,['body' => json_encode($data)]);
		$result = json_decode($responses->getBody()->getContents());
		/*   echo "<pre>"; print_r($result); die; */
		$data = json_decode(json_encode($result), true);
		$dataArr = $data["Reports"][0];
		//return $this->getResponse(200,'status',$result->Reports[0]->ReportStatus);
		$status = 1;
		if($result->Reports[0]->ReportStatus == 'NotAvailable'){
			$status = 0;
		}
		return $this->getResponse(200,'report status',$data,$status);
	}

	public function reportDown(Request $request)
	{
		$validator = Validator::make($request->all(), [
		'property_id'   => 'required',
		'property_type' => 'required'
		]);

		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		}

		$fileType = "";
		$viewType = "";
		switch ($request->get('property_type')) {
			case '1':
			$fileType = 'ForeclosureReport';
			$viewType = 'foreclosure';
			break;
			case '2':
			$fileType = 'OpenLienReport';
			$viewType = 'openReport';
			break;
			case '3':
			$fileType = 'PropertyDetailReport';
			$viewType = 'propertyDetail';
			break;
			case '4':
			$fileType = 'TaxStatusReport';
			$viewType = 'taxReport';
			break;
			case '5':
			$this->salesComparables(intVal($request->get('property_id')));
			break;
			default:
			# code...
			break;
		}

		$userProperty = UserProperty::select('user_property.*')->where([['user_id',Auth::id()],['datatree.PropertyId',$request->get('property_id')]])->join('datatree','datatree.id','=','user_property.property_id')->first();
		//return $this->getResponse(200,'Response',$userProperty);
		$object = $request->get('property_type') == 1? 'for_closue_status' : ($request->get('property_type') == 2? 'open_lien_status' : ($request->get('property_type') == 3? 'property_detail_status' : ($request->get('property_type') == 4? 'tax_status_status' : 'sales_comparable_status')));
		$link = $request->get('property_type') == 1? 'forclosue' : ($request->get('property_type') == 2? 'openlien' : ($request->get('property_type') == 3? 'propertydetail' : ($request->get('property_type') == 4? 'taxstatus' : 'sales_comparable')));

		if ($userProperty->{$object} == '1') {
			$res = (Object)array(
			"url"=>url($userProperty->{$link})
			);

			return $this->getResponse(200,'Response',$res);
		}

		$reportType = array(
		$fileType
		);

		$data = array(
		"ProductNames" => $reportType,
		"SearchType"	 => "PROPERTY",
		"PropertyId"	 => intVal($request->get('property_id')),
		"ReferenceId"	 => "ABC"
		);

		$client = new Client(['headers' => [
		'Content-Type' => 'application/json',
		]]);

		$auth = array(
		'Username' => $this->dtapi_username,
		'Password' => $this->dtapi_password
		);

		$response = $client->post($this->dtapi_login_url,['body' => json_encode($auth)]);
		$token = $response->getBody()->getContents();
		$token = trim($token,'"');
		// dd($request->all());
		// die();
		$clients = new Client([
		'headers' => [
		'Content-Type' => 'application/json',
		'Authorization'=> $token
		]
		]); //GuzzleHttp\Client

		$responses = $clients->post($this->report_download_url,['body' => json_encode($data)]);
		$result = json_decode($responses->getBody()->getContents());

		$data = json_decode(json_encode($result), true);
		$dataArr = $data["Reports"][0];

		if ($result->Reports[0]->ReportStatus!="NotAvailable") {
			$report =	Configuration::where('type','property_report_price')->first();
			$download_report_price = isset($report->price) ? $report->price : '';

			$pointRate = DB::table('tbl_static')->select('point_per_dollar')->first();

			$pointData = array (
			'point'		=>	$download_report_price*$pointRate->point_per_dollar,
			'amount'	=>	$download_report_price,
			'user_id'	=>	Auth::id(),
			'type'		=>	'2',
			'transaction_detail'=>'Property Report Purchase',
			);

			$point = Points::create($pointData);
			/* add data in payment */
			$payment = array (
			'user_id'						=>	Auth::id(),
			'point_id'					=>	$point->id,
			'payment_type'			=>	'2',
			'amount'						=>	$download_report_price, //add amount in dollar
			'total_records'			=>	1,
			'payment_type_text'	=>	$fileType.' report download'
			);

			PaymentMaster::create($payment);

			$reportData = array (
			'point_id'			=>	$point->id,
			'user_id'			=>	Auth::id(),
			'report_type'		=>	$request->get('property_type'),
			'report_name'		=>	$fileType,
			'user_prop_id'		=>	$userProperty->id,
			'property_id'		=>	$request->get('property_id')
			);

			Report::create($reportData);

			$file		= uniqid().time().'.pdf';
			$file1		= uniqid().time().'.xlsx';
			$filePath	= 'reports/'.$file;
			$reportPath	= '';

			if ($request->get('property_type') == 3) {
				$reportData = $this->getPropertyDetailData($request->get('property_id'));
				$pdf = SnappyPDF::loadView('pdfs.property-detail-report.index', compact('reportData'));
				$pdf->setOption('header-html', url('/reports/property-detail-report/header/'.$request->get('property_id')));
				$pdf->setOption('footer-html', url('/reports/property-detail-report/footer'));
				$content	= $pdf->download()->getOriginalContent();
				$reportPath	= $this->saveReportToStorage($filePath, $content);
			} else {
				$pdf = PDF::setOptions([
				  'logOutputFile'	=> storage_path('logs/log.htm'),
				  'tempDir'			=> storage_path('logs/')
				])->loadView('Reports.'.$viewType, compact('result'));

				$content	= $pdf->download()->getOriginalContent();
				$reportPath	= $this->saveReportToStorage($filePath, $content);
			}

			UserProperty::where([['user_id', Auth::id()],['id', $userProperty->id]])->update([$object => '1', $link => $reportPath]);

			$userProper = UserProperty::where([['user_id', Auth::id()], ['datatree.PropertyId', $request->get('property_id')]])->join('datatree', 'datatree.id', '=', 'user_property.property_id')->first();

			$res = (Object)array(
				"url" => $userProper->{$link}
			);

			return $this->getResponse(200,'Response',$res);
		}
		else {
			return $this->getResponse(422,'We are having some issues in finding your report now. Please check back after some time.');
		}
	}

	public function salesComparables($propertyId)
	{
			$reportData = PropertyComparable::where('property_id', $propertyId)->first();

			if (!$reportData) {
					$this->getReportDataFromDataTreeAPI($propertyId);

					$reportData = PropertyComparable::where('property_id', $propertyId)->first();
			}

			$userProperty = UserProperty::select('user_property.*')->where([['user_id',Auth::id()],['datatree.PropertyId',$propertyId]])->join('datatree','datatree.id','=','user_property.property_id')->first();
			//return $this->getResponse(200,'Response',$userProperty);
			$object =  'sales_comparable_status';
			$link 	=  'sales_comparable';

			if ($userProperty->{$object} == '1') {
					$res = (Object)array(
							"url"=> $userProperty->{$link}
					);

					return $this->getResponse(200,'Response',$res);
			}

			// $dataTreeData = DataTree::where('PropertyId', '=', $propertyId)->first();
			//
			// $dataTreeData = json_decode($dataTreeData);

			$mapLatLong = [];

			foreach (json_decode($reportData->comparable_properties) as $value) {
					$mapLatLong[] = [
						'lat'  => $value->LocationInformation->Latitude,
						'long' => $value->LocationInformation->Longitude
					];
			}

			$reportData = (object) [
					'property_id'                   => $reportData->property_id,
					'property_report_status'        => $reportData->property_report_status,
					'comparable_properties'         => json_decode($reportData->comparable_properties),
					'comparable_properties_summary' => json_decode($reportData->comparable_properties_summary),
					'subject_property'              => json_decode($reportData->subject_property),
					'filters'                       => json_decode($reportData->filters),
			];

			$propertyData = $reportData->subject_property;

			$address = ($reportData->subject_property->SitusAddress->StreetAddress ? ucwords(strtolower($reportData->subject_property->SitusAddress->StreetAddress)) : '') . ', '. ($reportData->subject_property->SitusAddress->City ? ucwords(strtolower($reportData->subject_property->SitusAddress->City)) : '') . ', '. ($reportData->subject_property->SitusAddress->State ?? '') . ' '. ($reportData->subject_property->SitusAddress->Zip9 ?? '');
			$apn     =  $reportData->subject_property->LocationInformation->APN ?? '';
			$county  = $reportData->subject_property->SitusAddress->County ? ucwords(strtolower($reportData->subject_property->SitusAddress->County)) : '';

			$headerInfo = [
					'address' => $address,
					'apn'     => $apn,
					'county'  => $county,
			];

			$configs = json_decode(file_get_contents(config_path('filters-config.json')));

			$landUserArray = [];

			foreach ($configs->landUse ?? [] as $luse) {
					$landUserArray[$luse->val] = $luse->text;
			}

			$mortgageType = [];

			foreach ($configs->mortgageType ?? [] as $value) {
					$mortgageType[$value->val] = $value->text;
			}

			// return view('pdfs.sales-comparables.index', compact('reportData', 'propertyData', 'mapLatLong', 'landUserArray', 'mortgageType'));

			$pdf = SnappyPDF::loadView('pdfs.sales-comparables.index', compact('reportData', 'propertyData', 'mapLatLong', 'landUserArray', 'mortgageType'));
			$pdf->setOption('header-html', url('/reports/sales-comparables/header/'.base64_encode(json_encode($headerInfo))));
			$pdf->setOption('footer-html', url('/reports/sales-comparables/footer'));

			// return $pdf->download('sales-comparables-'.$propertyId.'.pdf');

			$pdf->save(public_path('reports/').'sales-comparables-'.$propertyId.'.pdf');

			// $pdf->stream('download.pdf');
			//dd($pdf);

			UserProperty::where([['user_id',Auth::id()],['id',$userProperty->id]])->update([$object=>'1',$link=>'reports/sales-comparables-'.$propertyId.'.pdf']);

			$userProper = UserProperty::where([['user_id',Auth::id()],['datatree.PropertyId',$propertyId]])->join('datatree','datatree.id','=','user_property.property_id')->first();

			$res = (Object)array(
					"url" => $userProper->{$link}
			);
			// echo "<pre>"; print_r('asd'); die;

			return $this->getResponse(200,'Response',$res);

	}

	public function propertyDetail($propertyId)
	{
		$property_exists = DataTree::where('PropertyId',$propertyId)->first();

		if ($property_exists) {
			$reportType = array('PropertyDetailReport');

			$data = array (
			"ProductNames"	=> $reportType,
			"SearchType"		=> "PROPERTY",
			"PropertyId"		=> intVal($propertyId),
			"ReferenceId"		=> "ABC"
			);

			$client = new Client([
			'headers'			 => [
			'Content-Type' => 'application/json',
			]]);

			$auth	=	array (
			'Username' =>	$this->dtapi_username,
			'Password' =>	$this->dtapi_password
			);

			$response	=	$client->post($this->dtapi_login_url,['body' => json_encode($auth)]);
			$token		=	$response->getBody()->getContents();
			$token		=	trim($token,'"');
			// dd($request->all());
			// die();
			$clients = new Client([
			'headers' => [
			'Content-Type'	=> 'application/json',
			'Authorization'	=> $token
			]
			]); //GuzzleHttp\Client

			try {
				$responses	=	$clients->post($this->report_download_url,['body' => json_encode($data)]);
				$result			=	json_decode($responses->getBody()->getContents());

				if ($result->Reports[0]->ReportStatus!="NotAvailable") {
					$data = $result->Reports[0]->Data;
					$detail_array = json_decode(json_encode($data), true);
					$dataP = PropertyDetail::where('property_id', $detail_array["SubjectProperty"]["PropertyId"] ?? $detail_array["PropertyId"])
					->whereNotNull('location_information')->whereNotNull('property_address')->first();

					if ($dataP) {
						$location = json_decode($dataP['location_information']);
						$address = json_decode($dataP['property_address']);
						$data_r = [];
						$data_r['property_id']	 		 = $dataP['property_id'];
						$data_r['Latitude']			 		 = $location->Latitude;
						$data_r['Longitude']		 		 = $location->Longitude;
						$data_r['City']					 		 = $address->City;
						$data_r['State']				 		 = $address->State;
						$data_r['Zip9']						   = $address->Zip9 ?? $address->Zip;
						$data_r['County']						 = $address->County;
						$data_r['StreetAddress']		 = $address->AddressLine1 ?? $address->streetAddress;
						$data_r['SitusCarrierRoute'] = $address->SitusCarrierRoute;

						if ($data_r) {
							return $this->getResponse(200,'Property Detail',$data_r);
						}
					}

					$detail = array (
					'property_id' 								 => $detail_array["SubjectProperty"]["PropertyId"] ?? $detail_array["PropertyId"],
					'property_report_status'			 =>	$result->Reports[0]->ReportStatus,
					'property_address'						 =>	json_encode($detail_array["SubjectProperty"]["SitusAddress"]),
					'owner_information'						 =>	json_encode($detail_array["OwnerInformation"]),
					'location_information'				 =>	json_encode($detail_array["LocationInformation"]),
					'site_information'						 =>	json_encode($detail_array["SiteInformation"]),
					'property_characteristics'	   =>	json_encode($detail_array["PropertyCharacteristics"]),
					'tax_information'							 =>	json_encode($detail_array["TaxInformation"]),
					'county_recording_history'		 =>	json_encode($detail_array["CountyRecordingHistory"]),
					'owner_transfer_information'	 =>	json_encode($detail_array["OwnerTransferInformation"]),
					'last_market_sale_information' =>	json_encode($detail_array["LastMarketSaleInformation"]),
					'prior_sale_information'			 =>	json_encode($detail_array["PriorSaleInformation"]),
					);
					//dd($data); die;
					PropertyDetail::updateOrCreate(['property_id' => $propertyId], $detail);

					$dataP = PropertyDetail::where('property_id',$detail_array["SubjectProperty"]["PropertyId"] ?? $detail_array["PropertyId"])->first();
					$location = json_decode($dataP['location_information']);
					$address = json_decode($dataP['property_address']);
					$data_r = [];
					$data_r['property_id'] 			 = $dataP['property_id'];
					$data_r['Latitude'] 				 = $location->Latitude;
					$data_r['Longitude'] 				 = $location->Longitude;
					$data_r['City'] 						 = $address->City;
					$data_r['State'] 						 = $address->State;
					$data_r['Zip9'] 						 = $address->Zip9 ?? $address->Zip;
					$data_r['County'] 					 = $address->County;
					$data_r['StreetAddress'] 		 = $address->StreetAddress ?? $address->streetAddress;
					$data_r['SitusCarrierRoute'] = $address->SitusCarrierRoute;

					return $this->getResponse(200,'Property Detail',$data_r);
				}
				else {
					//$data = PropertyDetail::where('property_id',$detail_array["SubjectProperty"]["PropertyId"])->first();
					//echo "<pre>"; print_r($result); ;
					$detail = array(
					'property_id' 						=> 	$result->Reports[0]->PropertyId,
					'property_report_status'	=>	$result->Reports[0]->ReportStatus,);

					$updated = PropertyDetail::updateOrCreate(['property_id' => $result->Reports[0]->PropertyId],$detail);

					$data = DataTree::select('PropertyId as property_id','Latitude','Longitude','SitusCity as City','SitusState as State','SitusZip9 as Zip9','County',DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as StreetAddress'),'SitusCarrierCode as SitusCarrierRoute')->where('PropertyId',$result->Reports[0]->PropertyId)->first();

					return $this->getResponse(200,'Property Detail',$data);
				}
			}
			catch (\Exception $e) {
				$detail = array(
				'property_id' 						=> 	$propertyId,
				'property_report_status'	=>	'NotAvailable',
				);

				$updated = PropertyDetail::updateOrCreate(['property_id' => $propertyId],$detail);

				$data = DataTree::select('PropertyId as property_id','Latitude','Longitude','SitusCity as City','SitusState as State','SitusZip9 as Zip9','County',DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as StreetAddress'),'SitusCarrierCode as SitusCarrierRoute')->where('PropertyId',$propertyId)->first();

				return $this->getResponse(200,'Property Detail',$data);
			}
		}
		else {
			return $this->getResponse(422,'We are having some issues in finding your report now. Please check back after some time.');
		}
	}


	public function getReports(Request $request)
	{
		$data = Report::select('tbl_purchased_records.*','points_transaction.point')->where('tbl_purchased_records.user_id',Auth::id())->join('points_transaction','points_transaction.id','=','tbl_purchased_records.point_id')->orderBy('tbl_purchased_records.id','desc')->get();
		return $this->getResponse(200,'Response',$data);
	}


	private function getPropertyDetailData($propertyId)
	{
		$reportData = PropertyDetail::where('property_id', '=', $propertyId)->first();

		if (!$reportData) {
			return [];
		}

		return (object) [
		'property_address'             => json_decode($reportData->property_address),
		'owner_information'            => json_decode($reportData->owner_information),
		'location_information'         => json_decode($reportData->location_information),
		'site_information'             => json_decode($reportData->site_information),
		'property_characteristics'     => json_decode($reportData->property_characteristics),
		'tax_information'              => json_decode($reportData->tax_information),
		'county_recording_history'     => json_decode($reportData->county_recording_history),
		'owner_transfer_information'   => json_decode($reportData->owner_transfer_information),
		'last_market_sale_information' => json_decode($reportData->last_market_sale_information),
		'prior_sale_information'       => json_decode($reportData->prior_sale_information),
		];
	}

	private function saveReportToStorage($filePath, $fileContent)
	{
		$storage = Storage::disk(env('STORAGE_DISK', 'public'));
		$storage->put($filePath, $fileContent);

		return $storage->url($filePath);
	}
}
