<?php

namespace App\Filament\Resources\CourseStudentResource\Pages;

use App\Filament\Resources\CourseStudentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseStudent extends EditRecord
{
    protected static string $resource = CourseStudentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
