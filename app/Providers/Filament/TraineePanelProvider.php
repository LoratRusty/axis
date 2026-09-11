<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class TraineePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('trainee')
            ->path('mi-programa')
            ->login()
            ->brandName('AXIS - Mi Programa')
            ->brandLogo(asset('images/logo.png'))
            ->brandLogoHeight('2.5rem')
            ->colors([
                'primary' => Color::hex('#1B2F6E'),
            ])
            ->discoverResources(in: app_path('Filament/Trainee/Resources'), for: 'App\Filament\Trainee\Resources')
            ->discoverPages(in: app_path('Filament/Trainee/Pages'), for: 'App\Filament\Trainee\Pages')
            ->pages([
                Dashboard::class,
                \App\Filament\Trainee\Pages\Expediente::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Trainee/Widgets'), for: 'App\Filament\Trainee\Widgets')
            ->widgets([
                //AccountWidget::class,
            ])
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
