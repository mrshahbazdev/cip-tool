<?php

namespace App\Filament\Project\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public static function getNavigationLabel(): string
    {
        return 'Overview';
    }

    // Yahan se "static" hata do
    public function getWidgets(): array
    {
        return [
            \App\Filament\Project\Widgets\TenantStats::class,
            // ...baad me aur widgets
        ];
    }

    public function getColumns(): int|array
    {
        return [
            'md' => 4,
            'xl' => 6,
        ];
    }
}
