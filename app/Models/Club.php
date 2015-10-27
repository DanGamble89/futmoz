<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $fillable = [
        'name', 'slug', 'name_abbr', 'ea_id', 'img',
    ];
}
