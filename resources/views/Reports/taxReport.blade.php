
	<div>
		<h1>Report Name: Tax Status Report</h1>
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

		<h4>TaxAuthority</h4>
		<ul>
			<li>TaxAuthority : <b>{{@$result->Reports[0]->Data->TaxAuthority}}</b></li>
		</ul>

		<h4>Taxes</h4>
		<ul>
			<li>Taxes : <b>{{@$result->Reports[0]->Data->Taxes}}</b></li>
		</ul>

		<h4>Tax Status</h4>
		<ul>
			<li>Property Id : <b>{{@$result->Reports[0]->Data->TaxStatus->PropertyId}}</b></li>
			<li>Effective Date : <b>{{@$result->Reports[0]->Data->TaxStatus->EffectiveDate}}</b></li>
			<li>Assessor Parcel : <b>{{@$result->Reports[0]->Data->TaxStatus->AssessorParcel}}</b></li>
			<li>Tax Year : <b>{{@$result->Reports[0]->Data->TaxStatus->TaxYear}}</b></li>
			<li>Assessed Value : <b>{{@$result->Reports[0]->Data->TaxStatus->AssessedValue}}</b></li>
			<li>Land : <b>{{@$result->Reports[0]->Data->TaxStatus->Land}}</b></li>
			<li>Improvements : <b>{{@$result->Reports[0]->Data->TaxStatus->Improvements}}</b></li>
			<li>Exemptions : <b>{{@$result->Reports[0]->Data->TaxStatus->Exemptions}}</b></li>
			<li>Exemption Types : <b>{{@$result->Reports[0]->Data->TaxStatus->ExemptionTypes}}</b></li>
			<li>Total TaxableAmt : <b>{{@$result->Reports[0]->Data->TaxStatus->TotalTaxableAmt}}</b></li>
			<li>Special Assessment : <b>{{@$result->Reports[0]->Data->TaxStatus->SpecialAssessment}}</b></li>
			<li>Addl Land : <b>{{@$result->Reports[0]->Data->TaxStatus->AddlLand}}</b></li>
			<li>Addl Improved : <b>{{@$result->Reports[0]->Data->TaxStatus->AddlImproved}}</b></li>
			<li>Property Tax : <b>{{@$result->Reports[0]->Data->TaxStatus->PropertyTax}}</b></li>
			<li>County Tax System ID : <b>{{@$result->Reports[0]->Data->TaxStatus->CountyTaxSystemID}}</b></li>
			<li>Assessed Year : <b>{{@$result->Reports[0]->Data->TaxStatus->AssessedYear}}</b></li>
			<li>Market Value : <b>{{@$result->Reports[0]->Data->TaxStatus->MarketValue}}</b></li>
			<li>Market Land Value : <b>{{@$result->Reports[0]->Data->TaxStatus->MarketLandValue}}</b></li>
			<li>Market Improv Value : <b>{{@$result->Reports[0]->Data->TaxStatus->MarketImprovValue}}</b></li>
			<li>Improved Percent : <b>{{@$result->Reports[0]->Data->TaxStatus->ImprovedPercent}}</b></li>
			<li>Delinquent Year : <b>{{@$result->Reports[0]->Data->TaxStatus->DelinquentYear}}</b></li>
			<li>Market Improv Value Percent : <b>{{@$result->Reports[0]->Data->TaxStatus->MarketImprovValuePercent}}</b></li>
			<li>Payee Legacy Identifier : <b>{{@$result->Reports[0]->Data->TaxStatus->PayeeLegacyIdentifier}}</b></li>
			<li>Authority Address : <b>{{@$result->Reports[0]->Data->TaxStatus->AuthorityAddress}}</b></li>
			<li>Type : <b>{{@$result->Reports[0]->Data->TaxStatus->Type}}</b></li>
			<li>Tax Payment Status Type : <b>{{@$result->Reports[0]->Data->TaxStatus->TaxPaymentStatusType}}</b></li>
			<li>Street Address : <b>{{@$result->Reports[0]->Data->TaxStatus->StreetAddress}}</b></li>
			<li>City : <b>{{@$result->Reports[0]->Data->TaxStatus->City}}</b></li>
			<li>County : <b>{{@$result->Reports[0]->Data->TaxStatus->County}}</b></li>
			<li>State : <b>{{@$result->Reports[0]->Data->TaxStatus->State}}</b></li>
			<li>Zip : <b>{{@$result->Reports[0]->Data->TaxStatus->Zip}}</b></li>
			<li>Supplemental Tax Year : <b>{{@$result->Reports[0]->Data->TaxStatus->SupplementalTaxYear}}</b></li>
			<li>Supplemental Tax Tax Bill Type : <b>{{@$result->Reports[0]->Data->TaxStatus->SupplementalTaxTaxBillType}}</b></li>
			<li>Is Supplemental Tax Available : <b>{{@$result->Reports[0]->Data->TaxStatus->IsSupplementalTaxAvailable}}</b></li>
			<li>Is Delinquent Tax Available : <b>{{@$result->Reports[0]->Data->TaxStatus->IsDelinquentTaxAvailable}}</b></li>
			<li>Tax Data Source : <b>{{@$result->Reports[0]->Data->TaxStatus->TaxDataSource}}</b></li>
		</ul>


		<h4>CurrentYearTax</h4>
		<table>
			<tr>
				<td>Tax Type</td>
				<td>Installment</td>
				<td>Amount</td>
				<td>Status</td>
				<td>Due Date</td>
				<td>Delinquent Date</td>
				<td>Penalty Amt</td>
				<td>Balance Due</td>
				<td>Annual Total</td>
			</tr>
			@foreach($result->Reports[0]->Data->TaxStatus->CurrentYearTax as $value)
			<tr>
				<td>{{$value->TaxType}}</td>
				<td>{{$value->Installment}}</td>
				<td>{{$value->Amount}}</td>
				<td>{{$value->Status}}</td>
				<td>{{$value->DueDate}}</td>
				<td>{{$value->DelinquentDate}}</td>
				<td>{{$value->PenaltyAmt}}</td>
				<td>{{$value->BalanceDue}}</td>
				<td>{{$value->AnnualTotal}}</td>
			</tr>
			@endforeach
		</table>
		
		<h4>AssessmentDetails</h4>
		<table>
			<tr>
				<td>Jurisdiction</td>
				<td>Code</td>
				<td>Description</td>
				<td>Type</td>
				<td>Amount</td>
			</tr>
			@foreach($result->Reports[0]->Data->TaxStatus->AssessmentDetails as $value)
			<tr>
				<td>{{$value->Jurisdiction}}</td>
				<td>{{$value->Code}}</td>
				<td>{{$value->Description}}</td>
				<td>{{$value->Type}}</td>
				<td>{{$value->Amount}}</td>
			</tr>
			@endforeach
		</table>

	</div>
