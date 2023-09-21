<?php

namespace App\Filament\Resources\AcademicRegistrationResource\Pages;

use App\Filament\Resources\AcademicRegistrationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcademicRegistrations extends ListRecords
{
    protected static string $resource = AcademicRegistrationResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
