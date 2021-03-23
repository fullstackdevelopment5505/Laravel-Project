<!DOCTYPE html>
<html lang="en">

<head>
	<title>Equity Reports</title>
	<meta name="keywords" content="Equity Reports">
	<meta name="description" content="Equity Reports">
	<meta charset="UTF-8">
	<meta name="author" content="Equity Reports">
	<meta name="viewport" content="width=device-width, initial-sTcale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>
		/** 
		Set the margins of the page to 0, so the footer and the header
		can be of the full height and width !
		**/
		@page {
		margin: 0cm 0cm;
		}
		
		/* Define now the real margins of every page in the PDF */
		body {
		margin:1cm 0;
		padding: 10px;
		font-size:14px;
		}
		
		/*HEADER START*/
		 
		 /*HEADER END*/
		 /* Main Content */
		 .main_content {
		    margin-bottom: 80px;
		 }
		 .table-top {
		    margin-top: 0px;
		 }
		 .table-top h4 {
		   color: #1b86e3;
           font-family: 'poppins';
        }
        .table {
            //margin-top: -20px;
        }
		 .table th {
		    border-top: 1px dotted #dee2e6;
		 }
		 .table tr .bold {
		    font-weight: 600 !important;
		    font-size: 17px;
		    line-height: 0px;
		    vertical-align: middle;
		}
		.table td, .table th {
		    padding: 9px;
		    vertical-align: top;
		    border-bottom: none;
		    border-top: none;
		}
		.table td {
		   width: 33.33%;
		}
		.table tbody td {
		    font-family: 'poppins';
		}
		.table td b {
		    font-weight: 600 !important;
        }
        .table td {
            white-space: no-wrap;
        }
		
		 /* Main Content */
		
		 /* Define the footer rules */
		.footer {
			padding: 0 10px;
			position: fixed; 
			bottom: 0cm; 
			left: 0cm; 
			right: 0cm;
			height:40px;
			background: #000;
			font-size:14px;
			-webkit-print-color-adjust: exact; 
		}
		.pagenum:before {
		    content: counter(page);
        }
        main {
            margin-top: 25px;
            margin-bottom: 25px;
        }
		
		 /* Footer Start */
		.page-number:before {
		  content: counter(page);
		}
		 
		 /* Footer End */
		 
		 .inner-table th,
		.inner-table td {
		padding: 0.25em 0.5em 0.25em 1em;
		vertical-align: middle;
		text-align: left;
		text-indent: -0.5em;
	}
	.inner-table th .row {
		vertical-align: middle;
		background-color: rgba(0, 0, 0, 0.1);
	}
	.inner-table th {
	vertical-align: middle;
	text-align: left;
	background-color: rgba(0, 0, 0, 0.1);
	}

	.inner-table th[scope=row] {
	vertical-align: middle;
	}

	.inner-table tr:nth-child(even) {
	background-color: rgba(0, 0, 0, 0.05);
	}

	.inner-table tr:nth-child(odd) {
	background-color: rgba(255, 255, 255, 0.05);
	}

	.inner-table td:nth-of-type(3) {
	//font-style: italic;
	}

	.inner-table th:nth-of-type(4),
	.inner-table td:nth-of-type(4) {
	text-align: left;
	}
	.page-break {
		page-break-after: always;
	}
	</style>
</head>

<body>
	<!-- HEADER START -->
	<header style="background:#1b86e3; position:fixed; top:0; left:0; right:0;padding: 0 10px;">
		<?php 
		$address = $result->Reports[0]->Data->SubjectProperty->SitusAddress->StreetAddress.' '.$result->Reports[0]->Data->SubjectProperty->SitusAddress->City.', '.$result->Reports[0]->Data->SubjectProperty->SitusAddress->State.','.$result->Reports[0]->Data->SubjectProperty->SitusAddress->Zip9;	?>
		<table width="100%" cellpadding="0" cellspacing="0"  align="top">
			<tr>
				<td style="padding:5px 0;text-align:left; width: 18%;"><img width="200px" src="{{public_path('assets/report/images/logo.png')}}" />
				</td>
				<td><p style="color:#fff; border-left: 2px solid white; font-weight:100px;font-size:16px; padding-left: 10px; margin-left: 10px;">Sales Comparable Report</p></td>
				<td align="right" style="color: #fff;font-size:12px;font-weight:100px;"><p>{{$address}}</p></td>
			</tr>
		</table>
		
		</header>
     <!-- HEADER END -->
    <footer class="footer">
	
		<table width="100%" cellpadding="0" cellspacing="0"  align="top">
			<tr>
				<td style="text-align:left; padding:5px 0; width: 16%;"><img width="100px" src="{{public_path('assets/report/images/logo.png')}}" />
				</td>
				<td align="middle" style="width:100%;text-align:center;color: #fff; font-size:14px; font-weight:normal;">Copyright 2020 Equity Finders Pro. All Rights Reserved. A Data Miners LLC Company</td>
				<td align="right" style="color: #fff; width: 20%; font-size:14px; font-weight:normal;">{{date('d-M-Y')}} | <span class="page-number"></span></td>
			</tr>
		</table>
		
	</footer>
   
    <!-- Wrap the content of your PDF inside a main tag -->
<main>
<script>if(counter(page)>1){ </script>

<script> } </script>
@if(@$result->Reports[0]->Data->ComparableCount >0)
<h2 style="color:#1b86e3; font-size:18px; border-bottom: 1px solid; padding-bottom: 10px;">Comparable Properties </h2>

<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>Total</b> : <span>{{@$result->Reports[0]->Data->ComparableCount}}</span>
		</td>
	</tr>
