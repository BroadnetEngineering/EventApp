<?php

namespace App\Models;

use App\Traits\Date;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'start_date', 'start_time', 'duration', 'timezone'
    ];

    protected $dates = [
        'start_date',
        'created_at',
        'updated_at'
    ];
}
