<?php

namespace App\Filament\Resources\MoveResource\Pages;

use App\Filament\Resources\MoveResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMove extends EditRecord
{
    protected static string $resource = MoveResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
