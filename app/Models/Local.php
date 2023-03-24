<?php

namespace App\Models;

use App\Models\Truck;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Local extends Model
{
    use HasFactory;
    public $guarded = [];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function distances()
    {
        return $this->belongsToMany(Distance::class);
    }
}
