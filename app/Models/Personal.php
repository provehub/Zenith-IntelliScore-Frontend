<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'middle_name',
        'username',
        'profile_image',
        'bio',
        'dob',
        'gender',
        'phone',
        'alternate_phone',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'religion',
        'ethnicity',
        'nationality',
        'spoken_languages',
        'marital_status',
        'number_of_children',
        'blood_type',
        'medical_conditions',
        'disabilities',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'bank_name',
        'account_number',
        'crypto_wallet_address',
        'preferred_language',
        'preferred_currency',
        'timezone',
        'notification_preferences',
        'is_verified',
        'terms_accepted_at',
        'privacy_policy_accepted_at',
        'is_blacklisted',
    ];
    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
