<?php

namespace App\Filament\Resources\EditMarkResource\Pages;

use App\Filament\Resources\EditMarkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEditMarks extends ListRecords
{
    protected static string $resource = EditMarkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
