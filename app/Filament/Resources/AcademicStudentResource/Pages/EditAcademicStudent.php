<?php

namespace App\Filament\Resources\AcademicStudentResource\Pages;

use App\Filament\Resources\AcademicStudentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcademicStudent extends EditRecord
{
    protected static string $resource = AcademicStudentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
