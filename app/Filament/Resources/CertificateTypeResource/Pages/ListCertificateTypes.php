<?php

namespace App\Filament\Resources\CertificateTypeResource\Pages;

use App\Filament\Resources\CertificateTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCertificateTypes extends ListRecords
{
    protected static string $resource = CertificateTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