</table>
<?php $total = $result->Reports[0]->Data->ComparableCount; ?>
@foreach(@$result->Reports[0]->Data->ComparableProperties as $key => $properties)
<h2 style="color:#1b86e3; font-size:16px; border-bottom: 1px solid; padding-bottom: 10px;">Property {{$key+1}} </h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>PropertyId</b> : <span>{{@$properties->PropertyId}}</span>
		</td>
		<td><b>DistanceFromSubject</b> : <span>{{$properties->DistanceFromSubject}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#000000; font-size:16px; border-bottom:1px dotted; padding-bottom: 5px;">SitusAddress </h2>

<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>StreetAddress</b> : <span>{{@$properties->SitusAddress->StreetAddress}}</span>
		</td>
		<td><b>City</b> : <span>{{$properties->SitusAddress->City}}</span>
		</td><td><b>State</b> : <span>{{$properties->SitusAddress->State}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Zip9</b> : <span>{{@$properties->SitusAddress->Zip9}}</span>
		</td>
		<td><b>County</b> : <span>{{$properties->SitusAddress->County}}</span>
		</td><td><b>SitusCarrierRoute</b> : <span>{{$properties->SitusAddress->SitusCarrierRoute}}</span>
		</td>
	</tr>
	<tr>
		<td><b>APN</b> : <span>{{@$properties->SitusAddress->APN}}</span></td>
		<td></td>
		<td></td>
	</tr>
</table>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>OwnerName1Full</b> : <span>{{$properties->OwnerName1Full}}</span>
		</td>
		<td><b>OwnerName2Full</b> : <span>{{$properties->OwnerName2Full}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#000000; border-bottom:1px dotted; font-size:16px; padding-bottom: 5px;">OwnerMailingAddress </h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>StreetAddress</b> : <span>{{@$properties->OwnerMailingAddress->StreetAddress}}</span>
		</td>
		<td><b>City</b> : <span>{{$properties->OwnerMailingAddress->City}}</span>
		</td><td><b>State</b> : <span>{{$properties->OwnerMailingAddress->State}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Zip9</b> : <span>{{@$properties->OwnerMailingAddress->Zip9}}</span>
		</td>
		<td><b>MailCarrierRoute</b> : <span>{{$properties->OwnerMailingAddress->MailCarrierRoute}}</span>
		</td>
	</tr>
</table>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>AssessedValue</b> : <span>{{$properties->AssessedValue}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#000000; border-bottom:1px dotted; font-size:16px; padding-bottom: 5px;">LocationInformation </h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>APN</b> : <span>{{@$properties->LocationInformation->APN}}</span>
		</td>
		<td><b>Subdivision</b> : <span>{{$properties->LocationInformation->Subdivision}}</span>
		</td><td><b>Latitude</b> : <span>{{$properties->LocationInformation->Latitude}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Longitude</b> : <span>{{@$properties->LocationInformation->Longitude}}</span>
		</td>
		<td><b>CensusTract</b> : <span>{{$properties->LocationInformation->CensusTract}}</span>
		</td><td><b>CensusBlock</b> : <span>{{$properties->LocationInformation->CensusBlock}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#000000; border-bottom:1px dotted; font-size:16px; padding-bottom: 5px;">SiteInformation </h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>Zoning</b> : <span>{{@$properties->SiteInformation->Zoning}}</span>
		</td>
		<td><b>LandUse</b> : <span>{{$properties->SiteInformation->LandUse}}</span>
		</td><td><b>Acres</b> : <span>{{$properties->SiteInformation->Acres}}</span>
		</td>
	</tr>
	<tr>
		<td><b>LotArea</b> : <span>{{@$properties->SiteInformation->LotArea}}</span>
		</td>
		<td><b>FloodZoneCode</b> : <span>{{$properties->SiteInformation->FloodZoneCode}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#000000; border-bottom:1px dotted; font-size:16px; padding-bottom: 5px;">PropertyCharacteristics </h2>
<table class="inner-table page-break" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>LivingArea</b> : <span>{{@$properties->PropertyCharacteristics->LivingArea}}</span>
		</td>
		<td><b>TotalRooms</b> : <span>{{$properties->PropertyCharacteristics->TotalRooms}}</span>
		</td><td><b>Bedrooms</b> : <span>{{$properties->PropertyCharacteristics->Bedrooms}}</span>
		</td>
	</tr>
	<tr>
		<td><b>FullBath</b> : <span>{{@$properties->PropertyCharacteristics->FullBath}}</span>
		</td>
		<td><b>HalfBath</b> : <span>{{$properties->PropertyCharacteristics->HalfBath}}</span>
		</td>
		<td><b>YearBuilt</b> : <span>{{$properties->PropertyCharacteristics->YearBuilt}}</span>
		</td>
	</tr>
	<tr>
		<td><b>EFFYear</b> : <span>{{@$properties->PropertyCharacteristics->EFFYear}}</span>
		</td>
		<td><b>FirePlaceCount</b> : <span>{{$properties->PropertyCharacteristics->FirePlaceCount}}</span>
		</td><td><b>FirePlaceIndicator</b> : <span>{{$properties->PropertyCharacteristics->FirePlaceIndicator}}</span>
		</td>
	</tr>
	<tr>
		<td><b>NumberOfStories</b> : <span>{{@$properties->PropertyCharacteristics->NumberOfStories}}</span>
		</td>
		<td><b>ParkingType</b> : <span>{{$properties->PropertyCharacteristics->ParkingType}}</span>
		</td>
		<td><b>RoofMaterial</b> : <span>{{$properties->PropertyCharacteristics->RoofMaterial}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Pool</b> : <span>{{@$properties->PropertyCharacteristics->Pool}}</span>
		</td>
		<td><b>AirConditioning</b> : <span>{{$properties->PropertyCharacteristics->AirConditioning}}</span>
		</td>
		<td><b>Baths</b> : <span>{{$properties->PropertyCharacteristics->Baths}}</span>
		</td>
	</tr>
</table>

<h2 style="color:#000000; border-bottom:1px dotted; font-size:16px; padding-bottom: 5px;">PriorSaleInformation </h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>PriorSaleDate</b> : <span>{{@$properties->PriorSaleInformation->PriorSaleDate}}</span>
		</td>
		<td><b>PriorRecordingDate</b> : <span>{{$properties->PriorSaleInformation->PriorRecordingDate}}</span>
		</td><td><b>PriorSalePrice</b> : <span>{{$properties->PriorSaleInformation->PriorSalePrice}}</span>
		</td>
	</tr>
	<tr>
		<td><b>PriorDocNumber</b> : <span>{{@$properties->PriorSaleInformation->PriorDocNumber}}</span>
		</td>
		<td><b>PriorDocNumberCmtId</b> : <span>{{$properties->PriorSaleInformation->PriorDocNumberCmtId}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#000000; border-bottom:1px dotted; font-size:16px; padding-bottom: 5px;">LastMarketSaleInformation </h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>SaleDate</b> : <span>{{@$properties->LastMarketSaleInformation->SaleDate}}</span>
		</td>
		<td><b>RecordingDate</b> : <span>{{$properties->LastMarketSaleInformation->RecordingDate}}</span>
		</td><td><b>SalePrice</b> : <span>{{$properties->LastMarketSaleInformation->SalePrice}}</span>
		</td>
	</tr>
	<tr>
		<td><b>SaleType</b> : <span>{{@$properties->LastMarketSaleInformation->SaleType}}</span>
		</td>
		<td><b>TransferDocumentNumber</b> : <span>{{$properties->LastMarketSaleInformation->TransferDocumentNumber}}</span>
		</td><td><b>TransferDocumentNumberCmtId</b> : <span>{{$properties->LastMarketSaleInformation->TransferDocumentNumberCmtId}}</span>
		</td>
	</tr>
	<tr>
		<td><b>FirstMortgageAmount</b> : <span>{{@$properties->LastMarketSaleInformation->FirstMortgageAmount}}</span>
		</td>
		<td><b>FirstMortgageType</b> : <span>{{$properties->LastMarketSaleInformation->FirstMortgageType}}</span>
		</td>
	</tr>
</table>
<span style="border: 1px solid #000000;display:block; padding-top:10px;"></span>
@if( $key <= $total )
<div class="page-break"></div>
@endif 
@endforeach
@endif
<h2 style="color:#1b86e3;font-size:18px;border-bottom: 1px solid; padding-bottom: 10px;">Comparable Properties Summary</h2>
<table class="inner-table" align="center" width="100%">
  <tr>
	<th id="ColAuthor">Title</th>
    <th id="ColFlag">Subject</th>
    <th id="ColAuthor">Low</th>
    <th id="ColTitle">Average</th>
    <th id="ColYear">High</th>
  </tr>
  <tr>
    <th scope="row" class="row_title" id="Row01">Sale Price</th>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->SalePrice->Subject}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->SalePrice->Low}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->SalePrice->Average}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->SalePrice->High}}</td>
    
  </tr>
  <tr>
    <th scope="row" class="row_title"  id="Row02">Sale Listed Price</th>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->SaleListedPrice->Subject}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->SaleListedPrice->Low}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->SaleListedPrice->Average}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->SaleListedPrice->High}}</td>
    
  </tr>
  <tr>
    <th scope="row"  class="row_title"  id="Row03">Price Per SqFt</th>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->PricePerSqFt->Subject}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->PricePerSqFt->Low}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->PricePerSqFt->Average}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->PricePerSqFt->High}}</td>
  </tr>
  <tr>
    <th scope="row"  class="row_title"  id="Row04">Year Built</th>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->YearBuilt->Subject}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->YearBuilt->Low}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->YearBuilt->Average}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->YearBuilt->High}}</td>
    
  </tr>
  <tr>
    <th scope="row"  class="row_title"  id="Row05">Lot Area</th>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->LotArea->Subject}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->LotArea->Low}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->LotArea->Average}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->LotArea->High}}</td>
  </tr>
  <tr>
    <th scope="row"  class="row_title"  id="Row06">Bedrooms</th>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->Bedrooms->Subject}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->Bedrooms->Low}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->Bedrooms->Average}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->Bedrooms->High}}</td>
  </tr>
  <tr>
    
    <th scope="row"  class="row_title"  id="Row07">Bathrooms</th>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->Bathrooms->Subject}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->Bathrooms->Low}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->Bathrooms->Average}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->Bathrooms->High}}</td>
  </tr>
   <tr>
    
    <th scope="row"  class="row_title"  id="Row08">Stories</th>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->Stories->Subject}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->Stories->Low}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->Stories->Average}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->Stories->High}}</td>
  </tr>
   <tr>
    
    <th scope="row"  class="row_title"  id="Row09">Distance From Subject</th>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->DistanceFromSubject->Subject}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->DistanceFromSubject->Low}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->DistanceFromSubject->Average}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->DistanceFromSubject->High}}</td>
  </tr> 
  <tr>
    
    <th scope="row"  class="row_title"  id="Row10">Living Area</th>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->LivingArea->Subject}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->LivingArea->Low}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->LivingArea->Average}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->LivingArea->High}}</td>
  </tr>
  <tr>
	<th id="ColTitle">Title</th>
	<th id="ColAuthor">Min Bed Rooms</th>
    <th id="ColFlag">Avg Bed Rooms</th>
    <th id="ColAuthor">Max Bed Rooms</th>
    <th id="ColYear"></th>
  </tr>
  <tr>
    <th scope="row"  class="row_title"  id="Row11">Bedrooms</th>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->MinBedRooms}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->AvgBedRooms}}</td>
    <td>{{@$result->Reports[0]->Data->ComparablePropertiesSummary->MaxBedRooms}}</td>
    <td></td>
  </tr>
