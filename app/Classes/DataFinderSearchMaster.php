<?php
    namespace App\Classes;

    // DataFinderSearchMaster
    class DataFinderSearchMaster {
        // declare variables 
        public $address;
        public $city;
        public $state;
        public $houseNo;
        public $street; 
        public $searchTypeFlag;
        public $enteredDate; 

        // get and set address
        public function setAddress($address) { $this->address = $address; }
        public function getAddress() { return $this->address; }

        // get and set city
        public function setCity($city) { $this->city = $city; }
        public function getCity() { return $this->city; }

        // get and set state
        public function setState($state) { $this->state = $state; }
        public function getState() { return $this->state; }

        // get and set houseNo
        public function setHouseNo($houseNo) { $this->houseNo = $houseNo; }
        public function getHouseNo() { return $this->houseNo; }

        // get and set street
        public function setStreet($street) { $this->street = $street; }
        public function getStreet() { return $this->street; }

        // get and set searchTypeFlag
        public function setSearchTypeFlag($searchTypeFlag) { $this->searchTypeFlag = $searchTypeFlag; }
        public function getSearchTypeFlag() { return $this->searchTypeFlag; }

        // get and set enteredDate 
        public function setEnteredDate($enteredDate) { $this->enteredDate = $enteredDate; }
        public function getEnteredDate() { return $this->enteredDate; }

    }
?>