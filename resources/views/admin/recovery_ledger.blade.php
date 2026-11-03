<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Terhapus & Blockchain Ledger - Digital Board</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 shrink-0">
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="toggleAdminMobileSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition cursor-pointer" title="Buka Menu Sidebar">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-8 h-8 object-contain flex lg:hidden shrink-0">
                <div>
                    <h2 class="font-extrabold text-base text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-teal-600"></i>
                        Data Terhapus & Blockchain Ledger
                    </h2>
                    <p class="text-[11px] text-slate-500 hidden sm:block">Database 2 (digital_board_recovery) • Snapshot & Pemulihan Real-Time</p>
                </div>
            </div>

            <!-- Blockchain Badge & Verify Button -->
            <div class="flex items-center gap-2">
                @if($chainStatus['is_valid'])
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold rounded-xl shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Blockchain Valid & Utuh
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold rounded-xl shadow-xs">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                        Terdeteksi Manipulasi ({{ $chainStatus['corrupted_count'] }})
                    </span>
                @endif
            </div>
        </header>

        <!-- Body Content -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-4 sm:p-6 lg:p-8 space-y-6">

            <!-- Flash Alert -->
            @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-emerald-800 text-xs font-semibold shadow-xs">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif
            @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-center gap-3 text-rose-800 text-xs font-semibold shadow-xs">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            <!-- 4 Quick Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-trash-can-arrow-up"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-slate-500">Data Terhapus</p>
                        <h4 class="text-xl font-extrabold text-slate-800">{{ number_format($totalDeleted) }}</h4>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-cubes-stacked"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-slate-500">Total Blok Rantai</p>
                        <h4 class="text-xl font-extrabold text-slate-800">{{ number_format($totalBlocks) }}</h4>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-plus-circle"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-slate-500">Data Dibuat (Created)</p>
                        <h4 class="text-xl font-extrabold text-slate-800">{{ number_format($totalCreated) }}</h4>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-slate-500">Data Diubah (Updated)</p>
                        <h4 class="text-xl font-extrabold text-slate-800">{{ number_format($totalUpdated) }}</h4>
                    </div>
                </div>
            </div>

            <!-- Filters & Search Bar -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                <form action="{{ route('admin.recovery') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 text-xs">
                    
                    <!-- Action Tabs -->
                    <div class="inline-flex p-1 bg-slate-100 rounded-xl border border-slate-200/70 overflow-x-auto">
                        <a href="{{ route('admin.recovery', ['action' => 'DELETED', 'table' => $tableFilter, 'search' => $search]) }}"
                           class="px-3.5 py-1.5 rounded-lg font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ $actionFilter === 'DELETED' ? 'bg-amber-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                            <i class="fa-solid fa-trash-can"></i> Data Terhapus
                        </a>
                        <a href="{{ route('admin.recovery', ['action' => 'ALL', 'table' => $tableFilter, 'search' => $search]) }}"
                           class="px-3.5 py-1.5 rounded-lg font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ $actionFilter === 'ALL' ? 'bg-teal-800 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                            <i class="fa-solid fa-list"></i> Semua Blok (Ledger)
                        </a>
                        <a href="{{ route('admin.recovery', ['action' => 'CREATED', 'table' => $tableFilter, 'search' => $search]) }}"
                           class="px-3.5 py-1.5 rounded-lg font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ $actionFilter === 'CREATED' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                            <i class="fa-solid fa-circle-plus"></i> Dibuat
                        </a>
                        <a href="{{ route('admin.recovery', ['action' => 'UPDATED', 'table' => $tableFilter, 'search' => $search]) }}"
                           class="px-3.5 py-1.5 rounded-lg font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ $actionFilter === 'UPDATED' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                            <i class="fa-solid fa-pen"></i> Diubah
                        </a>
                    </div>

                    <!-- Table Select & Keyword Search -->
                    <div class="flex items-center gap-2.5">
                        <input type="hidden" name="action" value="{{ $actionFilter }}">
                        
                        <select name="table" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="">Semua Tabel</option>
                            @foreach($availableTables as $tbl)
                                <option value="{{ $tbl }}" {{ $tableFilter === $tbl ? 'selected' : '' }}>{{ $tbl }}</option>
                            @endforeach
                        </select>

                        <div class="relative flex-1 md:w-64">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari matkul, ID, hash..." 
                                   class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>

                        <button type="submit" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white font-bold rounded-xl transition cursor-pointer">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Data Table Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                                <th class="py-3.5 px-4 text-center">Blok #</th>
                                <th class="py-3.5 px-4">Tabel Sumber</th>
                                <th class="py-3.5 px-4">ID Asli</th>
                                <th class="py-3.5 px-4 text-center">Aksi</th>
                                <th class="py-3.5 px-4">Snapshot Ringkasan Data</th>
                                <th class="py-3.5 px-4">Hash Rantai (SHA-256)</th>
                                <th class="py-3.5 px-4">Waktu</th>
                                <th class="py-3.5 px-4 text-center">Opsi Pemulihan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($ledgers as $item)
                                @php
                                    $payload = is_array($item->payload) ? $item->payload : json_decode($item->payload, true);
                                    // Ringkasan ramah manusia
                                    $summary = $payload['mata_kuliah'] 
                                        ?? ($payload['name'] ?? ($payload['nama_lengkap'] ?? ($payload['nama'] ?? ($payload['judul'] ?? ($payload['nama_prodi'] ?? 'Data ID #' . $item->record_id)))));
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-3 px-4 text-center font-extrabold text-slate-700">
                                        #{{ $item->id }}
                                    </td>
                                    <td class="py-3 px-4 font-bold text-slate-800">
                                        <span class="inline-block px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-700 font-mono text-[10px]">
                                            {{ $item->table_name }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-mono font-bold text-slate-600">
                                        #{{ $item->record_id }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($item->action === 'DELETED')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200 font-bold text-[10px]">
                                                <i class="fa-solid fa-trash-can text-[9px]"></i> DELETED
                                            </span>
                                        @elseif($item->action === 'CREATED')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[10px]">
                                                <i class="fa-solid fa-plus text-[9px]"></i> CREATED
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200 font-bold text-[10px]">
                                                <i class="fa-solid fa-pen text-[9px]"></i> UPDATED
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="max-w-xs truncate font-semibold text-slate-800" title="{{ $summary }}">
                                            {{ $summary }}
                                        </div>
                                        <button type="button" 
                                                onclick="showDetailModal({{ json_encode($item) }})" 
                                                class="text-[10px] text-teal-600 hover:text-teal-800 font-bold hover:underline cursor-pointer mt-0.5 inline-flex items-center gap-1">
                                            <i class="fa-solid fa-eye text-[9px]"></i> Lihat Detail Lengkap
                                        </button>
                                    </td>
                                    <td class="py-3 px-4 font-mono text-[10px] text-slate-500" title="Prev: {{ $item->previous_hash }} &#10;Curr: {{ $item->current_hash }}">
                                        <span class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-800 font-bold">
                                            {{ substr($item->current_hash, 0, 10) }}...{{ substr($item->current_hash, -6) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-[11px] text-slate-500 whitespace-nowrap">
                                        {{ $item->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <button type="button" 
                                                onclick="confirmRestore({{ $item->id }}, '{{ $item->table_name }}', {{ $item->record_id }})" 
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-bold text-[11px] shadow-xs transition cursor-pointer">
                                            <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-12 text-slate-400">
                                        <i class="fa-solid fa-box-open text-4xl mb-3 text-slate-300"></i>
                                        <p class="font-bold text-sm">Belum Ada Data Sesuai Filter</p>
                                        <p class="text-xs text-slate-400 mt-1">Coba ubah tab filter aksi atau pilih tabel lain.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($ledgers->hasPages())
                <div class="p-4 border-t border-slate-100 flex items-center justify-between">
                    {{ $ledgers->links() }}
                </div>
                @endif
            </div>

        </div>
    </main>

    <!-- Modal Detail Snapshot JSON -->
    <div id="detailModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[85vh] flex flex-col shadow-2xl border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <div>
                        <h3 id="modalTitle" class="font-extrabold text-sm text-slate-800">Detail Snapshot Blok</h3>
                        <p id="modalSubtitle" class="text-[11px] text-slate-500">Fotokopi Utuh dari Database 2</p>
                    </div>
                </div>
                <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-xl bg-slate-200/80 hover:bg-slate-300 text-slate-600 flex items-center justify-center cursor-pointer transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            <div class="p-5 overflow-y-auto custom-scrollbar space-y-4 text-xs">
                <div>
                    <label class="font-bold text-slate-600 block mb-1">Kode Hash SHA-256 (Segel Blockchain):</label>
                    <div id="modalHash" class="p-2.5 bg-slate-100 rounded-xl font-mono text-[11px] text-teal-800 break-all select-all font-semibold"></div>
                </div>
                <div>
                    <label class="font-bold text-slate-600 block mb-1">Previous Hash (Rantai Sebelumnya):</label>
                    <div id="modalPrevHash" class="p-2.5 bg-slate-100 rounded-xl font-mono text-[11px] text-slate-600 break-all select-all"></div>
                </div>
                <div>
                    <label class="font-bold text-slate-600 block mb-1">Seluruh Isian Kolom Snapshot Data:</label>
                    <div id="modalFieldsGrid" class="grid grid-cols-1 sm:grid-cols-2 gap-2"></div>
                </div>
            </div>
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="button" onclick="closeDetailModal()" class="px-4 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-xl font-bold text-xs cursor-pointer transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Restore POST -->
    <form id="restoreForm" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        function showDetailModal(item) {
            document.getElementById('modalTitle').textContent = `Detail Snapshot Blok #${item.id} - [${item.table_name}]`;
            document.getElementById('modalSubtitle').textContent = `Aksi: ${item.action} • Waktu: ${item.created_at}`;
            document.getElementById('modalHash').textContent = item.current_hash;
            document.getElementById('modalPrevHash').textContent = item.previous_hash;

            const grid = document.getElementById('modalFieldsGrid');
            grid.innerHTML = '';

            const payload = typeof item.payload === 'string' ? JSON.parse(item.payload) : item.payload;
            for (const [key, val] of Object.entries(payload)) {
                const box = document.createElement('div');
                box.className = 'p-2 bg-slate-50 border border-slate-200/70 rounded-xl';
                box.innerHTML = `
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">${key}</div>
                    <div class="font-semibold text-slate-800 text-xs mt-0.5 break-words">${val !== null ? val : '<span class="text-slate-300 italic">null</span>'}</div>
                `;
                grid.appendChild(box);
            }

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        function confirmRestore(id, tableName, recordId) {
            Swal.fire({
                title: 'Pulihkan Data Ini?',
                html: `Data dari tabel <strong>${tableName}</strong> dengan ID <strong>#${recordId}</strong> akan dikembalikan secara utuh ke Database 1.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d97706',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fa-solid fa-rotate-left mr-1.5"></i> Ya, Pulihkan Sekarang!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl p-6 font-sans',
                    title: 'text-base font-extrabold text-slate-800'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('restoreForm');
                    form.action = `/admin/recovery/${id}/restore`;
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
