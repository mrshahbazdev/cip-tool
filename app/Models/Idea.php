<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Idea extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'team_name',
        'pain_score',
        'cost',
        'duration',
        'status',
        'created_by',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
