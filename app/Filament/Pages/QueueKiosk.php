<?php

namespace App\Filament\Pages;

use App\Models\Service;
use App\Services\QueueService;
use App\Services\ThermalPrinterService;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

class QueueKiosk extends Page
{
    protected static BackedEnum|string|null $navigationIcon =
        Heroicon::OutlinedBriefcase;

    protected static ?string $navigationLabel = 'Kiosk Cetak Antrian';

    // Filament v3 → view NON-static
    protected string $view = 'filament.pages.queue-kiosk';

    protected QueueService $queueService;
    protected ThermalPrinterService $thermalPrinterService;

    /**
     * Filament v3 → layout WAJIB lewat method
     */
    public function getLayout(): string
    {
        return 'filament.layouts.base-kiosk';
    }

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public function mount(): void
    {
        $this->queueService = app(QueueService::class);
        $this->thermalPrinterService = app(ThermalPrinterService::class);
    }

    protected function getViewData(): array
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        return [
            'services' => Service::where('is_active', true)->get(),
        ];
    }

    public function print(int $serviceId): void
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $queue = $this->queueService->addQueue($serviceId);

        $time = $queue->created_at
            ->setTimezone('Asia/Jakarta')
            ->format('d-m-Y H:i');

        $text = $this->thermalPrinterService->createText([
            ['text' => 'Puskesmas Tinewati', 'align' => 'center'],
            ['text' => 'Jl. Garut–Tasikmalaya No 82', 'align' => 'center'],
            ['text' => '-----------------', 'align' => 'center'],
            ['text' => 'NOMOR ANTRIAN', 'align' => 'center'],
            ['text' => $queue->number, 'align' => 'center', 'style' => 'double'],
            ['text' => $time, 'align' => 'center'],
            ['text' => '-----------------', 'align' => 'center'],
            ['text' => $queue->service->name, 'align' => 'center'],
            ['text' => '-----------------', 'align' => 'center'],
            ['text' => 'Silakan menunggu di ruang tunggu', 'align' => 'center'],
            ['text' => 'Terima kasih', 'align' => 'center'],
        ]);

        $this->dispatch('print-start', $text);
    }
}
