<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XAccount extends Model
{
    protected $table = 'x_accounts';

    protected $fillable = [
        'user_id','project_id','status',
        'access_token','access_token_secret',
        'consumer_key','consumer_secret','bearer_token',
    ];

    // Auto-encrypt in DB, auto-decrypt when you read
    protected $casts = [
        'access_token'        => 'encrypted',
        'access_token_secret' => 'encrypted',
        'consumer_key'        => 'encrypted',
        'consumer_secret'     => 'encrypted',
        'bearer_token'        => 'encrypted',
    ];

    // Never leak in API responses/logs
    protected $hidden = [
        'access_token','access_token_secret','consumer_key','consumer_secret','bearer_token',
    ];
}
