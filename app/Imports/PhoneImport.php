<?php

namespace App\Imports;

use App\Models\SmsContact;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PhoneImport implements WithHeadingRow, ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        if (!isset($row['notelp'])) {
            return null;
        }
    
        return new SmsContact([
            'phone' => $row['notelp'],
            'name' => $row['name'],
        ]);
    }
}
