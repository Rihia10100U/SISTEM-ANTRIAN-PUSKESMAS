{{-- resources/views/filament/pages/queue-kiosk.blade.php --}}
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="grid grid-cols-2 gap-6">
        @foreach ($services as $service)
            <button
                class="bg-red-500 hover:bg-red-600 text-white text-xl font-semibold py-6 px-10 rounded-lg shadow-md transition duration-300 ease-in-out"
            >
                {{ $service->name }}
            </button>
        @endforeach
    </div>
</div>
