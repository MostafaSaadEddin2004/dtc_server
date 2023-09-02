<?php

namespace App\Filament\Resources\CertificateTypeResource\Pages;

use App\Filament\Resources\CertificateTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCertificateType extends EditRecord
{
    protected static string $resource = CertificateTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
