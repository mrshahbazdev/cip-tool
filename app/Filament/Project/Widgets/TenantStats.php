<?php

namespace App\Filament\Project\Widgets;

use App\Models\Idea;
use App\Models\Team;
use App\Models\User;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TenantStats extends StatsOverviewWidget
{

    protected function getStats(): array
    {
        $project = tenant(); // ya jo bhi tumhara current tenant helper hai

        $teamsCount = Team::query()
            ->where('project_id', $project->id)
            ->count();

        $membersCount = User::query()
            ->whereHas('projects', fn ($q) => $q->where('projects.id', $project->id))
            ->count();

        $ideasCount = Idea::query()
            ->where('project_id', $project->id)
            ->where('status', '!=', 'done')
            ->count();

        $ideasToday = Idea::query()
            ->where('project_id', $project->id)
            ->whereDate('created_at', today())
            ->count();

        return [
            Stat::make('Active teams', $teamsCount)
                ->description('Teams using this workspace')
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
