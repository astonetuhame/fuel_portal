<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function loadings()
    {
        return $this->hasMany(Loading::class);
    }

    public function routes()
    {
        return $this->belongsToMany(Route::class);
    }


}
