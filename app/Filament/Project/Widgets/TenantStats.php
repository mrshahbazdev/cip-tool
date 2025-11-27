<?php

namespace App\Filament\Project\Widgets;

use App\Models\Project;
use App\Models\User;
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

        // Members count (pivot relation: project_user)
        $membersCount = User::query()
            ->whereHas('projects', fn ($q) => $q->where('projects.id', $project->id))
            ->count();

        return [
            Stat::make('People in this workspace', $membersCount)
                ->description('Invited & active members')
                ->color('success'),
        ];
    }
}
