<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogCategory extends Model
{
    protected $fillable = ['name', 'slug', 'meta_title', 'meta_description', 'content', 'parent_id', 'language_code'];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'blog_category_post');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(BlogCategory::class, 'parent_id');
    }

    public function scopeLanguage($query, $locale = null)
    {
        return $query->where('language_code', $locale ?: app()->getLocale());
    }
}
