<?php

namespace App\Filament\Pages;

use App\Models\Service;
use App\Services\QueueService;
use App\Services\ThermalPrinterService;
use Filament\Pages\Page;

class QueueKiosk extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-printer';

    protected static string $view = 'filament.pages.queue-kiosk';

    protected static string $layout = 'filament.layouts.base-kiosk';

    protected static ?string $navigationLabel = 'Kiosk Cetak Antrian';

    protected ThermalPrinterService $thermalPrinterService;

    protected QueueService $queueService;

    public function __construct()
    {
        $this->thermalPrinterService = app(ThermalPrinterService::class);

        $this->queueService = app(QueueService::class);
    }

    public function getViewData(): array
    {
        return [
            'services' => Service::where('is_active', true)->get()
        ];
    }

    public function print($serviceId)
    {
        $newQueue = $this->queueService->addQueue($serviceId);

        $text = $this->thermalPrinterService->createText([
            ['text' => 'Puskesmas Natuna', 'align' => 'center'],
            ['text' => 'Jalan Kebenaran No. 123', 'align' => 'center'],
            ['text' => '-----------------', 'align' => 'center'],
            ['text' => 'NOMOR ANTRIAN', 'align' => 'center'],
            ['text' => $newQueue->number, 'align' => 'center', 'style' => 'double'],
            ['text' => $newQueue->created_at->format('d-m-Y H:i'), 'align' => 'center'],
            ['type' => 'qrcode', 'data' => route('queue.status', ['id' => generate_id($newQueue->id)]), 'size' => 4, 'align' => 'center'],
            ['text' => '-----------------', 'align' => 'center'],
            ['text' => 'Silakan scan QR Code', 'align' => 'center'],
            ['text' => 'di atas untuk melihat', 'align' => 'center'],
            ['text' => 'status antrian Anda', 'align' => 'center'],
            ['text' => '-----------------', 'align' => 'center'],
            ['text' => 'Terima kasih', 'align' => 'center']
        ]);

        $this->dispatch("print-start", $text);
    }
}
