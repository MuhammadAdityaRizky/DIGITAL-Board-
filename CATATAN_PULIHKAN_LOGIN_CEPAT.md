# PANDUAN MEMULIHKAN FITUR AKSES CEPAT (QUICK / DEMO LOGIN)

> **Catatan:** File ini dibuat sebagai catatan panduan agar fitur "Akses Cepat (Akun Resmi)" pada halaman Login dapat dipulihkan/dikembalikan kapan saja setelah hosting selesai atau saat diminta oleh pengguna.

---

## 1. Lokasi File yang Diubah

Fitur Akses Cepat melibatkan 2 file:
1. `routes/web.php` (Definisi Route)
2. `resources/views/auth/login.blade.php` (Tampilan UI Kartu Akses Cepat)

---

## 2. Cara Mengaktifkan / Memulihkan Kembali

### Langkah A: Aktifkan Route di `routes/web.php`
Buka file `routes/web.php` sekitar baris 14, ubah dari:
```php
// [TEMPORARY HIDE UNTUK HOSTING / PRODUCTION] Dinonaktifkan sementara untuk keamanan hosting
// Route::get('/demo-login/{role}', [AuthController::class, 'demoLogin'])->name('demo.login');
```
Menjadi aktif kembali:
```php
Route::get('/demo-login/{role}', [AuthController::class, 'demoLogin'])->name('demo.login');
```

---

### Langkah B: Munculkan Tampilan di `resources/views/auth/login.blade.php`
Buka file `resources/views/auth/login.blade.php` tepat di bawah tag penutup `</form>` (sekitar baris 215), hapus tanda pembuka comment `{{--` dan penutup `--}}`:

```blade
<!-- Divider QUICK LOGIN RESMI -->
<div class="relative flex py-3.5 items-center">
    <div class="flex-grow border-t border-slate-200"></div>
    <span class="flex-shrink mx-3 text-[10px] text-slate-400 uppercase tracking-widest font-extrabold">AKSES CEPAT (AKUN RESMI)</span>
    <div class="flex-grow border-t border-slate-200"></div>
</div>

<!-- Quick Real Accounts (3 Cards) -->
<div class="grid grid-cols-3 gap-2 sm:gap-3">
    <!-- Admin Button -->
    <a href="{{ route('demo.login', 'admin') }}" 
       class="demo-login-btn p-2.5 sm:p-3 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl sm:rounded-2xl text-center transition duration-200 group shadow-xs">
        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center mx-auto mb-1 group-hover:scale-110 transition transform">
            <i class="fa-solid fa-shield-halved text-xs"></i>
        </div>
        <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 block leading-tight">Admin</span>
        <span class="text-[9px] sm:text-[10px] text-slate-400 font-medium block mt-0.5">admin1</span>
    </a>

    <!-- Dosen Button -->
    <a href="{{ route('demo.login', 'dosen') }}" 
       class="demo-login-btn p-2.5 sm:p-3 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl sm:rounded-2xl text-center transition duration-200 group shadow-xs">
        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-1 group-hover:scale-110 transition transform">
            <i class="fa-solid fa-id-badge text-xs"></i>
        </div>
        <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 block leading-tight">Dosen</span>
        <span class="text-[9px] sm:text-[10px] text-slate-400 font-medium block mt-0.5">Anggra Triawan</span>
    </a>

    <!-- Mahasiswa Button -->
    <a href="{{ route('demo.login', 'mahasiswa') }}" 
       class="demo-login-btn p-2.5 sm:p-3 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl sm:rounded-2xl text-center transition duration-200 group shadow-xs">
        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center mx-auto mb-1 group-hover:scale-110 transition transform">
            <i class="fa-solid fa-graduation-cap text-xs"></i>
        </div>
        <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 block leading-tight">Mahasiswa</span>
        <span class="text-[9px] sm:text-[10px] text-slate-400 font-medium block mt-0.5">M. Irghi Alparizi</span>
    </a>
</div>
```

---

## 3. Catatan Controller Backend
Logika login cepat di backend berada di `app/Http/Controllers/AuthController.php` pada fungsi:
```php
public function demoLogin(string $role)
```
Fungsi controller tersebut **TIDAK DIHAPUS**, sehingga tetap aman dan siap dipanggil kapan pun route dan view-nya diaktifkan kembali.