</table>

<h2 style="color:#1b86e3;font-size:18px;border-bottom: 1px solid; padding-bottom: 10px;">SubjectProperty</h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>PropertyId</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyId}}</span>
		</td>
		<td><b>DistanceFromSubject</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->DistanceFromSubject}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#1b86e3;font-size:16px;border-bottom: 1px solid; padding-bottom: 10px;">SitusAddress</h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr> 
		<td><b>StreetAddress</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->StreetAddress}}</span>
		</td>
		<td><b>City</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->City}}</span>
		</td>
		<td><b>State</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->State}}</span>
		</td>
		
	</tr>
	<tr>
		<td><b>Zip9</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->Zip9}}</span>
		</td>
		<td><b>County</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->County}}</span>
		</td>
		<td><b>SitusCarrierRoute</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->SitusCarrierRoute}}</span>
		</td>
		<td><b>APN</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->APN}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#1b86e3;font-size:16px;border-bottom: 1px solid; padding-bottom: 10px;">OwnerMailingAddress</h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">

	<tr>
		<td><b>StreetAddress</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->OwnerMailingAddress->StreetAddress}}</span>
		</td>
		<td><b>City</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->OwnerMailingAddress->City}}</span>
		</td>
		<td><b>State</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->OwnerMailingAddress->State}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Zip9</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->OwnerMailingAddress->Zip9}}</span>
		</td>
		<td><b>County</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->OwnerMailingAddress->County}}</span>
		</td>
		<td><b>MailCarrierRoute</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->OwnerMailingAddress->MailCarrierRoute}}</span>
		</td>
	</tr>
	<tr>
		<td><b>OwnerName1Full</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->OwnerName1Full}}</span>
		</td>
		<td><b>OwnerName2Full</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->OwnerName2Full}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#1b86e3;font-size:16px;border-bottom: 1px solid; padding-bottom: 10px;">AssessedValue</h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>AssessedValue</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->AssessedValue}}</span>
		</td>
	</tr>
