<?php

namespace App\Filament\Resources\AcademicStudentResource\Pages;

use App\Filament\Resources\AcademicStudentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcademicStudents extends ListRecords
{
    protected static string $resource = AcademicStudentResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
