<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'transaction_id',
        'gateway',
        'description',
        'currency',
        'gateway_txn',
];

    protected $casts = [
        'amount' => 'float',
    ];

    protected $appends = ['created_at_formatted','amount_formatted'];

    public function getAmountFormattedAttribute()
    {
        // retun number format with 2 decimal point
        return number_format($this->amount, 2);
    }


    public function getCreatedAtFormattedAttribute()
    {
        // Return date with day, month, year, and time. Example: "Wednesday, 15 December 2021 14:30:00"
        return $this->created_at->format('l, d F Y H:i:s');
    }

}
