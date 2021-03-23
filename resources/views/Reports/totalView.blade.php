
	<div>
		<h1>Report Name: Total View Report</h1>
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
			<li>Owner Vesting Info : <b></li>
			<li>Vesting Owner : <b>{{@$result->Reports[0]->Data->OwnerInformation->OwnerVestingInfo->VestingOwner}}</b></li>
			<li>Vesting Ownership Right : <b>{{@$result->Reports[0]->Data->OwnerInformation->OwnerVestingInfo->VestingOwnershipRight}}</b></li>
			<li>Vesting Etal : <b>{{@$result->Reports[0]->Data->OwnerInformation->OwnerVestingInfo->VestingEtal}}</b></li>
			<li>OwnerOccupied Indicator : <b>{{@$result->Reports[0]->Data->OwnerInformation->OwnerOccupiedIndicator}}</b></li>
		</ul>

		<h4>Mailing Address</h4>
		<ul>
			<li>Street Address : <b>{{@$result->Reports[0]->Data->OwnerInformation->MailingAddress->StreetAddress}}</b></li>
			<li>City : <b>{{@$result->Reports[0]->Data->OwnerInformation->MailingAddress->City}}</b></li>
			<li>State : <b>{{@$result->Reports[0]->Data->OwnerInformation->MailingAddress->State}}</b></li>
			<li>Zip 9 : <b></b>{{@$result->Reports[0]->Data->OwnerInformation->MailingAddress->Zip9}}</li>
			<li>Mail Carrier Route : <b>{{@$result->Reports[0]->Data->OwnerInformation->MailingAddress->MailCarrierRoute}}</b></li>
		</ul>


		<h4>Legal And Vestin Data</h4>
		<ul>
			<li>Assessed Owner : <b>{{@$result->Reports[0]->Data->LegalAndVestingData->AssessedOwner}}</b></li>
			<li>Vesting Name : <b>{{@$result->Reports[0]->Data->LegalAndVestingData->VestingName}}</b></li>
			<li>Vesting Description : <b>{{@$result->Reports[0]->Data->LegalAndVestingData->VestingDescription}}</b></li>
			<li>Estimated Value Low : <b>{{@$result->Reports[0]->Data->LegalAndVestingData->EstimatedValueLow}}</b></li>
			<li>Estimated Value High : <b>{{@$result->Reports[0]->Data->LegalAndVestingData->EstimatedValueHigh}}</b></li>
			<li>Legal Description : <b>{{@$result->Reports[0]->Data->LegalAndVestingData->LegalDescription}}</b></li>
		</ul>

		<h4>Last Market Sale Information</h4>
		<ul>
			<li>Seller Name : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->SellerName}}</b></li>
			<li>Buyer Name : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->BuyerName}}</b></li>
			<li>Sale Date : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->SaleDate}}</b></li>
			<li>Recording Date : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->RecordingDate}}</b></li>
			<li>Sale Price : <b>{{@$result->Reports[0]->Data->LastMarketSaleInformation->SalePrice}}</b></li>
			
		</ul>

		<h4>Listing Property Detail</h4>
		<ul>
			<li>Listing Status : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->ListingStatus}}</b></li>
			<li>Listing Price : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->ListingPrice}}</b></li>
			<li>Listing Sold Price : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->ListingSoldPrice}}</b></li>
			<li>Days On Market : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->DaysOnMarket}}</b></li>
			<li>Property Type : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->PropertyType}}</b></li>
			<li>Property Sub Type : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->PropertySubType}}</b></li>
			<li>Zoning : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->Zoning}}</b></li>
			<li>YearBuilt : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->YearBuilt}}</b></li>
			<li>Garage Type : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->GarageType}}</b></li>
			<li>Garage Nbr : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->GarageNbr}}</b></li>
			<li>Interior Features : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->InteriorFeatures}}</b></li>
			<li>Exterior Features : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->ExteriorFeatures}}</b></li>
			<li>LotSize SqFt : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->LotSizeSqFt}}</b></li>
			<li>GLAHome Size STD : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->GLAHomeSizeSTD}}</b></li>
			<li>Basement : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->Basement}}</b></li>
			<li>Bedrooms : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->Bedrooms}}</b></li>
			<li>Bathrooms : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->Bathrooms}}</b></li>
			<li>Pool : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->Pool}}</b></li>
			<li>Fireplace : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->Fireplace}}</b></li>
			<li>Heating : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->Heating}}</b></li>
			<li>Cooling : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->Cooling}}</b></li>
			<li>Roofing : <b>{{@$result->Reports[0]->Data->ListingPropertyDetail->Roofing}}</b></li>
			
		</ul>

		<h4>Fore Closure Data</h4>
		<ul>
			<li>Status : <b>{{@$result->Reports[0]->Data->ForeClosureData->Status}}</b></li>
			<li>FilingDate : <b>{{@$result->Reports[0]->Data->ForeClosureData->FilingDate}}</b></li>
			<li>DocumentType : <b>{{@$result->Reports[0]->Data->ForeClosureData->DocumentType}}</b></li>
			<li>Unpaid Balance : <b>{{@$result->Reports[0]->Data->ForeClosureData->UnpaidBalance}}</b></li>
			<li>Auction Date : <b>{{@$result->Reports[0]->Data->ForeClosureData->AuctionDate}}</b></li>
			
		</ul>

		<h4>Association Information</h4>
		@if(!empty($result->Reports[0]->Data->AssociationInformation))
		@foreach($result->Reports[0]->Data->AssociationInformation as $value)
		<ul>
			<li>AssocType : <b>{{@$value->AssocType}}</b></li>
			<li>Name : <b>{{@$value->Name}}</b></li>
			<li>Address : <b></li>
			<li>StreetAddress : <b>{{@$value->Address->StreetAddress}}</b></li>
			<li>City : <b>{{@$value->Address->City}}</b></li>
			<li>State : <b>{{@$value->Address->State}}</b></li></b></li>
			<li>Zip5 : <b>{{@$value->Address->Zip5}}</b></li>
			<li>Plus4 : <b>{{@$value->Address->Plus4}}</b></li></b></li>
			<li>Phone : <b>{{@$value->Phone}}</b></li>
			<li>Email : <b>{{@$value->Email}}</b></li>
			<li>Amount : <b>{{@$value->Amount}}</b></li>
			<li>Frequency : <b>{{@$value->Frequency}}</b></li>
		</ul>
		@endforeach
		@else
			
		<ul>
			<li>AssocType : <b></b></li>
			<li>Name : <b></b></li>
			<li>Address : <b></li>
			<li>StreetAddress : <b></b></li>
			<li>City : <b></b></li>
			<li>State : <b></b></li></b></li>
			<li>Zip5 : <b></b></li>
			<li>Plus4 : <b></b></li></b></li>
			<li>Phone : <b></b></li>
			<li>Email : <b></b></li>
			<li>Amount : <b></b></li>
			<li>Frequency : <b></b></li>
		</ul>
		@endif
		<h4>PropertyDetailData</h4>
		<ul>
			<li>Subdivision : <b>{{@$result->Reports[0]->Data->PropertyDetailData->Subdivision}}</b></li>
			<li>Site Information : </li>
			<li>Zoning : <b>{{@$result->Reports[0]->Data->PropertyDetailData->SiteInformation->Zoning}}</b></li>
			<li>Land Use : <b>{{@$result->Reports[0]->Data->PropertyDetailData->SiteInformation->LandUse}}</b></li>
			<li>Acres : <b>{{@$result->Reports[0]->Data->PropertyDetailData->SiteInformation->Acres}}</b></li>
			<li>Lot Area : <b>{{@$result->Reports[0]->Data->PropertyDetailData->SiteInformation->LotArea}}</b></li>
			<li>Flood Zone Code : <b>{{@$result->Reports[0]->Data->PropertyDetailData->SiteInformation->FloodZoneCode}}</b></li>
			<li>PropertyCharacteristics : </li>
			<li>Gross Area : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->GrossArea}}</b></li>
			<li>Living Area : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->LivingArea}}</b></li>
			<li>Total Adjusted Area : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->TotalAdjustedArea}}</b></li>
			<li>Above Grade : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->AboveGrade}}</b></li>
			<li>Total Rooms : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->TotalRooms}}</b></li>
			<li>Bedrooms : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->Bedrooms}}</b></li>
			<li>Full Bath : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->FullBath}}</b></li>
			<li>HalfBath : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->HalfBath}}</b></li>
			<li>Year Built : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->YearBuilt}}</b></li>
			<li>EFF Year : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->EFFYear}}</b></li>
			<li>Fire Place Count : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->FirePlaceCount}}</b></li>
			<li>Number Of Stories : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->NumberOfStories}}</b></li>
			<li>Parking Type : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->ParkingType}}</b></li>
			<li>Garage Area : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->GarageArea}}</b></li>
			<li>Garage Capacity : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->GarageCapacity}}</b></li>
			<li>Basement Area : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->BasementArea}}</b></li>
			<li>Basement Type : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->BasementType}}</b></li>
			<li>Roof Type : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->RoofType}}</b></li>
			<li>Foundation: <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->Foundation}}</b></li>
			<li>Roof Material : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->RoofMaterial}}</b></li>
			<li>Construct Type : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->ConstructType}}</b></li>
			<li>Exterior Wall : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->ExteriorWall}}</b></li>
			<li>Porch Type : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->PorchType}}</b></li>
			<li>Patio Type : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->PatioType}}</b></li>
			<li>Pool : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->Pool}}</b></li>
			<li>Air Conditioning : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->AirConditioning}}</b></li>
			<li>Heat Type : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->HeatType}}</b></li>
			<li>Style : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->Style}}</b></li>
			<li>Quality : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->Quality}}</b></li>
			<li>Condition : <b>{{@$result->Reports[0]->Data->PropertyDetailData->PropertyCharacteristics->Condition}}</b></li>
		</ul>
		
		<h4>County Recording History</h4>
		<ul>
			<li>Sales History Start Date : <b>{{@$result->Reports[0]->Data->PropertyDetailData->CountyRecordingHistory->SalesHistoryStartDate}}</b></li>
			<li>Sales History Through dare : <b>{{@$result->Reports[0]->Data->PropertyDetailData->CountyRecordingHistory->SalesHistoryThroughDate}}</b></li>
			<li>Mortgage History Start Date: <b>{{@$result->Reports[0]->Data->PropertyDetailData->CountyRecordingHistory->MortgageHistoryStartDate}}</b></li>
			<li>Mortgage History Through Date : <b>{{@$result->Reports[0]->Data->PropertyDetailData->CountyRecordingHistory->MortgageHistoryThroughDate}}</b></li>
			<li>Assignment History Start Date : <b>{{@$result->Reports[0]->Data->PropertyDetailData->CountyRecordingHistory->AssignmentHistoryStartDate}}</b></li>
			<li>Assignment History Through Date : <b>{{@$result->Reports[0]->Data->PropertyDetailData->CountyRecordingHistory->AssignmentHistoryThroughDate}}</b></li>
			<li>Release History Start Date : <b>{{@$result->Reports[0]->Data->PropertyDetailData->CountyRecordingHistory->ReleaseHistoryStartDate}}</b></li>
			<li>Release History Through Date : <b>{{@$result->Reports[0]->Data->PropertyDetailData->CountyRecordingHistory->ReleaseHistoryThroughDate}}</b></li>
			<li>Foreclosure History Star tDate : <b>{{@$result->Reports[0]->Data->PropertyDetailData->CountyRecordingHistory->ForeclosureHistoryStartDate}}</b></li>
			<li>Foreclosure History Through Date : <b>{{@$result->Reports[0]->Data->PropertyDetailData->CountyRecordingHistory->ForeclosureHistoryThroughDate}}</b></li>
		</ul>

		<h4>Transactions</h4>
		@if(!empty($result->Reports[0]->Data->Transactions))
			@foreach($result->Reports[0]->Data->Transactions as $key => $value)
		<ul>
			<li>Id : <b>{{@$value->Id}}</b></li>
			<li>Type : <b>{{@$value->Type}}</b></li>
			<li>Type Description : <b>{{@$value->TypeDescription}}</b></li>
			<li>Extended Type : <b>{{@$value->ExtendedType}}</b></li>
			<li>Extended Type Description : <b>{{@$value->ExtendedTypeDescription}}</b></li>
			<li>Tx Date : <b>{{@$value->TxDate}}</b></li>
			<li>Doc Type : <b>{{@$value->DocType}}</b></li>
			<li>Buyer Borrower : <b>{{@$value->BuyerBorrower}}</b></li>
			<li>Seller Lender : <b>{{@$value->SellerLender}}</b></li>
			<li>Amount : <b>{{@$value->Amount}}</b></li>
			<li>Doc Id : <b>{{@$value->DocId}}</b></li>
			<li>Book Page : <b>{{@$value->BookPage}}</b></li>
			<li>CMT Identifier : <b>{{@$value->CMTIdentifier}}</b></li>
			<li>Volume CMT Identifier : <b>{{@$value->VolumeCMTIdentifier}}</b></li>
			<li>Title Company : <b>{{@$value->TitleCompany}}</b></li>
			<li>Buyer Name : <b>{{@$value->BuyerName}}</b></li>
			<li>Seller Name : <b>{{@$value->SellerName}}</b></li>
			<li>Sale Date : <b>{{@$value->SaleDate}}</b></li>
			<li>Sale Type : <b>{{@$value->SaleType}}</b></li>
			<li>Lender : <b>{{@$value->Lender}}</b></li>
			<li>Borrower 1 : <b>{{@$value->Borrower1}}</b></li>
			<li>Borrower 2 : <b>{{@$value->Borrower2}}</b></li>
			<li>Borrower 3 : <b>{{@$value->Borrower3}}</b></li>
			<li>Borrower 4 : <b>{{@$value->Borrower4}}</b></li>
			<li>Loan Amount : <b>{{@$value->LoanAmount}}</b></li>
			<li>Finance Type : <b>{{@$value->FinanceType}}</b></li>
			<li>Mortgage Loan Type : <b>{{@$value->MortgageLoanType}}</b></li>
			<li>Mortgage Term : <b>{{@$value->MortgageTerm}}</b></li>
			<li>Mortage Rate Type : <b>{{@$value->MortageRateType}}</b></li>
			<li>Mortgage Rate : <b>{{@$value->MortgageRate}}</b></li>
			<li>Original Recording Date : <b>{{@$value->OriginalRecordingDate}}</b></li>
			<li>Original Doc Id : <b>{{@$value->OriginalDocId}}</b></li>
			<li>Previous Lender : <b>{{@$value->PreviousLender}}</b></li>
			<li>Filing Date : <b>{{@$value->FilingDate}}</b></li>
			<li>Unpaid Balance : <b>{{@$value->UnpaidBalance}}</b></li>
			<li>Trustee Name : <b>{{@$value->TrusteeName}}</b></li>
			<li>Defendant 1 : <b>{{@$value->Defendant1}}</b></li>
			<li>Defendant 2 : <b>{{@$value->Defendant2}}</b></li>
			<li>Defendant 3 : <b>{{@$value->Defendant3}}</b></li>
			<li>Defendant 4 : <b>{{@$value->Defendant4}}</b></li>
			<li>Sale Verified : <b>{{@$value->SaleVerified}}</b></li>
			<li>Release Verified : <b>{{@$value->ReleaseVerified}}</b></li>
			<li>Finance Verified : <b>{{@$value->FinanceVerified}}</b></li>
			<li>Foreclosure Verified : <b>{{@$value->ForeclosureVerified}}</b></li>
			<li>Assignment Verified : <b>{{@$value->AssignmentVerified}}</b></li>
			<li>Is Transaction Node : <b>{{@$value->IsTransactionNode}}</b></li>
			<li>Transaction Type : <b>{{@$value->TransactionType}}</b></li>
			<li>Buyer 1 : <b>{{@$value->Buyer1}}</b></li>
			<li>Buyer 2 : <b>{{@$value->Buyer2}}</b></li>
			<li>Buyer 3 : <b>{{@$value->Buyer3}}</b></li>
			<li>Buyer 4 : <b>{{@$value->Buyer4}}</b></li>
			<li>Document Damar Type : <b>{{@$value->DocumentDamarType}}</b></li>
			<li>Lien Position : <b>{{@$value->LienPosition}}</b></li>
			<li>Additional Lien Position : <b>{{@$value->AdditionalLienPosition}}</b></li>
			<li>Is Only Finance : <b>{{@$value->IsOnlyFinance}}</b></li>
			<li>Sale Instrument Number : <b>{{@$value->SaleInstrumentNumber}}</b></li>
			<li>Sale Arms Length Indicator : <b>{{@$value->SaleArmsLengthIndicator}}</b></li>
			<li>Doc Type Damar Code : <b>{{@$value->DocTypeDamarCode}}</b></li>
			<li>Borrowers : <b>{{@$value->DocTypeDamarCode}}</b></li>
			<li>Finance Document Type Code : <b>{{@$value->FinanceDocumentTypeCode}}</b></li>
			<li>Sale Deed Type Damar Code : <b>{{@$value->SaleDeedTypeDamarCode}}</b></li>
			<li>Seq Lien Position : <b>{{@$value->SeqLienPosition}}</b></li>
			<li>Original Book Page Doc Id : <b>{{@$value->OriginalBookPageDocId}}</b></li>
		</ul>
		@endforeach
		@else
			No Transaction Data
		@endif
		<h4>Involuntary Lien Info</h4>
		<ul>
			<li>APN : <b>{{@$result->Reports[0]->Data->InvoluntaryLienInfo->APN}}</b></li>
			<li>State Code : <b>{{@$result->Reports[0]->Data->InvoluntaryLienInfo->StateCode}}</b></li>
			<li>County Code: <b>{{@$result->Reports[0]->Data->InvoluntaryLienInfo->CountyCode}}</b></li>
			<li>State Fips : <b>{{@$result->Reports[0]->Data->InvoluntaryLienInfo->StateFips}}</b></li>
			<li>County Fips : <b>{{@$result->Reports[0]->Data->InvoluntaryLienInfo->CountyFips}}</b></li>
			<li>Involuntary Liens Items Count : <b>{{@$result->Reports[0]->Data->InvoluntaryLienInfo->InvoluntaryLiensItemsCount}}</b></li>
			<li>From Date : <b>{{@$result->Reports[0]->Data->InvoluntaryLienInfo->FromDate}}</b></li>
			<li>To Date : <b>{{@$result->Reports[0]->Data->InvoluntaryLienInfo->ToDate}}</b></li>
			
		</ul>
		<h4>Involuntary Liens Items</h4>
		@if(!empty($result->Reports[0]->Data->InvoluntaryLiensItems))
			@foreach($result->Reports[0]->Data->InvoluntaryLiensItems as $key => $value)
		<ul>
			<li>Party Name : <b>{{@$value->PartyName}}</b></li>
			<li>Party 1 Full Names : <b>{{@$value->Party1FullNames}}</b></li>
			<li>Party 1 Last Name : <b>{{@$value->Party1LastName}}</b></li>
			<li>Party 1 First Name : <b>{{@$value->Party1FirstName}}</b></li>
			<li>Party 1 Middle Name : <b>{{@$value->Party1MiddleName}}</b></li>
			<li>Party 2 Full Names : <b>{{@$value->Party2FullNames}}</b></li>
			<li>Party 2 Last Name : <b>{{@$value->Party2LastName}}</b></li>
			<li>Party 2 First Name : <b>{{@$value->Party2FirstName}}</b></li>
			<li>Party 2 Middle Name : <b>{{@$value->Party2MiddleName}}</b></li>
			<li>Land Legal Info : <b>{{@$value->LandLegalInfo}}</b></li>
			<li>Document Date : <b>{{@$value->DocumentDate}}</b></li>
			<li>Document Category : <b>{{@$value->DocumentCategory}}</b></li>
			<li>Document Description : <b>{{@$value->DocumentDescription}}</b></li>
			<li>Document Type : <b>{{@$value->DocumentType}}</b></li>
			<li>Document Number : <b>{{@$value->DocumentNumber}}</b></li>
			<li>Cmt Id : <b>{{@$value->CmtId}}</b></li>
			<li>Document Id : <b>{{@$value->DocumentId}}</b></li>
			<li>Parent Document Id : <b>{{@$value->ParentDocumentId}}</b></li>
			<li>Parent Document Number : <b>{{@$value->ParentDocumentNumber}}</b></li>
			<li>Is Child Doc Type : <b>{{@$value->IsChildDocType}}</b></li>
			@if(!empty($value->IsChildDocType->ChildRecords))
				<ul><h5>Child Records</h5></ul>
				@foreach($value->IsChildDocType->ChildRecords as $value)
				<li>Party Name : <b>{{@$value->PartyName}}</b></li>
				<li>Party 1 Full Names : <b>{{@$value->Party1FullNames}}</b></li>
				<li>Party 1 Last Name : <b>{{@$value->Party1LastName}}</b></li>
				<li>Party 1 First Name : <b>{{@$value->Party1FirstName}}</b></li>
				<li>Party 1 Middle Name : <b>{{@$value->Party1MiddleName}}</b></li>
				<li>Party 2 Full Names : <b>{{@$value->Party2FullNames}}</b></li>
				<li>Party 2 Last Name : <b>{{@$value->Party2LastName}}</b></li>
				<li>Party 2 First Name : <b>{{@$value->Party2FirstName}}</b></li>
				<li>Party 2 Middle Name : <b>{{@$value->Party2MiddleName}}</b></li>
				<li>Land Legal Info : <b>{{@$value->LandLegalInfo}}</b></li>
				<li>Document Date : <b>{{@$value->DocumentDate}}</b></li>
				<li>Document Category : <b>{{@$value->DocumentCategory}}</b></li>
				<li>Document Description : <b>{{@$value->DocumentDescription}}</b></li>
				<li>Document Type : <b>{{@$value->DocumentType}}</b></li>
				<li>Document Number : <b>{{@$value->DocumentNumber}}</b></li>
				<li>Cmt Id : <b>{{@$value->CmtId}}</b></li>
				<li>Document Id : <b>{{@$value->DocumentId}}</b></li>
				<li>Parent Document Id : <b>{{@$value->ParentDocumentId}}</b></li>
				<li>Parent Document Number : <b>{{@$value->ParentDocumentNumber}}</b></li>
				<li>Is Child Doc Type : <b>{{@$value->IsChildDocType}}</b></li>
				@endforeach
			@else
				<ul><h3>ChildRecords</h4></ul>
			@endif
		</ul>
		@endforeach
		@else
			No Transaction Data
		@endif
		<h4>Near By Listing Data</h4>
		@if(!empty($result->Reports[0]->Data->NearByListingData))
			@foreach($result->Reports[0]->Data->NearByListingData as $key => $value)
			<li>Fips : <b>{{@$value->Fips}}</b></li>
			<li>Distance : <b>{{@$value->Distance}}</b></li>
			<li>REF ID : <b>{{@$value->REF_ID}}</b></li>
			<li>House Number : <b>{{@$value->HouseNumber}}</b></li>
			<li>Direction : <b>{{@$value->Direction}}</b></li>
			<li>Street Name : <b>{{@$value->Street_Name}}</b></li>
			<li>Street Type : <b>{{@$value->Street_Type}}</b></li>
			<li>Post Direction : <b>{{@$value->Post_Direction}}</b></li>
			<li>Unit Type : <b>{{@$value->Unit_Type}}</b></li>
			<li>Unit : <b>{{@$value->Unit}}</b></li>
			<li>City : <b>{{@$value->City}}</b></li>
			<li>State : <b>{{@$value->State}}</b></li>
			<li>Zip : <b>{{@$value->Zip}}</b></li>
			<li>Listing Status : <b>{{@$value->ListingStatus}}</b></li>
			<li>Listing Date : <b>{{@$value->ListingDate}}</b></li>
			<li>Listing Price : <b>{{@$value->ListingPrice}}</b></li>
			<li>Listing Sold Date : <b>{{@$value->ListingSoldDate}}</b></li>
			<li>Listing Sold Price : <b>{{@$value->ListingSoldPrice}}</b></li>
			<li>Lot Size SqFt : <b>{{@$value->LotSizeSqFt}}</b></li>
			<li>GLA_Home Size STD : <b>{{@$value->GLA_HomeSizeSTD}}</b></li>
			<li>YearBuilt : <b>{{@$value->YearBuilt}}</b></li>
			<li>BedRooms : <b>{{@$value->BedRooms}}</b></li>
			<li>BathRooms : <b>{{@$value->BathRooms}}</b></li>
			<li>GarageNbr : <b>{{@$value->GarageNbr}}</b></li>
			<li>PricePerSqFt : <b>{{@$value->PricePerSqFt}}</b></li>
			<li>Latitude : <b>{{@$value->Latitude}}</b></li>
			<li>Longitude : <b>{{@$value->Longitude}}</b></li>
			<li>LastSaleDate : <b>{{@$value->LastSaleDate}}</b></li>
			<li>SalePrice : <b>{{@$value->SalePrice}}</b></li>
			@endforeach
		@endif
		
		<h4>Near By Sales Data</h4>
		@if(!empty($result->Reports[0]->Data->NearBySalesData))
			@foreach($result->Reports[0]->Data->NearBySalesData as $key => $value)
			<li>Id : <b>{{@$value->Id}}</b></li>
			<li>Distance From Subject : <b>{{@$value->DistanceFromSubject}}</b></li>
			<li>Distance From Subject Miles : <b>{{@$value->DistanceFromSubjectMiles}}</b></li>
			<li>Property Status : <b>{{@$value->PropertyStatus}}</b></li>
			<li>Address : <b>{{@$value->Address}}</b></li>
			<li>Address2 : <b>{{@$value->Address2}}</b></li>
			<li>City : <b>{{@$value->City}}</b></li>
			<li>State : <b>{{@$value->State}}</b></li>
			<li>Zip : <b>{{@$value->Zip}}</b></li>
			<li>StreetName : <b>{{@$value->StreetName}}</b></li>
			<li>StreetDir : <b>{{@$value->StreetDir}}</b></li>
			<li>StreetPostDir : <b>{{@$value->StreetPostDir}}</b></li>
			<li>StreetType : <b>{{@$value->StreetType}}</b></li>
			<li>StreetNumber : <b>{{@$value->StreetNumber}}</b></li>
			<li>Last Listed Date : <b>{{@$value->LastListedDate}}</b></li>
			<li>Last Sale Date : <b>{{@$value->LastSaleDate}}</b></li>
			<li>For Sale Listed Price : <b>{{@$value->ForSaleListedPrice}}</b></li>
			<li>Sale Price : <b>{{@$value->SalePrice}}</b></li>
			<li>Lot Sqft : <b>{{@$value->LotSqft}}</b></li>
			<li>Sq Foot : <b>{{@$value->SqFoot}}</b></li>
			<li>YearBuilt : <b>{{@$value->YearBuilt}}</b></li>
			<li>PriceSqFt : <b>{{@$value->PriceSqFt}}</b></li>
			<li>BedRooms : <b>{{@$value->BedRooms}}</b></li>
			<li>BathRooms : <b>{{@$value->BathRooms}}</b></li>
			<li>GarageSpaces : <b>{{@$value->GarageSpaces}}</b></li>
			<li>Longitude : <b>{{@$value->Longitude}}</b></li>
			<li>Latitude : <b>{{@$value->Latitude}}</b></li>
			@endforeach
		@endif
		
		<h4>MarketTrendData</h4>
		<h5>MedianTrendDetail</h5>
		
			<ul> MonthYear :</ul>
			@if(!empty($result->Reports[0]->Data->MarketTrendData->MedianTrendDetail->MonthYear))
				@foreach($result->Reports[0]->Data->MarketTrendData->MedianTrendDetail->MonthYear as $value)
					<li><b>{{$value}}</b></li>
				@endforeach
			@endif
			<ul> MedianListing :</ul>
			@if(!empty($result->Reports[0]->Data->MarketTrendData->MedianTrendDetail->MedianListing))
				@foreach($result->Reports[0]->Data->MarketTrendData->MedianTrendDetail->MedianListing as $value)
					<li><b>{{$value}}</b></li>
				@endforeach
			@endif
			<ul> MedianSale :</ul>
			@if(!empty($result->Reports[0]->Data->MarketTrendData->MedianTrendDetail->MedianSale))
				@foreach($result->Reports[0]->Data->MarketTrendData->MedianTrendDetail->MedianSale as $value)
					<li><b>{{$value}}</b></li>
				@endforeach
			@endif
			
			<li>IsDataAvailable: <b>{{$result->Reports[0]->Data->MarketTrendData->MedianTrendDetail->IsDataAvailable}}</b></li>
		<h5>SalesnForeclosure</h5>
		<ul> Period :</ul>
			@if(!empty($result->Reports[0]->Data->MarketTrendData->SalesnForeclosure->Period))
				@foreach($result->Reports[0]->Data->MarketTrendData->SalesnForeclosure->Period as $value)
					<li><b>{{$value}}</b></li>
				@endforeach
			@endif
		<ul> SaleCount :</ul>
			@if(!empty($result->Reports[0]->Data->MarketTrendData->SalesnForeclosure->SaleCount))
				@foreach($result->Reports[0]->Data->MarketTrendData->SalesnForeclosure->SaleCount as $value)
					<li><b>{{$value}}</b></li>
				@endforeach
			@endif
		<ul> ForeclosureCount :</ul>
			@if(!empty($result->Reports[0]->Data->MarketTrendData->SalesnForeclosure->ForeclosureCount))
				@foreach($result->Reports[0]->Data->MarketTrendData->SalesnForeclosure->ForeclosureCount as $value)
					<li><b>{{$value}}</b></li>
				@endforeach
			@endif
		<ul> ForeclosureCount :</ul>
			@if(!empty($result->Reports[0]->Data->MarketTrendData->SalesnForeclosure->ForeclosureCount))
				@foreach($result->Reports[0]->Data->MarketTrendData->SalesnForeclosure->ForeclosureCount as $value)
					<li><b>{{$value}}</b></li>
				@endforeach
			@endif
		
			<li>IsDataAvailable: <b>{{$result->Reports[0]->Data->MarketTrendData->SalesnForeclosure->IsDataAvailable}}</b></li>
		<h5>SalesDetails</h5>
		<ul>
			<li>SoldHomes : <b>{{@$result->Reports[0]->Data->MarketTrendData->SalesDetails->SoldHomes}}</b></li>
			<li>SoldHomesChange : <b>{{@$result->Reports[0]->Data->MarketTrendData->SalesDetails->SoldHomesChange}}</b></li><li>AvgSoldPrice : <b>{{@$result->Reports[0]->Data->MarketTrendData->SalesDetails->AvgSoldPrice}}</b></li><li>AvgSoldPriceChange : <b>{{@$result->Reports[0]->Data->MarketTrendData->SalesDetails->AvgSoldPriceChange}}</b></li><li>AvgSqft : <b>{{@$result->Reports[0]->Data->MarketTrendData->SalesDetails->AvgSqft}}</b></li><li>AvgSqftChange : <b>{{@$result->Reports[0]->Data->MarketTrendData->SalesDetails->AvgSqftChange}}</b></li><li>AvgSoldPriceSqft : <b>{{@$result->Reports[0]->Data->MarketTrendData->SalesDetails->AvgSoldPriceSqft}}</b></li><li>AvgSoldPriceSqftChange : <b>{{@$result->Reports[0]->Data->MarketTrendData->SalesDetails->AvgSoldPriceSqftChange}}</b></li><li>AvgAge : <b>{{@$result->Reports[0]->Data->MarketTrendData->SalesDetails->AvgAge}}</b></li>
			</li><li>AvgAgeChange : <b>{{@$result->Reports[0]->Data->MarketTrendData->SalesDetails->AvgAgeChange}}</b></li><li>IsDataAvailable : <b>{{@$result->Reports[0]->Data->MarketTrendData->SalesDetails->IsDataAvailable}}</b></li>
		</ul>
		<h5>ListingDetails</h5>
		<ul>
			<li>HomesForSale : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->HomesForSale}}</b></li>
			<li>HomesForSaleChange : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->HomesForSaleChange}}</b></li><li>AvgListPrice : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->AvgListPrice}}</b></li><li>AvgListPriceChange : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->AvgListPriceChange}}</b></li><li>AvgDaysOnMarket : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->AvgDaysOnMarket}}</b></li><li>AvgDaysOnMarketChange : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->AvgDaysOnMarketChange}}</b></li><li>AvgListPriceSqft : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->AvgListPriceSqft}}</b></li><li>AvgListPriceSqftChange : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->AvgListPriceSqftChange}}</b></li><li>NewListingLast30Days : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->NewListingLast30Days}}</b></li>
			</li><li>NewListingLast30DaysChange : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->NewListingLast30DaysChange}}</b></li><li>SalesLast30Days : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->SalesLast30Days}}</b></li>
			<li>SalesLast30DaysChange : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->SalesLast30DaysChange}}</b></li><li>IsDataAvailable : <b>{{@$result->Reports[0]->Data->MarketTrendData->ListingDetails->IsDataAvailable}}</b></li>
		</ul>
		<h5>SubjectComparisionDetails</h5>
		<ul>
			<li>LowPrice : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->LowPrice}}</b></li>
			<li>HighPrice : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->HighPrice}}</b></li><li>SubjectPrice : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->SubjectPrice}}</b></li><li>LowSqft : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->LowSqft}}</b></li><li>HighSqft : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->HighSqft}}</b></li><li>SubjectSqft : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->SubjectSqft}}</b></li><li>LowPricePerSqft : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->LowPricePerSqft}}</b></li><li>HighPricePerSqft : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->HighPricePerSqft}}</b></li><li>SubjectPriceSqft : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->SubjectPriceSqft}}</b></li>
			</li><li>SubjectPricePercentage : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->SubjectPricePercentage}}</b></li><li>SubjectSqftPercentage : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->SubjectSqftPercentage}}</b></li>
			<li>SubjectPriceSqftPercentage : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->SubjectPriceSqftPercentage}}</b></li><li>IsDataAvailable : <b>{{@$result->Reports[0]->Data->MarketTrendData->SubjectComparisionDetails->IsDataAvailable}}</b></li>
		</ul>
	</div>

