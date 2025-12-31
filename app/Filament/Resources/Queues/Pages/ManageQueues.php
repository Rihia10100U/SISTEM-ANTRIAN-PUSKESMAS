<?php

namespace App\Filament\Resources\Queues\Pages;

use App\Filament\Resources\Queues\QueueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageQueues extends ManageRecords
{
    protected static string $resource = QueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
