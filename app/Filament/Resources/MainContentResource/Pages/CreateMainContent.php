<?php

namespace App\Filament\Resources\MainContentResource\Pages;

use App\Filament\Resources\MainContentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMainContent extends CreateRecord
{
    protected static string $resource = MainContentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
