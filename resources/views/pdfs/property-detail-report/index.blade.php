<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="{{ asset('/assets/pdfs/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/pdfs/sales.css') }}" />
    <title>Property Detail Report</title>
    <style media="screen">
      td {
        width: 150px;
      }

      table {
        width: 100%;
      }

      hr {
        margin-top: 4px;
        margin-bottom: 8px;
      }
    </style>
  </head>
  <body>
    <div class="col-12">
      <section>
        <table class="avoid-inside-break">
          <tr>
            <th colspan="6">
              <h6><strong>Owner Information</strong></h6>
            </th>
          </tr>
          <tr>
            <td valign="top">Owner Name</td>
            <td colspan="2">{{ strtolower($reportData->owner_information->OwnerNames) ?? '' }}</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Vesting:</td>
            <td>{{ strtolower($reportData->owner_information->OwnerVestingInfo->VestingOwner) ?? '' }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Mailing Address:</td>
            <td colspan="2">{{ strtolower($reportData->owner_information->MailingAddress->StreetAddress) ?? '' }}, {{ strtolower($reportData->owner_information->MailingAddress->City) ?? '' }}, {{ $reportData->owner_information->MailingAddress->State ?? '' }} {{ $reportData->owner_information->MailingAddress->Zip9 ?? '' }}</td>
            <td></td>
            <td>Occupancy:</td>
            <td>{{ $reportData->owner_information->Occupancy ?? '' }}</td>
          </tr>
        </table>
        <hr />
        <table class="avoid-inside-break">
          <tr>
            <th colspan="6">
              <h6><strong>Location Information</strong></h6>
            </th>
          </tr>
          <tr>
            <td valign="top">Legal Description:</td>
            <td colspan="3" class="text-justify" style="padding-right: 40px;">{{ $reportData->location_information->LegalDescription ?? '' }}</td>
            <td valign="top">County:</td>
            <td valign="top">{{ $reportData->property_address->County ?? '' }}, {{ $reportData->property_address->State }}</td>
          </tr>
          <tr>
            <td>APN:</td>
            <td>{{ $reportData->location_information->Apn ?? '' }}</td>
            <td>Alternate APN:</td>
            <td>{{ $reportData->location_information->AlternateApn ?? '' }}</td>
            <td>Census Tract / Block:</td>
            <td>
              {{ $reportData->location_information->CensusTract ?? '' }}
                @if($reportData->location_information->CensusTract || $reportData->location_information->CensusBlock) / @endif
              {{ $reportData->location_information->CensusBlock ?? '' }}
            </td>
          </tr>
          <tr>
            <td>Munic / Twnshp:</td>
            <td>{{ $reportData->location_information->MunicipalityTownship ?? '' }}</td>
            <td>Twnshp-Rng-Sec:</td>
            <td>{{ $reportData->location_information->TownshipRangeSection ?? '' }}</td>
            <td>Legal Lot / Block:</td>
            <td>
              {{ $reportData->location_information->LegalLot ?? '' }}
                @if($reportData->location_information->LegalLot || $reportData->location_information->LegalBlock) / @endif
              {{ $reportData->location_information->LegalBlock ?? '' }}
            </td>
          </tr>
          <tr>
            <td>Subdivision:</td>
            <td>{{ $reportData->location_information->Subdivision ?? '' }}</td>
            <td>Tract #:</td>
            <td>{{ $reportData->location_information->TractNumber ?? '' }}</td>
            <td>Legal Book / Page:</td>
            <td>{{ $reportData->location_information->LegalBookPage ?? '' }}</td>
          </tr>
          <tr>
            <td>Neighborhood:</td>
            <td>{{ $reportData->location_information->NeighborhoodName ?? '' }}</td>
            <td>School District:</td>
            <td>{{ $reportData->location_information->SchoolDistrict ?? '' }}</td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Elementary School:</td>
            <td>{{ $reportData->location_information->ElementarySchool ?? '' }}</td>
            <td>Middle School:</td>
            <td>{{ $reportData->location_information->MiddleSchool ?? '' }}</td>
            <td>High School:</td>
            <td>{{ $reportData->location_information->HighSchool ?? '' }}</td>
          </tr>
          <tr>
            <td>Latitude:</td>
            <td>{{ $reportData->location_information->Latitude ? round($reportData->location_information->Latitude, 5) : '' }}</td>
            <td>Longitude:</td>
            <td>{{ $reportData->location_information->Longitude ? round($reportData->location_information->Longitude, 5) : '' }}</td>
            <td></td>
            <td></td>
          </tr>
        </table>
        <hr />
        <table class="avoid-inside-break">
          <tr>
            <th colspan="6">
              <h6><strong>Last Transfer / Conveyance - Current Owner</strong></h6>
            </th>
          </tr>
          <tr>
            <td>Transfer / Rec Date:</td>
            <td>
              {{ $reportData->owner_transfer_information->SaleDate ? date('m/d/Y', strtotime($reportData->owner_transfer_information->SaleDate)) : '' }}
                @if($reportData->owner_transfer_information->SaleDate || $reportData->owner_transfer_information->RecordingSaleDate) / @endif
              {{ $reportData->owner_transfer_information->RecordingSaleDate ? date('m/d/Y', strtotime($reportData->owner_transfer_information->RecordingSaleDate)) : '' }}
            </td>
            <td>Price:</td>
            <td>
              {{ $reportData->owner_transfer_information->SalePrice ? '$'. number_format($reportData->owner_transfer_information->SalePrice) : '' }}
            </td>
            <td>Transfer Doc #:</td>
            <td>{{ $reportData->owner_transfer_information->TransferDocumentNumber ?? '' }}</td>
          </tr>
          <tr>
            <td>Buyer Name:</td>
            <td>{{ $reportData->owner_transfer_information->BuyerName ?? '' }}</td>
            <td>Seller Name:</td>
            <td>{{ $reportData->owner_transfer_information->SellerName ?? '' }}</td>
            <td>Deed Type:</td>
            <td>{{ $reportData->owner_transfer_information->DeedType  ?? '' }}</td>
          </tr>
        </table>
        <hr />
        <table class="avoid-inside-break">
          <tr>
            <th colspan="6">
              <h6><strong>Last Market Sale</strong></h6>
            </th>
          </tr>
          <tr>
            <td>Sale / Rec Date:</td>
            <td>
              {{ $reportData->last_market_sale_information->SaleDate ? date('m/d/Y', strtotime($reportData->last_market_sale_information->SaleDate)) : '' }}
                @if($reportData->last_market_sale_information->SaleDate || $reportData->last_market_sale_information->RecordingDate) / @endif
              {{ $reportData->last_market_sale_information->RecordingDate ? date('m/d/Y', strtotime($reportData->last_market_sale_information->RecordingDate)) : '' }}
            </td>
            <td>Sale Price / Type:</td>
            <td>
              {{ $reportData->last_market_sale_information->SalePrice ? '$'. number_format($reportData->last_market_sale_information->SalePrice) : '' }}
                @if($reportData->last_market_sale_information->SalePrice || $reportData->last_market_sale_information->SaleType) / @endif
              {{ $reportData->last_market_sale_information->SaleType ?? '' }}
            </td>
            <td>Deed Type:</td>
            <td>{{ $reportData->last_market_sale_information->DeedType ?? '' }}</td>
          </tr>
          <tr>
            <td>Multi / Split Sale:</td>
            <td>{{ $reportData->last_market_sale_information->MultiOrSplitSaleIdentifier ?? '' }}</td>
            <td>Price / Sq. Ft.:</td>
            <td>{{ $reportData->last_market_sale_information->PricePerSquareFoot ? '$'. round($reportData->last_market_sale_information->PricePerSquareFoot) : '' }}</td>
            <td>New Construction:</td>
            <td>{{ $reportData->last_market_sale_information->NewConstruction ?? '' }}</td>
          </tr>
          <tr>
            <td>1st Mtg Amt / Type:</td>
            <td>
              {{ $reportData->last_market_sale_information->FirstMortgageAmount ? '$'. number_format($reportData->last_market_sale_information->FirstMortgageAmount) : '' }}
                @if($reportData->last_market_sale_information->FirstMortgageAmount || $reportData->last_market_sale_information->FirstMortgageType) / @endif
              {{ $reportData->last_market_sale_information->FirstMortgageType ?? '' }}
            </td>
            <td>1st Mtg Rate / Type:</td>
            <td>
              {{ $reportData->last_market_sale_information->FirstMortgageInterestRate ? '$'. number_format($reportData->last_market_sale_information->FirstMortgageInterestRate) : '' }}
                @if($reportData->last_market_sale_information->FirstMortgageInterestRate || $reportData->last_market_sale_information->FirstMortgageInterestRate) / @endif
              {{ $reportData->last_market_sale_information->FirstMortgageInterestType ?? '' }}
            </td>
            <td>1st Mtg Doc #:</td>
            <td>{{ $reportData->last_market_sale_information->FirstMortgageDocumentNumber ?? '' }}</td>
          </tr>
          <tr>
            <td>2nd Mtg Amt / Type:</td>
            <td>
              {{ $reportData->last_market_sale_information->SecondMortgageAmount ? '$'. number_format($reportData->last_market_sale_information->SecondMortgageAmount) : '' }}
                @if($reportData->last_market_sale_information->SecondMortgageAmount || $reportData->last_market_sale_information->SecondMortgageType) / @endif
              {{ $reportData->last_market_sale_information->SecondMortgageType ?? '' }}
            </td>
            <td>2nd Mtg Rate / Type:</td>
            <td>
              {{ $reportData->last_market_sale_information->SecondMortgageInterestRate ? '$'. number_format($reportData->last_market_sale_information->SecondMortgageInterestRate) : '' }}
                @if($reportData->last_market_sale_information->SecondMortgageInterestRate || $reportData->last_market_sale_information->SecondMortgageInterestType) / @endif
              {{ $reportData->last_market_sale_information->SecondMortgageInterestType ?? '' }}
            </td>
            <td>Sale Doc #:</td>
            <td>{{ $reportData->last_market_sale_information->TransferDocumentNumber ?? '' }}</td>
          </tr>
          <tr>
            <td>Seller Name:</td>
            <td>{{ $reportData->last_market_sale_information->SellerName ?? '' }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Lender:</td>
            <td>{{ $reportData->last_market_sale_information->Lender ?? '' }}</td>
            <td></td>
            <td></td>
            <td>Title Company:</td>
            <td>{{ $reportData->last_market_sale_information->TitleCompany ?? '' }}</td>
          </tr>
        </table>
        <hr />
        <table class="avoid-inside-break">
          <tr>
            <th colspan="6">
              <h6><strong>Prior Sale Information</strong></h6>
            </th>
          </tr>
          <tr>
            <td>Sale / Rec Date:</td>
            <td>
              {{ $reportData->prior_sale_information->PriorSaleDate ? date('m/d/Y', strtotime($reportData->prior_sale_information->PriorSaleDate)) : '' }}
                @if($reportData->prior_sale_information->PriorSaleDate || $reportData->prior_sale_information->PriorRecordingDate) / @endif
              {{ $reportData->prior_sale_information->PriorRecordingDate ? date('m/d/Y', strtotime($reportData->prior_sale_information->PriorRecordingDate)) : '' }}
            </td>
            <td>Sale Price / Type:</td>
            <td>
              {{ $reportData->prior_sale_information->PriorSalePrice ? '$'. number_format($reportData->prior_sale_information->PriorSalePrice) : '' }}
                @if($reportData->prior_sale_information->PriorSalePrice || $reportData->prior_sale_information->PriorSaleTypeDescription) / @endif
              {{ $reportData->prior_sale_information->PriorSaleTypeDescription ?? ''}}
            </td>
            <td>Prior Deed Type:</td>
            <td>{{ $reportData->prior_sale_information->PriorDeedType ?? '' }}</td>
          </tr>
          <tr>
            <td>1st Mtg Amt / Type:</td>
            <td>
              {{ $reportData->prior_sale_information->PriorFirstMortgageAmount ? '$'. number_format($reportData->prior_sale_information->PriorFirstMortgageAmount) : '' }}
                @if($reportData->prior_sale_information->PriorFirstMortgageAmount || $reportData->prior_sale_information->PriorFirstMortgageType) / @endif
              {{ $reportData->prior_sale_information->PriorFirstMortgageType ?? '' }}
            </td>
            <td>1st Mtg Rate / Type:</td>
            <td>
              {{ $reportData->prior_sale_information->PriorFirstMortgageInterestRate ? '$'. number_format($reportData->prior_sale_information->PriorFirstMortgageInterestRate) : '' }}
                @if($reportData->prior_sale_information->PriorFirstMortgageInterestRate || $reportData->prior_sale_information->PriorFirstMortgageInterestType) / @endif
              {{ $reportData->prior_sale_information->PriorFirstMortgageInterestType ?? '' }}
            </td>
            <td>Prior Sale Doc #:</td>
            <td>{{ $reportData->prior_sale_information->PriorDocNumber ?? '' }}</td>
          </tr>
          <tr>
            <td>Prior Lender:</td>
            <td>{{ $reportData->prior_sale_information->PriorLender ?? '' }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </table>
        <hr />
        <table class="avoid-inside-break">
          <tr>
            <th colspan="6">
              <h6><strong>Property Characteristics</strong></h6>
            </th>
          </tr>
          <tr>
            <td>Gross Living Area:</td>
            <td>{{ $reportData->property_characteristics->GrossArea ? number_format($reportData->property_characteristics->GrossArea) .' Sq. Ft.' : '' }}</td>
            <td>Total Rooms:</td>
            <td>{{ $reportData->property_characteristics->TotalRooms ?? '' }}</td>
            <td>Year Built / Eff:</td>
            <td>
              {{ $reportData->property_characteristics->YearBuilt ?? '' }}
                @if($reportData->property_characteristics->YearBuilt || $reportData->property_characteristics->EFFYear) / @endif
              {{ $reportData->property_characteristics->EFFYear ?? '' }}</td>
          </tr>
          <tr>
            <td>Living Area:</td>
            <td>{{ $reportData->property_characteristics->LivingArea ? number_format($reportData->property_characteristics->LivingArea) .' Sq. Ft.' : '' }}</td>
            <td>Bedrooms:</td>
            <td>{{ $reportData->property_characteristics->Bedrooms ?? '' }}</td>
            <td>Stories:</td>
            <td>{{ $reportData->property_characteristics->NumberOfStories ?? '' }}</td>
          </tr>
          <tr>
            <td>Total Adj. Area:</td>
            <td>{{ $reportData->property_characteristics->TotalAdjustedArea ? number_format($reportData->property_characteristics->TotalAdjustedArea) .' Sq. Ft.' : '' }}</td>
            <td>Baths (F / H)</td>
            <td>
              {{ $reportData->property_characteristics->FullBath ?? '' }}
                @if($reportData->property_characteristics->FullBath || $reportData->property_characteristics->HalfBath) / @endif
              {{ $reportData->property_characteristics->HalfBath ?? '' }}</td>
            <td>Parking Type:</td>
            <td>{{ $reportData->property_characteristics->ParkingType ?? '' }}</td>
          </tr>
          <tr>
            <td>Above Grade:</td>
            <td>{{ $reportData->property_characteristics->AboveGrade ?? '' }}</td>
            <td>Pool:</td>
            <td>{{ $reportData->property_characteristics->Pool ?? '' }}</td>
            <td>Garage #:</td>
            <td>{{ $reportData->property_characteristics->GarageCapacity ?? '' }}</td>
          </tr>
          <tr>
            <td>Basement Area:</td>
            <td>{{ $reportData->property_characteristics->BasementArea ?? '' }}</td>
            <td>Fireplace:</td>
            <td>{{ $reportData->property_characteristics->Fireplace ?? '' }}</td>
            <td>Garage Area:</td>
            <td>{{ $reportData->property_characteristics->GarageArea ? $reportData->property_characteristics->GarageArea .' Sq. Ft.' : ''}}</td>
          </tr>
          <tr>
            <td>Style:</td>
            <td>{{ $reportData->property_characteristics->Style ?? '' }}</td>
            <td>Cooling:</td>
            <td>{{ $reportData->property_characteristics->AirConditioning ?? '' }}</td>
            <td>Porch Type:</td>
            <td>{{ $reportData->property_characteristics->PorchType ?? '' }}</td>
          </tr>
          <tr>
            <td>Foundation:</td>
            <td>{{ $reportData->property_characteristics->Foundation ?? '' }}</td>
            <td>Heating:</td>
            <td>{{ $reportData->property_characteristics->HeatType ?? '' }}</td>
            <td>Patio Type:</td>
            <td>{{ $reportData->property_characteristics->PatioType ?? '' }}</td>
          </tr>
          <tr>
            <td>Quality:</td>
            <td>{{ $reportData->property_characteristics->Quality ?? '' }}</td>
            <td>Exterior Wall:</td>
            <td>{{ $reportData->property_characteristics->ExteriorWall ?? '' }}</td>
            <td>Roof Type:</td>
            <td>{{ $reportData->property_characteristics->RoofType ?? '' }}</td>
          </tr>
          <tr>
            <td>Condition:</td>
            <td>{{ $reportData->property_characteristics->Condition ?? '' }}</td>
            <td>Construction Type:</td>
            <td>{{ $reportData->property_characteristics->ConstructType ?? '' }}</td>
            <td>Roof Material:</td>
            <td>{{ $reportData->property_characteristics->RoofMaterial ?? '' }}</td>
          </tr>
        </table>
        <hr />
        <table class="avoid-inside-break">
          <tr>
            <th colspan="6">
              <h6><strong>Site Information</strong></h6>
            </th>
          </tr>
          <tr>
            <td>Land Use:</td>
            <td>{{ $reportData->site_information->LandUse ?? '' }}</td>
            <td>Lot Area:</td>
            <td>{{ $reportData->site_information->LotArea ? number_format($reportData->site_information->LotArea) .' Sq. Ft.' : '' }}</td>
            <td>Zoning:</td>
            <td>{{ $reportData->site_information->Zoning ?? '' }}</td>
          </tr>
          <tr>
            <td>State Use:</td>
            <td>{{ $reportData->site_information->StateUse ?? '' }}</td>
            <td>Lot Width / Depth:</td>
            <td>
              {{ $reportData->site_information->LotWidth ?? '' }}
                @if($reportData->site_information->LotWidth || $reportData->site_information->LotDepth) / @endif
              {{ $reportData->site_information->LotDepth ?? '' }}
            </td>
            <td># of Buildings</td>
            <td>{{ $reportData->site_information->NumberOfBuildings ?? '' }}</td>
          </tr>
          <tr>
            <td>County Use:</td>
            <td>
              {{ $reportData->site_information->CountyUseCode }}
                @if($reportData->site_information->CountyUseCode && $reportData->site_information->CountyUse) - @endif
              {{ $reportData->site_information->CountyUse ?? '' }}
            </td>
            <td>Usable Lot:</td>
            <td>{{ $reportData->site_information->UsableLot ?? '' }}</td>
            <td>Res / Comm Units:</td>
            <td>
              {{ $reportData->site_information->UnitsResidential ?? '' }}
                @if($reportData->site_information->UnitsResidential || $reportData->site_information->UnitsCommercial) / @endif
              {{ $reportData->site_information->UnitsCommercial ?? '' }}
            </td>
          </tr>
          <tr>
            <td>Site Influence:</td>
            <td>{{ $reportData->site_information->SiteInfluence ?? '' }}</td>
            <td>Acres:</td>
            <td>{{ $reportData->site_information->Acres ?? '' }}</td>
            <td>Water / Sewer Type:</td>
            <td>
              {{ $reportData->site_information->WaterType ?? '' }}
                @if($reportData->site_information->WaterType || $reportData->site_information->SewerType) / @endif
              {{ $reportData->site_information->SewerType ?? '' }}</td>
          </tr>
          <tr>
            <td>Flood Zone Code:</td>
            <td>{{ $reportData->site_information->FloodZoneCode ?? '' }}</td>
            <td>Flood Map #:</td>
            <td>{{ $reportData->site_information->FloodMap ?? '' }}</td>
            <td>Flood Map Date:</td>
            <td>{{ $reportData->site_information->FloodMapDate ? date('m/d/Y', strtotime($reportData->site_information->FloodMapDate)) : '' }}</td>
          </tr>
          <tr>
            <td>Community Name:</td>
            <td>{{ $reportData->site_information->CommunityName ?? '' }}</td>
            <td>Flood Panel #</td>
            <td>{{ $reportData->site_information->FloodPanel ?? '' }}</td>
            <td>Inside SFHA:</td>
            <td>{{ $reportData->site_information->InsideSFHA ?? '' }}</td>
          </tr>
        </table>
        <table class="avoid-inside-break">
          <tr>
            <th colspan="6">
              <h6><strong>Tax Information</strong></h6>
            </th>
          </tr>
          <tr>
            <td>Assessed Year:</td>
            <td>{{ $reportData->tax_information->AssessedYear ?? '' }}</td>
            <td>Assessed Value:</td>
            <td>{{ $reportData->tax_information->AssessedValue ? '$'. number_format($reportData->tax_information->AssessedValue) : '' }}</td>
            <td>Market Total Value:</td>
            <td>{{ $reportData->tax_information->MarketValue ? '$'. number_format($reportData->tax_information->MarketValue) : '' }}</td>
          </tr>
          <tr>
            <td>Tax Year:</td>
            <td>{{ $reportData->tax_information->TaxYear ?? '' }}</td>
            <td>Land Value:</td>
            <td>{{ $reportData->tax_information->LandValue ? '$'. number_format($reportData->tax_information->LandValue) : '' }}</td>
            <td>Market Land Value:</td>
            <td>{{ $reportData->tax_information->MarketLandValue ? '$'. number_format($reportData->tax_information->MarketLandValue) : '' }}</td>
          </tr>
          <tr>
            <td>Tax Area:</td>
            <td>{{ $reportData->tax_information->TaxArea ?? '' }}</td>
            <td>Improvement Value:</td>
            <td>{{ $reportData->tax_information->ImprovementValue ? '$'. number_format($reportData->tax_information->ImprovementValue) : '' }}</td>
            <td>Market Imprv Value:</td>
            <td>{{ $reportData->tax_information->MarketImprovValue ? '$'. number_format($reportData->tax_information->MarketImprovValue) : '' }}</td>
          </tr>
          <tr>
            <td>Property Tax:</td>
            <td>{{ $reportData->tax_information->PropertyTax ? '$'. number_format($reportData->tax_information->PropertyTax, 2) : '' }}</td>
            <td>Improved %:</td>
            <td>{{ $reportData->tax_information->ImprovedPercent ? $reportData->tax_information->ImprovedPercent .'%' : '' }}</td>
            <td>Market Imprv %:</td>
            <td>{{ $reportData->tax_information->MarketImprovValuePercent ? $reportData->tax_information->MarketImprovValuePercent.'%' : '' }}</td>
          </tr>
          <tr>
            <td>Exemption:</td>
            <td>{{ $reportData->tax_information->TaxExemption ?? '' }}</td>
            <td>Delinquent Year:</td>
            <td>{{ $reportData->tax_information->DelinquentYear ?? '' }}</td>
            <td></td>
            <td></td>
          </tr>
        </table>
      </section>
      <br />
      <div class="w-100" style="page-break-before: always;">
        <br />
        <p class="text-justify mt-7">
          Disclaimer: This report: (i) is not an insured product or service or an abstract, legal opinion or a representation of the condition of title to real property, and (ii) is issued exclusively for the benefit of First American
          Equity Finders LLC (Equity Finders) customers and may not be used or relied upon by any other person. Estimated property values are: (i) based on available data; (ii) are not guaranteed or warranted; (iii) do not constitute an
          appraisal; and (iv) should not be relied upon in lieu of an appraisal. Equity Finders does not represent or warrant that the information is complete or free from error, and expressly disclaims any liability to any person or entity
          for loss or damage caused by errors or omissions in the report. If the "verified" logo ( ) is displayed, or a record is designated "verified," Equity Finder's algorithm matched fields from two or more data sources to confirm
          source data.
        </p>
        <p>
          This report is not title insurance. Pursuant to S. 627.7843, Florida statutes, the maximum liability of the issuer of this property information report for errors or omissions in this property information report is limited to the
          amount paid for this property information report, and is further limited to the person(s) expressly identified by name in the property information report as the recipient(s) of the property information report. School information
          is copyrighted and provided by GreatSchools.org.
        </p>
      </div>
    </div>
  </body>
</html>
