<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Agenda Dosen - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar (Desktop Only) -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex">
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold tracking-wider text-teal-400">Smart Lab Management</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-border-all"></i>
                <span class="text-xs font-semibold tracking-wide">Dashboard</span>
            </a>
            <a href="{{ route('dosen.agenda') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full">
                <i class="fa-solid fa-calendar-alt"></i>
                <span class="text-xs font-semibold tracking-wide">Agenda</span>
            </a>
            <a href="{{ route('dosen.mahasiswa') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-users"></i>
                <span class="text-xs font-semibold tracking-wide">Daftar Mahasiswa</span>
            </a>
            <a href="{{ route('dosen.perizinan') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-file-signature"></i>
                <span class="text-xs font-semibold tracking-wide">Verifikasi Perizinan</span>
            </a>
            <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-gear"></i>
                <span class="text-xs font-semibold tracking-wide">Pengaturan</span>
            </a>
        </nav>

        <div class="p-6 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 text-rose-400 hover:text-rose-300 text-xs font-bold w-full transition">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-teal-800 text-white rounded-lg flex lg:hidden items-center justify-center font-bold">
                    <i class="fa-solid fa-graduation-cap text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Riwayat Agenda Mengajar</h2>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-bold text-xs text-slate-800">{{ $dosen->nama }}</p>
                    <p class="text-[9px] font-semibold tracking-wider text-slate-500">Dosen Informatika</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-850 flex items-center justify-center font-bold text-xs">
                    {{ substr($dosen->nama, 0, 2) }}
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-4 md:p-6 space-y-6">
            
            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm mb-4">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm mb-4">
                    <i class="fa-solid fa-circle-xmark text-red-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Error!</span>
                        <p class="mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif
            
            <!-- Filter Bar -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <form action="{{ route('dosen.agenda') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end text-xs">
                    <div class="flex-grow w-full">
                        <label class="block text-slate-655 font-bold mb-1.5">Cari Sesi / Mata Kuliah</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan mata kuliah, catatan..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400"></i>
                        </div>
                    </div>
                    <div class="w-full md:w-48">
                        <label class="block text-slate-655 font-bold mb-1.5">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="flex-grow md:flex-grow-0 px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition-all shadow-sm">
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'tanggal']))
                            <a href="{{ route('dosen.agenda') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition-all border border-slate-200 text-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Agendas List -->
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex flex-wrap justify-between items-center gap-3">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Daftar Seluruh Agenda Kelas</h3>
                        <span class="text-[10px] bg-teal-50 text-teal-850 font-bold px-2 py-0.5 rounded-full mt-1 inline-block">{{ $agendas->total() }} Kelas Ditemukan</span>
                    </div>
                    
                    <div class="flex items-center gap-3 ml-auto">
                        @if($agendas->count() > 0)
                            <button type="button" id="btn-toggle-select" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-bold rounded-lg transition-all flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-square-check"></i> Pilih Banyak
                            </button>
                            <div id="container-check-all" class="flex items-center gap-2 mr-2 border-r border-slate-250 pr-3 hidden">
                                <input type="checkbox" id="check-all" class="rounded text-teal-800 focus:ring-teal-700/30 w-3.5 h-3.5">
                                <label for="check-all" class="text-[11px] text-slate-650 font-bold cursor-pointer">Pilih Semua</label>
                            </div>
                            <button type="button" onclick="submitBulkDelete()" id="btn-bulk-delete" class="px-3 py-2 bg-rose-50 hover:bg-rose-100 border border-rose-250 text-rose-700 text-[10px] font-bold rounded-lg transition-all hidden flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                            </button>
                        @endif
                        <button type="button" onclick="startDosenQRScanner()" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-lg shadow-md transition-all flex items-center gap-1.5">
                            <i class="fa-solid fa-qrcode"></i> Scan QR
                        </button>
                        <button type="button" onclick="toggleModal('modal-add-agenda')" class="px-4 py-2 bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold rounded-lg shadow-md transition-all flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-plus"></i> Tambah Agenda
                        </button>
                    </div>
                </div>
                
                <div id="agenda-list-container" class="p-6 space-y-4">
                    @include('dosen.agenda_partial')
                </div>
            </div>
        </div>
            
        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only - Floating Scan QR) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('dosen.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-[9px] font-medium">Dashboard</span>
        </a>
        <a href="{{ route('dosen.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-850 font-bold">
            <i class="fa-solid fa-calendar-alt text-lg"></i>
            <span class="text-[9px] font-bold">Agenda</span>
        </a>
        <div class="relative w-14 h-14 -mt-6 flex justify-center items-center bg-teal-850 text-white rounded-2xl shadow-md border-4 border-slate-50">
            <button type="button" onclick="startDosenQRScanner()" class="flex items-center justify-center w-full h-full text-white" title="Scan QR Presensi">
                <i class="fa-solid fa-qrcode text-xl"></i>
            </button>
        </div>
        <a href="{{ route('dosen.mahasiswa') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-users text-lg"></i>
            <span class="text-[9px] font-medium">Mahasiswa</span>
        </a>
        <a href="{{ route('dosen.pengaturan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-[9px] font-medium">Pengaturan</span>
        </a>
    </nav>

    <!-- Modal Add Agenda -->
    <div id="modal-add-agenda" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="toggleModal('modal-add-agenda')"></div>
        
        <!-- Modal Content -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden text-left">
                <!-- Header -->
                <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-800">
                    <h3 class="font-bold text-sm flex items-center gap-2">
                        <i class="fa-solid fa-calendar-plus text-teal-705"></i> Buat Agenda Baru
                    </h3>
                    <button type="button" onclick="toggleModal('modal-add-agenda')" class="text-slate-400 hover:text-slate-650 text-base">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                
                <!-- Body -->
                <form action="{{ route('dosen.agenda.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Ruangan Laboratorium</label>
                        <select name="lab_id" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            @foreach($labs as $lab)
                                <option value="{{ $lab->id }}">{{ $lab->nama_lab }} ({{ $lab->lokasi }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Mata Kuliah</label>
                        <input type="text" name="judul_agenda" required placeholder="Contoh: Pemrograman Web" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Fakultas</label>
                        <select name="fakultas" required onchange="handleFakultasChange(this.value, 'input-jurusan-hidden-add', 'label-jurusan-add', 'select-jurusan-dropdown-add')" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="" disabled selected>Pilih Fakultas</option>
                            @foreach($fakultas as $fak)
                                <option value="{{ $fak->nama_fakultas }}">{{ $fak->nama_fakultas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="custom-search-select relative">
                        <label class="block text-slate-700 font-bold mb-1">Jurusan / Program Studi</label>
                        <!-- Hidden input to submit the form value -->
                        <input type="hidden" name="jurusan" id="input-jurusan-hidden-add" required>
                        
                        <!-- Trigger Button -->
                        <button type="button" onclick="toggleSearchSelect('select-jurusan-dropdown-add')" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-left text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none flex justify-between items-center">
                            <span id="label-jurusan-add" class="text-slate-400">Pilih Program Studi</span>
                            <i class="fa-solid fa-chevron-down text-slate-400 text-[10px]"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="select-jurusan-dropdown-add" class="absolute left-0 right-0 mt-1 bg-white border border-slate-250 rounded-xl shadow-xl z-50 hidden flex flex-col max-h-60 overflow-hidden">
                            <!-- Search Input -->
                            <div class="p-2 border-b border-slate-100 sticky top-0 bg-white">
                                <div class="relative">
                                    <input type="text" onkeyup="filterSearchSelect('select-jurusan-dropdown-add', this.value)" placeholder="Cari Program Studi..." class="w-full pl-8 pr-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs">
                                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-[10px]"></i>
                                </div>
                            </div>
                            
                            <!-- Options List -->
                            <div class="overflow-y-auto flex-grow py-1 max-h-44 scrollbar-thin animate-fadeIn">
                                @foreach($prodis as $prod)
                                    <button type="button" data-fakultas="{{ $prod->fakultas->nama_fakultas }}" onclick="selectSearchOption('input-jurusan-hidden-add', 'label-jurusan-add', 'select-jurusan-dropdown-add', '{{ $prod->nama_prodi }}')" class="w-full text-left px-4 py-2 hover:bg-slate-50 text-slate-750 transition text-xs select-option-item">
                                        {{ $prod->nama_prodi }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Kelas</label>
                            <select name="kelas" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="" disabled selected>Pilih Kelas</option>
                                <option value="A">Kelas A</option>
                                <option value="B">Kelas B</option>
                                <option value="C">Kelas C</option>
                                <option value="D">Kelas D</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Semester</label>
                            <select name="semester" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="" disabled selected>Pilih Semester</option>
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                                <option value="3">Semester 3</option>
                                <option value="4">Semester 4</option>
                                <option value="5">Semester 5</option>
                                <option value="6">Semester 6</option>
                                <option value="7">Semester 7</option>
                                <option value="8">Semester 8</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Tanggal</label>
                        <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Jam Masuk</label>
                            <input type="time" name="waktu_masuk" required value="08:00" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Jam Keluar</label>
                            <input type="time" name="waktu_keluar" required value="10:30" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Rencana Pembelajaran</label>
                        <textarea name="rencana_pembelajaran" rows="3" required placeholder="Tuliskan materi..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2 border-t border-slate-100 bg-white">
                        <button type="button" onclick="toggleModal('modal-add-agenda')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-800 hover:bg-teal-900 text-white font-bold rounded-lg transition">Buat Agenda</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Toggle & Search Select Script -->
    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.toggle('hidden');
            }
        }

        function toggleSearchSelect(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        function selectSearchOption(hiddenInputId, labelId, dropdownId, value) {
            const hiddenInput = document.getElementById(hiddenInputId);
            const label = document.getElementById(labelId);
            const dropdown = document.getElementById(dropdownId);
            
            if (hiddenInput && label && dropdown) {
                hiddenInput.value = value;
                label.innerText = value;
                label.classList.remove('text-slate-400');
                label.classList.add('text-slate-700');
                dropdown.classList.add('hidden');
            }
        }

        function filterSearchSelect(dropdownId, query) {
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                const options = dropdown.getElementsByClassName('select-option-item');
                const lowercaseQuery = query.toLowerCase();
                
                for (let i = 0; i < options.length; i++) {
                    const text = options[i].textContent || options[i].innerText;
                    const matchesSearch = text.toLowerCase().indexOf(lowercaseQuery) > -1;
                    
                    if (matchesSearch) {
                        options[i].classList.remove('hidden-by-search');
                        if (!options[i].classList.contains('hidden-by-fakultas')) {
                            options[i].style.display = "";
                        }
                    } else {
                        options[i].classList.add('hidden-by-search');
                        options[i].style.display = "none";
                    }
                }
            }
        }

        function handleFakultasChange(selectedFakultas, hiddenInputId, labelId, dropdownId) {
            // Reset prodi label & input value
            const hiddenInput = document.getElementById(hiddenInputId);
            const label = document.getElementById(labelId);
            if (hiddenInput && label) {
                hiddenInput.value = "";
                label.innerText = "Pilih Program Studi";
                label.classList.add('text-slate-400');
                label.classList.remove('text-slate-700');
            }
            
            // Filter options by data-fakultas
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                const options = dropdown.getElementsByClassName('select-option-item');
                for (let i = 0; i < options.length; i++) {
                    const optFak = options[i].getAttribute('data-fakultas');
                    if (!selectedFakultas || optFak === selectedFakultas) {
                        options[i].classList.remove('hidden-by-fakultas');
                        if (!options[i].classList.contains('hidden-by-search')) {
                            options[i].style.display = "";
                        }
                    } else {
                        options[i].classList.add('hidden-by-fakultas');
                        options[i].style.display = "none";
                    }
                }
            }
        }

        // Close search dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInsideSelect = event.target.closest('.custom-search-select');
            if (!isClickInsideSelect) {
                const dropdowns = document.querySelectorAll('[id^="select-jurusan-dropdown"]');
                dropdowns.forEach(function(dropdown) {
                    dropdown.classList.add('hidden');
                });
            }
        });
    </script>

    <!-- Hidden form for bulk delete -->
    <form id="bulk-delete-form" action="{{ route('dosen.agenda.bulk-delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <!-- Bulk delete checkboxes Script -->
    <script>
        function submitBulkDelete() {
            const checkedBoxes = document.querySelectorAll('.agenda-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('Silakan pilih setidaknya satu agenda untuk dihapus.');
                return;
            }
            
            if (confirm('Apakah Anda yakin ingin menghapus seluruh agenda terpilih?')) {
                const form = document.getElementById('bulk-delete-form');
                
                // Clear any previous dynamic inputs
                form.querySelectorAll('input[name="agenda_ids[]"]').forEach(el => el.remove());
                
                // Append checked agenda IDs
                checkedBoxes.forEach(cb => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'agenda_ids[]';
                    input.value = cb.value;
                    form.appendChild(input);
                });
                
                form.submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkAll = document.getElementById('check-all');
            const checkboxes = document.querySelectorAll('.agenda-checkbox');
            const btnBulkDelete = document.getElementById('btn-bulk-delete');
            const selectedCount = document.getElementById('selected-count');
            
            const btnToggleSelect = document.getElementById('btn-toggle-select');
            const containerCheckAll = document.getElementById('container-check-all');
            const containerCheckboxes = document.querySelectorAll('.container-checkbox');
            const innerContainers = document.querySelectorAll('.inner-agenda-container');
            
            let selectModeActive = false;

            if (btnToggleSelect) {
                btnToggleSelect.addEventListener('click', function() {
                    selectModeActive = !selectModeActive;
                    
                    if (selectModeActive) {
                        // Activate select mode
                        containerCheckAll.classList.remove('hidden');
                        containerCheckboxes.forEach(cb => cb.classList.remove('hidden'));
                        innerContainers.forEach(container => {
                            container.classList.remove('pl-2');
                            container.classList.add('pl-7');
                        });
                        btnToggleSelect.innerHTML = `<i class="fa-solid fa-xmark"></i> Batal Pilih`;
                        btnToggleSelect.classList.remove('bg-slate-100', 'hover:bg-slate-200', 'text-slate-700');
                        btnToggleSelect.classList.add('bg-slate-200', 'text-slate-800');
                    } else {
                        // Deactivate select mode
                        containerCheckAll.classList.add('hidden');
                        containerCheckboxes.forEach(cb => cb.classList.add('hidden'));
                        innerContainers.forEach(container => {
                            container.classList.remove('pl-7');
                            container.classList.add('pl-2');
                        });
                        btnToggleSelect.innerHTML = `<i class="fa-solid fa-square-check"></i> Pilih Banyak`;
                        btnToggleSelect.classList.remove('bg-slate-200', 'text-slate-800');
                        btnToggleSelect.classList.add('bg-slate-100', 'hover:bg-slate-200', 'text-slate-700');
                        
                        // Uncheck everything
                        if (checkAll) checkAll.checked = false;
                        checkboxes.forEach(cb => cb.checked = false);
                        updateBulkDeleteButton();
                    }
                });
            }

            if (checkAll) {
                checkAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                    updateBulkDeleteButton();
                });

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        const allChecked = Array.from(checkboxes).every(c => c.checked);
                        checkAll.checked = allChecked;
                        updateBulkDeleteButton();
                    });
                });
            }

            function updateBulkDeleteButton() {
                const checkedCount = Array.from(checkboxes).filter(c => c.checked).length;
                if (selectedCount) {
                    selectedCount.innerText = checkedCount;
                }
                if (btnBulkDelete) {
                    if (checkedCount > 0 && selectModeActive) {
                        btnBulkDelete.classList.remove('hidden');
                    } else {
                        btnBulkDelete.classList.add('hidden');
                    }
                }
            }

            // Real-time dynamic polling for student check-ins
            function pollAgendas() {
                // If bulk selection mode is active, do not poll
                if (selectModeActive) return;

                // If any modal (edit agenda, add agenda) is open, do not poll
                const openModal = document.querySelector('div[id^="modal-"]:not(.hidden)');
                if (openModal) return;

                // Check if any input/textarea in details has focus
                const activeEl = document.activeElement;
                if (activeEl && (activeEl.tagName === 'INPUT' || activeEl.tagName === 'TEXTAREA')) {
                    return;
                }

                // Backup which details are currently open
                const openDetailsIndices = [];
                document.querySelectorAll('#agenda-list-container details').forEach((details, index) => {
                    if (details.open) {
                        openDetailsIndices.push(index);
                    }
                });

                fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.ok) return response.json();
                    throw new Error('Network error');
                })
                .then(data => {
                    if (data.html) {
                        const container = document.getElementById('agenda-list-container');
                        if (container.innerHTML !== data.html) {
                            container.innerHTML = data.html;

                            // Restore open state
                            document.querySelectorAll('#agenda-list-container details').forEach((details, index) => {
                                if (openDetailsIndices.includes(index)) {
                                    details.open = true;
                                }
                            });
                        }
                    }
                })
                .catch(err => console.error("Error polling agendas: ", err));
            }

            // Start polling every 5 seconds
            setInterval(pollAgendas, 5000);
        });
    </script>

    <!-- Hidden form for QR attendance submission -->
    <form id="dosen-absensi-form" action="{{ route('dosen.absensi.submit') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="qr_code_token" id="dosen-qr-token-input">
    </form>

    <!-- QR Scanner Modal -->
    <div id="modal-qr-scanner" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100 text-slate-800">
                <h3 class="font-bold text-base flex items-center gap-2">
                    <i class="fa-solid fa-camera text-teal-800"></i> Pindai QR Code Board
                </h3>
                <button type="button" onclick="closeScannerModal()" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            
            <div class="space-y-4">
                <div id="qr-reader" class="overflow-hidden rounded-xl border border-slate-200" style="width: 100%; min-height: 250px;"></div>
                <div id="qr-reader-results" class="text-center text-xs text-slate-500 font-mono"></div>
            </div>
            
            <div class="flex pt-3 border-t border-slate-100">
                <button type="button" onclick="closeScannerModal()" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold text-xs">Tutup</button>
            </div>
        </div>
    </div>

    <!-- html5-qrcode script -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrcodeScanner = null;

        function startDosenQRScanner() {
            document.getElementById('modal-qr-scanner').classList.remove('hidden');
            
            html5QrcodeScanner = new Html5Qrcode("qr-reader");
            const config = { fps: 10, qrbox: { width: 220, height: 220 } };
            
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    let cameraId = devices[0].id;
                    for (let i = 0; i < devices.length; i++) {
                        const label = devices[i].label.toLowerCase();
                        if (label.includes('back') || label.includes('rear') || label.includes('lingkungan') || label.includes('belakang')) {
                            cameraId = devices[i].id;
                            break;
                        }
                    }
                    
                    html5QrcodeScanner.start(
                        cameraId,
                        config,
                        (decodedText, decodedResult) => {
                            document.getElementById('dosen-qr-token-input').value = decodedText;
                            document.getElementById('dosen-absensi-form').submit();
                            closeScannerModal();
                        },
                        (errorMessage) => {}
                    ).catch((err) => {
                        console.error("Gagal memulai kamera: ", err);
                        alert("Gagal mengakses kamera. Detail: " + err);
                        closeScannerModal();
                    });
                } else {
                    html5QrcodeScanner.start(
                        { facingMode: "environment" },
                        config,
                        (decodedText, decodedResult) => {
                            document.getElementById('dosen-qr-token-input').value = decodedText;
                            document.getElementById('dosen-absensi-form').submit();
                            closeScannerModal();
                        },
                        (errorMessage) => {}
                    ).catch((err) => {
                        console.error("Gagal memulai kamera: ", err);
                        alert("Gagal mengakses kamera. Detail: " + err);
                        closeScannerModal();
                    });
                }
            }).catch(err => {
                console.error("Gagal getCameras: ", err);
                html5QrcodeScanner.start(
                    { facingMode: "environment" },
                    config,
                    (decodedText, decodedResult) => {
                        document.getElementById('dosen-qr-token-input').value = decodedText;
                        document.getElementById('dosen-absensi-form').submit();
                        closeScannerModal();
                    },
                    (errorMessage) => {}
                ).catch((err2) => {
                    console.error("Gagal memulai kamera: ", err2);
                    alert("Gagal mengakses kamera. Detail:\n1. " + err + "\n2. " + err2);
                    closeScannerModal();
                });
            });
        }

        function closeScannerModal() {
            document.getElementById('modal-qr-scanner').classList.add('hidden');
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner = null;
                }).catch(err => {
                    console.error("Gagal menghentikan scanner: ", err);
                });
            }
        }
    </script>
</body>
</html>
