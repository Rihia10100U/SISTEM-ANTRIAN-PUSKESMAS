<?php

namespace App\Filament\Widgets;

use App\Models\Queue;
use App\Models\Service;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ServiceDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Kepadatan Layanan Hari Ini';
    protected static ?int $sort = 2; // Urutan tampilan

    protected function getData(): array
    {
        // Ambil data layanan dan hitung jumlah antrian hari ini per layanan
        $services = Service::withCount(['queues' => function ($query) {
            $query->whereDate('created_at', Carbon::today());
        }])->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pasien',
                    'data' => $services->pluck('queues_count'), // Data angka
                    'backgroundColor' => [
                        '#3b82f6', '#ef4444', '#22c55e', '#f59e0b', '#8b5cf6' 
                    ], // Warna-warni chart
                ],
            ],
            'labels' => $services->pluck('name'), // Label (Umum, Gigi, KIA)
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}