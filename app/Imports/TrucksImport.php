<?php

namespace App\Imports;

use App\Models\Truck;
use Maatwebsite\Excel\Concerns\ToModel;

class TrucksImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Truck([
            'truck_no' => $row[0],
            'type' => $row[1],
        ]);
    }
}
