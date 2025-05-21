<?php

namespace App\Filament\Resources\GuestMessageResource\Pages;

use App\Filament\Resources\GuestMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGuestMessage extends CreateRecord
{
    protected static string $resource = GuestMessageResource::class;
}
