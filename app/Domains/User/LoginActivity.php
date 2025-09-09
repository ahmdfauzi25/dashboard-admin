<?php

namespace App\Domains\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginActivity extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'event',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Domains\User\Models\User::class);
    }
}


