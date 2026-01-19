<?php

namespace App\Filament\Resources\Counters\Pages;

use App\Filament\Resources\Counters\CounterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCounters extends ManageRecords
{
    protected static string $resource = CounterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
