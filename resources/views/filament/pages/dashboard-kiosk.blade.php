<div class="flex flex-col flex-grow p-4" wire:poll.500ms="callNextQueue">
    <div class="grid grid-cols-2 gap-6 justify-center">
        @foreach($counters as $counter)
        <div class="p-6 rounded-lg shadow-lg text-center border-l-4 border-{{ $counter->service->color }}-500
             @if($counter->is_active && !$counter->is_available) bg-green-100 @endif">
            <!-- Header dengan warna service -->
            <div class="mb-4">
                <h2 class="text-2xl font-bold mb-1">{{ $counter->name }}</h2>
                <p class="text-{{ $counter->service->color }}-600 font-medium">
                    {{ $counter->service->name }}
                </p>
            </div>

            <!-- Nomor antrian -->
            <div class="space-y-2 transition-all duration-600 ease-in-out transform hover:scale-105">
                @if($counter->activeQueue)
                    <div class="text-5xl font-bold text-{{ $counter->service->color }}-600 animate-pulse">
                        {{ $counter->activeQueue->number }}
                    </div>

                    <div class="text-lg font-semibold px-4 py-1 rounded-full inline-block
                              bg-{{ $counter->service->color }}-100 text-{{ $counter->service->color }}-800
                              transition-colors duration-500">
                        {{ $counter->activeQueue->kiosk_label }}
                    </div>
                @else
                    <div class="text-4xl font-bold text-black-650">
                        ---
                    </div>
                    <div class="text-lg text-black-500">
                        Tidak ada antrian
                    </div>
                @endif
            </div>

            <!-- Status loket -->
            <div class="mt-4">
                <p class="text-sm font-medium rounded-full px-3 py-1 inline-block
                         @if(!$counter->is_active) bg-gray-100 text-gray-800
                         @elseif($counter->is_available) bg-green-100 text-green-800
                         @else bg-yellow-100 text-yellow-800 @endif
                         transition-colors duration-300">
                    @if(!$counter->is_active)
                        Loket tidak aktif
                    @elseif($counter->is_available)
                        Siap Melayani
                    @else
                        Sedang Melayani
                    @endif
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>
