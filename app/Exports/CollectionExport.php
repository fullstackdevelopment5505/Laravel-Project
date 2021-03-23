<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class CollectionExport implements FromCollection, WithHeadings, WithTitle
{
    use Exportable;

	private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
	public function title(): string
    {
        return 'Emails';
    }
    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'version',
            'query-id',
            'num-results',
            'query-time',
			'#RawScore',
			'#WeightedScore',
			'#RawMatchCodes',
			'#MergeCtr',
            '#MaxRawScore',
            '#NormalizedRawScore',
            '#MaxWeightedScore',
			'#NormalizedWeightedScore',
			'Results:FirstName',
			'Results:MiddleName',
			'Results:LastName',
			'Results:Address',
			'Results:City',
			'Results:State',
			'Results:Zip',
			'Results:Country',
			'Results:TimeStamp',
			'Results:EmailAddr',
			'Results:IP',
			'Results:URLSource',
			'Results:EmailAddrUsable',
			'input-query:FirstName',
			'input-query:LastName',
			'input-query:Address',
			'input-query:City',
			'input-query:State',
			'input-query:PostalCode',
			'input-query:HouseNum',
			'input-query:Street',
			'phone:AreaCode',
			'phone:LineType',
			'phone:PhoneNumber',
		    'phone:Name',
			'phone:MatchLevel',
			'phone:MaxValidationLevel', 
			'phone:Count', 
			'Demograph: FirstName',
			'Demograph: LastName',
			'Demograph: Address',
			'Demograph: City',
			'Demograph: State',
			'Demograph: Zip',
			'Demograph: DOB',
			'Demograph: AgeRange',
			'Demograph: TimeStamp',
			'Demograph: EthnicGroup',
			'Demograph: SingleParent',
			'Demograph: WorkingWoman',
			'Demograph: SOHOIndicator',
			'Demograph: Language',
			'Demograph: Religion',
			'Demograph: NumberOfChildren',
			'Demograph: MaritalStatusInHousehold',
			'Demograph: HomeOwnerRenter',
			'Demograph: Education',
			'Demograph: Occupation',
			'Demograph: OccupationDetail',
			'Demograph: Gender',
			'Demograph: PresenceOfChildren',
			'Interest: Magazines',
			'Interest: ComputerAndTechnology',
			'Interest: ExerciseHealthGrouping',
			'Interest: MailOrderBuyer',
			'Interest: TravelGrouping',
			'Interest: OnlineEducation',
			'Interest: SportsGrouping',
			'Interest: SportsOutdoorsGrouping',
			'Interest: BooksAndReading',
			'Interest: ArtsAntiquesCollectibles',
			'Interest: PetOwner',
			'Interest: HealthBeautyWellness',
			'Interest: Music',
			'Interest: Movie',
			'Interest: SelfImprovement',
			'Interest: WomensApparel',
			'Finance:FirstName',
			'Finance:MiddleName',
			'Finance:LastName',
			'Finance:Address',
			'Finance:City',
			'Finance:State',
			'Finance:Zip',
			'Finance:Country',
			'Finance:TimeStamp',
			'Finance: EstimatedHouseholdIncome',
			'Finance: LengthOfResidence',
			'Finance: HomePurchaseDate',
			'Finance: HomePurchasePrice',
			'Finance: DwellingType',
			'Finance: HomeValue',
			'Finance: NumberCreditLines',
			'Finance: CreditCardUser',
			'Finance: CardHolderGasDeptRetail',
			'Finance: AutoYear',
			'Finance: AutoMake',
			'Finance: AutoModel',
			'Finance: AutoEdition',
			'Finance: EstWealth',
			'Finance: UpscaleCardHolder',
			
        ];
    }

}