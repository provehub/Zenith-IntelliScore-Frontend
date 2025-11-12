<?php

namespace App\Models;

use App\Models\{User};
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
     use HasFactory;

    protected $fillable = ['name', 'description',
     'document', 
     'phone', 
     'profile_image', 
     'cover', 
     'agent_type', 
     'cacdoc', 
     'addressdoc', 
     'addressproof', 
     'company_role', 
     'otherdoc', 
     'company_role', 
     'website', 
     'offical_email', 
     'experience', 
     'selfie', 
     'plan', 
     'featured', 
     'slug', 
     'seo', 
     'extras', 
     'verif', 
     'isonline', 
     'status', 
     'user_id', 
     'identity'];

    protected $guarded = [];

    protected $appends = ['img','labels','social'];

    public function getLabelsAttribute()
    {
        return 'agents';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getImgAttribute()
    {
        return asset("storage/vendor/profile/{$this->profile_image}");
    }

    public function getSocialAttribute()
    {
        // Decode the 'seo' JSON column, return as array or empty array if null
        return json_decode($this->seo, true) ?? [
            'facebook'  => '',
            'instagram' => '',
            'tiktok'    => '',
            'youtube'   => '',
            'x'         => '',
            'linkedin'  => '',
        ];
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $newSlug = Str::slug($value);
        $existingSlug = $this->getAttribute('slug');

        if (empty($this->attributes['slug'])) {
        // Check for uniqueness only if the new slug is different from the existing one
        if ($existingSlug !== $newSlug) {
            $count = static::where('slug', 'like', "{$newSlug}%")->count();

            if ($count > 0) {
                $newSlug .= '-' . ($count + 1);
            }
            $this->attributes['slug'] = $newSlug;
        }
    }
    }

      /**
     * The attribute to use for route model binding.
     *
     * @var string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
