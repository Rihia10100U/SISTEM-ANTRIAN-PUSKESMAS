<?php

namespace App\Filament\Pages;

use App\Models\Counter;
use App\Models\Queue;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class DashboardKiosk extends Page
{
    protected static BackedEnum|string|null $navigationIcon =
        Heroicon::OutlinedTableCells;

    protected static ?string $navigationLabel = 'Kiosk Ruang Tunggu';

    // Filament v3 → NON-static
    protected string $view = 'filament.pages.dashboard-kiosk';

    // Filament v3 → HARUS public
    public function getLayout(): string
    {
        return 'filament.layouts.base-kiosk';
    }

    protected function getViewData(): array
    {
        return [
            'counters' => Counter::with(['service', 'activeQueue'])->get(),
        ];
    }

    public function callNextQueue(): void
    {
       $nextQueues = Queue::where('status', 'waiting')
       ->whereDate('created_at', now()->format('Y-m-d'))
       ->whereNull('called_at')
       ->get();

       foreach ($nextQueues as $nextQueue)
       {
            if (!$nextQueue->counter) continue;

            $this->dispatch("queue-called", "Nomor Antrian " . $nextQueue->number . " segera ke " . $nextQueue->counter->name);

        foreach ($queues as $queue) {
            if (! $queue->counter) {
                continue;
            }

            $this->dispatch(
                'queue-called',
                message:
                    'Nomor Antrian ' . $queue->number .
                    ' segera ke ' . $queue->counter->name
            );

            $queue->update([
                'called_at' => now(),
            ]);
        }
    }
}
}