<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mesin Antrian Puskesmas Tinewati</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    @filamentScripts
    @filamentStyles
</head>
<body class="flex-col min-w-screen min-h-screen bg-gray-100">
    <header class="bg-blue-600 text-white p-4">
        <div class="flex flex-col items-center">
            <h1 class="text-2xl font-bold">Mesin Antrian Puskesmas Tinewati</h1>
            <div class="flex items-center mt-2">
                <!-- Tanggal -->
                <span id="date" class="text-lg font-medium"></span>
                <!-- Waktu -->
                <span id="time" class="text-lg font-bold ml-2"></span>
            </div>
        </div>
        <button id="kiosk-mode-button" class="bg-white text-blue-600 p-2 rounded absolute top-2 right-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
             </svg>
        </button>
    </header>

    <main class="p-6 w-full h-full flex flex-grow">
        {{ $slot }}
    </main>

    @stack('scripts')
    <script>
        // Fungsi untuk update waktu realtime
        function updateRealtimeClock() {
            const now = new Date();
            
            // Format waktu: HH.MM.SS
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}.${minutes}.${seconds}`;
            
            // Format tanggal: Hari, DD Bulan YYYY
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                           'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();
            
            const dateString = `${dayName}, ${date} ${monthName} ${year}`;
            
            // Update elemen di DOM
            document.getElementById('date').textContent = dateString;
            document.getElementById('time').textContent = timeString;
        }

        // Update waktu setiap detik
        setInterval(updateRealtimeClock, 1000);
        
        // Inisialisasi awal
        updateRealtimeClock();

        // Kiosk mode button
        document.getElementById('kiosk-mode-button').addEventListener('click', () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch((err) => {
                    console.error(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                });
            } else {
                document.exitFullscreen();
            }
        });
    </script>
</body>
</html>