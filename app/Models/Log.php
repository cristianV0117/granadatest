<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'username',
        'request_timestamp',
        'num_countries_returned',
        'countries_details',
    ];
}
