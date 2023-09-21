<?php

namespace App\Filament\Resources\AcademicRegistrationResource\Pages;

use App\Filament\Resources\AcademicRegistrationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcademicRegistration extends EditRecord
{
    protected static string $resource = AcademicRegistrationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
