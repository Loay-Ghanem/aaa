<?php

namespace App\Filament\Resources\EmpolyeeResource\Pages;

use Filament\Actions;
use Illuminate\Http\Client\Request;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EmpolyeeResource;

class EditEmpolyee extends EditRecord
{
    protected static string $resource = EmpolyeeResource::class;

    protected function getHeaderActions(): array
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
