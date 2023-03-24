<?php

namespace App\Imports;

use App\Models\Route;
use Maatwebsite\Excel\Concerns\ToModel;

class RouteImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Route([
            'route_code' => $row[0],
            'route_name' => $row[1],
            'destination_country' => $row[2],
            'single_diff' => $row[3],
            'double_diff' => $row[4],
        ]);
    }
}
