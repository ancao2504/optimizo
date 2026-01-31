<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'features',
        'tool_limits',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'tool_limits' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Get the users with this plan.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if plan allows access to a specific tool.
     */
    public function canAccessTool(string $toolSlug): bool
    {
        $limits = $this->tool_limits ?? [];

        // If no limit is set for this tool, allow access
        if (!isset($limits[$toolSlug])) {
            return true;
        }

        // Check if limit is greater than 0 (or -1 for unlimited)
        return $limits[$toolSlug] === -1 || $limits[$toolSlug] > 0;
    }

    /**
     * Get the limit for a specific tool.
     */
    public function getToolLimit(string $toolSlug): ?int
    {
        $limits = $this->tool_limits ?? [];
        return $limits[$toolSlug] ?? null;
    }
}
