<?php
    namespace App\Classes;
    
    // DataFinderSearchMaster Class
    class DataFinderStatusMaster {
        // declare variables
        public $queryId;
        public $numberResults;
        public $executionTime;
        public $enteredDate;

        // get and set queryId
        public function setQueryId($queryId) { $this->queryId = $queryId; }
        public function getQueryId() { return $this->queryId; }

        // get and set numberResults
        public function setNumberResults($numberResults) { $this->numberResults = $numberResults; }
        public function getNumberResults() { return $this->numberResults; }

        // get and set executionTime
        public function setExecutionTime($executionTime) { $this->executionTime = $executionTime; }
        public function getExecutionTime() { return $this->executionTime; }

        // get and set enteredDate 
        public function setEnteredDate($enteredDate) { $this->enteredDate = $enteredDate; }
        public function getEnteredDate() { return $this->enteredDate; }
    }
?>