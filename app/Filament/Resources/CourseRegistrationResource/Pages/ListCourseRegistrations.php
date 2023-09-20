<?php

namespace App\Filament\Resources\CourseRegistrationResource\Pages;

use App\Filament\Resources\CourseRegistrationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourseRegistrations extends ListRecords
{
    protected static string $resource = CourseRegistrationResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
