<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="{{ asset('/assets/pdfs/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/pdfs/sales.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/pdfs/leaflet/leaflet.css') }}">
        <script src="{{ asset('/assets/pdfs/leaflet/leaflet.js') }}"></script>
        <title>Sales Comparables</title>
    </head>
    <body>
        <div class="col-12">
            @include('pdfs.sales-comparables.property-details-table')
            <table class="col-8">
                <tr>
                    <th>Search Criteria</th>
                </tr>
                <tr>
                    <td># Months Back:</td>
                    <td>{{ $reportData->filters->MonthsBack ?? '' }}</td>
                    <td>Distance From Subject:</td>
                    <td>{{ $reportData->filters->DistanceFromSubjectMiles ? $reportData->filters->DistanceFromSubjectMiles . ' mi' : '' }}</td>
                </tr>
                <tr>
                    <td>Living Area Difference:</td>
                    <td>{{ $reportData->filters->LivingAreaDifference ? number_format($reportData->filters->LivingAreaDifference, 1) . ' + / -' : '' }}</td>
                    <td>Land Use:</td>
                    <td>
                      @foreach($reportData->filters->LandUse as $landUse)
                        {{ isset($landUserArray[$landUse]) ? $landUserArray[$landUse] : $landUse  }}
                      @endforeach
                    </td>
                </tr>
            </table>
            <br />
            <h6><strong>25 Comparable Properties Found</strong></h6>
            <table class="table border col-12">
                <tr>
                    <th colspan="5" class="text-center bg-light">COMPARABLE PROPERTY SUMMARY</th>
                </tr>
                <tr class="table-secondary">
                    <td></td>
                    <td>Subject</td>
                    <td>Low</td>
                    <td>Average</td>
                    <td>High</td>
                </tr>
                <tr>
                    <td class="table1 text-right">Price</td>
                    <td>{{ $reportData->comparable_properties_summary->SaleListedPrice->Subject ? '$'. number_format($reportData->comparable_properties_summary->SaleListedPrice->Subject) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->SaleListedPrice->Low ? '$'. number_format($reportData->comparable_properties_summary->SaleListedPrice->Low) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->SaleListedPrice->Average ? '$'. number_format($reportData->comparable_properties_summary->SaleListedPrice->Average) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->SaleListedPrice->High ? '$'. number_format($reportData->comparable_properties_summary->SaleListedPrice->High) : '' }}</td>
                </tr>
                <tr>
                    <td class="table1 text-right">Living Area</td>
                    <td>{{ $reportData->comparable_properties_summary->LivingArea->Subject ? number_format($reportData->comparable_properties_summary->LivingArea->Subject) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->LivingArea->Low ? number_format($reportData->comparable_properties_summary->LivingArea->Low) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->LivingArea->Average ? number_format($reportData->comparable_properties_summary->LivingArea->Average) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->LivingArea->High ? number_format($reportData->comparable_properties_summary->LivingArea->High) : '' }}</td>
                </tr>
                <tr>
                    <td class="table1 text-right">Price / Sq. Ft.</td>
                    <td>{{ $reportData->comparable_properties_summary->PricePerSqFt->Subject ? '$'. number_format($reportData->comparable_properties_summary->PricePerSqFt->Subject) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->PricePerSqFt->Low ? '$'. number_format($reportData->comparable_properties_summary->PricePerSqFt->Low) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->PricePerSqFt->Average ? '$'. number_format($reportData->comparable_properties_summary->PricePerSqFt->Average) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->PricePerSqFt->High ? '$'. number_format($reportData->comparable_properties_summary->PricePerSqFt->High) : '' }}</td>
                </tr>
                <tr>
                    <td class="table1 text-right">Bedrooms</td>
                    <td>{{ $reportData->comparable_properties_summary->Bedrooms->Subject ? number_format($reportData->comparable_properties_summary->Bedrooms->Subject) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->Bedrooms->Low ? number_format($reportData->comparable_properties_summary->Bedrooms->Low) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->Bedrooms->Average ? number_format($reportData->comparable_properties_summary->Bedrooms->Average) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->Bedrooms->High ? number_format($reportData->comparable_properties_summary->Bedrooms->High) : '' }}</td>
                </tr>
                <tr>
                    <td class="table1 text-right">Baths</td>
                    <td>{{ $reportData->comparable_properties_summary->Bathrooms->Subject ? number_format($reportData->comparable_properties_summary->Bathrooms->Subject) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->Bathrooms->Low ? number_format($reportData->comparable_properties_summary->Bathrooms->Low) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->Bathrooms->Average ? number_format($reportData->comparable_properties_summary->Bathrooms->Average) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->Bathrooms->High ? number_format($reportData->comparable_properties_summary->Bathrooms->High) : '' }}</td>
                </tr>
                <tr>
                    <td class="table1 text-right">Lot Area</td>
                    <td>{{ $reportData->comparable_properties_summary->LotArea->Subject ? number_format($reportData->comparable_properties_summary->LotArea->Subject) .' Sq. Ft.' : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->LotArea->Low ? number_format($reportData->comparable_properties_summary->LotArea->Low) .' Sq. Ft.' : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->LotArea->Average ? number_format($reportData->comparable_properties_summary->LotArea->Average) .' Sq. Ft.' : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->LotArea->High ? number_format($reportData->comparable_properties_summary->LotArea->High) .' Sq. Ft.' : '' }}</td>
                </tr>
                <tr>
                    <td class="table1 text-right">Stories</td>
                    <td>{{ $reportData->comparable_properties_summary->Stories->Subject ? number_format($reportData->comparable_properties_summary->Stories->Subject) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->Stories->Low ? number_format($reportData->comparable_properties_summary->Stories->Low) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->Stories->Average ? number_format($reportData->comparable_properties_summary->Stories->Average, 2) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->Stories->High ? number_format($reportData->comparable_properties_summary->Stories->High) : '' }}</td>
                </tr>
                <tr>
                    <td class="table1 text-right">Year Built</td>
                    <td>{{ $reportData->comparable_properties_summary->YearBuilt->Subject ?? '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->YearBuilt->Low ?? '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->YearBuilt->Average ? round($reportData->comparable_properties_summary->YearBuilt->Average) : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->YearBuilt->High ?? '' }}</td>
                </tr>
                <tr>
                    <td class="table1 text-right">Distance</td>
                    <td>{{ $reportData->comparable_properties_summary->DistanceFromSubject->Subject ? number_format($reportData->comparable_properties_summary->DistanceFromSubject->Subject, 2) .' mi' : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->DistanceFromSubject->Low ? number_format($reportData->comparable_properties_summary->DistanceFromSubject->Low, 2) .' mi' : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->DistanceFromSubject->Average ? number_format($reportData->comparable_properties_summary->DistanceFromSubject->Average, 2) .' mi' : '' }}</td>
                    <td>{{ $reportData->comparable_properties_summary->DistanceFromSubject->High ? number_format($reportData->comparable_properties_summary->DistanceFromSubject->High, 2) .' mi' : '' }}</td>
                </tr>
            </table>
            <div style="page-break-before: always;"></div>
            <br />
              <div style = "width: 950px; height: 500px; margin-top: 105px;">
                <div id="map" style = "width: 98%; height: 90%;"></div>
                <div class="mt-2">
                  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png" alt="" />
                  <span class="mr-3">Subject Property</span>
                  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png" alt="" />
                  <span>Comparables</span>
                </div>
              </div>
            <br />

            <table class="table border mb-0">
                <tr>
                    <th colspan="13" class="text-center bg-light">COMPARABLES</th>
                </tr>
                <tr class="table-secondary">
                    <th>#</th>
                    <th>MI</th>
                    <th>ST</th>
                    <th>Address</th>
                    <th>Sold</th>
                    <th>Sold For</th>
                    <th>Listed</th>
                    <th>Listed At</th>
                    <th>Sq.Ft.</th>
                    <th>$/Sq.Ft.</th>
                    <th>Bds/Bths</th>
                    <th>Lot Size</th>
                    <th>Age</th>
                </tr>
                @foreach($reportData->comparable_properties as $key => $report)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $report->DistanceFromSubject ? number_format($report->DistanceFromSubject, 2) : '' }}</td>
                    <td></td>
                    <td>
                        {{ $report->SitusAddress->StreetAddress ? strtolower($report->SitusAddress->StreetAddress) : '' }},
                        {{ $report->SitusAddress->City ? strtolower($report->SitusAddress->City) : '' }},
                        {{ $report->SitusAddress->State ?? '' }}
                        {{ $report->SitusAddress->Zip9 ?? '' }}
                    </td>
                    <td>{{ $report->LastMarketSaleInformation->SaleDate ? date('m/d/Y', strtotime($report->LastMarketSaleInformation->SaleDate)) : '' }}</td>
                    <td>{{ $report->LastMarketSaleInformation->SalePrice ? '$'. number_format($report->LastMarketSaleInformation->SalePrice) : '' }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $report->PropertyCharacteristics->LivingArea ? number_format($report->PropertyCharacteristics->LivingArea) : '' }}</td>
                    <td></td>
                    <td>
                        {{ $report->PropertyCharacteristics->Bedrooms ?? '' }}
                        @if($report->PropertyCharacteristics->Bedrooms || $report->PropertyCharacteristics->Baths) / @endif
                        {{ $report->PropertyCharacteristics->Baths ?? '' }}
                    </td>
                    <td>{{ $report->SiteInformation->LotArea ? number_format($report->SiteInformation->LotArea) : '' }}</td>
                    <td></td>
                </tr>
                @endforeach
            </table>

            <table class="w-50 my-1">
                <tr>
                    <td>L: Listed</td>
                    <td>R: REO</td>
                    <td>R: REO Sale</td>
                    <td>SS: Short Sale</td>
                    <td>D: Default</td>
                    <td>A: Auction</td>
                </tr>
            </table>
            <br />
            <div style="page-break-before: always;"></div>
            @foreach($reportData->comparable_properties as $key => $propertyData)
            @include('pdfs.sales-comparables.property-details-table')
            @endforeach

            <div style="page-break-before: always;"></div>
            <div class="col-12">
                <br />
                <p class="text-justify mt-7">
                    Disclaimer: This report: (i) is not an insured product or service or an abstract, legal opinion or a representation of the condition of title to real
                    property, and (ii) is issued exclusively for the benefit of First American Equity Finders LLC (Equity Finders) customers and may not be used or relied upon by
                    any other person. Estimated property values are: (i) based on available data; (ii) are not guaranteed or warranted; (iii) do not constitute an appraisal;
                    and (iv) should not be relied upon in lieu of an appraisal. Equity Finders does not represent or warrant that the information is complete or free from error,
                    and expressly disclaims any liability to any person or entity for loss or damage caused by errors or omissions in the report. If the "verified" logo
                    ( ) is displayed, or a record is designated "verified," Equity Finder's algorithm matched fields from two or more data sources to confirm source data.
                    This report is not title insurance. Pursuant to S. 627.7843, Florida statutes, the maximum liability of the issuer of this property information report for
                    errors or omissions in this property information report is limited to the amount paid for this property information report, and is further limited to the
                    person(s) expressly identified by name in the property information report as the recipient(s) of the property information report.
                </p>
            </div>
        </div>
        <input type="hidden" value="{{ json_encode($mapLatLong) }}" id="mapLatLong">
        <script type="text/javascript">
            var map = L.map('map', { zoomControl: false }).setView([{{ $reportData->subject_property->LocationInformation->Latitude }}, {{ $reportData->subject_property->LocationInformation->Longitude }}], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            var greenIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            L.marker([{{ $reportData->subject_property->LocationInformation->Latitude }}, {{ $reportData->subject_property->LocationInformation->Longitude }}], {icon: greenIcon}).addTo(map);

            var mapLatLong = document.getElementById("mapLatLong").value;

            Array.prototype.forEach.call(JSON.parse(mapLatLong), function(latLong, key) {
                var marker =  '<div class="marker">';
                    marker += '<img class="marker" src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png"/>';
                    marker += '<span class="marker-label">'+ (++key) +'</span>';
                    marker += '</div>';

                L.marker([latLong['lat'], latLong['long']], {
                        icon: new L.DivIcon({
                        className: 'my-div-icon',
                        html: marker
                    })
                }).addTo(map);
            });

            // document.getElementsByClassName( 'leaflet-control-attribution' )[0].style.display = 'none';
        </script>
    </body>
</html>