</table>
<div class="page-break"></div>
<h2 style="color:#1b86e3;font-size:16px;border-bottom: 1px solid; padding-bottom: 10px;">LocationInformation</h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>APN</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LocationInformation->APN}}</span>
		</td>
		<td><b>Subdivision</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LocationInformation->Subdivision}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Latitude</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LocationInformation->Latitude}}</span>
		</td>
		<td><b>Longitude</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LocationInformation->Longitude}}</span>
		</td>
	</tr>
	<tr>
		<td><b>CensusTract</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LocationInformation->CensusTract}}</span>
		</td>
		<td><b>CensusBlock</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LocationInformation->CensusBlock}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#1b86e3;font-size:14px;border-bottom: 1px solid; padding-bottom: 10px;">SiteInformation</h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>Zoning</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->SiteInformation->Zoning}}</span>
		</td>
		<td><b>LandUse</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->SiteInformation->LandUse}}</span>
		</td>
		<td><b>Acres</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->SiteInformation->Acres}}</span>
		</td>
	</tr>
	<tr>
		<td><b>LotArea</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->SiteInformation->LotArea}}</span>
		</td>
		<td><b>FloodZoneCode</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->SiteInformation->FloodZoneCode}}</span>
		</td>
		<td></td>
	</tr>
</table>
<h2 style="color:#1b86e3;font-size:16px;border-bottom: 1px solid; padding-bottom: 10px;">PropertyCharacteristics</h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>LivingArea</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->LivingArea}}</span>
		</td>
		<td><b>TotalRooms</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->TotalRooms}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Bedrooms</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->Bedrooms}}</span>
		</td>
		<td><b>FullBath</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->FullBath}}</span>
		</td>
	</tr>
	<tr>
		<td><b>HalfBath</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->HalfBath}}</span>
		</td>
		<td><b>YearBuilt</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->YearBuilt}}</span>
		</td>
	</tr>
	<tr>
		<td><b>EFFYear</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->EFFYear}}</span>
		</td>
		<td><b>FirePlaceCount</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->FirePlaceCount}}</span>
		</td>
	</tr>
	<tr>
		<td><b>FirePlaceIndicator</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->FirePlaceIndicator}}</span>
		</td>
		<td><b>NumberOfStories</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->NumberOfStories}}</span>
		</td>
	</tr>
	<tr>
		<td><b>ParkingType</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->ParkingType}}</span>
		</td>
		<td><b>RoofMaterial</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->RoofMaterial}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Pool</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->Pool}}</span>
		</td>
		<td><b>AirConditioning</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->AirConditioning}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Baths</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PropertyCharacteristics->Baths}}</span>
		</td>
		<td></td>
	</tr>
</table>
<h2 style="color:#1b86e3;font-size:16px;border-bottom: 1px solid; padding-bottom: 10px;">PriorSaleInformation</h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>PriorSaleDate</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PriorSaleInformation->PriorSaleDate}}</span>
		</td>
		<td><b>PriorRecordingDate</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PriorSaleInformation->PriorRecordingDate}}</span>
		</td>
	</tr>
	<tr>
		<td><b>PriorSalePrice</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PriorSaleInformation->PriorSalePrice}}</span>
		</td>
		<td><b>PriorDocNumber</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PriorSaleInformation->PriorDocNumber}}</span>
		</td>
	</tr>
	<tr>
		<td><b>PriorDocNumberCmtId</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->PriorSaleInformation->PriorDocNumberCmtId}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#1b86e3;font-size:16px;border-bottom: 1px solid; padding-bottom: 10px;">LastMarketSaleInformation</h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>SaleDate</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LastMarketSaleInformation->SaleDate}}</span>
		</td>
		<td><b>RecordingDate</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LastMarketSaleInformation->RecordingDate}}</span>
		</td>
	</tr>
	<tr>
		<td><b>SalePrice</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LastMarketSaleInformation->SalePrice}}</span>
		</td>
		<td><b>SaleType</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LastMarketSaleInformation->SaleType}}</span>
		</td>
	</tr>
	<tr>
		<td><b>TransferDocumentNumber</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LastMarketSaleInformation->TransferDocumentNumber}}</span>
		</td>
		<td><b>TransferDocumentNumberCmtId</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LastMarketSaleInformation->TransferDocumentNumberCmtId}}</span>
		</td>
	</tr>
	<tr>
		<td><b>FirstMortgageAmount</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LastMarketSaleInformation->FirstMortgageAmount}}</span>
		</td>
		<td><b>FirstMortgageType</b> : <span>{{@$result->Reports[0]->Data->SubjectProperty->LastMarketSaleInformation->FirstMortgageType}}</span>
		</td>
	</tr>
