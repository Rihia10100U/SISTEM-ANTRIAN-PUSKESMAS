<div class="container py-8 px-4 mx-auto max-w-xl space-y-6" wire:poll.5000ms="loadData">

    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Status Antrian</h1>
        <p class="mt-2 text-sm text-gray-600">{{ $queue->service->name }}</p>
        <p class="mt-1 text-gray-500 text-xs">{{ now()->format('d M Y 05:i') }}</p>
    </div>


    <x-filament::section>

        <x-slot name="heading">Nomor Antrian Anda</x-slot>

        <div class="flex justify-between items-center">
            <div class="text-4xl font-bold text-primary-600">{{ $queue->number }}</div>

            <x-filament::badge>
                {{ $this->getStatusLabel() }}
            </x-filament::badge>
        </div>

        @if($queue->counter && $queue->called_at && !$queue->served_at)
        <div class="mt-2 bg-primary-50 border rounded-lg px-4 py-3">
            <div class="flex items-center gap-2">
                <x-heroicon-o-information-circle class="h-8 w-8 text-primary-500"/>
                <span class="text-primary-700">Silakan menuju ke <span class="font-bold">{{ $queue->counter->name }}</span></span>
            </div>
        </div>
        @endif

    </x-filament::section>

    <x-filament::section>

        <x-slot name="heading">Antrian Sedang Dilayani</x-slot>

        @if ($waitingCount)
            <x-slot name="description">Terdapat <strong>{{ $waitingCount }} antrian</strong> di belakang Anda</x-slot>
        @endif

        <div class="space-y-4">

            @foreach ($currentQueues as $currentQueue)
                <div class="border rounded-md p-3 text-center">
                    <p class="text-sm text-gray-500">{{$currentQueue->counter->name}}</p>
                    <p class="text-xl font-semibold text-primary-600">{{ $currentQueue->number }}</p>
                </div>
            @endforeach

        </div>

    </x-filament::section>

</div>