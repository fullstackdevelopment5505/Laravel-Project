<table class="col-12 mt-3 avoid-inside-break">
    <tr>
        <td rowspan="5" width="125"><img class="property-img" src="{{ asset('assets/pdfs/empty-home.png') }}" width="110px" height="75px" alt="Image"></td>
    </tr>
    <tr>
        <td colspan="5">
            <strong>{{ $propertyData->DistanceFromSubject ? 'Comp #' . ++$key . ' - '. number_format($propertyData->DistanceFromSubject, 2) .' Miles From Subject' : 'Subject Property' }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <strong>
                {{ $propertyData->SitusAddress->StreetAddress ? strtolower($propertyData->SitusAddress->StreetAddress). ',' : '' }}
                {{ $propertyData->SitusAddress->City ? strtolower($propertyData->SitusAddress->City). ',' : '' }}
                {{ $propertyData->SitusAddress->State ?? '' }}
                {{ $propertyData->SitusAddress->Zip9 ?? '' }}
            </strong>
        </td>
    </tr>
    <tr>
        <td>
            Sale Price / Type:
            {{ $propertyData->LastMarketSaleInformation->SalePrice ? '$'. number_format($propertyData->LastMarketSaleInformation->SalePrice) : '' }}
              @if($propertyData->LastMarketSaleInformation->SalePrice || $propertyData->LastMarketSaleInformation->SaleType) / @endif
            {{ $propertyData->LastMarketSaleInformation->SaleType ? strtolower($propertyData->LastMarketSaleInformation->SaleType) : '' }}
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>
            Sale / Rec Date:
            {{ $propertyData->LastMarketSaleInformation->SaleDate ? date('m/d/Y', strtotime($propertyData->LastMarketSaleInformation->SaleDate)) : '' }}
              @if($propertyData->LastMarketSaleInformation->SaleDate || $propertyData->LastMarketSaleInformation->RecordingDate) / @endif
            {{ $propertyData->LastMarketSaleInformation->RecordingDate ? date('m/d/Y', strtotime($propertyData->LastMarketSaleInformation->RecordingDate)) : '' }}
        </td>
        <td></td>
        <td></td>
        <td>Sale Doc #:</td>
        <td>{{ $propertyData->LastMarketSaleInformation->TransferDocumentNumber ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="6" class="line-height-10">&nbsp;</td>
    </tr>
    <tr>
        <td>Year Built / Eff:</td>
        <td>
            {{ $propertyData->PropertyCharacteristics->YearBuilt ?? '' }}
              @if($propertyData->PropertyCharacteristics->YearBuilt || $propertyData->PropertyCharacteristics->EFFYear) / @endif
            {{ $propertyData->PropertyCharacteristics->EFFYear ?? '' }}
        </td>
        <td>Lot Area:</td>
        <td>{{ $propertyData->SiteInformation->LotArea ? number_format($propertyData->SiteInformation->LotArea) .' Sq. Ft.' : '' }}</td>
        <td>Bedrooms:</td>
        <td>{{ $propertyData->PropertyCharacteristics->Bedrooms ?? '' }}</td>
    </tr>
    <tr>
        <td>Assessed Value:</td>
        <td>{{ $propertyData->AssessedValue ? '$'. number_format($propertyData->AssessedValue) : '' }}</td>
        <td>Living Area:</td>
        <td>{{ $propertyData->PropertyCharacteristics->LivingArea ? number_format($propertyData->PropertyCharacteristics->LivingArea) .' Sq. Ft.' : '' }}</td>
        <td>Baths (F / H):</td>
        <td>{{ $propertyData->PropertyCharacteristics->FullBath ?? '' }}
              @if($propertyData->PropertyCharacteristics->FullBath || $propertyData->PropertyCharacteristics->HalfBath) / @endif
            {{ $propertyData->PropertyCharacteristics->HalfBath ?? '' }}
        </td>
    </tr>
    <tr>
        <td>Land Use:</td>
        <td>{{ $propertyData->SiteInformation->LandUse ?? '' }}</td>
        <td>Pool:</td>
        <td>{{ $propertyData->PropertyCharacteristics->Pool ?? '' }}</td>
        <td>Total Rooms:</td>
        <td>{{ $propertyData->PropertyCharacteristics->TotalRooms ? number_format($propertyData->PropertyCharacteristics->TotalRooms) : '' }}</td>
    </tr>
    <tr>
        <td>Owner Name:</td>
        <td>
            {{ $propertyData->OwnerName1Full ? strtolower($propertyData->OwnerName1Full) : '' }}
            @if($propertyData->OwnerName1Full && $propertyData->OwnerName2Full) \ @endif
            {{ $propertyData->OwnerName2Full ? strtolower($propertyData->OwnerName2Full) : '' }}
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Mailing Address: </td>
        <td>
            {{ $propertyData->OwnerMailingAddress->StreetAddress ? strtolower($propertyData->OwnerMailingAddress->StreetAddress). ',' : '' }}
            {{ $propertyData->OwnerMailingAddress->City ? strtolower($propertyData->OwnerMailingAddress->City). ',' : '' }}
            {{ $propertyData->OwnerMailingAddress->State ?? '' }}
            {{ $propertyData->OwnerMailingAddress->Zip9 ?? '' }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>County:</td>
        <td>{{ $propertyData->SitusAddress->County ? strtolower($propertyData->SitusAddress->County) : '' }}</td>
        <td>Zoning:</td>
        <td>{{ $propertyData->SiteInformation->Zoning ?? '' }}</td>
        <td>Stories:</td>
        <td>{{ $propertyData->PropertyCharacteristics->NumberOfStories ?? '' }}</td>
    </tr>
    <tr>
        <td>APN:</td>
        <td>{{ $propertyData->LocationInformation->APN ?? '' }}</td>
        <td>Acres:</td>
        <td>{{ $propertyData->SiteInformation->Acres ? round($propertyData->SiteInformation->Acres, 2) : '' }}</td>
        <td>Roof Material: </td>
        <td>{{ $propertyData->PropertyCharacteristics->RoofMaterial ?? '' }}</td>
    </tr>
    <tr>
        <td>Subdivision:</td>
        <td>{{ $propertyData->LocationInformation->Subdivision ? strtolower($propertyData->LocationInformation->Subdivision) : '' }}</td>
        <td>Cooling:</td>
        <td>{{ $propertyData->PropertyCharacteristics->AirConditioning ? strtolower($propertyData->PropertyCharacteristics->AirConditioning) : '' }}</td>
        <td>Prior Sale Price:</td>
        <td>{{ $propertyData->PriorSaleInformation->PriorSalePrice ? '$'. number_format($propertyData->PriorSaleInformation->PriorSalePrice) : '' }}</td>
    </tr>
    <tr>
        <td>Census Tct / Blk:</td>
        <td>
            {{ $propertyData->LocationInformation->CensusTract ?? '' }}
              @if($propertyData->LocationInformation->CensusTract || $propertyData->LocationInformation->CensusBlock) / @endif
            {{ $propertyData->LocationInformation->CensusBlock ?? '' }}
        </td>
        <td>Fireplace:</td>
        <td>{{ $propertyData->PropertyCharacteristics->FirePlaceCount ? number_format($propertyData->PropertyCharacteristics->FirePlaceCount) : '' }}</td>
        <td>Prior Sale Date:</td>
        <td>{{ $propertyData->PriorSaleInformation->PriorSaleDate ? date('m/d/Y', strtotime($propertyData->PriorSaleInformation->PriorSaleDate)) : '' }}</td>
    </tr>
    <tr>
        <td>1st Mtg / Type:</td>
        <td>
            {{ $propertyData->LastMarketSaleInformation->FirstMortgageAmount ? '$'. number_format($propertyData->LastMarketSaleInformation->FirstMortgageAmount) : '' }}
              @if($propertyData->LastMarketSaleInformation->FirstMortgageAmount || $propertyData->LastMarketSaleInformation->FirstMortgageType) / @endif
            {{ isset($mortgageType[$propertyData->LastMarketSaleInformation->FirstMortgageType]) ? $mortgageType[$propertyData->LastMarketSaleInformation->FirstMortgageType] : $propertyData->LastMarketSaleInformation->FirstMortgageType }}
        </td>
        <td>Parking Type:</td>
        <td>{{ $propertyData->PropertyCharacteristics->ParkingType ? strtolower($propertyData->PropertyCharacteristics->ParkingType) : '' }}</td>
        <td>Prior Rec Date:</td>
        <td>{{ $propertyData->PriorSaleInformation->PriorRecordingDate ? date('m/d/Y', strtotime($propertyData->PriorSaleInformation->PriorRecordingDate)) : '' }}</td>
    </tr>
    <tr>
        <td>Res / Comm Units:</td>
        <td></td>
        <td>Flood Zone Code:</td>
        <td>{{ $propertyData->SiteInformation->FloodZoneCode ?? '' }}</td>
        <td>Prior Sale Doc #:</td>
        <td>{{ $propertyData->PriorSaleInformation->PriorDocNumber ?? '' }}</td>
    </tr>
    <tr>
        <td style="border-bottom: 1px solid #d6d6d6;" colspan="6"><br></td>
    </tr>
</table>
