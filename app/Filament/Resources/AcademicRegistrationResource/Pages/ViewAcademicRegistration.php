<?php

namespace App\Filament\Resources\AcademicRegistrationResource\Pages;

use App\Filament\Resources\AcademicRegistrationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAcademicRegistration extends ViewRecord
{
    protected static string $resource = AcademicRegistrationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
