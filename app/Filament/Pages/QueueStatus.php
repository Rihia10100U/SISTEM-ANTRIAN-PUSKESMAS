<?php

namespace App\Filament\Pages;

use BackedEnum;
use UnitEnum;
use Filament\Support\Icons\Heroicon;
use App\Models\Queue;
use Filament\Pages\BasePage;
use Livewire\Attributes\Url;

class QueueStatus extends BasePage
{
    protected string $view = 'filament.pages.queue-status';

    protected static ?string $title = 'Status Antrian';

    #[Url]
    public ?string $id = null;

    public $queue = null;

    public $waitingCount = 0;

    public $currentQueues = [];
    
    public$statusLabels = [
        'waiting' => 'Menunggu',
        'called' => 'Dipanggil',
        'serving' => 'Dilayani',
        'finished' => 'Selesai',
        'canceled' => 'Dibatalkan'
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        if (!$this->id) return;

        $this->queue = Queue::findOrFail($this->id);

    }

    public function getStatusLabel()
    {
        if (!$this->queue) return '';

        return $this->statusLabels[$this->queue->status] ?? '';
    }
}
