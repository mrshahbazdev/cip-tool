<?php

namespace App\Filament\Project\Widgets;

use App\Models\Idea;
use App\Models\Team;
use App\Models\User;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Request;
use App\Models\Project;

class TenantStats extends StatsOverviewWidget
{

    protected function getStats(): array
    {
        // Old:
        // $project = tenant();

        // New: current subdomain se project loa d karo
        $host = request()->getHost(); // work.cip-tools.de
        $parts = explode('.', $host);
        $slug = $parts[0] ?? null;

        $project = Project::where('slug', $slug)->firstOrFail();

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
            // Stat::make(...) jaise pehle likhe the, woh yahan hi rehne do
        ];
    }

}
