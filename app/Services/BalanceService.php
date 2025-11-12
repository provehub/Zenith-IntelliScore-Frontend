<?php
namespace App\Services;

use App\Models\{User,Balance};
use Illuminate\Support\Facades\DB;

class BalanceService
{
    /**
     * Credit a user’s balance after verifying payment.
     */
    public function credit(User $user, float $amount): Balance
    {
        return DB::transaction(function () use ($user, $amount) {
            // ensure the user has a balance row
            $balance = Balance::firstOrCreate(
                ['user_id' => $user->id],
                ['amount' => 0]
            );

            $balance->deposit($amount);
            return $balance;
        });
    }
}

