<?php

namespace App\Filament\Resources\CertificateTypeResource\Pages;

use App\Filament\Resources\CertificateTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCertificateType extends CreateRecord
{
    protected static string $resource = CertificateTypeResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
