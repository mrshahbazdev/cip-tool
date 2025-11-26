<?php

namespace App\Models;

use BackedEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Concerns\HasTenants;
use Filament\Models\Contracts\HasTenants as HasTenantsContract;


class User extends Authenticatable implements FilamentUser
{
    use  HasFactory, Notifiable;

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
        // Abhi simple rule: sirf is_admin users Filament panels access kar sakte hain
        return $this->is_admin === true;
    }

    // Optional, agar kahin purana code isko use kar raha ho:
    public function canAccessFilament(): bool
    {
        return $this->is_admin === true;
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    // Projects jahan ye OWNER hai (owner_id)
    public function ownedProjects()
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    // Projects jahan ye MEMBER hai (pivot project_user)
    public function memberProjects()
    {
        return $this->belongsToMany(Project::class, 'project_user')
            ->withPivot('role')
            ->withTimestamps();
    }
}
