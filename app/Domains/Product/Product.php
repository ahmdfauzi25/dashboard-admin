<?php

namespace App\Domains\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'image_url',
		'price',
		'is_active',
	];

	protected $casts = [
		'is_active' => 'boolean',
		'price' => 'integer',
	];
}


