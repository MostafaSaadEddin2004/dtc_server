<?php

namespace App\Filament\Resources\AcademicStudentResource\Pages;

use App\Filament\Resources\AcademicStudentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAcademicStudent extends ViewRecord
{
    protected static string $resource = AcademicStudentResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
}
