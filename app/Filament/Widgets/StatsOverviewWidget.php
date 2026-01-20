<?php

namespace App\Filament\Widgets;

use App\Models\Queue;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '15s'; 
    protected static ?int $sort = 1; // Pastikan ini di urutan teratas

    protected function getStats(): array
    {
        $today = Carbon::today();

        $stats = [
            Stat::make('Total Antrian Masuk', Queue::whereDate('created_at', $today)->count())
                ->description('Semua layanan')
                ->icon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Selesai Dilayani', Queue::whereDate('created_at', $today)->where('status', 'completed')->count())
                ->description('Pasien pulang')
                ->icon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Batal / Terlewat', Queue::whereDate('created_at', $today)->whereIn('status', ['cancelled', 'skipped'])->count())
                ->description('Tidak hadir saat dipanggil')
                ->icon('heroicon-m-x-circle')
                ->color('danger'),
        ];

        // --- BAGIAN 2: STATISTIK PER LAYANAN (Looping) ---
        $services = Service::where('is_active', true)->get();

        foreach ($services as $service) {
            
            // Hitung total pasien per layanan
            $total = Queue::whereDate('created_at', $today)
                ->where('service_id', $service->id)
                ->count();

            // Hitung yang statusnya 'waiting' (Menunggu)
            $waiting = Queue::whereDate('created_at', $today)
                ->where('service_id', $service->id)
                ->where('status', 'waiting')
                ->count();
            
            // Hitung yang sedang dilayani ('serving')
            $serving = Queue::whereDate('created_at', $today)
                ->where('service_id', $service->id)
                ->where('status', 'serving')
                ->count();

            // Logika Deskripsi: Menampilkan yang menunggu vs sedang dilayani
            $desc = "{$waiting} Menunggu, {$serving} Sedang dilayani";

            $stats[] = Stat::make($service->name, $total)
                ->description($desc)
                ->icon('heroicon-m-identification') // Icon kartu identitas/poli
                ->color($waiting > 5 ? 'danger' : 'info') // Merah jika antrian panjang
                ->chart([2, 5, $total]); // Grafik dummy mini
        }

        return $stats;
    }
}