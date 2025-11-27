<?php

namespace App\Filament\Project\Widgets;

use App\Models\Project;
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

        $project = Project::where('slug', $slug)->first();

        if (! $project) {
            return [
                Stat::make('Workspace', 'Not found')
                    ->description('Check project slug / subdomain')
                    ->color('danger'),
            ];
        }

        return [
            Stat::make('Workspace', $project->name)
                ->description("Slug: {$project->slug}")
                ->color('success'),
        ];
    }
}
