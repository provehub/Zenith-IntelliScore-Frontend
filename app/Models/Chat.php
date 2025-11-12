<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{User,Message,Listing,Call};
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['archive_user1_id', 'archive_user2_id', 'owner', 'owner_type', 'user1_id', 'user2_id','listing_id'];

 

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    public function calls(): HasMany
    {
        return $this->hasMany(Call::class, 'chat_id')->latest('created_at');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_id')->latest('created_at');
    }

    public function messagesmobile(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_id');
    }
    public function oldestMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_id')->oldest('created_at');
    }
}
