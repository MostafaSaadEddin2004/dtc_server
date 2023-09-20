<?php

namespace App\Filament\Resources\CourseRegistrationResource\Pages;

use App\Filament\Resources\CourseRegistrationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCourseRegistration extends ViewRecord
{
    protected static string $resource = CourseRegistrationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
