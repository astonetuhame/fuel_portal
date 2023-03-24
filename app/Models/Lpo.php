<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lpo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function loadings()
    {
         return $this->belongsToMany(Loading::class)->withPivot('loading_date');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);

    }

    // protected $casts = [
    //     'date' => 'date:d-m-Y'
    // ];
}
