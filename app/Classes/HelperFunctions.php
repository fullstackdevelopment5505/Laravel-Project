<?php 
    namespace App\Classes;
    use DB; 

    // helperfunctions class 
    class HelperFunctions {
        // appendData function 
        // adds data to database 
        public function appendData($column, $appendedData, $id, $table_name) {
            // for loop to insert variable amount of columns 
            for ($i = 0; $i < count($column); $i++) {
                DB::table($table_name)->where('id', $id)->update([$column[$i] => $appendedData[$i]]);
            }
        }

        // updateFlag
        // updates the flag that tells how many time row has been searched 
        public function updateFlag($flagType, $table_name, $id) {
            DB::table($table_name)->where('id', $id)->update([$flagType => 1]);
        }

        // requestSql function 
        // make database connection and return the result at the specified ID 
        public function requestSql($table_name, $column, $id) {
            $results_obj = DB::table($table_name)->find($id); // mysql query
            $query_result = $results_obj->$column; // query_result is an std class object 
            return $query_result; // return result 
        }
    }
?>