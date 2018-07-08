<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'name', 'rate'
    ];
}
