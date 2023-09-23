<?php

namespace App\Filament\Resources\AcademicRegistrationResource\Pages;

use App\Filament\Resources\AcademicRegistrationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Spatie\Valuestore\Valuestore;

class EditAcademicRegistration extends EditRecord
{
    protected static string $resource = AcademicRegistrationResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $valueStore = ValueStore::make(config('filament-settings.path'));
        if ($valueStore->get('registration_start_at') >= now() || $valueStore->get('registration_end_at') <= now()) {
            redirect()->route('filament.resources.academic-registrations.index');
            return $data;
        }

        return $data;
    }

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }
}
