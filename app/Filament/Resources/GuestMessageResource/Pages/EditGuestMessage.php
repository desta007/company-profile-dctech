<?php

namespace App\Filament\Resources\GuestMessageResource\Pages;

use App\Filament\Resources\GuestMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuestMessage extends EditRecord
{
    protected static string $resource = GuestMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
