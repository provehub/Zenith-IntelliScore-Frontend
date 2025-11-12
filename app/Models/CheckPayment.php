<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckPayment extends Model
{
    protected $fillable = ['body','status','payment_id','payment_type','charge','transaction_ref','others',
];
}
