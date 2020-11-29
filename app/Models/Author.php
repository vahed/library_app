<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Author extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['dob']; //instances of dates cast to Carbon date

    public function setDobAttribute($dob)
    {
        $this->attributes['dob'] = Carbon::parse($dob);
    }
}