</table>
<span style="border: 1px solid #000000;display:block; padding-top:10px;"></span>
<div class="page-break"></div>
<h2 style="color:#1b86e3;font-size:18px;border-bottom: 1px solid; padding-bottom: 10px;">Filters</h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>StreetNumber</b> : <span>{{@$result->Reports[0]->Data->Filters->StreetNumber}}</span>
		</td>
		<td><b>StreetTypes</b> : <span>{{@$result->Reports[0]->Data->Filters->StreetTypes}}</span>
		</td>
		<td><b>StreetDir</b> : <span>{{@$result->Reports[0]->Data->Filters->StreetDir}}</span>
		</td>
	</tr>
	<tr>
		<td><b>StreetNames</b> : <span>{{@$result->Reports[0]->Data->Filters->StreetNames}}</span>
		</td>
		<td><b>StreetPostDir</b> : <span>{{@$result->Reports[0]->Data->Filters->StreetPostDir}}</span>
		</td>
		<td><b>Cities</b> : <span>{{@$result->Reports[0]->Data->Filters->Cities}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Counties</b> : <span>{{@$result->Reports[0]->Data->Filters->Counties}}</span>
		</td>
		<td><b>ZipCodeRange</b> : <span>{{@$result->Reports[0]->Data->Filters->ZipCodeRange}}</span>
		</td>
		<td><b>MailingZipCodeRange</b> : <span>{{@$result->Reports[0]->Data->Filters->MailingZipCodeRange}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Polygons</b> : <span>{{@$result->Reports[0]->Data->Filters->Polygons}}</span>
		</td>
		<td><b>Radials</b> : <span>{{@$result->Reports[0]->Data->Filters->Radials}}</span>
		</td>
		<td><b>Points</b> : <span>{{@$result->Reports[0]->Data->Filters->Points}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Unit</b> : <span>{{@$result->Reports[0]->Data->Filters->Unit}}</span>
		</td>
		<td><b>NeighborhoodCode</b> : <span>{{@$result->Reports[0]->Data->Filters->NeighborhoodCode}}</span>
		</td>
		<td><b>HOACode</b> : <span>{{@$result->Reports[0]->Data->Filters->HOACode}}</span>
		</td>
	</tr>
	<tr>
		<td><b>UnitType</b> : <span>{{@$result->Reports[0]->Data->Filters->UnitType}}</span>
		</td>
		<td><b>SubdivisionName</b> : <span>{{@$result->Reports[0]->Data->Filters->SubdivisionName}}</span>
		</td>
		<td><b>TaxArea</b> : <span>{{@$result->Reports[0]->Data->Filters->TaxArea}}</span>
		</td>
	</tr>
	<tr>
		<td><b>StateFips</b> : <span>{{@$result->Reports[0]->Data->Filters->StateFips}}</span>
		</td>
		<td><b>CountyFips</b> : <span>{{@$result->Reports[0]->Data->Filters->CountyFips}}</span>
		</td>
		<td><b>SubjectPropertyAddress</b> : <span>{{@$result->Reports[0]->Data->Filters->SubjectPropertyAddress}}</span>
		</td>
	</tr>
	<tr>
		<td><b>StateCountyFips</b> : <span>{{@$result->Reports[0]->Data->Filters->StateCountyFips}}</span>
		</td>
		<td><b>ProximityNumProperties</b> : <span>{{@$result->Reports[0]->Data->Filters->ProximityNumProperties}}</span>
		</td>
		<td><b>ProximityRefAddress</b> : <span>{{@$result->Reports[0]->Data->Filters->ProximityRefAddress}}</span>
		</td>
	</tr>	
	<tr>
		<td><b>ProximityMaxDistance</b> : <span>{{@$result->Reports[0]->Data->Filters->ProximityMaxDistance}}</span>
		</td>
		<td><b>ProximityPropertyId</b> : <span>{{@$result->Reports[0]->Data->Filters->ProximityPropertyId}}</span>
		</td>
		<td><b>ProximityMarker</b> : <span>{{@$result->Reports[0]->Data->Filters->ProximityMarker}}</span>
		</td>
	</tr>
	<tr>
		<td><b>BookPage</b> : <span>{{@$result->Reports[0]->Data->Filters->BookPage}}</span>
		</td>
		<td><b>PropertyIds</b> : <span>{{@$result->Reports[0]->Data->Filters->PropertyIds}}</span>
		</td>
		<td><b>ApnRange</b> : <span>{{@$result->Reports[0]->Data->Filters->ApnRange}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#1b86e3;font-size:16px;border-bottom: 1px solid; padding-bottom: 10px;">LotArea</h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>Lower</b> : <span>{{@$result->Reports[0]->Data->Filters->LotArea->Lower}}</span>
		</td>
		<td><b>Upper</b> : <span>{{@$result->Reports[0]->Data->Filters->LotArea->Upper}}</span>
		</td>
	</tr>
</table>
<h2 style="color:#1b86e3;font-size:16px;border-bottom: 1px solid; padding-bottom: 10px;">BuildingAreaSquareFeet</h2>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
    <tr>
		<td><b>Lower</b> : <span>{{@$result->Reports[0]->Data->Filters->BuildingAreaSquareFeet->Lower}}</span>
		</td>
		<td><b>Upper</b> : <span>{{@$result->Reports[0]->Data->Filters->BuildingAreaSquareFeet->Upper}}</span>
		</td>
	</tr>
	
</table>

<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
    <tr>
		<td><b>LotAcreage</b> : <span>{{@$result->Reports[0]->Data->Filters->LotAcreage}}</span>
		</td>
	</tr>
</table>

<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr><th><b>LandUse</b> :</th></tr>
	@foreach(@$result->Reports[0]->Data->Filters->LandUse as $key=>$val)
    <tr><td>{{@$val}}</td></tr>
	@endforeach
</table>
<table class="inner-table" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>SiteInfluence</b> : <span>{{@$result->Reports[0]->Data->Filters->SiteInfluence}}</span>
		</td>
		<td><b>NewConstruction</b> : <span>{{@$result->Reports[0]->Data->Filters->NewConstruction}}</span>
		</td>
		
	</tr>
	<tr>
		<td><b>NewConstructionFlag</b> : <span>{{@$result->Reports[0]->Data->Filters->NewConstructionFlag}}</span>
		</td>
		<td><b>UnitsResidential</b> : <span>{{@$result->Reports[0]->Data->Filters->UnitsResidential}}</span>
		</td>
	</tr>
	<tr>
		<td><b>PoolOption</b> : <span>{{@$result->Reports[0]->Data->Filters->PoolOption}}</span>
		</td>
		<td><b>AssesedValue</b> : <span>{{@$result->Reports[0]->Data->Filters->AssesedValue}}</span>
		</td>
	</tr>
	
	<tr>
		<td><b>TotalNumberOfRooms</b> : <span>{{@$result->Reports[0]->Data->Filters->TotalNumberOfRooms}}</span>
		</td>
		<td><b>TotalNumberOfBedrooms</b> : <span>Lower: {{@$result->Reports[0]->Data->Filters->TotalNumberOfBedrooms->Lower}}</span>
		<span>Upper: {{@$result->Reports[0]->Data->Filters->TotalNumberOfBedrooms->Upper}}</span>
		</td>
	</tr>
	<tr>
		<td><b>TotalNumberOfBathrooms</b> : <span>Lower: {{@$result->Reports[0]->Data->Filters->TotalNumberOfBathrooms->Lower}}</span>
		<span>Upper: {{@$result->Reports[0]->Data->Filters->TotalNumberOfBathrooms->Upper}}</span>
		</td>
		<td><b>NumberOfGarageSpaces</b> : <span>{{@$result->Reports[0]->Data->Filters->NumberOfGarageSpaces}}</span>
		</td>
	</tr>
	<tr>
		<td><b>YearBuilt</b> : <span>{{@$result->Reports[0]->Data->Filters->YearBuilt}}</span>
		</td>
		<td><b>ZoningCode</b> : <span>{{@$result->Reports[0]->Data->Filters->ZoningCode}}</span>
		</td>
	</tr>
	<tr><?php $arr = []; 
		foreach($result->Reports[0]->Data->Filters->StyleCode as $key=>$val){ $arr[] = $val; } 
	?>
		<td><b>Stories</b> : <span>{{@$result->Reports[0]->Data->Filters->Stories}}</span>
		</td>
		<td><b>NumberOfStories</b> : <span>{{@$result->Reports[0]->Data->Filters->NumberOfStories}}</span>
		</td>
		
	</tr>
	<tr>
		<td><b>StyleCode</b> : <span><?php echo implode(',',$arr); ?></span>
		</td>
		<td><b>Ethnicity</b> : <span>{{@$result->Reports[0]->Data->Filters->Ethnicity}}</span>
		</td>
	</tr>
	<tr>
		<td><b>HomeEquityPercentage</b> : <span>{{@$result->Reports[0]->Data->Filters->HomeEquityPercentage}}</span>
		</td>
		<td><b>HomeEquityValue</b> : <span>{{@$result->Reports[0]->Data->Filters->HomeEquityValue}}</span>
		</td>
	</tr>
	<tr>
		<td><b>AssessorValueType</b> : <span>{{@$result->Reports[0]->Data->Filters->AssessorValueType}}</span>
		</td>
		<td><b>TotalValue</b> : <span>{{@$result->Reports[0]->Data->Filters->TotalValue}}</span>
		</td>
	</tr>
	<tr>
		<td><b>LandValue</b> : <span>{{@$result->Reports[0]->Data->Filters->LandValue}}</span>
		</td>
		<td><b>ImprovementValue</b> : <span>{{@$result->Reports[0]->Data->Filters->ImprovementValue}}</span>
		</td>
		
	</tr>
	<tr>
		<td><b>ImprovementPercentage</b> : <span>{{@$result->Reports[0]->Data->Filters->ImprovementPercentage}}</span>
		</td>
		<td><b>DelinquencyRecordingDate</b> : <span>{{@$result->Reports[0]->Data->Filters->DelinquencyRecordingDate}}</span>
		</td>
	</tr>
	<tr>
		<td><b>DelinquentMortgageAmount</b> : <span>{{@$result->Reports[0]->Data->Filters->DelinquentMortgageAmount}}</span>
		</td>
		<td><b>Exemptions</b> : <span>{{@$result->Reports[0]->Data->Filters->Exemptions}}</span>
		</td>
	</tr>
	<tr>
		<td><b>Exemptions</b> : <span>{{@$result->Reports[0]->Data->Filters->Exemptions}}</span>
		</td>
		<td><b>TransactionType</b> : <span>{{@$result->Reports[0]->Data->Filters->TransactionType}}</span>
		</td>
	</tr>
	<tr>
		<td><b>ForSaleListedPrice</b> : <span>{{@$result->Reports[0]->Data->Filters->ForSaleListedPrice}}</span>
		</td>
		<td><b>ForeclosureSaleAmount</b> : <span>{{@$result->Reports[0]->Data->Filters->ForeclosureSaleAmount}}</span>
		</td>
	</tr>
	
	</table>
	<div class="page-break"></div>
	<table class="inner-table" style="margin-top:20px;" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>ForeclosureDate</b> : <span>{{@$result->Reports[0]->Data->Filters->ForeclosureDate}}</span>
		</td>
		<td><b>InterestRate</b> : <span>{{@$result->Reports[0]->Data->Filters->InterestRate}}</span>
		</td>
	</tr>
	<tr>
		<td><b>InterestRateType</b> : <span>{{@$result->Reports[0]->Data->Filters->InterestRateType}}</span>
		</td>
		<td><b>LastSaleDate</b> : <span>{{@$result->Reports[0]->Data->Filters->LastSaleDate->Lower}} to {{@$result->Reports[0]->Data->Filters->LastSaleDate->Upper}}</span>
		</td>
	</tr>
	<tr>
		<td><b>LastMarketSaleRecordingDate</b> : <span>{{@$result->Reports[0]->Data->Filters->LastMarketSaleRecordingDate}}</span>
		</td>
		<td><b>IncludePropertiesWithOutDates</b> : <span>{{@$result->Reports[0]->Data->Filters->IncludePropertiesWithOutDates}}</span>
		</td>
	</tr>
	<tr>
		<td><b>LoanAmount</b> : <span>{{@$result->Reports[0]->Data->Filters->LoanAmount}}</span>
		</td>
		<td><b>MostRecentLenderName</b> : <span>{{@$result->Reports[0]->Data->Filters->MostRecentLenderName}}</span>
		</td>
	</tr>
	<tr>
		<td><b>MostRecentMortgageAmount</b> : <span>{{@$result->Reports[0]->Data->Filters->MostRecentMortgageAmount}}</span>
		</td>
		<td><b>MostRecentTransferDate</b> : <span>{{@$result->Reports[0]->Data->Filters->MostRecentTransferDate}}</span>
		</td>
	</tr>
	<tr>
		<td><b>MostRecentMortgageRecordingDate</b> : <span>{{@$result->Reports[0]->Data->Filters->MostRecentMortgageRecordingDate}}</span>
		</td>
		<td><b>MostRecentTransferRecordingDate</b> : <span>{{@$result->Reports[0]->Data->Filters->MostRecentTransferRecordingDate->Lower ? @$result->Reports[0]->Data->Filters->MostRecentTransferRecordingDate->Lower.' to '. @$result->Reports[0]->Data->Filters->MostRecentTransferRecordingDate->Upper : ''}}</span>
		</td>
	</tr>
	<tr>
		<td><b>MostRecentTransferValue</b> : <span>{{@$result->Reports[0]->Data->Filters->MostRecentTransferValue}}</span>
		</td>
		<td><b>ListingStatus</b> : <span>{{@$result->Reports[0]->Data->Filters->LastSaleDate->ListingStatus}}</span>
		</td>
	</tr>
	<tr>
		<td><b>OriginalListDate</b> : <span>{{@$result->Reports[0]->Data->Filters->OriginalListDate}}</span>
		</td>
		<td><b>OwnerFirstNames</b> : <span>{{@$result->Reports[0]->Data->Filters->OwnerFirstNames}}</span>
		</td>
	</tr>
	<tr>
		<td><b>OwnerLastNames</b> : <span>{{@$result->Reports[0]->Data->Filters->OwnerLastNames}}</span>
		</td>
		<td><b>OwnerNames</b> : <span>{{@$result->Reports[0]->Data->Filters->OwnerNames}}</span>
		</td>
	</tr>
	<tr>
		<td><b>RecordingMonth</b> : <span>{{@$result->Reports[0]->Data->Filters->RecordingMonth}}</span>
		</td>
		<td><b>SalePrice</b> : <span>{{@$result->Reports[0]->Data->Filters->SalePrice->Lower ? @$result->Reports[0]->Data->Filters->SalePrice->Lower.' to '. @$result->Reports[0]->Data->Filters->SalePrice->Upper : ''}}</span>
		</td>
	</tr>
	<tr>
		<td><b>EstimatedValue</b> : <span>{{@$result->Reports[0]->Data->Filters->EstimatedValue}}</span>
		</td>
		<td><b>SalePriceType</b> : <span>{{@$result->Reports[0]->Data->Filters->SalePriceType}}</span>
		</td>
	</tr>
	<tr>
		<td><b>SellerName</b> : <span>{{@$result->Reports[0]->Data->Filters->SellerName}}</span>
		</td>
		<td><b>SubdivTractNbr</b> : <span>{{@$result->Reports[0]->Data->Filters->SubdivTractNbr}}</span>
		</td>
	</tr>
	<tr><?php $foc = []; 
		foreach($result->Reports[0]->Data->Filters->ForeclosureStatus as $key=>$val){ $foc[] = $val; } 
	?>
		<td><b>DoNotMail</b> : <span>{{@$result->Reports[0]->Data->Filters->DoNotMail}}</span>
		</td>
		<td><b>ForeclosureStatus</b> :  <span><?php echo implode(',',$foc); ?></span>
		</td>
	</tr>
	<tr>
		<td><b>ForeclosureRecordingDate</b> : <span>{{@$result->Reports[0]->Data->Filters->ForeclosureRecordingDate}}</span>
		</td>
		<td><b>AuctionDate</b> : <span>{{@$result->Reports[0]->Data->Filters->AuctionDate}}</span>
		</td>
	</tr>
	<tr>
		<td><b>AuctionSaleAmount</b> : <span>{{@$result->Reports[0]->Data->Filters->AuctionSaleAmount}}</span>
		</td>
		<td><b>isVerified</b> : <span>{{@$result->Reports[0]->Data->Filters->isVerified}}</span>
		</td>
	</tr>
	
</table>
	<table class="inner-table" style="margin-top:20px;" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><b>isDistressed</b> : <span>{{@$result->Reports[0]->Data->Filters->isDistressed}}</span>
		</td>
		<td><b>OwnerOccupied</b> : <span>{{@$result->Reports[0]->Data->Filters->OwnerOccupied}}</span>
		</td>
	</tr>
	<tr>
		<td><b>DistressedDate</b> : <span>{{@$result->Reports[0]->Data->Filters->DistressedDate}}</span>
		</td>
		<td><b>DistressedAmount</b> : <span>{{@$result->Reports[0]->Data->Filters->DistressedAmount}}</span>
		</td>
	</tr>
	<tr>
		<td><b>DeedType</b> : <span>{{@$result->Reports[0]->Data->Filters->DeedType}}</span>
		</td>
		<td><b>MailingStreetNumber</b> : <span>{{@$result->Reports[0]->Data->Filters->MailingStreetNumber}}</span>
		</td>
	</tr>
	<tr>
		<td><b>MailingStreetDir</b> : <span>{{@$result->Reports[0]->Data->Filters->MailingStreetDir}}</span>
		</td>
		<td><b>MailingStreetName</b> : <span>{{@$result->Reports[0]->Data->Filters->MailingStreetName}}</span>
		</td>
	</tr>
	<tr>
		<td><b>MailingStreetTypes</b> : <span>{{@$result->Reports[0]->Data->Filters->MailingStreetTypes}}</span>
		</td>
		<td><b>MailingStreetPostDir</b> : <span>{{@$result->Reports[0]->Data->Filters->MailingStreetPostDir}}</span>
		</td>
	</tr>
	<tr>
		<td><b>MailingUnit</b> : <span>{{@$result->Reports[0]->Data->Filters->MailingUnit}}</span>
		</td>
		<td><b>MailingCities</b> : <span>{{@$result->Reports[0]->Data->Filters->MailingCities}}</span>
		</td>
	</tr>
	<tr>
		<td><b>MailingStateFips</b> : <span>{{@$result->Reports[0]->Data->Filters->MailingStateFips}}</span>
		</td>
		<td><b>MailingCountyFips</b> : <span>{{@$result->Reports[0]->Data->Filters->MailingCountyFips}}</span>
		</td>
	</tr>
	<tr>
		<td><b>MailingStateCountyFips</b> : <span>{{@$result->Reports[0]->Data->Filters->MailingStateCountyFips}}</span>
		</td>
		<td><b>CountyUseCode</b> : <span>{{@$result->Reports[0]->Data->Filters->CountyUseCode}}</span>
		</td>
	</tr>
	<tr>
		<td><b>ReturnAll</b> : <span>{{@$result->Reports[0]->Data->Filters->ReturnAll}}</span>
		</td>
		<td><b>ChangesMade</b> : <span>{{@$result->Reports[0]->Data->Filters->ChangesMade}}</span>
		</td>
	</tr>
	<tr>
		<td><b>MaxReturn</b> : <span>{{@$result->Reports[0]->Data->Filters->MaxReturn}}</span>
		</td>
		<td><b>PropertyId</b> : <span>{{@$result->Reports[0]->Data->Filters->PropertyId}}</span>
		</td>
	</tr>
	<tr><?php $gr = []; 
		foreach($result->Reports[0]->Data->Filters->GeographicOptions as $key=>$val){ $gr[] = $val; } 
	?>
		<td><b>SelectedPropertyIds</b> : <span>{{@$result->Reports[0]->Data->Filters->SelectedPropertyIds}}</span>
		</td>
		<td><b>GeographicOptions</b> : <span><?php echo implode(',',$gr); ?></span>
		</td>
	</tr>
	<tr>
		<td><b>LivingAreaDifference</b> : <span>{{@$result->Reports[0]->Data->Filters->LivingAreaDifference}}</span>
		</td>
		<td><b>MonthsBack</b> : <span>{{@$result->Reports[0]->Data->Filters->MonthsBack}}</span>
		</td>
	</tr>
	<tr>
		<td><b>DistanceFromSubject</b> : <span>{{@$result->Reports[0]->Data->Filters->DistanceFromSubject->DistanceFromSubject}}</span>
		</td>
		<td><b>DistanceFromSubjectMiles</b> : <span>{{@$result->Reports[0]->Data->Filters->DistanceFromSubject->DistanceFromSubjectMiles}}</span>
		</td>
	</tr>
	<tr>
		<td><b>ExcludeForeclosure</b> : <span>{{@$result->Reports[0]->Data->Filters->ExcludeForeclosure}}</span>
		</td>
		<td><b>ExcludeDistressed</b> : <span>{{@$result->Reports[0]->Data->Filters->ExcludeDistressed}}</span>
		</td>
	</tr>
	<tr>
		<td><b>ListedProperties</b> : <span>{{@$result->Reports[0]->Data->Filters->ListedProperties}}</span>
		</td>
		<td><b>ShapeWkt</b> : <span>{{@$result->Reports[0]->Data->Filters->ShapeWkt}}</span>
		</td>
	</tr>
	<tr>
		<td><b>SpatialType</b> : <span>{{@$result->Reports[0]->Data->Filters->SpatialType}}</span>
		</td>
		<td>
		</td>
	</tr>
	</table>
	<h2 style="color:#1b86e3;font-size:16px;border-bottom: 1px solid; padding-bottom: 10px;">CenterPoint</h2>
	<table class="inner-table" style="margin-top:20px;" width="100%" cellpadding="0" cellspacing="0"  align="top">
	<tr>
		<td><span>{{@$result->Reports[0]->Data->Filters->DistanceFromSubject->CenterPoint->Point['0']}}</span>
		</td>
		<td><span>{{@$result->Reports[0]->Data->Filters->DistanceFromSubject->CenterPoint->Point['1']}}</span>
		</td>
	</tr>
	</table>
<!-- Main Content End -->

<script>if(counter(page)>1){ </script><script> }
</script>
 </main>
</body>

</html>