<?php

namespace App\Models;

use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MessageImage extends Model
{
    use HasFactory;

    protected $fillable = ['filename'];
    protected $appends = ['img'];

    
    public function messages(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    public function getImgAttribute()
    {
        return asset("storage/messages/{$this->filename}");
    }
}
