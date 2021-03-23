

	<div>
		<h1>Report Name: Foreclosure Report</h1>
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

		<h4>Latest Foreclosure Activity</h4>
		<ul>
			<li>Current Through Date : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->CurrentThroughDate}}</b></li>
			<li>Document Type : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->DocumentType}}</b></li>
			<li>Lis Pendens Type : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->LisPendensType}}</b></li>
			<li>Recording Date : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->RecordingDate}}</b></li>
			<li>Original Doc Number : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->OriginalDocNumber}}</b></li>
			<li>Original Recording Date : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->OriginalRecordingDate}}</b></li>
			<li>Filing Date : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->FilingDate}}</b></li>
			<li>Default Date : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->DefaultDate}}</b></li>
			<li>Default Amount : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->DefaultAmount}}</b></li>
			<li>Unpaid Balance : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->UnpaidBalance}}</b></li>
			<li>Auction Date : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->AuctionDate}}</b></li>
			<li>Auction Location : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->AuctionLocation}}</b></li>
			<li>Auction City : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->AuctionCity}}</b></li>
			<li>Opening By id : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->OpeningBid}}</b></li>
			<li>Borrower 1 : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->Borrower1}}</b></li>
			<li>Borrower 2 : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->Borrower2}}</b></li>
			<li>Defendant 1 : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->Defendant1}}</b></li>
			<li>Defendant 2 : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->Defendant2}}</b></li>
			<li>Trustee 1 : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->Trustee1}}</b></li>
			<li>Trustee 2 : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->Trustee2}}</b></li>
			<li>Attorney 1 : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->Attorney1}}</b></li>
			<li>Attorney 2 : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->Attorney2}}</b></li>
			<li>Plain Tiff 1 : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->PlainTiff1}}</b></li>
			<li>Plain Tiff 2 : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->PlainTiff2}}</b></li>
			<li>Title Company: <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->TitleCompany}}</b></li>
			<li>Foreclosure Doc Type : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->ForeclosureDocType}}</b></li>
			<li>Foreclosure Doc Number : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->ForeclosureDocNumber}}</b></li>
			<li>Foreclosure Doc Num CMT Id : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->ForeclosureDocNumCMTId}}</b></li>
			<li>Foreclosure Book Page : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->ForeclosureBookPage}}</b></li>
			<li>Foreclosure Volume CMT Id : <b>{{@$result->Reports[0]->Data->LatestForeclosureActivity->ForeclosureVolumeCMTId}}</b></li>
		</ul>
		
		<h4>Original Mortgage</h4>
		<table>
			<tr>
				<td>Id</td>
				<td>Type</td>
				<td>Tx Date</td>
				<td>Doc Type</td>
				<td>Buyer Borrower</td>
				<td>Seller Lender</td>
				<td>Amount</td>
				<td>Doc Id</td>
				<td>Book Page</td>
				<td>CMT Identifier</td>
				<td>Volume CMT Identifier</td>
				<td>Title Company</td>
				<td>Buyer</td>
				<td>Seller</td>
				<td>SaleDate</td>
				<td>Sale Type</td>
				<td>Lender</td>
				<td>Borrower 1</td>
				<td>Borrower 2</td>
				<td>Borrower 3</td>
				<td>Borrower 4</td>
				<td>Loan Amount</td>
				<td>Finance Type</td>
				<td>Mortgage Loan Type</td>
				<td>Mortage Rate Type</td>
				<td>Mortgage Rate</td>
				<td>Is True</td>
				<td>RetFinance Type</td>
				<td>Ret Rate Type</td>
				<td>Original Doc Number</td>
				<td>Mortgage Doc Number 1</td>
				<td>Mortgage Doc Number 2</td>
				<td>Doc Number 1</td>
				<td>Document Type</td>
			</tr>
			@foreach($result->Reports[0]->Data->OriginalMortgage as $value)
			<tr>
				<td>{{$value->Id}}</td>
				<td>{{$value->Type}}</td>
				<td>{{$value->TxDate}}</td>
				<td>{{$value->DocType}}</td>
				<td>{{$value->BuyerBorrower}}</td>
				<td>{{$value->SellerLender}}</td>
				<td>{{$value->Amount}}</td>
				<td>{{$value->DocId}}</td>
				<td>{{$value->BookPage}}</td>
				<td>{{$value->CMTIdentifier}}</td>
				<td>{{$value->VolumeCMTIdentifier}}</td>
				<td>{{$value->TitleCompany}}</td>
				<td>{{$value->Buyer}}</td>
				<td>{{$value->Seller}}</td>
				<td>{{$value->SaleDate}}</td>
				<td>{{$value->SaleType}}</td>
				<td>{{$value->Lender}}</td>
				<td>{{$value->Borrower1}}</td>
				<td>{{$value->Borrower2}}</td>
				<td>{{$value->Borrower3}}</td>
				<td>{{$value->Borrower4}}</td>
				<td>{{$value->LoanAmount}}</td>
				<td>{{$value->FinanceType}}</td>
				<td>{{$value->MortgageLoanType}}</td>
				<td>{{$value->MortageRateType}}</td>
				<td>{{$value->MortgageRate}}</td>
				<td>{{$value->IsTrue}}</td>
				<td>{{$value->RetFinanceType}}</td>
				<td>{{$value->RetRateType}}</td>
				<td>{{$value->OriginalDocNumber}}</td>
				<td>{{$value->MortgageDocNumber1}}</td>
				<td>{{$value->MortgageDocNumber2}}</td>
				<td>{{$value->DocNumber1}}</td>
				<td>{{$value->DocumentType}}</td>
			</tr>
			@endforeach
		</table>

		<h4>Foreclosure Summary</h4>
		<table>
			<tr>
				<td>Document Type</td>
				<td>Recording Date</td>
				<td>Document Number</td>
				<td>Document Cmt Id</td>
				<td>Original Document Number</td>
				<td>Original Rec Date</td>
				<td>Un Paid Balance</td>
				<td>Lender</td>
				<td>Finance Document Type Code</td>
				<td>Child Records</td>
				<td>Is Selected</td>
			</tr>
			@foreach($result->Reports[0]->Data->ForeclosureSummary as $value)
			<tr>
				<td>{{$value->DocumentType}}</td>
				<td>{{$value->RecordingDate}}</td>
				<td>{{$value->DocumentNumber}}</td>
				<td>{{$value->DocumentCmtId}}</td>
				<td>{{$value->OriginalDocumentNumber}}</td>
				<td>{{$value->OriginalRecDate}}</td>
				<td>{{$value->UnPaidBalance}}</td>
				<td>{{$value->Lender}}</td>
				<td>{{$value->FinanceDocumentTypeCode}}</td>
				<td>@if(!empty($value->ChildRecords))
					<div> <ul>
					@foreach($value->ChildRecords as $child)
					<li>DocumentType : <b>{{@$child->DocumentType}}</b></li>
					<li>RecordingDate : <b>{{@$child->RecordingDate}}</b></li>
					<li>DocumentNumber : <b>{{@$child->DocumentNumber}}</b></li>
					<li>DocumentCmtId : <b>{{@$child->DocumentCmtId}}</b></li>
					<li>OriginalDocumentNumber : <b>{{@$child->OriginalDocumentNumber}}</b></li>
					<li>OriginalRecDate : <b>{{@$child->OriginalRecDate}}</b></li>
					<li>UnPaidBalance : <b>{{@$child->UnPaidBalance}}</b></li>
					<li>Lender : <b>{{@$child->Lender}}</b></li>
					<li>FinanceDocumentTypeCode : <b>{{@$child->FinanceDocumentTypeCode}}</b></li>
					@if($child->ChildRecords)
						<ul>
						@foreach($child->ChildRecords as $subchild)
						<li><b>{{@$subchild}}</b></li>
						@endforeach
						</ul>
					@endif
					@endforeach
					</ul>
					</div>
				@endif</td>
				<td>{{$value->IsSelected}}</td>
			</tr>
			@endforeach
		</table>

	</div>
