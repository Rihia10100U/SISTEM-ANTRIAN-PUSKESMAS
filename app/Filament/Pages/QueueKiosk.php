<?php

namespace App\Filament\Pages;

use App\Models\Service;
use App\Services\QueueService;
use App\Services\ThermalPrinterService;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth; // Tambahkan impor Auth facade

class QueueKiosk extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static string $view = 'filament.pages.queue-kiosk';
    protected static string $layout = 'filament.layouts.base-kiosk';
    protected static ?string $navigationLabel = 'Kiosk Cetak Antrian';

    protected ThermalPrinterService $thermalPrinterService;
    protected QueueService $queueService;

    // Pindahkan method canView() ke atas setelah deklarasi properti
    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public function __construct()
    {
        $this->thermalPrinterService = app(ThermalPrinterService::class);
        $this->queueService = app(QueueService::class);
    }

    public function getViewData(): array
    {
        // Tambahkan pengecekan akses untuk data juga
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        return [
            'services' => Service::where('is_active', true)->get()
        ];
    }

    public function print($serviceId)
    {
        // Tambahkan pengecekan akses untuk action print
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $newQueue = $this->queueService->addQueue($serviceId);
        $jakartaTime = $newQueue->created_at
            ->setTimezone('Asia/Jakarta')
            ->format('d-m-Y H:i');

        $text = $this->thermalPrinterService->createText([
            ['text' => 'Puskemas Tinewati', 'align' => 'center'],
            ['text' => 'Jl.Garut-Tasikmalaya No 82 Singasari Kec. Singaparna', 'align' => 'center'],
            ['text' => 'Singasari Kec. Singaparna', 'align' => 'center'],
            ['text' => '-----------------', 'align' => 'center'],
            ['text' => 'NOMOR ANTRIAN', 'align' => 'center'],
            ['text' => $newQueue->number, 'align' => 'center', 'style' => 'double'],
            ['text' => $jakartaTime, 'align' => 'center'],
            ['text' => '-----------------', 'align' => 'center'],
            ['text' => $newQueue->service->name, 'align' => 'center'],
             ['text' => '-----------------', 'align' => 'center'],
            ['text' => 'Silakan menunggu antrian Anda', 'align' => 'center'],
            ['text' => 'di ruang tunggu', 'align' => 'center'],
            ['text' => 'untuk menunggu panggilan', 'align' => 'center'],
            ['text' => 'antrian Anda', 'align' => 'center'],
            ['text' => '-----------------', 'align' => 'center'],
            ['text' => 'Terima kasih', 'align' => 'center']
        ]);

        $this->dispatch("print-start", $text);
    }
}
