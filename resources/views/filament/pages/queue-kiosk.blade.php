<<<<<<< Updated upstream
<div class="flex flex-col items-center justify-center min-h-screen p-6 bg-gray-50">
=======
<<<<<<< Updated upstream
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
>>>>>>> Stashed changes

    <div class="mb-10 text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Selamat Datang</h1>
        <p class="text-xl text-gray-600">Silakan pilih layanan untuk mengambil nomor antrian</p>
    </div>
<<<<<<< Updated upstream

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
=======
</div>
=======
<div class="flex flex-col flex-grow min-h-screen">

    <div class="flex justify-end gap-2">
        <button id="connect-button" class="bg-green-700 text-white p-2 rounded">
            ⚙️Sambungkan Printer
        </button>
    </div>

   <div class="flex flex-col flex-grow min-h-screen bg-slate-50"> 



    <div class="pt-16 pb-10 px-4 text-center">
      
        <h1 class="text-5xl md:text-5xl font-black  text-bold text-black tracking-tight mb-4 drop-shadow-sm">
            SELAMAT DATANG
        </h1>
        
        {{-- Sub-judul / Nama Instansi (Opsional, agar terlihat resmi) --}}
        <h2 class="text-3xl font-bold text-green-700 mb-6">
            PUSKESMAS CIPASUNG
        </h2>

        {{-- Instruksi yang Ramah & Jelas --}}
        <div class="inline-block bg-green-700 px-8 py-3 rounded-full shadow-sm border border-slate-200">
            <p class="text-xl text-slate-50 font-medium">
                Silakan sentuh tombol layanan di bawah untuk mengambil tiket
            </p>
        </div>
    </div>

    {{-- BAGIAN 2: TOMBOL LAYANAN (Posisi Tengah Bawah) --}}
    <div class="flex-grow flex flex-col items-center justify-center pb-10 w-full">
        
        <div class="grid grid-cols-2 gap-10">
            @foreach($services as $service)
                <button wire:click="print({{$service->id}})" 
                    class="group relative bg-red-700 border-b-8 border-gray-300 
                           text-white hover:bg-red-700 hover:text-white hover:border-red-900
                           shadow-xl rounded-2xl
                           text-4xl font-bold
                           py-12 px-16
                           min-w-[350px]
                           transition-all duration-200 transform hover:-translate-y-1">
                    
                    {{$service->name}}
                </button>
            @endforeach
        </div>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('livewire:initialized', () => {
    const connectButton = document.getElementById('connect-button');
    connectButton.addEventListener('click', async () => {
        window.connectedPrinter = await getPrinter()
    })
    Livewire.on("print-start", async (text) => {
        await printThermal(text)
    })
})
</script>
@endpush
>>>>>>> Stashed changes
>>>>>>> Stashed changes
