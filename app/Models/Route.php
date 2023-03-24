<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function trucks()
    {
        return $this->belongsToMany(Truck::class);
    }

    public function loadings()
    {
        return $this->hasMany(Loading::class);
    }


}
