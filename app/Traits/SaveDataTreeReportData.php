<?php
namespace App\Traits;

use App\Model\ApiMode;
use GuzzleHttp\Client;
use App\Model\PropertyComparable;

/**
 * Save DataTree report data in tables
 */
trait SaveDataTreeReportData
{

    private $dtapi_username, $dtapi_password, $dtapi_login_url, $report_download_url, $property_count_url, $property_list_url;

    public function initConfig()
    {
        $data = ApiMode::where('api_name','datatree')->first();
        $this->dtapi_username      = env('DTAPI_TEST_AUTHENTICATE_USERNAME');
        $this->dtapi_password      = env('DTAPI_TEST_AUTHENTICATE_PASSWORD');
        $this->dtapi_login_url     = env('DTAPI_TEST_AUTHENTICATE_URL');
        $this->report_download_url = env('DTAPI_TEST_REPORT_DOWNLOAD_URL');
        $this->property_count_url  = env('DTAPI_TEST_PROPERTY_COUNT_URL');
        $this->property_list_url   = env('DTAPI_TEST_PROPERTY_LIST_URL');

        if (isset($data) && $data->mode == 1) {
            $this->dtapi_username      = env('DTAPI_LIVE_AUTHENTICATE_USERNAME');
            $this->dtapi_password      = env('DTAPI_LIVE_AUTHENTICATE_PASSWORD');
            $this->dtapi_login_url     = env('DTAPI_LIVE_AUTHENTICATE_URL');
            $this->report_download_url = env('DTAPI_LIVE_REPORT_DOWNLOAD_URL');
            $this->property_count_url  = env('DTAPI_LIVE_PROPERTY_COUNT_URL');
            $this->property_list_url   = env('DTAPI_LIVE_PROPERTY_LIST_URL');
        }
    }


    public function getReportDataFromDataTreeAPI($propertyId)
    {
        $reportType = ['SalesComparables'];

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


            $report = $result->Reports[0];

            if ($report->ReportStatus!="NotAvailable") {
                $data = $report->Data;
                $detail_array = json_decode(json_encode($data), true);
                
                $filters = array (
                  'MonthsBack'               => $detail_array["Filters"]["MonthsBack"],
                  'DistanceFromSubjectMiles' => $detail_array["Filters"]["DistanceFromSubject"]["DistanceFromSubjectMiles"],
                  'LivingAreaDifference'     => $detail_array["Filters"]["LivingAreaDifference"],
                  'LandUse'                  => $detail_array["Filters"]["LandUse"],
                  'UnitsCommercial'          => $detail_array["Filters"]["UnitsCommercial"],
                  'UnitsResidential'         => $detail_array["Filters"]["UnitsResidential"],
                );

                $detail = array (
                    'property_id'                   => $report->PropertyId,
                    'property_report_status'        => $report->ReportStatus,
                    'comparable_properties'         => json_encode($detail_array["ComparableProperties"]),
                    'comparable_properties_summary' => json_encode($detail_array["ComparablePropertiesSummary"]),
                    'subject_property'              => json_encode($detail_array["SubjectProperty"]),
                    'filters'                       => json_encode($filters),
                );

                PropertyComparable::updateOrCreate(['property_id' => $propertyId], $detail);
            }

        } catch (\Exception $e) {
          //
        }

    }


}
