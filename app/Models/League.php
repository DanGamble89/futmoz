<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $fillable = [
        'name', 'slug', 'name_abbr', 'ea_id', 'img', 'img_dark_small',
        'img_dark_medium', 'img_dark_large', 'img_light_small',
        'img_light_medium', 'img_light_large'
    ];
}
