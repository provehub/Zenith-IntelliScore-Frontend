<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'account_name','account_no','period',
        'credit_trust_score','risk_band','pd_90d',
        'meta','features','score','project_id'
    ];

    protected $casts = [
        'meta'     => 'array',
        'features' => 'array',
        'score'    => 'array',
    ];
}
