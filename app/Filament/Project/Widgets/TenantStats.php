<?php

namespace App\Filament\Project\Widgets;

use App\Models\Idea;
use App\Models\Team;
use App\Models\User;
use App\Models\Project;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TenantStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Current subdomain se project (tenant) load karo, e.g. work.cip-tools.de
        $host = request()->getHost();
        $parts = explode('.', $host);
        $slug = $parts[0] ?? null;

        $project = Project::where('slug', $slug)->firstOrFail();

        // Teams count (agar Team model project_id use karta hai)
        $teamsCount = Team::query()
            ->where('project_id', $project->id)
            ->count();

        // Members count (pivot relation: project_user)
        $membersCount = User::query()
            ->whereHas('projects', fn ($q) => $q->where('projects.id', $project->id))
            ->count();

        // Open ideas in pipeline
        $ideasCount = Idea::query()
            ->where('project_id', $project->id)
            ->where('status', '!=', 'done')
            ->count();

        // Ideas created today
        $ideasToday = Idea::query()
            ->where('project_id', $project->id)
            ->whereDate('created_at', today())
            ->count();

        return [
            Stat::make('Active teams', $teamsCount)
                ->description('Teams in this workspace')
                ->color('info'),

            Stat::make('People in this workspace', $membersCount)
                ->description('Invited & active members')
                ->color('success'),

            Stat::make('Ideas in pipeline', $ideasCount)
                ->description('Open across all teams')
                ->color('warning'),

            Stat::make('New ideas today', $ideasToday)
                ->description('Created in the last 24 hours')
                ->color(Color::Amber),
        ];
    }
}
