<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nation extends Model
{
    protected $fillable = [
        'name', 'slug', 'name_abbr', 'ea_id', 'img', 'img_small', 'img_medium',
        'img_large'
    ];

    public function leagues()
    {
        return $this->hasMany('App\Models\League');
    }
}
