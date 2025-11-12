<?php

namespace App\Models;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'user_id'
    ];

    protected $casts = [
        'seo' => 'array',
    ];

    protected $appends = ['img','labels'];

    public function getLabelsAttribute()
    {
        return 'categories';
    }

    public function getImgAttribute()
    {
        return asset("storage/categories/{$this->image}");
    }

    public function subcategory(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }
}
