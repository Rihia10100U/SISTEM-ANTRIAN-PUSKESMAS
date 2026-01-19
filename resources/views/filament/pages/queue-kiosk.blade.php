<div class="flex flex-col items-center justify-center min-h-screen p-6 bg-gray-50">

    <div class="mb-10 text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Selamat Datang</h1>
        <p class="text-xl text-gray-600">Silakan pilih layanan untuk mengambil nomor antrian</p>
    </div>

    {{-- Grid Tombol Layanan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full max-w-6xl">

        {{-- Loop Services dari Computed Property --}}
        @foreach($this->services as $service)
            <button
                wire:click="print({{ $service->id }})"
                wire:loading.attr="disabled"
                class="relative group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl
                       border-2 border-transparent hover:border-{{ $service->color ?? 'blue' }}-500
                       transition-all duration-300 transform hover:-translate-y-1 text-center">

                {{-- Efek Loading saat diklik --}}
                <div wire:loading wire:target="print({{ $service->id }})"
                     class="absolute inset-0 bg-white/80 flex items-center justify-center rounded-2xl z-10">
                    <svg class="animate-spin h-8 w-8 text-{{ $service->color ?? 'blue' }}-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </div>

                {{-- Nama Layanan --}}
                <h3 class="text-3xl font-bold text-gray-800 group-hover:text-{{ $service->color ?? 'blue' }}-600 mb-2">
                    {{ $service->name }}
                </h3>

                <p class="text-gray-500 font-medium">Klik untuk cetak tiket</p>
            </button>
        @endforeach

    </div>

    {{-- Footer --}}
    <div class="mt-12 text-gray-400 text-sm">
        &copy; {{ date('Y') }} Puskesmas Tinewati
    </div>
</div>
