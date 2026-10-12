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
            <button type="button" onclick="closeScannerModal()" class="text-slate-400 hover:text-slate-600 text-lg cursor-pointer">&times;</button>
        </div>
        
        <div class="space-y-4">
            <div id="qr-reader" class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50" style="width: 100%; min-height: 250px;"></div>
            <div id="qr-reader-results" class="text-center text-xs text-slate-500 font-mono"></div>

            <!-- Fallback manual input inside modal for camera issues -->
            <div class="pt-3 border-t border-slate-100 space-y-2 text-left">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                    <i class="fa-solid fa-keyboard text-teal-800 mr-1"></i> Alternatif: Input Manual Token / ID Agenda
                </label>
                <div class="flex gap-2">
                    <input type="text" id="modal-dosen-manual-token-input" placeholder="Contoh: AGENDA_ID_1" 
                           class="flex-1 bg-slate-50 border border-slate-200 rounded-2xl px-3 py-2 text-xs uppercase font-bold tracking-widest text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 focus:bg-white">
                    <button type="button" onclick="submitDosenModalManualToken()" class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-2xl text-xs font-bold uppercase transition shadow-sm flex items-center gap-1.5 shrink-0 cursor-pointer">
                        <i class="fa-solid fa-paper-plane"></i> Kirim
                    </button>
                </div>
                <p class="text-xs text-slate-500 font-medium italic">Gunakan input ini jika kamera perangkat Anda bermasalah atau tidak dapat dibuka.</p>
            </div>
        </div>
        
        <div class="flex pt-3 border-t border-slate-100">
            <button type="button" onclick="closeScannerModal()" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold text-xs cursor-pointer">Tutup</button>
        </div>
    </div>
</div>

<!-- html5-qrcode script (load once if not present) -->
<script>
    if (typeof Html5Qrcode === 'undefined') {
        const script = document.createElement('script');
        script.src = "https://unpkg.com/html5-qrcode";
        script.type = "text/javascript";
        document.head.appendChild(script);
    }
</script>

<script>
    if (typeof window.html5QrcodeScanner === 'undefined') {
        window.html5QrcodeScanner = null;
    }

    function startDosenQRScanner() {
        const modal = document.getElementById('modal-qr-scanner');
        if (!modal) return;
        modal.classList.remove('hidden');

        if (typeof Html5Qrcode === 'undefined') {
            setTimeout(startDosenQRScanner, 300);
            return;
        }
        
        window.html5QrcodeScanner = new Html5Qrcode("qr-reader");
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
                
                window.html5QrcodeScanner.start(
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
                    alert("Gagal mengakses kamera. Silakan gunakan Alternatif Input Manual di bawah.");
                });
            } else {
                window.html5QrcodeScanner.start(
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
                    alert("Gagal mengakses kamera. Silakan gunakan Alternatif Input Manual di bawah.");
                });
            }
        }).catch(err => {
            console.error("Gagal getCameras: ", err);
            window.html5QrcodeScanner.start(
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
                alert("Gagal mengakses kamera. Silakan gunakan Alternatif Input Manual di bawah.");
            });
        });
    }

    function closeScannerModal() {
        const modal = document.getElementById('modal-qr-scanner');
        if (modal) modal.classList.add('hidden');
        if (window.html5QrcodeScanner) {
            window.html5QrcodeScanner.stop().then(() => {
                window.html5QrcodeScanner = null;
            }).catch(err => {
                console.error("Gagal menghentikan scanner: ", err);
            });
        }
    }

    function submitDosenModalManualToken() {
        const input = document.getElementById('modal-dosen-manual-token-input');
        const val = input ? input.value.trim() : '';
        if (!val) {
            alert('Silakan masukkan Kode Token / ID Agenda terlebih dahulu.');
            return;
        }
        document.getElementById('dosen-qr-token-input').value = val;
        document.getElementById('dosen-absensi-form').submit();
        closeScannerModal();
    }
</script>
