<?php

namespace App\Filament\Resources\EmpolyeeResource\Pages;

use App\Filament\Resources\EmpolyeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmpolyee extends CreateRecord
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected static string $resource = EmpolyeeResource::class;
}
