<?php

namespace App\Imports;

use App\Model\Company;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportUsers implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        // foreach ($row[0] as $key => $value) {
        //     dd($value);
        // }
        // return new Company([
        //     'company_name'     => $row[0]
        // ]);
    }
}
