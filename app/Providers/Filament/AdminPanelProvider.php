<?php

namespace App\Models;

use BackedEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
class User extends Authenticatable implements FilamentUser, HasTenants
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_admin'          => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Filament access
    |--------------------------------------------------------------------------
    */

    public function canAccessPanel(Panel $panel): bool
    {
        // Sirf is_admin users Filament panel access kar sakte hain
        return $this->is_admin === true;
    }

    // Optional backward compatibility:
    public function canAccessFilament(): bool
    {
        return $this->is_admin === true;
    }

    /*
    |--------------------------------------------------------------------------
    | Tenancy (Projects as tenants)
    |--------------------------------------------------------------------------
    */

    // Projects jahan ye MEMBER hai (project_user pivot)
    public function memberProjects()
    {
        return $this->belongsToMany(Project::class, 'project_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Filament: return all tenants (projects) this user can access.
     */
    public function getTenants(Panel $panel): Collection
    {
        // Filament docs pattern: teams() ki jagah memberProjects() [web:211][web:217]
        return $this->memberProjects()->get();
    }

    /**
     * Filament: can the user access a specific tenant?
     */
    public function canAccessTenant(Model $tenant): bool
    {
        // Sirf wahi project jisme user member hai [web:211][web:217]
        return $this->memberProjects()->whereKey($tenant->getKey())->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | Owner relation (super admin owning projects)
    |--------------------------------------------------------------------------
    */

    // Projects jahan ye OWNER hai (owner_id column)
    public function ownedProjects()
    {
        return $this->hasMany(Project::class, 'owner_id');
    }
}
