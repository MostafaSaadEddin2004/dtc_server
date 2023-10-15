<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Reworck\FilamentSettings\FilamentSettings::setFormFields([
            \Filament\Forms\Components\DatePicker::make('registration_start_at')
                ->label('Academic Registration Start At'),
            \Filament\Forms\Components\DatePicker::make('registration_end_at')
                ->label('Academic Registration End At'),
            \Filament\Forms\Components\DatePicker::make('interview_at')
                ->label('Interview At'),
        ]);
        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament.css');
        });
    }
}
