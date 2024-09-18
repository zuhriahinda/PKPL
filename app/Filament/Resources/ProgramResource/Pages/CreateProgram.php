<?php

namespace App\Filament\Resources\ProgramResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProgramResource;

class CreateProgram extends CreateRecord
{
    protected static string $resource = ProgramResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status_id'] = 1;
    
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
