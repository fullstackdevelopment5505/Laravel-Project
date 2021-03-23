<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\ApiMode;
use App\PropertyDetail;
use App\Model\PropertyComparable;
use App\Model\DataTree;

use GuzzleHttp\Client;
use SnappyPDF;

use App\Traits\SaveDataTreeReportData;

class DownloadReportController extends Controller
{
    use SaveDataTreeReportData;

    public function __construct()
    {
        $this->initConfig();
    }

    public function salesComparables($propertyId)
    {
        $reportData = PropertyComparable::where('property_id', $propertyId)->first();

        if (!$reportData) {
            $this->getReportDataFromDataTreeAPI($propertyId);

            $reportData = PropertyComparable::where('property_id', $propertyId)->first();
        }

        $dataTreeData = DataTree::where('PropertyId', '=', $propertyId)->first();

        $dataTreeData = json_decode($dataTreeData);

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

        // return view('pdfs.sales-comparables.index', compact('reportData', 'propertyData', 'mapLatLong', 'landUserArray', 'mortgageType', 'dataTreeData'));

        $pdf = SnappyPDF::loadView('pdfs.sales-comparables.index', compact('reportData', 'propertyData', 'mapLatLong', 'landUserArray'));
        $pdf->setOption('header-html', url('/reports/sales-comparables/header/'.base64_encode(json_encode($headerInfo))));
        $pdf->setOption('footer-html', url('/reports/sales-comparables/footer'));

        return $pdf->download('sales-comparables-'.$propertyId.'.pdf');

    }

    public function salesComparablesHeader($header)
    {
        $headerInfo = json_decode(base64_decode($header), true);

        return view('pdfs.sales-comparables.header', compact('headerInfo'));
    }

    public function salesComparablesFooter()
    {
        return view('pdfs.sales-comparables.footer');
    }

    public function propertyDetailReport($propertyId)
    {
        $reportData = $this->getPropertyDetailData($propertyId);
        //
        // $pdf = SnappyPDF::loadView('pdfs.property-detail-report.index', compact('reportData'));
        // $pdf->setOption('header-html', url('/reports/property-detail-report/header/'.$propertyId));
        // $pdf->setOption('footer-html', url('/reports/property-detail-report/footer'));
        //
        // return $pdf->download('property-details.pdf');

        return view('pdfs.property-detail-report.index', compact('reportData'));
    }

    public function propertyDetailReportHeader(Request $request, $propertyId)
    {
        // $headerInfo = $request->only('address', 'apn');
        $reportData = $this->getPropertyDetailData($propertyId);
        $address = ($reportData->property_address->StreetAddress ?? '') . ', '. ($reportData->property_address->City ?? '') . ', ' . ($reportData->property_address->State ?? '') .' '. ($reportData->property_address->Zip9 ?? '');
        $apn = $reportData->property_address->APN ?? '';
        $county = $reportData->property_address->County ?? '';

        $headerInfo = [
            'address' => $address,
            'apn' => $apn,
            'county' => $county,
        ];

        return view('pdfs.property-detail-report.header', compact('headerInfo'));
    }

    public function propertyDetailReportFooter()
    {
        return view('pdfs.property-detail-report.footer');
    }

    private function getPropertyDetailData($propertyId)
    {
        $reportData = PropertyDetail::where('property_id', $propertyId)->first();

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
}
