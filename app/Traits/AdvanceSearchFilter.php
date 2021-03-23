<?php
namespace App\Traits;

/**
 * Advance Search filter trait
 */
trait AdvanceSearchFilter
{
    public function advanceSearchFilters($request)
    {
        $filter = [];

        #State and County Bundle

        if ($request->has('state') && $request->get('state') != '') {
            $filter[] = (object) [
                'FilterName'      => 'StateFips',
                'FilterOperator'  => 'is',
                'FilterValues'    => array($request->get('state')['val']),
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('county') && count($request->get('county')) > 0) {
            $county = [];

            foreach ($request->get('county') as $key => $value) {
                if (strlen($value['val']) == 1) {
                    $county[] = $request->get('state')['val'].'00'.$value['val'];
                } elseif (strlen($value['val']) == 2) {
                    $county[] = $request->get('state')['val'].'0'.$value['val'];
                } else {
                    $county[] = $request->get('state')['val'].$value['val'];
                }
            }

            $filter[] = (object) [
                'FilterName'      => 'CountyFips',
                'FilterOperator'  => $request->get('countySelect'),
                'FilterValues'    => $county,
                'FilterGroup'     => 0
            ];
        }

        #Situs Information Filters

        if ($request->has('city') && count($request->get('city')) > 0) {
            $city = [];

            foreach ($request->get('city') as $key => $value) {
                $city[] = str_replace('-', ' ', $value['text']);
            }

            $filter[] = (object) [
                'FilterName'      => 'Cities',
                'FilterOperator'  => $request->get('citySelect'),
                'FilterValues'    => $city,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('zipcode') && $request->get('zipcode') != '') {
            $zip  = [];

            if ($request->get('zipSelect') != 'is between') {
                $zip[] = $request->get('zipcode');
            } else {
                $zip[] = $request->get('zipcode');
                $zip[] = $request->get('zipcodeTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'ZipCodeRange',
                'FilterOperator'  => $request->get('zipSelect'),
                'FilterValues'    => $zip,
                'FilterGroup'     => 0
            ];
        }

        #Address Bundle Filters

        if ($request->has('streetNumberFrom') && $request->get('streetNumberFrom') != '') {
            $streetNumber = [];

            if ($request->get('streetNumberSelect') != 'is between') {
                $streetNumber[] = $request->get('streetNumberFrom');
            } else {
                $streetNumber[] = $request->get('streetNumberFrom');
                $streetNumber[] = $request->get('streetNumberTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'StreetNumber',
                'FilterOperator'  => $request->get('streetNumberSelect'),
                'FilterValues'    => $streetNumber,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('streetDir') && count($request->get('streetDir')) > 0) {
            $streetDir = [];

            foreach ($request->get('streetDir') as $key => $value) {
                $streetDir[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'StreetDir',
                'FilterOperator'  => 'is',
                'FilterValues'    => $streetDir,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('streetNames') && $request->get('streetNames') != '') {
            $streetNumber = [$request->get('streetNames')];

            $filter[] = (object) [
                'FilterName'      => 'StreetNames',
                'FilterOperator'  => $request->get('streetNamesSelect'),
                'FilterValues'    => $streetNumber,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('streetTypes') && count($request->get('streetTypes')) > 0) {
            $streetTypes = [];

            foreach ($request->get('streetTypes') as $key => $value) {
                $streetTypes[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'StreetTypes',
                'FilterOperator'  => 'is',
                'FilterValues'    => $streetTypes,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('streetPostDir') && count($request->get('streetPostDir')) > 0) {
            $streetPostDir = [];

            foreach ($request->get('streetPostDir') as $key => $value) {
                $streetPostDir[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'StreetPostDir',
                'FilterOperator'  => 'is',
                'FilterValues'    => $streetPostDir,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('unitFrom') && $request->get('unitFrom') != '') {
            $streetNumber = [];

            if ($request->get('unitSelect') != 'is between') {
                $streetNumber[] = $request->get('unitFrom');
            } else {
                $streetNumber[] = $request->get('unitFrom');
                $streetNumber[] = $request->get('unitTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'Unit',
                'FilterOperator'  => $request->get('unitSelect'),
                'FilterValues'    => $streetNumber,
                'FilterGroup'     => 0
            ];
        }

        #Characteristic Filters

        if ($request->has('landUse') && count($request->get('landUse')) > 0) {
            $land = [];

            foreach ($request->get('landUse') as $key => $value) {
                $land[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'LandUse',
                'FilterOperator'  => 'is',
                'FilterValues'    => $land,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('countyUseCode') && $request->get('countyUseCode') != '') {
            $countyUseCode = [$request->get('countyUseCode')];

            $filter[] = (object) [
                'FilterName'      => 'CountyUseCode',
                'FilterOperator'  => 'is',
                'FilterValues'    => $countyUseCode,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('zoningCodeFrom') && $request->get('zoningCodeFrom') != '') {
            $zoningCode = [];

            if ($request->get('zoningCodeSelect') != 'is between') {
                $zoningCode[] = $request->get('zoningCodeFrom');
            } else {
                $zoningCode[] = $request->get('zoningCodeFrom');
                $zoningCode[] = $request->get('zoningCodeTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'ZoningCode',
                'FilterOperator'  => $request->get('zoningCodeSelect'),
                'FilterValues'    => $zoningCode,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('siteInfluence') && count($request->get('siteInfluence')) > 0) {
            $siteInfluence = [];

            foreach ($request->get('siteInfluence') as $key => $value) {
                $siteInfluence[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'SiteInfluence',
                'FilterOperator'  => 'is',
                'FilterValues'    => $siteInfluence,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('yearBuiltFrom') && $request->get('yearBuiltFrom') != '') {
            $yearBuilt = [];

            if ($request->get('yearBuiltSelect') != 'is between') {
                $yearBuilt[] = $request->get('yearBuiltFrom');
            } else {
                $yearBuilt[] = $request->get('yearBuiltFrom');
                $yearBuilt[] = $request->get('yearBuiltTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'YearBuilt',
                'FilterOperator'  => $request->get('yearBuiltSelect'),
                'FilterValues'    => $yearBuilt,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('buildingAreaSquareFeetFrom') && $request->get('buildingAreaSquareFeetFrom') != '') {
            $buildingAreaSquareFeet = [];

            if ($request->get('buildingAreaSquareFeetSelect') != 'is between') {
                $buildingAreaSquareFeet[] = $request->get('buildingAreaSquareFeetFrom');
            } else {
                $buildingAreaSquareFeet[] = $request->get('buildingAreaSquareFeetFrom');
                $buildingAreaSquareFeet[] = $request->get('buildingAreaSquareFeetTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'BuildingAreaSquareFeet',
                'FilterOperator'  => $request->get('buildingAreaSquareFeetSelect'),
                'FilterValues'    => $buildingAreaSquareFeet,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('totalNumberOfBedroomsFrom') && $request->get('totalNumberOfBedroomsFrom') != '') {
            $totalNumberOfBedrooms = [];

            if ($request->get('totalNumberOfBedroomsSelect') != 'is between') {
                $totalNumberOfBedrooms[] = $request->get('totalNumberOfBedroomsFrom');
            } else {
                $totalNumberOfBedrooms[] = $request->get('totalNumberOfBedroomsFrom');
                $totalNumberOfBedrooms[] = $request->get('totalNumberOfBedroomsTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'TotalNumberOfBedrooms',
                'FilterOperator'  => $request->get('totalNumberOfBedroomsSelect'),
                'FilterValues'    => $totalNumberOfBedrooms,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('totalNumberOfBathroomsFrom') && $request->get('totalNumberOfBathroomsFrom') != '') {
            $totalNumberOfBathrooms = [];

            if ($request->get('totalNumberOfBathroomsSelect') != 'is between') {
                $totalNumberOfBathrooms[] = $request->get('totalNumberOfBathroomsFrom');
            } else {
                $totalNumberOfBathrooms[] = $request->get('totalNumberOfBathroomsFrom');
                $totalNumberOfBathrooms[] = $request->get('totalNumberOfBathroomsTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'TotalNumberOfBathrooms',
                'FilterOperator'  => $request->get('totalNumberOfBathroomsSelect'),
                'FilterValues'    => $totalNumberOfBathrooms,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('totalNumberOfRoomsFrom') && $request->get('totalNumberOfRoomsFrom') != '') {
            $totalNumberOfRooms = [];

            if ($request->get('totalNumberOfRoomsSelect') != 'is between') {
                $totalNumberOfRooms[] = $request->get('totalNumberOfRoomsFrom');
            } else {
                $totalNumberOfRooms[] = $request->get('totalNumberOfRoomsFrom');
                $totalNumberOfRooms[] = $request->get('totalNumberOfRoomsTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'TotalNumberOfRooms',
                'FilterOperator'  => $request->get('totalNumberOfRoomsSelect'),
                'FilterValues'    => $totalNumberOfRooms,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('lotAreaFrom') && $request->get('lotAreaFrom') != '') {
            $lotArea = [];

            if ($request->get('lotAreaSelect') != 'is between') {
                $lotArea[] = $request->get('lotAreaFrom');
            } else {
                $lotArea[] = $request->get('lotAreaFrom');
                $lotArea[] = $request->get('lotAreaTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'LotArea',
                'FilterOperator'  => $request->get('lotAreaSelect'),
                'FilterValues'    => $lotArea,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('lotAcreageFrom') && $request->get('lotAcreageFrom') != '') {
            $lotAcreage = [];

            if ($request->get('lotAcreageSelect') != 'is between') {
                $lotAcreage[] = $request->get('lotAcreageFrom');
            } else {
                $lotAcreage[] = $request->get('lotAcreageFrom');
                $lotAcreage[] = $request->get('lotAcreageTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'LotAcreage',
                'FilterOperator'  => $request->get('lotAcreageSelect'),
                'FilterValues'    => $lotAcreage,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('numberOfStoriesFrom') && $request->get('numberOfStoriesFrom') != '') {
            $numberOfStories = [];

            if ($request->get('numberOfStoriesSelect') != 'is between') {
                $numberOfStories[] = $request->get('numberOfStoriesFrom');
            } else {
                $numberOfStories[] = $request->get('numberOfStoriesFrom');
                $numberOfStories[] = $request->get('numberOfStoriesTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'NumberOfStories',
                'FilterOperator'  => $request->get('numberOfStoriesSelect'),
                'FilterValues'    => $numberOfStories,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('poolOption') && count($request->get('poolOption')) > 0) {
            $poolOption = [];

            foreach ($request->get('poolOption') as $key => $value) {
                $poolOption[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'PoolOption',
                'FilterOperator'  => 'is',
                'FilterValues'    => $poolOption,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('numberOfGarageSpacesFrom') && $request->get('numberOfGarageSpacesFrom') != '') {
            $numberOfGarageSpaces = [];

            if ($request->get('numberOfGarageSpacesSelect') != 'is between') {
                $numberOfGarageSpaces[] = $request->get('numberOfGarageSpacesFrom');
            } else {
                $numberOfGarageSpaces[] = $request->get('numberOfGarageSpacesFrom');
                $numberOfGarageSpaces[] = $request->get('numberOfGarageSpacesTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'NumberOfGarageSpaces',
                'FilterOperator'  => $request->get('numberOfGarageSpacesSelect'),
                'FilterValues'    => $numberOfGarageSpaces,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('numberOfUnitsFrom') && $request->get('numberOfUnitsFrom') != '') {
            $numberOfUnits = [];

            if ($request->get('numberOfUnitsSelect') != 'is between') {
                $numberOfUnits[] = $request->get('numberOfUnitsFrom');
            } else {
                $numberOfUnits[] = $request->get('numberOfUnitsFrom');
                $numberOfUnits[] = $request->get('numberOfUnitsTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'NumberOfGarageSpaces',
                'FilterOperator'  => $request->get('numberOfUnitsSelect'),
                'FilterValues'    => $numberOfUnits,
                'FilterGroup'     => 0
            ];
        }

        #Owner Information Filters

        if ($request->has('ownerLastNames') && $request->get('ownerLastNames') != '') {
            $ownerLastNames = [];

            if (is_array($request->get('ownerLastNames'))) {
                foreach ($request->get('ownerLastNames') as $key => $value) {
                    $ownerLastNames[] = $value['val'];
                }
            } else {
                $ownerLastNames[] = $request->get('ownerLastNames');
            }

            $filter[] = (object) [
                'FilterName'      => 'OwnerLastNames',
                'FilterOperator'  => 'is',
                'FilterValues'    => $ownerLastNames,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('ownerFirstNames') && $request->get('ownerFirstNames') != '') {
            $ownerFirstNames = [];

            if (is_array($request->get('ownerFirstNames'))) {
                foreach ($request->get('ownerFirstNames') as $key => $value) {
                    $ownerFirstNames[] = $value['val'];
                }
            } else {
                $ownerFirstNames[] = $request->get('ownerFirstNames');
            }

            $filter[] = (object) [
                'FilterName'      => 'OwnerFirstNames',
                'FilterOperator'  => 'is',
                'FilterValues'    => $ownerFirstNames,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('ownerNames') && $request->get('ownerNames') != '') {
            $ownerNames = [];

            if (is_array($request->get('ownerNames'))) {
                foreach ($request->get('ownerNames') as $key => $value) {
                    $ownerNames[] = $value['val'];
                }
            } else {
                $ownerNames[] = $request->get('ownerNames');
            }

            $filter[] = (object) [
                'FilterName'      => 'OwnerNames',
                'FilterOperator'  => 'is',
                'FilterValues'    => $ownerNames,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('ethnicity') && count($request->get('ethnicity')) > 0) {
            $ethnicity = [];

            foreach ($request->get('ethnicity') as $key => $value) {
                $ethnicity[]=$value['val'];
            }

            $filter[] = (object) [
                'FilterName'=> 'Ethnicity',
                'FilterOperator'=> 'is',
                'FilterValues'=> $ethnicity,
                'FilterGroup'=> 0
            ];
        }

        if ($request->has('exemption') && count($request->get('exemption')) > 0) {
            $exemption = array();

            foreach ($request->get('exemption') as $key => $value) {
                $exemption[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'Exemptions',
                'FilterOperator'  => 'is',
                'FilterValues'    => $exemption,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('occupancy') && count($request->get('occupancy')) > 0) {
            $occupancy = [];

            foreach ($request->get('occupancy') as $key => $value) {
              $occupancy[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'OwnerOccupied',
                'FilterOperator'  => 'is',
                'FilterValues'    => $occupancy,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('corporateOwned') && count($request->get('corporateOwned')) > 0) {
            $corporateOwned = [];

            foreach ($request->get('corporateOwned') as $key => $value) {
              $corporateOwned[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'CorporateOwned',
                'FilterOperator'  => 'is',
                'FilterValues'    => $corporateOwned,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('doNotMail') && count($request->get('doNotMail')) > 0) {
            $doNotMail = [];

            foreach ($request->get('doNotMail') as $key => $value) {
              $doNotMail[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'DoNotMail',
                'FilterOperator'  => 'is',
                'FilterValues'    => $doNotMail,
                'FilterGroup'     => 0
            ];
        }

        #Sale Information Filters

        if ($request->has('transactionType') && count($request->get('transactionType')) > 0) {
            $transactionType = [];

            foreach ($request->get('transactionType') as $key => $value) {
              $transactionType[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'TransactionType',
                'FilterOperator'  => 'is',
                'FilterValues'    => $transactionType,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('salePriceFrom') && $request->get('salePriceFrom') != '') {
            $salePrice = [];

            if ($request->get('salePriceSelect') != 'is between') {
                $salePrice[] = $request->get('salePriceFrom');
            } else {
                $salePrice[] = $request->get('salePriceFrom');
                $salePrice[] = $request->get('salePriceTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'SalePrice',
                'FilterOperator'  => $request->get('salePriceSelect'),
                'FilterValues'    => $salePrice,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('salePriceType') && count($request->get('salePriceType')) > 0) {
            $salePriceType = [];

            foreach ($request->get('salePriceType') as $key => $value) {
              $salePriceType[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'SalePriceType',
                'FilterOperator'  => 'is',
                'FilterValues'    => $salePriceType,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('saleDateFrom') && $request->get('saleDateFrom') != '') {
            $date = [];

            if ($request->get('saleDateSelect') != 'is between') {
                $date[] = $request->get('saleDateFrom')['month'].'/'.$request->get('saleDateFrom')['day'].'/'.$request->get('saleDateFrom')['year'];
            } else {
                $date[] = $request->get('saleDateFrom')['month'].'/'.$request->get('saleDateFrom')['day'].'/'.$request->get('saleDateFrom')['year'];
                $date[] = $request->get('saleDateTo')['month'].'/'.$request->get('saleDateTo')['day'].'/'.$request->get('saleDateTo')['year'];
            }

            $filter[] = (object) [
                'FilterName'      => 'SaleDate',
                'FilterOperator'  => $request->get('saleDateSelect'),
                'FilterValues'    => $date,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('marketSaleRecordingDateFrom') && $request->get('marketSaleRecordingDateFrom') != '') {
            $date = [];

            if ($request->get('marketSaleRecordingDateSelect') != 'is between') {
                $date[] = $request->get('marketSaleRecordingDateFrom')['month'].'/'.$request->get('marketSaleRecordingDateFrom')['day'].'/'.$request->get('marketSaleRecordingDateFrom')['year'];
            } else {
                $date[] = $request->get('marketSaleRecordingDateFrom')['month'].'/'.$request->get('marketSaleRecordingDateFrom')['day'].'/'.$request->get('marketSaleRecordingDateFrom')['year'];
                $date[] = $request->get('marketSaleRecordingDateTo')['month'].'/'.$request->get('marketSaleRecordingDateTo')['day'].'/'.$request->get('marketSaleRecordingDateTo')['year'];
            }

            $filter[] = (object) [
                'FilterName'      => 'MarketSaleRecordingDate',
                'FilterOperator'  => $request->get('marketSaleRecordingDateSelect'),
                'FilterValues'    => $date,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('recordingMonth') && count($request->get('recordingMonth')) > 0) {
            $recordingMonth = [];

            foreach ($request->get('recordingMonth') as $key => $value) {
              $recordingMonth[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'RecordingMonth',
                'FilterOperator'  => 'is',
                'FilterValues'    => $recordingMonth,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('sellerName') && $request->get('sellerName') != '') {
            $sellerName = [$request->get('sellerName')];

            $filter[] = (object) [
                'FilterName'      => 'SellerName',
                'FilterOperator'  => $request->get('sellerNameSelect'),
                'FilterValues'    => $sellerName,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('deedType') && count($request->get('deedType')) > 0) {
            $deedType = [];

            foreach ($request->get('deedType') as $key => $value) {
              $deedType[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'DeedType',
                'FilterOperator'  => 'is',
                'FilterValues'    => $deedType,
                'FilterGroup'     => 0
            ];
        }

        #Financing Information Filters

        if ($request->has('mortgageAmountFrom') && $request->get('mortgageAmountFrom') != '') {
            $amount = [];

            if ($request->get('mortgageAmountSelect') == 'is') {
                $amount[] = $request->get('mortgageAmountFrom');
            } else {
                $amount[] = $request->get('mortgageAmountFrom');
                $amount[] = $request->get('mortgageAmountTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'MostRecentMortgageAmount',
                'FilterOperator'  => $request->get('mortgageAmountSelect'),
                'FilterValues'    => $amount,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('mortgageRecordingFrom') && $request->get('mortgageRecordingFrom') != '') {
            $mortgageDate = array();

            if ($request->get('mortgageRecordingDate') != 'is between') {
                $mortgageDate[]=$request->get('mortgageRecordingFrom')['month'].'/'.$request->get('mortgageRecordingFrom')['day'].'/'.$request->get('mortgageRecordingFrom')['year'];
            } else {
                $mortgageDate[]=$request->get('mortgageRecordingFrom')['month'].'/'.$request->get('mortgageRecordingFrom')['day'].'/'.$request->get('mortgageRecordingFrom')['year'];
                $mortgageDate[]=$request->get('mortgageRecordingTo')['month'].'/'.$request->get('mortgageRecordingTo')['day'].'/'.$request->get('mortgageRecordingTo')['year'];
            }

            $filter[] = (object) [
                'FilterName'      => 'MostRecentMortgageRecordingDate',
                'FilterOperator'  => $request->get('mortgageRecordingDate'),
                'FilterValues'    => $mortgageDate,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('mortgageType') && count($request->get('mortgageType')) > 0) {
            $mortgageType = [];

            foreach ($request->get('mortgageType') as $key => $value) {
                $mortgageType[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'FirstMortgageType',
                'FilterOperator'  => 'is',
                'FilterValues'    => $mortgageType,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('sellerCarryBack') && count($request->get('sellerCarryBack')) > 0) {
            $sellerCarryBack = [];

            foreach ($request->get('sellerCarryBack') as $key => $value) {
                $sellerCarryBack[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'SellerCarryBack',
                'FilterOperator'  => 'is',
                'FilterValues'    => $sellerCarryBack,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('mortgageInterestFrom') && $request->get('mortgageInterestFrom') != '') {
            $interest = [];

            if ($request->get('mortgageInterestStatus') != 'is between') {
                $interest[] = $request->get('mortgageInterestFrom');
            } else {
                $interest[] = $request->get('mortgageInterestFrom');
                $interest[] = $request->get('mortgageInterestTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'InterestRate',
                'FilterOperator'  => $request->get('mortgageInterestStatus'),
                'FilterValues'    => $interest,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('financingDeedType') && count($request->get('financingDeedType')) > 0) {
            $financingDeedType = [];

            foreach ($request->get('financingDeedType') as $key => $value) {
                $financingDeedType[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'FinancingDeedType',
                'FilterOperator'  => 'is',
                'FilterValues'    => $financingDeedType,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('interstRateType') && count($request->get('interstRateType')) > 0) {
            $interstRateType = [];

            foreach ($request->get('interstRateType') as $key => $value) {
                $interstRateType[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'InterestRateType',
                'FilterOperator'  => 'is',
                'FilterValues'    => $interstRateType,
                'FilterGroup'     => 0
            ];
        }

        #Equity Filters

        if ($request->has('homeEquityValueFrom') && $request->get('homeEquityValueFrom') != '') {
            $homeEquityValue = [];

            if ($request->get('homeEquityValue') != 'is between') {
                $homeEquityValue[] = $request->get('homeEquityValueFrom');
            } else {
                $homeEquityValue[] = $request->get('homeEquityValueFrom');
                $homeEquityValue[] = $request->get('homeEquityValueTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'HomeEquityValue',
                'FilterOperator'  => $request->get('homeEquityValue'),
                'FilterValues'    => $homeEquityValue,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('homeEquityPercentageFrom') && $request->get('homeEquityPercentageFrom') != '') {
            $homeEquityPercentage = [];

            if ($request->get('homeEquityPercentage') != 'is between') {
                $homeEquityPercentage[] = $request->get('homeEquityPercentageFrom');
            } else {
                $homeEquityPercentage[] = $request->get('homeEquityPercentageFrom');
                $homeEquityPercentage[] = $request->get('homeEquityPercentageTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'HomeEquityPercentage',
                'FilterOperator'  => $request->get('homeEquityPercentage'),
                'FilterValues'    => $homeEquityPercentage,
                'FilterGroup'     => 0
            ];
        }

        #Assessor Information Filters

        if ($request->has('assdTotalValueFrom') && $request->get('assdTotalValueFrom') != '') {
            $assdTotalValue = [];

            if ($request->get('assdTotalValue') != 'is between') {
                $assdTotalValue[] = $request->get('assdTotalValueFrom');
            } else {
                $assdTotalValue[] = $request->get('assdTotalValueFrom');
                $assdTotalValue[] = $request->get('assdTotalValueTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'AssdTotalValue',
                'FilterOperator'  => $request->get('assdTotalValue'),
                'FilterValues'    => $assdTotalValue,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('assdLandValueFrom') && $request->get('assdLandValueFrom') != '') {
            $assdLandValue = [];

            if ($request->get('assdLandValue') != 'is between') {
                $assdLandValue[] = $request->get('assdLandValueFrom');
            } else {
                $assdLandValue[] = $request->get('assdLandValueFrom');
                $assdLandValue[] = $request->get('assdLandValueTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'AssdLandValue',
                'FilterOperator'  => $request->get('assdLandValue'),
                'FilterValues'    => $assdLandValue,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('mktTotalValueFrom') && $request->get('mktTotalValueFrom') != '') {
            $mktTotalValue = [];

            if ($request->get('mktTotalValue') != 'is between') {
                $mktTotalValue[] = $request->get('mktTotalValueFrom');
            } else {
                $mktTotalValue[] = $request->get('mktTotalValueFrom');
                $mktTotalValue[] = $request->get('mktTotalValueTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'MktTotalValue',
                'FilterOperator'  => $request->get('mktTotalValue'),
                'FilterValues'    => $mktTotalValue,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('mktLandValueFrom') && $request->get('mktLandValueFrom') != '') {
            $mktLandValue = [];

            if ($request->get('mktLandValue') != 'is between') {
                $mktLandValue[] = $request->get('mktLandValueFrom');
            } else {
                $mktLandValue[] = $request->get('mktLandValueFrom');
                $mktLandValue[] = $request->get('mktLandValueTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'MktLandValue',
                'FilterOperator'  => $request->get('mktLandValue'),
                'FilterValues'    => $mktLandValue,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('apprTotalValueFrom') && $request->get('apprTotalValueFrom') != '') {
            $apprTotalValue = [];

            if ($request->get('apprTotalValue') != 'is between') {
                $apprTotalValue[] = $request->get('apprTotalValueFrom');
            } else {
                $apprTotalValue[] = $request->get('apprTotalValueFrom');
                $apprTotalValue[] = $request->get('apprTotalValueTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'ApprTotalValue',
                'FilterOperator'  => $request->get('apprTotalValue'),
                'FilterValues'    => $apprTotalValue,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('apprLandValueFrom') && $request->get('apprLandValueFrom') != '') {
            $apprLandValue = [];

            if ($request->get('apprLandValue') != 'is between') {
                $apprLandValue[] = $request->get('apprLandValueFrom');
            } else {
                $apprLandValue[] = $request->get('apprLandValueFrom');
                $apprLandValue[] = $request->get('apprLandValueTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'ApprLandValue',
                'FilterOperator'  => $request->get('apprLandValue'),
                'FilterValues'    => $apprLandValue,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('apprImprovementValueFrom') && $request->get('apprImprovementValueFrom') != '') {
            $apprImprovementValue = [];

            if ($request->get('apprImprovementValue') != 'is between') {
                $apprImprovementValue[] = $request->get('apprImprovementValueFrom');
            } else {
                $apprImprovementValue[] = $request->get('apprImprovementValueFrom');
                $apprImprovementValue[] = $request->get('apprImprovementValueTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'ApprImprovementValue',
                'FilterOperator'  => $request->get('apprImprovementValue'),
                'FilterValues'    => $apprImprovementValue,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('apprImprovementPercentageFrom') && $request->get('apprImprovementPercentageFrom') != '') {
            $apprImprovementPercentage = [];

            if ($request->get('apprImprovementPercentage') != 'is between') {
                $apprImprovementPercentage[] = $request->get('apprImprovementPercentageFrom');
            } else {
                $apprImprovementPercentage[] = $request->get('apprImprovementPercentageFrom');
                $apprImprovementPercentage[] = $request->get('apprImprovementPercentageTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'ApprImprovementPercentage',
                'FilterOperator'  => $request->get('apprImprovementPercentage'),
                'FilterValues'    => $apprImprovementPercentage,
                'FilterGroup'     => 0
            ];
        }

        #Market Value Filters

        if ($request->has('estimatedValueFrom') && $request->get('estimatedValueFrom') != '') {
            $estimatedValue = [];

            if ($request->get('estimatedValue') != 'is between') {
                $estimatedValue[] = $request->get('estimatedValueFrom');
            } else {
                $estimatedValue[] = $request->get('estimatedValueFrom');
                $estimatedValue[] = $request->get('estimatedValueTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'EstimatedValue',
                'FilterOperator'  => $request->get('estimatedValue'),
                'FilterValues'    => $estimatedValue,
                'FilterGroup'     => 0
            ];
        }

        #Listing Information Filters

        if ($request->has('listingStatus') && count($request->get('listingStatus')) > 0) {
            $listingStatus = [];

            foreach ($request->get('listingStatus') as $key => $value) {
                $listingStatus[]=$value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'ListingStatus',
                'FilterOperator'  => 'is',
                'FilterValues'    => $listingStatus,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('listingDateFrom') && $request->get('listingDateFrom')!='') {
            $listingDateStatus = [];

            if ($request->get('listingDateStatus') == 'is') {
                $listingDateStatus[] = $request->get('listingDateFrom')['month'].'/'.$request->get('listingDateFrom')['day'].'/'.$request->get('listingDateFrom')['year'];
            } else {
                $listingDateStatus[] = $request->get('listingDateFrom')['month'].'/'.$request->get('listingDateFrom')['day'].'/'.$request->get('listingDateFrom')['year'];
                $listingDateStatus[] = $request->get('listingDateTo')['month'].'/'.$request->get('listingDateTo')['day'].'/'.$request->get('listingDateTo')['year'];
            }

            $filter[] = (object) [
                'FilterName'      => 'OriginalListDate',
                'FilterOperator'  => $request->get('listingDateStatus'),
                'FilterValues'    => $listingDateStatus,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('listingPriceFrom') && $request->get('listingPriceFrom') != '') {
            $listingPrice = [];

            if ($request->get('listingPriceStatus') == 'is') {
                $listingPrice[] = $request->get('listingPriceFrom');
            } else {
                $listingPrice[] = $request->get('listingPriceFrom');
                $listingPrice[] = $request->get('listingPriceTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'ForSaleListedPrice',
                'FilterOperator'  => $request->get('listingPriceStatus'),
                'FilterValues'    => $listingPrice,
                'FilterGroup'     => 0
            ];
        }

        #Foreclosure Information Bundle

        if ($request->has('foreclosureStatus') && $request->get('foreclosureStatus') != '') {
            $filter[] = (object) [
                'FilterName'      => 'ForeclosureStatus',
                'FilterOperator'  => 'is',
                'FilterValues'    => array($request->get('foreclosureStatus')['val']),
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('foreclosureRecordedDateFrom') && $request->get('foreclosureRecordedDateFrom')!='') {
            $foreclosureRecordedDateStatus = [];

            if ($request->get('foreclosureRecordedDateStatus') == 'is') {
                $foreclosureRecordedDateStatus[] = $request->get('foreclosureRecordedDateFrom')['month'].'/'.$request->get('foreclosureRecordedDateFrom')['day'].'/'.$request->get('foreclosureRecordedDateFrom')['year'];
            } else {
                $foreclosureRecordedDateStatus[] = $request->get('foreclosureRecordedDateFrom')['month'].'/'.$request->get('foreclosureRecordedDateFrom')['day'].'/'.$request->get('foreclosureRecordedDateFrom')['year'];
                $foreclosureRecordedDateStatus[] = $request->get('foreclosureRecordedDateTo')['month'].'/'.$request->get('foreclosureRecordedDateTo')['day'].'/'.$request->get('foreclosureRecordedDateTo')['year'];
            }

            $filter[] = (object) [
                'FilterName'      => 'ForeclosureRecordedDate',
                'FilterOperator'  => $request->get('foreclosureRecordedDateStatus'),
                'FilterValues'    => $foreclosureRecordedDateStatus,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('foreclosureDateFrom') && $request->get('foreclosureDateFrom')!='') {
            $foreclosureDateStatus = [];

            if ($request->get('foreclosureDateStatus') == 'is') {
                $foreclosureDateStatus[] = $request->get('foreclosureDateFrom')['month'].'/'.$request->get('foreclosureDateFrom')['day'].'/'.$request->get('foreclosureDateFrom')['year'];
            } else {
                $foreclosureDateStatus[] = $request->get('foreclosureDateFrom')['month'].'/'.$request->get('foreclosureDateFrom')['day'].'/'.$request->get('foreclosureDateFrom')['year'];
                $foreclosureDateStatus[] = $request->get('foreclosureDateTo')['month'].'/'.$request->get('foreclosureDateTo')['day'].'/'.$request->get('foreclosureDateTo')['year'];
            }

            $filter[] = (object) [
                'FilterName'      => 'ForeclosureEventDate',
                'FilterOperator'  => $request->get('foreclosureDateStatus'),
                'FilterValues'    => $foreclosureDateStatus,
                'FilterGroup'     => 0
            ];
        }

        if ($request->has('foreclosureAmountFrom') && $request->get('foreclosureAmountFrom') != '') {
            $foreclosureAmountStatus = [];

            if ($request->get('foreclosureAmountStatus') == 'is') {
                $foreclosureAmountStatus[] = $request->get('foreclosureAmountFrom');
            } else {
                $foreclosureAmountStatus[] = $request->get('foreclosureAmountFrom');
                $foreclosureAmountStatus[] = $request->get('foreclosureAmountTo');
            }

            $filter[] = (object) [
                'FilterName'      => 'ForeclosureSaleAmount',
                'FilterOperator'  => $request->get('foreclosureAmountStatus'),
                'FilterValues'    => $foreclosureAmountStatus,
                'FilterGroup'     => 0
            ];
        }

        # Others
        if ($request->has('OpportunityZone') && count($request->get('OpportunityZone')) > 0) {
            $OpportunityZone = [];

            foreach ($request->get('OpportunityZone') as $key => $value) {
                $OpportunityZone[] = $value['val'];
            }

            $filter[] = (object) [
                'FilterName'      => 'OpportunityZone',
                'FilterOperator'  => 'is',
                'FilterValues'    => $OpportunityZone,
                'FilterGroup'     => 0
            ];
        }

        return $filter;
    }
}


/* if($request->has('state') && $request->get('state')!=''){

 $filter[]=(object)array(
   'FilterName'=> 'NeighborhoodName',
   'FilterOperator'=> 'Is',
   'FilterValues'=> 'Wynmoor',
   'FilterGroup'=> 0
 );
}    */

/* if($request->has('zipcode') && count($request->get('zipcode'))>0){
 $zipcode=array();
 foreach ($request->get('zipcode') as $key => $value) {
   $zipcode[]=$value['text'];
 }
 $filter[]=(object)array(
   'FilterName'=> 'ZipCodeRange',
   'FilterOperator'=> 'is',
   'FilterValues'=> $zipcode,
   'FilterGroup'=> 0
 );
} */
