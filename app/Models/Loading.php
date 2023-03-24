<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loading extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function lpos()
    {
        return $this->belongsToMany(Lpo::class)->withPivot('loading_date');
    }
}
