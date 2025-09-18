<?php

namespace App\Domains\JualAccount;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JualAccount extends Model
{
	use HasFactory;

	protected $table = 'jual_accounts';

	protected $fillable = [
		'title',
		'description',
		'price',
		'is_active',
	];
}


