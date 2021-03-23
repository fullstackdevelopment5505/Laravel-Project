
	<div>
		<h1>Report Name: Open Lien Report</h1>
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
		@foreach($result->Reports[0]->Data->Transactions as $value)
		<h4>Transactions</h4>
		<ul>
			<li>Id : <b>{{$value->Id}}</b></li>
			<li>Type : <b>{{$value->Type}}</b></li>
			<li>Type Description : <b>{{$value->TypeDescription}}</b></li>
			<li>Extended Type : <b>{{$value->ExtendedType}}</b></li>
			<li>Extended Type Description : <b>{{$value->ExtendedTypeDescription}}</b></li>
			<li>Tx Date : <b>{{$value->TxDate}}</b></li>
			<li>Doc Type : <b>{{$value->DocType}}</b></li>
			<li>Buyer Borrower : <b>{{$value->BuyerBorrower}}</b></li>
			<li>Seller Lender : <b>{{$value->SellerLender}}</b></li>
			<li>Amount : <b>{{$value->Amount}}</b></li>
			<li>Doc Id : <b>{{$value->DocId}}</b></li>
			<li>Book Page : <b>{{$value->BookPage}}</b></li>
			<li>CMT Identifier : <b>{{$value->CMTIdentifier}}</b></li>
			<li>Volume CMT Identifier : <b>{{$value->VolumeCMTIdentifier}}</b></li>
			<li>Title Company : <b>{{$value->TitleCompany}}</b></li>
			<li>Buyer Name : <b>{{$value->BuyerName}}</b></li>
			<li>Seller Name : <b><{{$value->SellerName}}/b></li>
			<li>Sale Date : <b>{{$value->SaleDate}}</b></li>
			<li>Sale Type : <b>{{$value->SaleType}}</b></li>
			<li>Lender : <b>{{$value->Lender}}</b></li>
			<li>Borrower 1 : <b>{{$value->Borrower1}}</b></li>
			<li>Borrower 2 : <b>{{$value->Borrower2}}</b></li>
			<li>Borrower 3 : <b>{{$value->Borrower3}}</b></li>
			<li>Borrower 4 : <b>{{$value->Borrower4}}</b></li>
			<li>Loan Amount : <b>{{$value->LoanAmount}}</b></li>
			<li>Finance Type : <b>{{$value->FinanceType}}</b></li>
			<li>Mortgage Loan Type : <b>{{$value->MortgageLoanType}}</b></li>
			<li>Mortgage Term : <b>{{$value->MortgageTerm}}</b></li>
			<li>Mortage Rate Type : <b>{{$value->MortageRateType}}</b></li>
			<li>Mortgage Rate : <b>{{$value->MortgageRate}}</b></li>
			<li>Original Recording Date : <b>{{$value->OriginalRecordingDate}}</b></li>
			<li>Original Doc Id : <b>{{$value->OriginalDocId}}</b></li>
			<li>Previous Lender : <b>{{$value->PreviousLender}}</b></li>
			<li>Filing Date : <b>{{$value->FilingDate}}</b></li>
			<li>Trustee Phone : <b>{{$value->TrusteePhone}}</b></li>
			<li>Unpaid Balance : <b>{{$value->UnpaidBalance}}</b></li>
			<li>Trustee Name : <b>{{$value->TrusteeName}}</b></li>
			<li>Defendant 1 : <b>{{$value->Defendant1}}</b></li>
			<li>Defendant 2 : <b>{{$value->Defendant2}}</b></li>
			<li>Defendant 3 : <b>{{$value->Defendant3}}</b></li>
			<li>Defendant 4 : <b>{{$value->Defendant4}}</b></li>
			<li>Sale Verified : <b>{{$value->SaleVerified}}</b></li>
			<li>Release Verified : <b>{{$value->ReleaseVerified}}</b></li>
			<li>Finance Verified : <b>{{$value->FinanceVerified}}</b></li>
			<li>Foreclosure Verified : <b>{{$value->ForeclosureVerified}}</b></li>
			<li>Assignment Verified : <b>{{$value->AssignmentVerified}}</b></li>
			<li>Is Transaction Node : <b>{{$value->IsTransactionNode}}</b></li>
			<li>Transaction Type : <b>{{$value->TransactionType}}</b></li>
			<li>Buyer 1 : <b>{{$value->Buyer1}}</b></li>
			<li>Buyer 2 : <b>{{$value->Buyer2}}</b></li>
			<li>Buyer 3 : <b>{{$value->Buyer3}}</b></li>
			<li>Buyer 4 : <b>{{$value->Buyer4}}</b></li>
			<li>Document Damar Type : <b>{{$value->DocumentDamarType}}</b></li>
			<li>Lien Position : <b>{{$value->LienPosition}}</b></li>
			<li>Additional Lien Position : <b>{{$value->AdditionalLienPosition}}</b></li>
			<li>Is Only Finance : <b>{{$value->IsOnlyFinance}}</b></li>
			<li>Sale Instrument Number : <b>{{$value->SaleInstrumentNumber}}</b></li>
			<li>Sale Arms Length Indicator : <b>{{$value->SaleArmsLengthIndicator}}</b></li>
			<li>Doc Type Damar Code : <b>{{$value->DocTypeDamarCode}}</b></li>
			<li>Borrowers : <b>{{$value->Borrowers}}</b></li>
			<li>Finance Document Type Code : <b>{{$value->FinanceDocumentTypeCode}}</b></li>
			<li>Sale Deed Type Damar Code : <b>{{$value->SaleDeedTypeDamarCode}}</b></li>
			<li>Seq Lien Position : <b>{{$value->SeqLienPosition}}</b></li>
			<li>Original Book Page Doc Id : <b>{{$value->OriginalBookPageDocId}}</b></li>
		</ul>
		@endforeach
	</div>

