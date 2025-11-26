<?php

namespace App\Providers\Filament;

use App\Models\Project;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Project\Pages\RegisterProject;

class ProjectPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('project')
            ->path('/') // subdomain pe root path [web:194]
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Project/Resources'), for: 'App\Filament\Project\Resources')
            ->discoverPages(in: app_path('Filament/Project/Pages'), for: 'App\Filament\Project\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Project/Widgets'), for: 'App\Filament\Project\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->tenant(
                Project::class,
                slugAttribute: 'slug', // projects.slug se tenant resolve hoga [web:211]
            )
            ->tenantDomain('{tenant:slug}.cip-tools.de') // work.cip-tools.de → slug=work [web:211][web:176]
            ->tenantRegistration(RegisterProject::class)
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                'project.tenant.exists',
            ])
            ->authMiddleware([

            ]);
    }
}
