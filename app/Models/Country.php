<?php

namespace App\Models;

use App\Models\{State,City};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    // public function market(): BelongsTo
    // {
    //     return $this->belongsTo(Country::class,'country_id');
    // }

    // public function country(): HasOne
    // {
    //     return $this->hasOne(Market::class);
    // }

}
