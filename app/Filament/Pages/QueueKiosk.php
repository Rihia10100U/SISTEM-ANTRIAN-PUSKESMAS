<?php

namespace App\Filament\Pages;

use App\Models\Service;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use UnitEnum;

class QueueKiosk extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected string $view = 'filament.pages.queue-kiosk';

    protected static string $layout = 'filament.layouts.base-kiosk';

    public function getViewData(): array
    {
        return [
            'services' => Service::where('is_active', true)->get(), // Data tambahan untuk tampilan dapat ditambahkan di sini
        ];
    }
}
