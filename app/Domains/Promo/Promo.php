<?php

namespace App\Domains\Promo;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'title','image_url','link_url','section','ends_at','is_active','position'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'ends_at' => 'datetime',
    ];
}


