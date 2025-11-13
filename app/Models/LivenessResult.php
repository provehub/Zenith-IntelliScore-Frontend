<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LivenessResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'extras',
        'project_id',
        'age',
        'gender',
        'steps',
        'snapshots',
    ];

    protected $casts = [
        'steps' => 'array',
        'snapshots' => 'array',
    ];
}
