<?php

namespace App\Filament\Resources\AcademicRegistrationResource\Pages;

use App\Filament\Resources\AcademicRegistrationResource;
use Filament\Pages\Actions;
use Spatie\Valuestore\Valuestore;
use Filament\Resources\Pages\ViewRecord;

class ViewAcademicRegistration extends ViewRecord
{
    protected static string $resource = AcademicRegistrationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make()
                ->hidden(function () {
                    $valueStore = ValueStore::make(config('filament-settings.path'));
                    return    $valueStore->get('registration_start_at') >= now() || $valueStore->get('registration_end_at') <= now();
                }),
        ];
    }
}