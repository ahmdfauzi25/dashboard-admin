<?php

namespace App\Domains\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	use HasFactory;

	protected $fillable = [
		'title',
		'description',
		'price',
		'is_active',
	];
}


