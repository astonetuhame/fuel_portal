<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    use HasFactory;

    public $guarded = [];

    public function local()
    {
         return $this->belongsTo(Local::class);
    }
    public function locals()
    {
         return $this->belongsToMany(Local::class);
    }

}
