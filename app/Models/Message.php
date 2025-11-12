<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\{MessageImage,Call};

class Message extends Model
{
    use HasFactory; 

    protected $fillable = ['body', 'user_id','chat_id','read_at'];

    protected $appends = ['time'];
    public function getTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    
    public function images(): HasMany
    {
        return $this->hasMany(MessageImage::class);
    }

    public function calls(): HasMany
    {
        return $this->hasMany(Call::class);
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
    
}
