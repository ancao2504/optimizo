<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'plan_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin.
     */
    public function getIsAdminAttribute(): bool
    {
        // Check via role model
        if ($this->roleModel) {
            return in_array($this->roleModel->slug, ['admin', 'super_admin']);
        }

        return false;
    }

    /**
     * Scope a query to only include admin users.
     */
    public function scopeAdmins($query)
    {
        return $query->whereHas('roleModel', function ($q) {
            $q->whereIn('slug', ['admin', 'super_admin']);
        });
    }

    /**
     * Get the role model for this user.
     */
    public function roleModel()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the plan for this user.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Check if user has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        // Check if user has a role model
        if (!$this->roleModel) {
            return false;
        }

        // Super admin has all permissions
        if ($this->roleModel->slug === 'super_admin') {
            return true;
        }

        // Check via role model
        return $this->roleModel->hasPermission($permission);
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->roleModel?->slug === $role;
    }

    /**
     * Check if user can access a specific tool based on their plan.
     */
    public function canAccessTool(string $toolSlug): bool
    {
        // If no plan assigned, allow access (backward compatibility)
        if (!$this->plan) {
            return true;
        }

        return $this->plan->canAccessTool($toolSlug);
    }

    /**
     * Get the tool limit for a specific tool.
     */
    public function getToolLimit(string $toolSlug): ?int
    {
        if (!$this->plan) {
            return null; // No limit
        }

        return $this->plan->getToolLimit($toolSlug);
    }
}
