<?php

namespace App\Filament\Widgets;

use App\Models\Queue;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class PeakHoursChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Kepadatan Pasien Per Jam (Hari Ini)';
    protected static ?int $sort = 3; // Taruh di urutan bawah
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $today = Carbon::today();
        
        // Inisialisasi array jam (07:00 sampai 16:00 misalnya)
        $hours = [];
        $data = [];
        
        for ($i = 7; $i <= 16; $i++) {
            $hourLabel = sprintf('%02d:00', $i);
            $hours[] = $hourLabel;
            
            // Hitung jumlah pasien yang mengambil tiket pada jam tersebut
            $count = Queue::whereDate('created_at', $today)
                ->whereTime('created_at', '>=', "$i:00:00")
                ->whereTime('created_at', '<=', "$i:59:59")
                ->count();
            
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pasien Masuk',
                    'data' => $data,
                    'backgroundColor' => '#22c55e',
                    'borderColor' => '#22c55e',
                ],
            ],
            'labels' => $hours,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}