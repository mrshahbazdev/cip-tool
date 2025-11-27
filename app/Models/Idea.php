<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
