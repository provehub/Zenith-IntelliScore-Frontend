<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balance extends Model
{
    // Prevent mass assignment of the 'amount' field by default:
    protected $guarded = ['id'];

    // Cast to decimal
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * INTERNAL: add funds (only via service / event)
     */
    public function deposit(float $value): void
    {
        $this->increment('amount', $value);
    }

    /**
     * INTERNAL: subtract funds (only via service / event)
     */
    public function withdraw(float $value): void
    {
        if ($value > $this->amount) {
            throw new \RuntimeException('Insufficient balance.');
        }
        $this->decrement('amount', $value);
    }
}
