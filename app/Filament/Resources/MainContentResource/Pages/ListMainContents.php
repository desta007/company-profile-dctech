<?php

namespace App\Filament\Resources\MainContentResource\Pages;

use App\Filament\Resources\MainContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMainContents extends ListRecords
{
    protected static string $resource = MainContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
