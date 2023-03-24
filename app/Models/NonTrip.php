<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonTrip extends Model
{
    use HasFactory;

    protected $protected = [];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }

    public function lpos()
    {
        return $this->belongsToMany(Lpo::class)->withPivot('date');
    }
}
