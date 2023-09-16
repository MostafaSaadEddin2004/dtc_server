<?php

namespace App\Filament\Resources\EditMarkResource\Pages;

use App\Filament\Resources\EditMarkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEditMark extends EditRecord
{
    protected static string $resource = EditMarkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
