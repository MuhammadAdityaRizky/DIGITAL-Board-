<?php

namespace App\Http\Controllers;

use App\Models\DokumenPropertiLab;
use App\Models\Fakultas;
use App\Models\ItemPropertiLab;
use App\Models\KategoriProperti;
use App\Models\Laboratorium;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertiLabController extends Controller
{
    /**
     * Titik Masuk Utama Menu Sidebar "Properti Lab"
     * - Super Admin: Masuk ke Layout 1 (Kumpulan Fakultas)
     * - Admin Fakultas: Langsung bypass ke Layout 2 (Kumpulan Lab milik fakultasnya)
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            $fakultas = Fakultas::withCount(['prodi'])->get()->map(function ($f) {
                $f->total_lab = Laboratorium::where('fakultas_id', $f->id)->count();
                return $f;
            });

            return view('admin.properti.layout1_fakultas', compact('fakultas'));
        }

        if ($user->isAdminFakultas()) {
            if (!$user->fakultas_id) {
                return redirect()->route('admin.dashboard')->with('error', 'Akun Admin Fakultas belum terhubung dengan fakultas manapun.');
            }
            return redirect()->route('admin.properti.fakultas', ['fakultasId' => $user->fakultas_id]);
        }

        abort(403, 'Akses tidak diizinkan.');
    }

    /**
     * Layout 2: Kumpulan Lab di Fakultas Tertentu
     */
    public function fakultas($fakultasId)
    {
        $user = auth()->user();

        if ($user->isAdminFakultas() && (int)$user->fakultas_id !== (int)$fakultasId) {
            abort(403, 'Anda tidak memiliki hak akses ke fakultas ini.');
        }

        $fakultas = Fakultas::findOrFail($fakultasId);
        $labs = Laboratorium::where('fakultas_id', $fakultasId)
            ->withCount('dokumenProperti')
            ->get();

        return view('admin.properti.layout2_lab', compact('fakultas', 'labs', 'user'));
    }

    /**
     * Layout 3: Dokumen Lab (Daftar dokumen pendataan inventaris)
     */
    public function lab($labId)
    {
        $user = auth()->user();
        $lab = Laboratorium::with('fakultas')->findOrFail($labId);

        if (!$user->canManageLab($lab)) {
            abort(403, 'Anda tidak memiliki hak akses ke laboratorium ini.');
        }

        $dokumenList = DokumenPropertiLab::where('lab_id', $labId)
            ->withCount('items')
            ->with('creator')
            ->latest('tanggal_pendataan')
            ->get();

        return view('admin.properti.layout3_dokumen', compact('lab', 'dokumenList', 'user'));
    }

    /**
     * Simpan Dokumen Baru pada Layout 3
     */
    public function storeDokumen(Request $request, $labId)
    {
        $user = auth()->user();
        $lab = Laboratorium::findOrFail($labId);

        if (!$user->canManageLab($lab)) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:150',
            'nomor_dokumen' => 'required|string|max:50',
            'nomor_revisi' => 'required|string|max:20',
            'tanggal_pendataan' => 'required|date',
        ]);

        $dokumen = DokumenPropertiLab::create([
            'lab_id' => $lab->id,
            'nama_dokumen' => $validated['nama_dokumen'],
            'nomor_dokumen' => $validated['nomor_dokumen'],
            'nomor_revisi' => $validated['nomor_revisi'],
            'tanggal_pendataan' => $validated['tanggal_pendataan'],
            'created_by' => $user->id,
        ]);

        return redirect()->route('admin.properti.dokumen.show', ['dokumenId' => $dokumen->id])
            ->with('success', 'Dokumen inventaris berhasil dibuat. Silakan tambahkan data properti.');
    }

    /**
     * Hapus Dokumen Inventaris
     */
    public function destroyDokumen($dokumenId)
    {
        $dokumen = DokumenPropertiLab::with('laboratorium')->findOrFail($dokumenId);
        $user = auth()->user();

        if (!$user->canManageLab($dokumen->laboratorium)) {
            abort(403, 'Akses ditolak.');
        }

        $labId = $dokumen->lab_id;
        $dokumen->delete();

        return redirect()->route('admin.properti.lab', ['labId' => $labId])
            ->with('success', 'Dokumen dan seluruh itemnya berhasil dihapus.');
    }

    /**
     * Layout 3/1: Kumpulan Kategori & Sub Kategori (CRUD)
     */
    public function kategoriIndex(Request $request)
    {
        $tab = $request->get('tab', 'semua'); // 'semua', 'kategori', 'sub_kategori'

        $query = KategoriProperti::with('parent');

        if ($tab === 'kategori') {
            $query->where('jenis', 'kategori');
        } elseif ($tab === 'sub_kategori') {
            $query->where('jenis', 'sub_kategori');
        }

        $categories = $query->orderBy('jenis', 'asc')->orderBy('nama', 'asc')->get();

        return view('admin.properti.layout3_1_kategori', compact('categories', 'tab'));
    }

    /**
     * Layout 3/1/1: Form Tambah Kategori / Sub Kategori
     */
    public function kategoriCreate()
    {
        $parentCategories = KategoriProperti::where('jenis', 'kategori')->orderBy('nama', 'asc')->get();
        return view('admin.properti.layout3_1_1_kategori_form', [
            'kategori' => new KategoriProperti(),
            'parentCategories' => $parentCategories,
            'isEdit' => false,
        ]);
    }

    /**
     * Simpan Kategori / Sub Kategori
     */
    public function kategoriStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'nullable|string|max:20',
            'jenis' => 'required|in:kategori,sub_kategori',
            'parent_id' => 'nullable|exists:kategori_properti,id',
        ]);

        if ($validated['jenis'] === 'kategori') {
            $validated['parent_id'] = null;
        }

        KategoriProperti::create($validated);

        return redirect()->route('admin.properti.kategori.index')
            ->with('success', 'Kategori/Sub Kategori berhasil ditambahkan.');
    }

    /**
     * Layout 3/1/1: Form Edit Kategori / Sub Kategori
     */
    public function kategoriEdit($id)
    {
        $kategori = KategoriProperti::findOrFail($id);
        $parentCategories = KategoriProperti::where('jenis', 'kategori')
            ->where('id', '!=', $id)
            ->orderBy('nama', 'asc')
            ->get();

        return view('admin.properti.layout3_1_1_kategori_form', [
            'kategori' => $kategori,
            'parentCategories' => $parentCategories,
            'isEdit' => true,
        ]);
    }

    /**
     * Update Kategori / Sub Kategori
     */
    public function kategoriUpdate(Request $request, $id)
    {
        $kategori = KategoriProperti::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'nullable|string|max:20',
            'jenis' => 'required|in:kategori,sub_kategori',
            'parent_id' => 'nullable|exists:kategori_properti,id',
        ]);

        if ($validated['jenis'] === 'kategori') {
            $validated['parent_id'] = null;
        }

        $kategori->update($validated);

        return redirect()->route('admin.properti.kategori.index')
            ->with('success', 'Kategori/Sub Kategori berhasil diperbarui.');
    }

    /**
     * Hapus Kategori / Sub Kategori
     */
    public function kategoriDestroy($id)
    {
        $kategori = KategoriProperti::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.properti.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Layout 4: Tampilan Dokumen Fisik UIKA (FT-SPR-INS-F-01)
     * - Header Lembar Dokumen
     * - Ringkasan Total Barang (Summary Units)
     * - Form Tambah Data Properti (Auto-fill Nomor & Ruang)
     * - Tabel 11 Kolom dengan Inline Editing
     */
    public function dokumenShow($dokumenId)
    {
        $user = auth()->user();
        $dokumen = DokumenPropertiLab::with([
            'laboratorium.fakultas',
            'creator',
            'items.kategori',
            'items.subKategori'
        ])->findOrFail($dokumenId);

        if (!$user->canManageLab($dokumen->laboratorium)) {
            abort(403, 'Akses ditolak ke laboratorium ini.');
        }

        $items = $dokumen->items;

        // Hitung Ringkasan Total Barang
        // Format: Nama / Kode Barang -> Total Unit
        $summary = [];
        $totalKeseluruhan = $items->count();

        foreach ($items as $item) {
            $key = $item->nama_properti;
            $kode = $item->kategori?->kode ?: ($item->subKategori?->kode ?: '');
            $displayKey = $key . ($kode ? " ({$kode})" : '');
            if (!empty($item->merk_type)) {
                $displayKey .= " " . $item->merk_type;
            }

            if (!isset($summary[$displayKey])) {
                $summary[$displayKey] = 0;
            }
            $summary[$displayKey]++;
        }

        // Master Kategori & Sub Kategori untuk Form & Inline Dropdown
        $kategoriList = KategoriProperti::where('jenis', 'kategori')->orderBy('nama', 'asc')->get();
        $subKategoriList = KategoriProperti::where('jenis', 'sub_kategori')->orderBy('nama', 'asc')->get();

        // Rekomendasi Nomor Inventaris Awal (Auto-generate)
        $defaultNomor = $this->buildAssetNumber($dokumen, null, null, 'PC');
        $defaultRuang = $this->extractRuangNumber($dokumen->laboratorium);

        return view('admin.properti.layout4_detail', compact(
            'dokumen',
            'items',
            'summary',
            'totalKeseluruhan',
            'kategoriList',
            'subKategoriList',
            'defaultNomor',
            'defaultRuang',
            'user'
        ));
    }

    /**
     * Helper AJAX: Generate Kode Nomor Inventaris Otomatis
     * Format: [KODE_BARANG]/[PRODI]/[RUANG]/[BULAN]/[TAHUN]/[NOMOR_URUT]
     * Contoh: PC/SI/209/10/26/16
     */
    public function generateKode(Request $request, $dokumenId)
    {
        $dokumen = DokumenPropertiLab::with('laboratorium.fakultas')->findOrFail($dokumenId);
        $kategoriId = $request->get('kategori_id');
        $subKategoriId = $request->get('sub_kategori_id');
        $namaProperti = $request->get('nama_properti');

        $kode = $this->buildAssetNumber($dokumen, $kategoriId, $subKategoriId, $namaProperti);
        $ruang = $this->extractRuangNumber($dokumen->laboratorium);

        return response()->json([
            'status' => 'success',
            'nomor' => $kode,
            'ruang' => $ruang,
        ]);
    }

    /**
     * Simpan Data Item Properti Baru (via Form Tambah Data Properti)
     */
    public function itemStore(Request $request, $dokumenId)
    {
        $dokumen = DokumenPropertiLab::with('laboratorium')->findOrFail($dokumenId);
        $user = auth()->user();

        if (!$user->canManageLab($dokumen->laboratorium)) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'kategori_id' => 'nullable|exists:kategori_properti,id',
            'sub_kategori_id' => 'nullable|exists:kategori_properti,id',
            'nama_properti' => 'required|string|max:150',
            'merk_type' => 'nullable|string|max:150',
            'nomor_inventaris' => 'nullable|string|max:100',
            'ruang' => 'nullable|string|max:100',
            'harga' => 'nullable|numeric|min:0',
            'tahun' => 'nullable|string|max:10',
            'kondisi' => 'required|in:baik,sedang,rusak',
            'frekuensi_pemeliharaan' => 'nullable|string|max:50',
        ]);

        // Auto-fill jika kosong
        if (empty($validated['ruang'])) {
            $validated['ruang'] = $this->extractRuangNumber($dokumen->laboratorium);
        }

        if (empty($validated['nomor_inventaris'])) {
            $validated['nomor_inventaris'] = $this->buildAssetNumber(
                $dokumen,
                $validated['kategori_id'] ?? null,
                $validated['sub_kategori_id'] ?? null,
                $validated['nama_properti']
            );
        }

        $maxUrutan = ItemPropertiLab::where('dokumen_id', $dokumenId)->max('urutan') ?? 0;
        $validated['dokumen_id'] = $dokumenId;
        $validated['urutan'] = $maxUrutan + 1;
        $validated['harga'] = $validated['harga'] ?? 0;

        ItemPropertiLab::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data properti berhasil ditambahkan.'
            ]);
        }

        return redirect()->route('admin.properti.dokumen.show', ['dokumenId' => $dokumenId])
            ->with('success', 'Data properti berhasil ditambahkan ke dokumen.');
    }

    /**
     * Ubah Langsung (Inline Editing) Item Properti via AJAX
     */
    public function itemInlineUpdate(Request $request, $itemId)
    {
        $item = ItemPropertiLab::with('dokumen.laboratorium')->findOrFail($itemId);
        $user = auth()->user();

        if (!$user->canManageLab($item->dokumen->laboratorium)) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak.'], 403);
        }

        $field = $request->input('field');
        $value = $request->input('value');

        $allowedFields = [
            'kategori_id',
            'sub_kategori_id',
            'nama_properti',
            'merk_type',
            'nomor_inventaris',
            'ruang',
            'harga',
            'tahun',
            'kondisi',
            'frekuensi_pemeliharaan',
        ];

        if (!in_array($field, $allowedFields)) {
            return response()->json(['status' => 'error', 'message' => 'Kolom tidak valid.'], 422);
        }

        if ($field === 'harga') {
            $value = preg_replace('/[^0-9.]/', '', $value);
            $value = $value === '' ? 0 : (float)$value;
        }

        if ($field === 'kondisi' && !in_array($value, ['baik', 'sedang', 'rusak'])) {
            return response()->json(['status' => 'error', 'message' => 'Nilai kondisi harus baik, sedang, atau rusak.'], 422);
        }

        $item->update([$field => $value]);

        return response()->json([
            'status' => 'success',
            'message' => 'Perubahan berhasil disimpan.',
            'item' => $item->fresh(['kategori', 'subKategori']),
        ]);
    }

    /**
     * Hapus Item Properti
     */
    public function itemDestroy($itemId)
    {
        $item = ItemPropertiLab::with('dokumen.laboratorium')->findOrFail($itemId);
        $user = auth()->user();

        if (!$user->canManageLab($item->dokumen->laboratorium)) {
            abort(403, 'Akses ditolak.');
        }

        $dokumenId = $item->dokumen_id;
        $item->delete();

        if (request()->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Item berhasil dihapus.']);
        }

        return redirect()->route('admin.properti.dokumen.show', ['dokumenId' => $dokumenId])
            ->with('success', 'Baris properti berhasil dihapus.');
    }

    // -------------------------------------------------------------
    // Private Helpers
    // -------------------------------------------------------------

    /**
     * Bangun Kode Penomoran Barang UIKA:
     * [KODE_BARANG]/[PRODI]/[RUANG]/[BULAN]/[TAHUN]/[NOMOR_URUT]
     * Contoh: PC/SI/209/10/26/16
     */
    private function buildAssetNumber($dokumen, $kategoriId = null, $subKategoriId = null, $namaProperti = null)
    {
        // 1. Kode Barang
        $kodeBarang = 'BRG';
        if ($kategoriId) {
            $cat = KategoriProperti::find($kategoriId);
            if ($cat && !empty($cat->kode)) {
                $kodeBarang = strtoupper(trim($cat->kode));
            }
        }
        if ($kodeBarang === 'BRG' && $subKategoriId) {
            $sub = KategoriProperti::find($subKategoriId);
            if ($sub && !empty($sub->kode)) {
                $kodeBarang = strtoupper(trim($sub->kode));
            }
        }
        if ($kodeBarang === 'BRG' && $namaProperti) {
            $namaLower = strtolower($namaProperti);
            if (str_contains($namaLower, 'komputer') || str_contains($namaLower, 'pc')) $kodeBarang = 'PC';
            elseif (str_contains($namaLower, 'kursi')) $kodeBarang = 'K';
            elseif (str_contains($namaLower, 'meja dosen')) $kodeBarang = 'MD';
            elseif (str_contains($namaLower, 'meja')) $kodeBarang = 'M';
            elseif (str_contains($namaLower, 'printer')) $kodeBarang = 'PR';
            elseif (str_contains($namaLower, 'papan') || str_contains($namaLower, 'whiteboard')) $kodeBarang = 'PT';
            elseif (str_contains($namaLower, 'cctv') || str_contains($namaLower, 'kamera')) $kodeBarang = 'C';
            elseif (str_contains($namaLower, 'ac') || str_contains($namaLower, 'conditioner')) $kodeBarang = 'AC';
            else {
                $words = explode(' ', trim($namaProperti));
                $kodeBarang = strtoupper(substr($words[0], 0, 2));
            }
        }

        // 2. Kode Prodi / Unit
        $kodeProdi = 'SI';
        if ($dokumen->laboratorium && $dokumen->laboratorium->fakultas) {
            $namaFak = strtolower($dokumen->laboratorium->fakultas->nama_fakultas);
            if (str_contains($namaFak, 'teknik') || str_contains($namaFak, 'sains')) {
                $kodeProdi = 'SI'; // atau TI / FT
            } elseif (str_contains($namaFak, 'ekonomi')) {
                $kodeProdi = 'MN';
            } elseif (str_contains($namaFak, 'agama')) {
                $kodeProdi = 'PAI';
            } else {
                $kodeProdi = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $dokumen->laboratorium->fakultas->nama_fakultas), 0, 2));
            }
        }

        // 3. Nomor Ruang Lab (misal 209)
        $ruang = $this->extractRuangNumber($dokumen->laboratorium);

        // 4. Bulan & Tahun Pendataan (2 digit bulan, 2 digit tahun)
        $tanggal = $dokumen->tanggal_pendataan ? Carbon::parse($dokumen->tanggal_pendataan) : now();
        $bulan = $tanggal->format('m');
        $tahun = $tanggal->format('y');

        // 5. Nomor Urut Barang sejenis di dokumen ini
        $countExisting = ItemPropertiLab::where('dokumen_id', $dokumen->id)
            ->where(function ($q) use ($kategoriId, $namaProperti) {
                if ($kategoriId) {
                    $q->where('kategori_id', $kategoriId);
                } elseif ($namaProperti) {
                    $q->where('nama_properti', $namaProperti);
                }
            })->count();
        $noUrut = str_pad($countExisting + 1, 2, '0', STR_PAD_LEFT);

        return "{$kodeBarang}/{$kodeProdi}/{$ruang}/{$bulan}/{$tahun}/{$noUrut}";
    }

    /**
     * Ekstrak nomor atau nama ruangan lab (contoh: 209 dari Lab Komputer Bersama (209))
     */
    private function extractRuangNumber($lab)
    {
        if (!$lab) return 'LAB';

        // Cari pola angka dalam nama lab atau lokasi, misal "209"
        if (preg_match('/(\d{3,4})/', $lab->nama_lab . ' ' . $lab->lokasi, $matches)) {
            return $matches[1];
        }

        return trim($lab->nama_lab);
    }
}

