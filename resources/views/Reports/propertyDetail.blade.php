
	<div>
		<h1>Report Name: Property Detail Report</h1>
		<h4>Situs Address</h4>
		<ul>
			<li>Street Address : <b>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->StreetAddress}}</b></li>
			<li>City : <b>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->City}}</b></li>
			<li>State : <b>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->State}}</b></li>
			<li>Zip9 : <b>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->Zip9}}</b></li>
			<li>County : <b>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->County}}</b></li>
			<li>Situs Carrier Route : <b>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->SitusCarrierRoute}}</b></li>
			<li>APN : <b>{{@$result->Reports[0]->Data->SubjectProperty->SitusAddress->APN}}</b></li>
		</ul>


		<h4>Parsed Street Address</h4>
		<ul>
			<li>Direction Prefix : <b>{{@$result->Reports[0]->Data->SubjectProperty->ParsedStreetAddress->DirectionPrefix}}</b></li>
			<li>Standardized House Number : <b>{{@$result->Reports[0]->Data->SubjectProperty->ParsedStreetAddress->StandardizedHouseNumber}}</b></li>
			<li>Street Name : <b>{{@$result->Reports[0]->Data->SubjectProperty->ParsedStreetAddress->StreetName}}</b></li>
			<li>Apartment Or Unit : <b>{{@$result->Reports[0]->Data->SubjectProperty->ParsedStreetAddress->ApartmentOrUnit}}</b></li>
		</ul>

		<h4>Owner Information</h4>
		<ul>
			<li>Owner Names : <b>{{@$result->Reports[0]->Data->OwnerInformation->OwnerNames}}</b></li>
			<li>Owner Occupied Indicator : <b>{{@$result->Reports[0]->Data->OwnerInformation->OwnerOccupiedIndicator}}</b></li>
			<li>Occupancy : <b>{{@$result->Reports[0]->Data->OwnerInformation->Occupancy}}</b></li>
		</ul>

		<h4>Mailing Address</h4>
		<ul>
			<li>Street Address : <b>{{@$result->Reports[0]->Data->OwnerInformation->MailingAddress->StreetAddress}}</b></li>
			<li>City : <b>{{@$result->Reports[0]->Data->OwnerInformation->MailingAddress->City}}</b></li>
			<li>State : <b>{{@$result->Reports[0]->Data->OwnerInformation->MailingAddress->State}}</b></li>
			<li>Zip 9 : <b></b>{{@$result->Reports[0]->Data->OwnerInformation->MailingAddress->Zip9}}</li>
			<li>Mail Carrier Route : <b>{{@$result->Reports[0]->Data->OwnerInformation->MailingAddress->MailCarrierRoute}}</b></li>
		</ul>


		<h4>Location Information</h4>
		<ul>
			<li>Legal Description : <b>{{@$result->Reports[0]->Data->LocationInformation->LegalDescription}}</b></li>
			<li>APN : <b>{{@$result->Reports[0]->Data->LocationInformation->APN}}</b></li>
			<li>Alternate APN : <b>{{@$result->Reports[0]->Data->LocationInformation->AlternateAPN}}</b></li>
			<li>Tax Account Number : <b>{{@$result->Reports[0]->Data->LocationInformation->TaxAccountNumber}}</b></li>
			<li>Subdivision : <b>{{@$result->Reports[0]->Data->LocationInformation->Subdivision}}</b></li>
			<li>Latitude : <b>{{@$result->Reports[0]->Data->LocationInformation->Latitude}}</b></li>
			<li>Longitude : <b>{{@$result->Reports[0]->Data->LocationInformation->Longitude}}</b></li>
			<li>County Fips : <b>{{@$result->Reports[0]->Data->LocationInformation->CountyFips}}</b></li>
			<li>Township Range Section : <b>{{@$result->Reports[0]->Data->LocationInformation->TownshipRangeSection}}</b></li>
			<li>Municipality Township : <b>{{@$result->Reports[0]->Data->LocationInformation->MunicipalityTownship}}</b></li>
			<li>Census Tract : <b>{{@$result->Reports[0]->Data->LocationInformation->CensusTract}}</b></li>
			<li>Census Block : <b>{{@$result->Reports[0]->Data->LocationInformation->CensusBlock}}</b></li>
			<li>Tract Number : <b>{{@$result->Reports[0]->Data->LocationInformation->TractNumber}}</b></li>
			<li>Legal Book Page : <b>{{@$result->Reports[0]->Data->LocationInformation->LegalBookPage}}</b></li>
			<li>LegalLot : <b>{{@$result->Reports[0]->Data->LocationInformation->LegalLot}}</b></li>
			<li>Map Reference One : <b>{{@$result->Reports[0]->Data->LocationInformation->MapReferenceOne}}</b></li>
			<li>Map Reference Two : <b>{{@$result->Reports[0]->Data->LocationInformation->MapReferenceTwo}}</b></li>
			<li>Neighborhood Name : <b>{{@$result->Reports[0]->Data->LocationInformation->NeighborhoodName}}</b></li>
			<li>School District : <b>{{@$result->Reports[0]->Data->LocationInformation->SchoolDistrict}}</b></li>
			<li>Elementary School : <b>{{@$result->Reports[0]->Data->LocationInformation->ElementarySchool}}</b></li>
			<li>Middle School : <b>{{@$result->Reports[0]->Data->LocationInformation->MiddleSchool}}</b></li>
			<li>High School : <b>{{@$result->Reports[0]->Data->LocationInformation->HighSchool}}</b></li>
		</ul>

		<h4>Site Information</h4>
		<ul>
			<li>Zoning : <b>{{@$result->Reports[0]->Data->SiteInformation->Zoning}}</b></li>
			<li>Land Use : <b>{{@$result->Reports[0]->Data->SiteInformation->LandUse}}</b></li>
			<li>County Use : <b>{{@$result->Reports[0]->Data->SiteInformation->CountyUse}}</b></li>
			<li>County Use Code : <b>{{@$result->Reports[0]->Data->SiteInformation->CountyUseCode}}</b></li>
			<li>State Use : <b>{{@$result->Reports[0]->Data->SiteInformation->StateUse}}</b></li>
			<li>Site Influence : <b>{{@$result->Reports[0]->Data->SiteInformation->SiteInfluence}}</b></li>
			<li>Number Of Buildings : <b>{{@$result->Reports[0]->Data->SiteInformation->NumberOfBuildings}}</b></li>
			<li>Units Residential : <b>{{@$result->Reports[0]->Data->SiteInformation->UnitsResidential}}</b></li>
			<li>Units Commercial : <b>{{@$result->Reports[0]->Data->SiteInformation->UnitsCommercial}}</b></li>
			<li>Water Type : <b>{{@$result->Reports[0]->Data->SiteInformation->WaterType}}</b></li>
			<li>Sewer Type : <b>{{@$result->Reports[0]->Data->SiteInformation->SewerType}}</b></li>
			<li>Acres : <b>{{@$result->Reports[0]->Data->SiteInformation->Acres}}</b></li>
			<li>Lot Area : <b>{{@$result->Reports[0]->Data->SiteInformation->LotArea}}</b></li>
			<li>Lot Width : <b>{{@$result->Reports[0]->Data->SiteInformation->LotWidth}}</b></li>
			<li>Lot Depth : <b>{{@$result->Reports[0]->Data->SiteInformation->LotDepth}}</b></li>
			<li>Usable Lot : <b>{{@$result->Reports[0]->Data->SiteInformation->UsableLot}}</b></li>
			<li>Flood ZoneCode : <b>{{@$result->Reports[0]->Data->SiteInformation->FloodZoneCode}}</b></li>
			<li>Flood Map : <b>{{@$result->Reports[0]->Data->SiteInformation->FloodMap}}</b></li>
			<li>Flood MapDate : <b>{{@$result->Reports[0]->Data->SiteInformation->FloodMapDate}}</b></li>
			<li>Flood Panel : <b>{{@$result->Reports[0]->Data->SiteInformation->FloodPanel}}</b></li>
			<li>Community Name : <b>{{@$result->Reports[0]->Data->SiteInformation->CommunityName}}</b></li>
			<li>Inside SFHA : <b>{{@$result->Reports[0]->Data->SiteInformation->InsideSFHA}}</b></li>
		</ul>

		<h4>Property Characteristics</h4>
		<ul>
			<li>Gross Area : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->GrossArea}}</b></li>
			<li>Living Area : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->LivingArea}}</b></li>
			<li>Total Adjusted Area : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->TotalAdjustedArea}}</b></li>
			<li>Above Grade : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->AboveGrade}}</b></li>
			<li>Total Rooms : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->TotalRooms}}</b></li>
			<li>Bedrooms : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->Bedrooms}}</b></li>
			<li>Full Bath : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->FullBath}}</b></li>
			<li>Half Bath : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->HalfBath}}</b></li>
			<li>Year Built : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->YearBuilt}}</b></li>
			<li>EFF Year : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->EFFYear}}</b></li>
			<li>Fire Place Count : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->FirePlaceCount}}</b></li>
			<li>Fire Place Indicator : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->FirePlaceIndicator}}</b></li>
			<li>Number Of Stories : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->NumberOfStories}}</b></li>
			<li>Parking Type : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->ParkingType}}</b></li>
			<li>Garage Area : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->GarageArea}}</b></li>
			<li>Garage Capacity : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->GarageCapacity}}</b></li>
			<li>Basement Area : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->BasementArea}}</b></li>
			<li>Roof Type : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->RoofType}}</b></li>
			<li>Foundation : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->Foundation}}</b></li>
			<li>Roof Material : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->RoofMaterial}}</b></li>
			<li>Construct Type : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->ConstructType}}</b></li>
			<li>Exterior Wall : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->ExteriorWall}}</b></li>
			<li>Porch Type : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->PorchType}}</b></li>
			<li>Patio Type : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->PatioType}}</b></li>
			<li>Pool : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->Pool}}</b></li>
			<li>Air Conditioning : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->AirConditioning}}</b></li>
			<li>Heat Type : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->HeatType}}</b></li>
			<li>Style : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->Style}}</b></li>
			<li>Quality : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->Quality}}</b></li>
			<li>Condition : <b>{{@$result->Reports[0]->Data->PropertyCharacteristics->Condition}}</b></li>
		</ul>

		<h4>Tax Information</h4>
		<ul>
			<li>Tax Year : <b>{{@$result->Reports[0]->Data->TaxInformation->TaxYear}}</b></li>
			<li>Total Taxable Value : <b>{{@$result->Reports[0]->Data->TaxInformation->TotalTaxableValue}}</b></li>
			<li>Property Tax : <b>{{@$result->Reports[0]->Data->TaxInformation->PropertyTax}}</b></li>
			<li>Tax Area : <b>{{@$result->Reports[0]->Data->TaxInformation->TaxArea}}</b></li>
			<li>Tax Exemption : <b>{{@$result->Reports[0]->Data->TaxInformation->TaxExemption}}</b></li>
			<li>Delinquent Year : <b>{{@$result->Reports[0]->Data->TaxInformation->DelinquentYear}}</b></li>
			<li>Assessed Year : <b>{{@$result->Reports[0]->Data->TaxInformation->AssessedYear}}</b></li>
			<li>Assessed Value : <b>{{@$result->Reports[0]->Data->TaxInformation->AssessedValue}}</b></li>
			<li>Land Value : <b>{{@$result->Reports[0]->Data->TaxInformation->LandValue}}</b></li>
			<li>Improvement Value : <b>{{@$result->Reports[0]->Data->TaxInformation->ImprovementValue}}</b></li>
			<li>Improved Percent : <b>{{@$result->Reports[0]->Data->TaxInformation->ImprovedPercent}}</b></li>
			<li>Market Value : <b>{{@$result->Reports[0]->Data->TaxInformation->MarketValue}}</b></li>
			<li>Market Land Value : <b>{{@$result->Reports[0]->Data->TaxInformation->MarketLandValue}}</b></li>
			<li>Market Improve Value : <b>{{@$result->Reports[0]->Data->TaxInformation->MarketImproveValue}}</b></li>
			<li>Market Improv Value Percent : <b>{{@$result->Reports[0]->Data->TaxInformation->MarketImprovValuePercent}}</b></li>
		</ul>

		<h4>County Recording History</h4>
		<ul>
			<li>Sales History Start Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->SalesHistoryStartDate}}</b></li>
			<li>Sales History Through Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->SalesHistoryThroughDate}}</b></li>
			<li>Mortgage History Start Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->MortgageHistoryStartDate}}</b></li>
			<li>Mortgage History Through Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->MortgageHistoryThroughDate}}</b></li>
			<li>Assignment History Start Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->AssignmentHistoryStartDate}}</b></li>
			<li>Assignment History Through Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->AssignmentHistoryThroughDate}}</b></li>
			<li>Release History Start Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->ReleaseHistoryStartDate}}</b></li>
			<li>Release History Through Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->ReleaseHistoryThroughDate}}</b></li>
			<li>Foreclosure History Start Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->ForeclosureHistoryStartDate}}</b></li>
			<li>Foreclosure History Through Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->ForeclosureHistoryThroughDate}}</b></li>
		</ul>

		<h4>Owner Transfer Information</h4>
		<ul>
			<li>Deed Type : <b>{{@$result->Reports[0]->Data->OwnerTransferInformation->DeedType}}</b></li>
			<li>Sale Date : <b>{{@$result->Reports[0]->Data->OwnerTransferInformation->SaleDate}}</b></li>
			<li>Recording Sale Date : <b>{{@$result->Reports[0]->Data->OwnerTransferInformation->RecordingSaleDate}}</b></li>
			<li>Sale Price : <b>{{@$result->Reports[0]->Data->OwnerTransferInformation->SalePrice}}</b></li>
			<li>Transfer Document Number : <b>{{@$result->Reports[0]->Data->OwnerTransferInformation->TransferDocumentNumber}}</b></li>
			<li>Transfer Document Cmt : <b>{{@$result->Reports[0]->Data->OwnerTransferInformation->TransferDocumentCmt}}</b></li>
			<li>Formatted Transfer Document Number : <b>{{@$result->Reports[0]->Data->OwnerTransferInformation->FormattedTransferDocumentNumber}}</b></li>
			<li>First Mortgage Document Number : <b>{{@$result->Reports[0]->Data->OwnerTransferInformation->FirstMortgageDocumentNumber}}</b></li>
			<li>Buyer Name : <b>{{@$result->Reports[0]->Data->OwnerTransferInformation->BuyerName}}</b></li>
			<li>Seller Name : <b>{{@$result->Reports[0]->Data->OwnerTransferInformation->SellerName}}</b></li>
			<li>Current Through Date : <b>{{@$result->Reports[0]->Data->OwnerTransferInformation->CurrentThroughDate}}</b></li>
		</ul>

		<h4>Last Market Sale Information</h4>
		<ul>
			<li>Deed Type : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->DeedType}}</b></li>
			<li>Sale Date : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->SaleDate}}</b></li>
			<li>Recording Date : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->RecordingDate}}</b></li>
			<li>Sale Price : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->SalePrice}}</b></li>
			<li>Sale Type : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->SaleType}}</b></li>
			<li>Multi Or Split Sale Identifier : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->MultiOrSplitSaleIdentifier}}</b></li>
			<li>Buyer Name : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->BuyerName}}</b></li>
			<li>Seller Name : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->SellerName}}</b></li>
			<li>Price Per Square Foot : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->PricePerSquareFoot}}</b></li>
			<li>Transfer Document Number : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->TransferDocumentNumber}}</b></li>
			<li>Transfer Document Cmt : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->TransferDocumentCmt}}</b></li>
			<li>First Mortgage Amount : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->FirstMortgageAmount}}</b></li>
			<li>First Mortgage Type : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->FirstMortgageType}}</b></li>
			<li>First Mortgage Interest Rate : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->FirstMortgageInterestRate}}</b></li>
			<li>First Mortgage Interest Type : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->FirstMortgageInterestType}}</b></li>
			<li>First Mortgage Document Number : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->FirstMortgageDocumentNumber}}</b></li>
			<li>New Construction : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->NewConstruction}}</b></li>
			<li>Lender : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->Lender}}</b></li>
			<li>Title Company : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->TitleCompany}}</b></li>
			<li>Second Mortgage Amount : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->SecondMortgageAmount}}</b></li>
			<li>Second Mortgage Type : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->SecondMortgageType}}</b></li>
			<li>Second Mortgage Interest Rate : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->SecondMortgageInterestRate}}</b></li>
			<li>Second Mortgage Interest Type : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->SecondMortgageInterestType}}</b></li>
			<li>Last Market Sale Verified : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->LastMarketSaleVerified}}</b></li>
			<li>Current Through Date : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->CurrentThroughDate}}</b></li>
		</ul>


		<h4>Prior Sale Information</h4>
		<ul>
			<li>Prior Deed Type : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorDeedType}}</b></li>
			<li>Prior Sale Date : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorSaleDate}}</b></li>
			<li>Prior Recording Date : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorRecordingDate}}</b></li>
			<li>Prior Sale Price : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorSalePrice}}</b></li>
			<li>Prior Sale Type Description : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorSaleTypeDescription}}</b></li>
			<li>Prior Buyer Name : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorBuyerName}}</b></li>
			<li>Prior Seller Name : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorSellerName}}</b></li>
			<li>Prior First Mortgage Amount : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorFirstMortgageAmount}}</b></li>
			<li>Prior First Mortgage Type : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorFirstMortgageType}}</b></li>
			<li>Prior First Mortgage Interest Rate : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorFirstMortgageInterestRate}}</b></li>
			<li>Prior First Mortgage Interest Type : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorFirstMortgageInterestType}}</b></li>
			<li>Prior Lender : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorLender}}</b></li>
			<li>Prior Doc Number : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorDocNumber}}</b></li>
			<li>Prior Doc Cmt : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorDocCmt}}</b></li>
			<li>Prior Sale Info Verified : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->PriorSaleInfoVerified}}</b></li>
			<li>Current Through Date : <b>{{@$result->Reports[0]->Data->PriorSaleInformation->CurrentThroughDate}}</b></li>
		</ul>
	</div>

