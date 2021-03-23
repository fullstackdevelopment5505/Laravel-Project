
	<div>
		<h1>Report Name: Transaction History Report</h1>
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
			<li>Sales History Through dare : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->SalesHistoryThroughDate}}</b></li>
			<li>Mortgage History Start Date: <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->MortgageHistoryStartDate}}</b></li>
			<li>Mortgage History Through Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->MortgageHistoryThroughDate}}</b></li>
			<li>Assignment History Start Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->AssignmentHistoryStartDate}}</b></li>
			<li>Assignment History Through Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->AssignmentHistoryThroughDate}}</b></li>
			<li>Release History Start Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->ReleaseHistoryStartDate}}</b></li>
			<li>Release History Through Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->ReleaseHistoryThroughDate}}</b></li>
			<li>Foreclosure History Star tDate : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->ForeclosureHistoryStartDate}}</b></li>
			<li>Foreclosure History Through Date : <b>{{@$result->Reports[0]->Data->CountyRecordingHistory->ForeclosureHistoryThroughDate}}</b></li>
		</ul>

		<h4>Transactions</h4>
		<ul>
			<li>Id : <b>{{@$result->Reports[0]->Data->Transactions->Id}}</b></li>
			<li>Type : <b>{{@$result->Reports[0]->Data->Transactions->Type}}</b></li>
			<li>Type Description : <b>{{@$result->Reports[0]->Data->Transactions->TypeDescription}}</b></li>
			<li>Extended Type : <b>{{@$result->Reports[0]->Data->Transactions->ExtendedType}}</b></li>
			<li>Extended Type Description : <b>{{@$result->Reports[0]->Data->Transactions->ExtendedTypeDescription}}</b></li>
			<li>Tx Date : <b>{{@$result->Reports[0]->Data->Transactions->TxDate}}</b></li>
			<li>Doc Type : <b>{{@$result->Reports[0]->Data->Transactions->DocType}}</b></li>
			<li>Buyer Borrower : <b>{{@$result->Reports[0]->Data->Transactions->BuyerBorrower}}</b></li>
			<li>Seller Lender : <b>{{@$result->Reports[0]->Data->Transactions->SellerLender}}</b></li>
			<li>Amount : <b>{{@$result->Reports[0]->Data->Transactions->Amount}}</b></li>
			<li>Doc Id : <b>{{@$result->Reports[0]->Data->Transactions->DocId}}</b></li>
			<li>Book Page : <b>{{@$result->Reports[0]->Data->Transactions->BookPage}}</b></li>
			<li>CMT Identifier : <b>{{@$result->Reports[0]->Data->Transactions->CMTIdentifier}}</b></li>
			<li>Volume CMT Identifier : <b>{{@$result->Reports[0]->Data->Transactions->VolumeCMTIdentifier}}</b></li>
			<li>Title Company : <b>{{@$result->Reports[0]->Data->Transactions->TitleCompany}}</b></li>
			<li>Buyer Name : <b>{{@$result->Reports[0]->Data->Transactions->BuyerName}}</b></li>
			<li>Seller Name : <b>{{@$result->Reports[0]->Data->Transactions->SellerName}}</b></li>
			<li>Sale Date : <b>{{@$result->Reports[0]->Data->Transactions->SaleDate}}</b></li>
			<li>Sale Type : <b>{{@$result->Reports[0]->Data->Transactions->SaleType}}</b></li>
			<li>Lender : <b>{{@$result->Reports[0]->Data->Transactions->Lender}}</b></li>
			<li>Borrower 1 : <b>{{@$result->Reports[0]->Data->Transactions->Borrower1}}</b></li>
			<li>Borrower 2 : <b>{{@$result->Reports[0]->Data->Transactions->Borrower2}}</b></li>
			<li>Borrower 3 : <b>{{@$result->Reports[0]->Data->Transactions->Borrower3}}</b></li>
			<li>Borrower 4 : <b>{{@$result->Reports[0]->Data->Transactions->Borrower4}}</b></li>
			<li>Loan Amount : <b>{{@$result->Reports[0]->Data->Transactions->LoanAmount}}</b></li>
			<li>Finance Type : <b>{{@$result->Reports[0]->Data->Transactions->FinanceType}}</b></li>
			<li>Mortgage Loan Type : <b>{{@$result->Reports[0]->Data->Transactions->MortgageLoanType}}</b></li>
			<li>Mortgage Term : <b>{{@$result->Reports[0]->Data->Transactions->MortgageTerm}}</b></li>
			<li>Mortage Rate Type : <b>{{@$result->Reports[0]->Data->Transactions->MortageRateType}}</b></li>
			<li>Mortgage Rate : <b>{{@$result->Reports[0]->Data->Transactions->MortgageRate}}</b></li>
			<li>Original Recording Date : <b>{{@$result->Reports[0]->Data->Transactions->OriginalRecordingDate}}</b></li>
			<li>Original Doc Id : <b>{{@$result->Reports[0]->Data->Transactions->OriginalDocId}}</b></li>
			<li>Previous Lender : <b>{{@$result->Reports[0]->Data->Transactions->PreviousLender}}</b></li>
			<li>Filing Date : <b>{{@$result->Reports[0]->Data->Transactions->FilingDate}}</b></li>
			<li>Unpaid Balance : <b>{{@$result->Reports[0]->Data->Transactions->UnpaidBalance}}</b></li>
			<li>Trustee Name : <b>{{@$result->Reports[0]->Data->Transactions->TrusteeName}}</b></li>
			<li>Defendant 1 : <b>{{@$result->Reports[0]->Data->Transactions->Defendant1}}</b></li>
			<li>Defendant 2 : <b>{{@$result->Reports[0]->Data->Transactions->Defendant2}}</b></li>
			<li>Defendant 3 : <b>{{@$result->Reports[0]->Data->Transactions->Defendant3}}</b></li>
			<li>Defendant 4 : <b>{{@$result->Reports[0]->Data->Transactions->Defendant4}}</b></li>
			<li>Sale Verified : <b>{{@$result->Reports[0]->Data->Transactions->SaleVerified}}</b></li>
			<li>Release Verified : <b>{{@$result->Reports[0]->Data->Transactions->ReleaseVerified}}</b></li>
			<li>Finance Verified : <b>{{@$result->Reports[0]->Data->Transactions->FinanceVerified}}</b></li>
			<li>Foreclosure Verified : <b>{{@$result->Reports[0]->Data->Transactions->ForeclosureVerified}}</b></li>
			<li>Assignment Verified : <b>{{@$result->Reports[0]->Data->Transactions->AssignmentVerified}}</b></li>
			<li>Is Transaction Node : <b>{{@$result->Reports[0]->Data->Transactions->IsTransactionNode}}</b></li>
			<li>Transaction Type : <b>{{@$result->Reports[0]->Data->Transactions->TransactionType}}</b></li>
			<li>Buyer 1 : <b>{{@$result->Reports[0]->Data->Transactions->Buyer1}}</b></li>
			<li>Buyer 2 : <b>{{@$result->Reports[0]->Data->Transactions->Buyer2}}</b></li>
			<li>Buyer 3 : <b>{{@$result->Reports[0]->Data->Transactions->Buyer3}}</b></li>
			<li>Buyer 4 : <b>{{@$result->Reports[0]->Data->Transactions->Buyer4}}</b></li>
			<li>Document Damar Type : <b>{{@$result->Reports[0]->Data->Transactions->DocumentDamarType}}</b></li>
			<li>Lien Position : <b>{{@$result->Reports[0]->Data->Transactions->LienPosition}}</b></li>
			<li>Additional Lien Position : <b>{{@$result->Reports[0]->Data->Transactions->AdditionalLienPosition}}</b></li>
			<li>Is Only Finance : <b>{{@$result->Reports[0]->Data->Transactions->IsOnlyFinance}}</b></li>
			<li>Sale Instrument Number : <b>{{@$result->Reports[0]->Data->Transactions->SaleInstrumentNumber}}</b></li>
			<li>Sale Arms Length Indicator : <b>{{@$result->Reports[0]->Data->Transactions->SaleArmsLengthIndicator}}</b></li>
			<li>Doc Type Damar Code : <b>{{@$result->Reports[0]->Data->Transactions->DocTypeDamarCode}}</b></li>
			<li>Borrowers : <b>{{@$result->Reports[0]->Data->Transactions->DocTypeDamarCode}}</b></li>
			<li>Finance Document Type Code : <b>{{@$result->Reports[0]->Data->Transactions->FinanceDocumentTypeCode}}</b></li>
			<li>Sale Deed Type Damar Code : <b>{{@$result->Reports[0]->Data->Transactions->SaleDeedTypeDamarCode}}</b></li>
			<li>Seq Lien Position : <b>{{@$result->Reports[0]->Data->Transactions->SeqLienPosition}}</b></li>
			<li>Original Book Page Doc Id : <b>{{@$result->Reports[0]->Data->Transactions->OriginalBookPageDocId}}</b></li>
		</ul>

	</div>

