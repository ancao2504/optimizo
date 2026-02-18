<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Language extends Model
{
    protected $fillable = [
        'code',
        'name',
        'native_name',
        'flag_icon',
        'flag_code',
        'is_active',
        'is_default',
        'direction',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'order' => 'integer',
    ];



    /**
     * Scope to get only active languages
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get default language
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Get the default language
     */
    public static function getDefault(): ?Language
    {
        return static::default()->first() ?? static::where('code', 'en')->first();
    }

    /**
     * Get language by code
     */
    public static function getByCode(string $code): ?Language
    {
        return static::where('code', $code)->first();
    }
}
