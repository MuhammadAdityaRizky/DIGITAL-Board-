@php
    // Find active agenda (current time falls between start and end time today)
    $currentTime = now()->format('H:i:s');
    
    $activeAgenda = $agendas->first(function($agenda) use ($currentTime) {
        return $currentTime >= $agenda->jam_mulai && $currentTime <= $agenda->jam_selesai;
    });
    
    // If no agenda is currently active, find the next upcoming one as the main active display
    if (!$activeAgenda) {
        $activeAgenda = $agendas->first(function($agenda) use ($currentTime) {
            return $agenda->jam_mulai > $currentTime;
        });
    }
    
    // Get next agenda after the active agenda
    $nextAgenda = null;
    if ($activeAgenda) {
        $nextAgenda = $agendas->first(function($agenda) use ($activeAgenda, $currentTime) {
            return $agenda->jam_mulai > $activeAgenda->jam_mulai && $agenda->jam_mulai > $currentTime;
        });
    }
    
    // Get latest announcement
    $latestAnnouncement = $pengumuman->first();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INFORMATION UIKA BOARD - Smart Lab</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f0f4f9;
        }
        .mono {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="min-h-screen text-slate-800 flex flex-col justify-between p-4 md:p-6 space-y-6">



    <!-- Header Section (Royal Blue with thin border) -->
    <header class="flex flex-col md:flex-row justify-between items-center bg-[#0c4ea6] border-2 border-[#1e60b8] rounded-2xl p-4 md:px-8 gap-4 shadow-md text-white">
        <!-- Logo & Campus Name -->
        <div class="flex items-center gap-4">
            <img src="https://commons.wikimedia.org/wiki/Special:FilePath/LOGO_UIKA_Terbaru2.png" 
                 alt="Logo UIKA" 
                 class="w-14 h-14 md:w-16 md:h-16 object-contain shrink-0">
            <div class="text-[11px] md:text-xs font-black tracking-wider leading-tight text-slate-100 uppercase">
                <div>Universitas</div>
                <div>Ibn Khaldun</div>
                <div>Bogor</div>
            </div>
        </div>

        <!-- Center Title -->
        <div class="text-center md:flex-1">
            <h1 class="text-xl md:text-3xl font-extrabold tracking-wide text-white uppercase drop-shadow-sm">
                INFORMATION UIKA BOARD
            </h1>
            <a href="{{ route('board') }}" class="inline-flex items-center gap-1.5 text-[9px] font-bold text-[#00b87c] hover:text-white uppercase tracking-widest mt-1 bg-black/25 px-2.5 py-1 rounded-full transition duration-300">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Portal Lab
            </a>
        </div>

        <!-- Clock & Date Section -->
        <div class="text-center md:text-right shrink-0">
            <div id="live-day" class="text-xs md:text-sm font-black tracking-widest text-slate-200 uppercase">RABU</div>
            <div id="live-date" class="text-[10px] md:text-xs font-bold text-slate-300">12 Agustus 2026</div>
            <div id="live-clock" class="text-2xl md:text-4xl font-extrabold text-white tracking-tight mt-0.5 leading-none">00:00 AM</div>
        </div>
    </header>

    <!-- Main Board Grid Container -->
    <div id="main-board-container" class="flex-grow flex flex-col justify-between">
        @include('welcome_partial')
    </div>
    </main>

    <!-- Invisible trigger / subtle admin portal link in footer -->
    <footer class="flex items-center justify-between text-slate-400 text-[10px] px-2">
        <div>&copy; 2026 Computer Laboratory Digital Board System</div>
        <div>
            <a href="{{ route('login') }}" class="text-slate-400 hover:text-slate-600 transition flex items-center gap-1">
                <i class="fa-solid fa-lock text-[9px]"></i> Portal Log In
            </a>
        </div>
    </footer>

    <!-- Clock implementation -->
    <script>
        function updateClock() {
            const now = new Date();
            
            // Format time in 24-hour format
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            
            document.getElementById('live-clock').innerText = `${hours}:${minutes}`;

            // Format date (e.g. RABU, 12 Agustus 2026)
            const days = ['MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU'];
            const months = ['Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli'];
            
            // Note: date logic adjustment for year 2026/real time. 
            // In standard JS, getMonth() returns index 0-11 representing Jan-Dec.
            const standardMonths = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const monthName = standardMonths[now.getMonth()];
            const year = now.getFullYear();

            document.getElementById('live-day').innerText = dayName;
            document.getElementById('live-date').innerText = `${date} ${monthName} ${year}`;
        }

        // Run immediately and then every second
        updateClock();
        setInterval(updateClock, 1000);
        


        // Dynamic AJAX live polling every 5 seconds
        setInterval(function() {
            fetch(window.location.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Network response was not ok.');
            })
            .then(data => {
                if (data.html) {
                    const container = document.getElementById('main-board-container');
                    if (container.innerHTML !== data.html) {
                        container.innerHTML = data.html;
                    }
                }
            })
            .catch(err => console.error("Error polling Digital Board updates: ", err));
        }, 5000);
    </script>
</body>
</html>
