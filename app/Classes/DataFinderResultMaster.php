<?php
    namespace App\Classes;
    
    // DataFinderResultMaster
    class DataFinderResultMaster {
        // declare variables
        public $rawScore; 
        public $weightedScore; 
        public $rawMatchCodes; 
        public $mergeCtr;
        public $maxRawScore; 
        public $normalizedRawScore; 
        public $maxWeightedScore; 
        public $normalizedWeightedScore; 
        public $firstName; 
        public $middleName; 
        public $lastName;
        public $address;
        public $city;
        public $county;
        public $state;
        public $zip;
        public $zip4; 
        public $country; 
        public $phone;
        public $timeStamp; 
        public $lineType;
        public $emailAddr;
        public $urlSource;
        public $emailAddrUsable;
        public $dob; 
        public $ageRange; 
        public $ethnicGroup;
        public $language;
        public $religion;
        public $numChildren;
        public $education;
        public $occupation;
        public $gender;
        public $childPresence;
        public $singleParent;
        public $seniorAdultInHousehold;
        public $youngAdultInHousehold;
        public $workingWoman;
        public $sohoIndicator;
        public $businessOwner;
        public $maritalStatus;
        public $homeOwnerRenter; 
        public $occupationalDetail;
        public $socialPresence;
        public $estimatedIncome;
        public $lengthResidence; 
        public $homePurchaseDate;
        public $homePurchasePrice; 
        public $dwellingType;
        public $homeValue;
        public $numberCreditLines;
        public $creditCardUser;
        public $cardHolderGasDeptRetail;
        public $autoYear;
        public $autoMake;
        public $autoModel;
        public $autoEdition;
        public $estWealth;
        public $upscaleCardHolder;
        public $magazines; 
        public $computerTechnology; 
        public $dietingWeightLoss;
        public $exerciseHealthGrouping;
        public $diyHomeImprovement; 
        public $jewlery; 
        public $mailOrderBuyer; 
        public $membershipClubs;
        public $travelGrouping;
        public $onlineEducation; 
        public $sportsGrouping;
        public $sportsOutdoorsGrouping;
        public $investing;
        public $booksReading;
        public $politicalDonor;
        public $hobbiesAndCrafts;
        public $cosmetics;
        public $charitableDonations;
        public $artsAntiques; 
        public $petOwner;
        public $cooking;
        public $autoparts;
        public $healthBeautyWellness; 
        public $parentingAndChildrensProducts; 
        public $music;
        public $movie;
        public $selfImprovement;
        public $womensApparel;
        
        // 87 items 

        // get and set rawScore
        public function setRawScore($rawScore) { $this->rawScore = $rawScore; }
        public function getRawScore() { return $this->rawScore; }

        // get and set weightedScore 
        public function setWeightedScore($weightedScore) { $this->weightedScore = $weightedScore; }
        public function getWeightedScore() { return $this->weightedScore; }

        //get and set rawMatchCodes
        public function setRawMatchCodes($rawMatchCodes) { $this->rawMatchCodes = $rawMatchCodes; }
        public function getRawMatchCodes() { return $this->rawMatchCodes; }

        // get and set mergeCtr
        public function setMergeCtr($mergeCtr) { $this->mergeCtr = $mergeCtr; }
        public function getMergeCtr() { return $this->mergeCtr; }

        // get and set maxRawScore
        public function setMaxRawScore($maxRawScore) { $this->maxRawScore = $maxRawScore; }
        public function getMaxRawScore() { return $this->maxRawScore; }

        // get and set normalizedRawScore
        public function setNormalizedRawScore($normalizedRawScore) { $this->normalizedRawScore = $normalizedRawScore; }
        public function getNormalizedRawScore() { return $this->normalizedRawScore; }

        // get and set maxWeightedScore
        public function setMaxWeightedScore($maxWeightedScore) { $this->maxWeightedScore = $maxWeightedScore; }
        public function getMaxWeightedScore() { return $this->maxWeightedScore; }

        // get and set normalizedWeightedScore
        public function setNormalizedWeightedScore($normalizedWeightedScore) { $this->normalizedWeightedScore = $normalizedWeightedScore; }
        public function getNormalizedWeightedScore() { return $this->normalizedWeightedScore; }

        // get and set firstName
        public function setFirstName($firstName) { $this->firstName = $firstName; }
        public function getFirstName() { return $this->firstName; }

        // get and set middleName
        public function setMiddleName($middleName) { $this->middleName = $middleName ; }
        public function getMiddleName() { return $this->middleName; }

        // get and set lastName
        public function setLastName($lastName) { $this->lastName = $lastName ; }
        public function getLastName() { return $this->lastName; }

        // get and set address
        public function setAddress($address) { $this->address = $address ; }
        public function getAddress() { return $this->address; }
        
        // get and set city
        public function setCity($city) { $this->city = $city ; }
        public function getCity() { return $this->city; }

        // get and set county
        public function setCounty($county) { $this->county = $county ; }
        public function getCounty() { return $this->county; }

        // get and set state
        public function setState($state) { $this->state = $state ; }
        public function getState() { return $this->state; }

        // get and set zip
        public function setZip($zip) { $this->zip = $zip ; }
        public function getZip() { return $this->zip; }

        // get and set zip4
        public function setZip4($zip4) { $this->zip4 = $zip4 ; }
        public function getZip4() { return $this->zip4; }

        // get and set country
        public function setCountry($country) { $this->country = $country ; }
        public function getCountry() { return $this->country; }

        // get and set phone
        public function setPhone($phone) { $this->phone = $phone ; }
        public function getPhone() { return $this->phone; }

        // get and set timeStamp
        public function setTimeStamp($timeStamp) { $this->timeStamp = $timeStamp ; }
        public function getTimeStamp() { return $this->timeStamp; }

        // get and set lineType
        public function setLineType($lineType) { $this->lineType = $lineType ; }
        public function getLineType() { return $this->lineType; }    
        
        // get and set emailAddr
        public function setEmailAddr($emailAddr) { $this->emailAddr = $emailAddr ; }
        public function getEmailAddr() { return $this->emailAddr; }    

        // get and set urlSource
        public function setUrlSource($urlSource) { $this->urlSource = $urlSource ; }
        public function getUrlSource() { return $this->urlSource; }   

        // get and set emailAddrUsable
        public function setEmailAddrUsable($emailAddrUsable) { $this->emailAddrUsable = $emailAddrUsable ; }
        public function getEmailAddrUsable() { return $this->emailAddrUsable; }    

        // get and set dob
        public function setDob($dob) { $this->dob = $dob ; }
        public function getDob() { return $this->dob; }  

        // get and set ageRange
        public function setAgeRange($ageRange) { $this->ageRange = $ageRange ; }
        public function getAgeRange() { return $this->ageRange; }  

        // get and set ethnicGroup
        public function setEthnicGroup($ethnicGroup) { $this->ethnicGroup = $ethnicGroup ; }
        public function getEthnicGroup() { return $this->ethnicGroup; }  

        // get and set language
        public function setLanguage($language) { $this->language = $language ; }
        public function getLanguage() { return $this->language; }  

        // get and set religion
        public function setReligion($religion) { $this->religion = $religion ; }
        public function getReligion() { return $this->religion; }  

        // get and set numChildren
        public function setNumChildren($numChildren) { $this->numChildren = $numChildren ; }
        public function getNumChildren() { return $this->numChildren; }  

        // get and set education
        public function setEducation($education) { $this->education = $education ; }
        public function getEducation() { return $this->education; } 
        
        // get and set occupation
        public function setOccupation($occupation) { $this->occupation = $occupation ; }
        public function getOccupation() { return $this->occupation; }  

        // get and set gender
        public function setGender($gender) { $this->gender = $gender ; }
        public function getGender() { return $this->gender; } 

        // get and set childPresence
        public function setChildPresence($childPresence) { $this->childPresence = $childPresence ; }
        public function getChildPresence() { return $this->childPresence; }  

        // get and set estimatedIncome
        public function setEstimatedIncome($estimatedIncome) { $this->estimatedIncome = $estimatedIncome ; }
        public function getEstimatedIncome() { return $this->estimatedIncome; }  

        // get and set lengthResidence
        public function setLengthResidence($lengthResidence) { $this->lengthResidence = $lengthResidence ; }
        public function getLengthResidence() { return $this->lengthResidence; }  

        // get and set homePurchaseDate
        public function setHomePurchaseDate($homePurchaseDate) { $this->homePurchaseDate = $homePurchaseDate ; }
        public function getHomePurchaseDate() { return $this->homePurchaseDate; }  

        // get and set homePurchasePrice
        public function setHomePurchasePrice($homePurchasePrice) { $this->homePurchasePrice = $homePurchasePrice ; }
        public function getHomePurchasePrice() { return $this->homePurchasePrice; }  

        // get and set dwellingType
        public function setDwellingType($dwellingType) { $this->dwellingType = $dwellingType ; }
        public function getDwellingType() { return $this->dwellingType; }  

        // get and set homeValue
        public function setHomeValue($homeValue) { $this->homeValue = $homeValue ; }
        public function getHomeValue() { return $this->homeValue; }  

        // get and set numberCreditLines
        public function setNumberCreditLines($numberCreditLines) { $this->numberCreditLines = $numberCreditLines ; }
        public function getNumberCreditLines() { return $this->numberCreditLines; }  

        // get and set creditCardUser
        public function setCreditCardUser($creditCardUser) { $this->creditCardUser = $creditCardUser ; }
        public function getCreditCardUser() { return $this->creditCardUser; }  
        
        // get and set cardHolderGasDeptRetail
        public function setCardHolderGasDeptRetail($cardHolderGasDeptRetail) { $this->cardHolderGasDeptRetail = $cardHolderGasDeptRetail ; }
        public function getCardHolderGasDeptRetail() { return $this->cardHolderGasDeptRetail; }  
    
        // get and set autoYear
        public function setAutoYear($autoYear) { $this->autoYear = $autoYear ; }
        public function getAutoYear() { return $this->autoYear; }  

        // get and set autoMake
        public function setAutoMake($autoMake) { $this->autoMake = $autoMake ; }
        public function getAutoMake() { return $this->autoMake; }  

        // get and set autoModel
        public function setAutoModel($autoModel) { $this->autoModel = $autoModel ; }
        public function getAutoModel() { return $this->autoModel; }  

        // get and set autoEdition
        public function setAutoEdition($autoEdition) { $this->autoEdition = $autoEdition ; }
        public function getAutoEdition() { return $this->autoEdition; }  

        // get and set estWealth
        public function setEstWealth($estWealth) { $this->estWealth = $estWealth ; }
        public function getEstWealth() { return $this->estWealth; }  

        // get and set upscaleCardHolder
        public function setUpscaleCardHolder($upscaleCardHolder) { $this->upscaleCardHolder = $upscaleCardHolder ; }
        public function getUpscaleCardHolder() { return $this->upscaleCardHolder; }  

        // get and set magazines
        public function setMagazines($magazines) { $this->magazines = $magazines ; }
        public function getMagazines() { return $this->magazines; } 

        // get and set computerTechnology
        public function setComputerTechnology($computerTechnology) { $this->computerTechnology = $computerTechnology ; }
        public function getComputerTechnology() { return $this->computerTechnology; } 

        // get and set dietingWeightLoss
        public function setDietingWeightLoss($dietingWeightLoss) { $this->dietingWeightLoss = $dietingWeightLoss ; }
        public function getDietingWeightLoss() { return $this->dietingWeightLoss; } 

        // get and set exerciseHealthGrouping
        public function setExerciseHealthGrouping($exerciseHealthGrouping) { $this->exerciseHealthGrouping = $exerciseHealthGrouping ; }
        public function getExerciseHealthGrouping() { return $this->exerciseHealthGrouping; } 

        // get and set diyHomeImprovement
        public function setDiyHomeImprovement($diyHomeImprovement) { $this->diyHomeImprovement = $diyHomeImprovement ; }
        public function getDiyHomeImprovement() { return $this->diyHomeImprovement; } 

        // get and set jewlery
        public function setJewlery($jewlery) { $this->jewlery = $jewlery ; }
        public function getJewlery() { return $this->jewlery; } 

        // get and set mailOrderBuyer
        public function setMailOrderBuyer($mailOrderBuyer) { $this->mailOrderBuyer = $mailOrderBuyer ; }
        public function getMailOrderBuyer() { return $this->mailOrderBuyer; } 

        // get and set membershipClubs
        public function setMembershipClubs($membershipClubs) { $this->membershipClubs = $membershipClubs ; }
        public function getMembershipClubs() { return $this->membershipClubs; } 

        // get and set travelGrouping
        public function setTravelGrouping($travelGrouping) { $this->travelGrouping = $travelGrouping ; }
        public function getTravelGrouping() { return $this->travelGrouping; } 

        // get and set onlineEducation
        public function setOnlineEducation($onlineEducation) { $this->onlineEducation = $onlineEducation ; }
        public function getOnlineEducation() { return $this->onlineEducation; } 

        // get and set sportsGrouping
        public function setSportsGrouping($sportsGrouping) { $this->sportsGrouping = $sportsGrouping ; }
        public function getSportsGrouping() { return $this->sportsGrouping; } 

        // get and set sportsOutdoorsGrouping
        public function setSportsOutdoorsGrouping($sportsOutdoorsGrouping) { $this->sportsOutdoorsGrouping = $sportsOutdoorsGrouping ; }
        public function getSportsOutdoorsGrouping() { return $this->sportsOutdoorsGrouping; } 

        // get and set investing 
        public function setInvesting($investing) { $this->investing = $investing ; }
        public function getInvesting() { return $this->investing; } 

        // get and set booksReading
        public function setBooksReading($booksReading) { $this->booksReading = $booksReading ; }
        public function getBooksReading() { return $this->booksReading; } 

        // get and set politicalDonor
        public function setPoliticalDonor($politicalDonor) { $this->politicalDonor = $politicalDonor ; }
        public function getPoliticalDonor() { return $this->politicalDonor; } 

        // get and set hobbiesAndCrafts
        public function setHobbiesAndCrafts($hobbiesAndCrafts) { $this->hobbiesAndCrafts = $hobbiesAndCrafts ; }
        public function getHobbiesAndCrafts() { return $this->hobbiesAndCrafts; } 

        // get and set cosmetics
        public function setCosmetics($cosmetics) { $this->cosmetics = $cosmetics ; }
        public function getCosmetics() { return $this->cosmetics; } 

        // get and set charitableDonations
        public function setCharitableDonations($charitableDonations) { $this->charitableDonations = $charitableDonations ; }
        public function getCharitableDonations() { return $this->charitableDonations; } 

        // get and set artsAntiques
        public function setArtsAntiques($artsAntiques) { $this->artsAntiques = $artsAntiques ; }
        public function getArtsAntiques() { return $this->artsAntiques; } 

        // get and set petOwner
        public function setPetOwner($petOwner) { $this->petOwner = $petOwner ; }
        public function getPetOwner() { return $this->petOwner; } 

        // get and set cooking
        public function setCooking($cooking) { $this->cooking = $cooking ; }
        public function getCooking() { return $this->cooking; } 

        // get and set autoparts
        public function setAutoparts($autoparts) { $this->autoparts = $autoparts ; }
        public function getAutoparts() { return $this->autoparts; } 

        // get and set healthBeautyWellness
        public function setHealthBeautyWellness($healthBeautyWellness) { $this->healthBeautyWellness = $healthBeautyWellness ; }
        public function getHealthBeautyWellness() { return $this->healthBeautyWellness; } 

        // get and set parentingAndChildrensProducts
        public function setParentingAndChildrensProducts($parentingAndChildrensProducts) { $this->parentingAndChildrensProducts = $parentingAndChildrensProducts ; }
        public function getParentingAndChildrensProducts() { return $this->parentingAndChildrensProducts; } 

        // get and set music
        public function setMusic($music) { $this->music = $music ; }
        public function getMusic() { return $this->music; } 

        // get and set movie
        public function setMovie($movie) { $this->movie = $movie ; }
        public function getMovie() { return $this->movie; } 

        // get and set selfImprovement
        public function setSelfImprovement($selfImprovement) { $this->selfImprovement = $selfImprovement ; }
        public function getSelfImprovement() { return $this->selfImprovement; } 

        // get and set healthBeautyWellness
        public function setWomensApparel($womensApparel) { $this->womensApparel = $womensApparel ; }
        public function getWomensApparel() { return $this->womensApparel; } 

        // get and set singleParent
        public function setSingleParent($singleParent) { $this->singleParent = $singleParent ; }
        public function getSingleParent() { return $this->singleParent; } 

        // get and set seniorAdultInHousehold
        public function setSeniorAdultInHousehold($seniorAdultInHousehold) { $this->seniorAdultInHousehold = $seniorAdultInHousehold ; }
        public function getSeniorAdultInHousehold() { return $this->seniorAdultInHousehold; } 
        
        // get and set youngAdultInHousehold
        public function setYoungAdultInHousehold($youngAdultInHousehold) { $this->youngAdultInHousehold = $youngAdultInHousehold ; }
        public function getYoungAdultInHousehold() { return $this->youngAdultInHousehold; } 
        
        // get and set workingWoman
        public function setWorkingWoman($workingWoman) { $this->workingWoman = $workingWoman ; }
        public function getWorkingWoman() { return $this->workingWoman; } 

        // get and set sohoIndicator
        public function setSohoIndicator($sohoIndicator) { $this->sohoIndicator = $sohoIndicator ; }
        public function getSohoIndicator() { return $this->sohoIndicator; } 

        // get and set businessOwner
        public function setBusinessOwner($businessOwner) { $this->businessOwner = $businessOwner ; }
        public function getBusinessOwner() { return $this->businessOwner; } 

        // get and set maritalStatus
        public function setMaritalStatus($maritalStatus) { $this->maritalStatus = $maritalStatus ; }
        public function getMaritalStatus() { return $this->maritalStatus; } 

        // get and set homeOwnerRenter
        public function setHomeOwnerRenter($homeOwnerRenter) { $this->homeOwnerRenter = $homeOwnerRenter ; }
        public function getHomeOwnerRenter() { return $this->homeOwnerRenter; } 

        // get and set occupationalDetail
        public function setOccupationalDetail($occupationalDetail) { $this->occupationalDetail = $occupationalDetail ; }
        public function getOccupationalDetail() { return $this->occupationalDetail; } 

        // get and set socialPresence
        public function setSocialPresence($socialPresence) { $this->socialPresence = $socialPresence ; }
        public function getSocialPresence() { return $this->socialPresence; } 
    }
?>