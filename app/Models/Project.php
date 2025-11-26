<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Project extends Model
{
    //
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'bonus_enabled',
        'bonus_text',
        'logo_path',
        'slogan',
        'trial_ends_at',
        'is_active',
    ];
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withPivot('role')
            ->withTimestamps();
    }

}
