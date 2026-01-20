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
            PUSKESMAS NATUNA
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
