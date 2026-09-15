# Design System — Digital Board (Smart Lab Management)

Dokumen ini adalah panduan desain umum untuk seluruh aplikasi Digital Board (Dashboard, Agenda Perkuliahan, Ketersediaan Lab, Pengaturan Akun, dan halaman lain yang akan dibuat setelahnya). Tujuannya: memastikan setiap halaman baru — dibuat oleh siapa pun, termasuk AI — konsisten dengan identitas visual yang sama, dan tidak jatuh ke pola generik "hasil AI" yang gampang ditebak.

Berlaku untuk **semua halaman**, bukan cuma satu fitur tertentu. Kalau menambah halaman baru, cek dulu ke dokumen ini sebelum menentukan warna/komponen sendiri.

---

## 1. Kenapa dokumen ini dibuat

Desain awal aplikasi ini (lihat referensi lama) punya banyak pola yang gampang dikenali sebagai "template AI generic":

- **Gradient teal/emerald** di logo, sidebar aktif, tombol utama, badge.
- **Semua kartu punya radius & shadow yang sama** tanpa hierarki — mata kuliah, sesi, badge, tombol semua dibulatkan seragam, jadi semua terasa "setara pentingnya" padahal tidak.
- **Badge status ALL CAPS berwarna pastel** (`SELESAI`, `MENDATANG`, `BENTROK RUANGAN!`).
- **Ikon dalam kotak bulat gradient** di kiri tiap card — dekoratif, tidak menambah informasi.
- **Meta-info dipisah titik tengah** (`Lab 209 · Sistem Informasi · Program Reguler`).
- **Label field huruf kapital semua** (`CARI SESI`, `TANGGAL PELAKSANAAN`).
- **Tombol warna-warni tanpa sistem**: hijau, kuning, biru, hitam, teal berdampingan tanpa aturan, kesannya "demo app", bukan produk matang.

Panduan ini menata ulang dari nol berangkat dari konteks nyata produk: **alat kerja administratif kampus**, dipakai dosen/staf tiap hari, seringkali cepat dan sambil multitasking — bukan aplikasi konsumen yang butuh kesan "menarik" secara marketing.

---

## 2. Prinsip inti (berlaku di semua halaman)

1. **Status adalah data, bukan dekorasi.** Penanda status (selesai/bentrok/pending/aktif) harus bisa dipindai cepat, tapi lewat bentuk + kata sederhana — bukan pil warna pastel ALL CAPS.
2. **Hierarki lewat tipografi & spacing, bukan lewat card-di-dalam-card.** Judul > sub info > metadata dibedakan lewat ukuran/berat huruf, bukan border dan shadow bertumpuk-tumpuk.
3. **Satu warna aksen, dipakai hemat.** Bukan gradient, bukan warna semantik acak per tombol.
4. **Kepadatan informasi tinggi tapi rapi** — ini dashboard kerja, orang scan banyak baris data, bukan landing page yang butuh whitespace dramatis.
5. **Konsisten lintas halaman.** Komponen (tombol, badge, tabel, form) yang sama harus terlihat sama persis di semua halaman — Dashboard, Agenda, Ketersediaan Lab, Pengaturan, dst.

---

## 3. Token desain (berlaku global)

### Warna

| Nama | Hex | Peran |
|---|---|---|
| `ink` | `#1C1B1A` | Teks utama — hitam hangat, bukan `#0B0B0B` template |
| `paper` | `#FAFAF8` | Latar utama aplikasi |
| `paper-raised` | `#FFFFFF` | Permukaan panel/tabel di atas `paper` |
| `line` | `#E4E1DA` | Semua garis pembatas & border tipis |
| `slate` | `#6B675F` | Teks sekunder, metadata, placeholder |
| `signal` | `#C4551C` | **Satu-satunya warna aksen aplikasi** — oranye bata gelap. Dipakai untuk aksi utama, item navigasi aktif, penekanan |
| `alert` | `#B3261E` | Khusus kondisi butuh perhatian: bentrok jadwal, error, peringatan |
| `done` | `#3A5F45` | Status selesai/berhasil — hijau tua muram, bukan hijau stabilo |

Tidak ada gradient di mana pun dalam aplikasi. Tidak ada warna pastel untuk badge/status.

### Tipografi

- **Display/heading:** *Fraunces* (serif berkarakter, sedikit oldstyle). Dipakai untuk judul halaman dan nama entitas utama (nama mata kuliah, nama lab, nama dokumen) — memberi rasa "dokumen institusional", bukan "app konsumen".
- **Body/UI:** *Inter* — untuk semua teks fungsional: tabel, form, tombol, navigasi.
- Skala: 13 / 15 / 18 / 24 / 32px. Line-height 1.4–1.5 untuk body, 1.15 untuk heading.
- **Tidak ada label ALL CAPS.** Semua label field dan status ditulis sentence case (`Cari agenda`, `Tanggal pelaksanaan`, `Selesai`, `Bentrok ruangan`).
- Status ditandai lewat **bentuk kecil (titik/segitiga/garis)** + kata biasa — bukan pil ALL CAPS.

### Layout & komponen umum

- **Navigasi sidebar:** teks + ikon garis tipis monokrom (bukan solid berwarna). Item aktif ditandai garis vertikal kiri warna `signal`, bukan blok solid penuh warna.
- **Daftar data** (agenda, jadwal lab, riwayat apa pun): default ke struktur **baris bertingkat mirip tabel/daftar**, dipisah garis horizontal tipis `line` — bukan tumpukan card seragam dengan shadow. Card penuh hanya dipakai untuk objek yang benar-benar berdiri sendiri (misal: satu ringkasan statistik), bukan untuk tiap baris data.
- **Ikon:** dipakai seminimal mungkin, monokrom mengikuti `ink`/`slate`. Hindari ikon dalam kotak bulat/rounded-square berwarna sebagai penanda dekoratif di tiap card.
- **Tombol** — sistem 3 tingkat, konsisten di semua halaman:
  - Primer (maksimal 1 per konteks/section): latar `signal`, teks putih.
  - Sekunder: outline `ink`, latar transparan.
  - Tersier/ikon: teks `slate`, tanpa latar (edit, hapus, aksi kecil).
- **Badge status:** bentuk kecil + kata, bukan pil warna pastel:
  - *Selesai* → titik bulat `done` + teks
  - *Pending/mendatang* → titik outline + teks
  - *Butuh perhatian/bentrok/error* → segitiga kecil `alert` + teks
- **Filter/pencarian:** satu baris toolbar tipis menyatu dengan konten, bukan panel putih besar terpisah berbingkai tebal.
- **Peringatan/notice inline** (misal bentrok jadwal, validasi gagal): blok dengan garis kiri tebal `alert`, menyatu dengan konten terkait — bukan kotak mengambang terpisah dengan tombol berbentuk pil.

---

## 4. Yang sengaja dihindari di seluruh aplikasi

- Gradient apa pun (logo, tombol, background, badge)
- Badge pil warna pastel ALL CAPS
- Ikon dalam kotak bulat/rounded-square berwarna sebagai hiasan tiap card
- Shadow abu-abu lembut yang sama di bawah semua elemen tanpa alasan hierarki
- Label field huruf kapital semua
- Meta-info dengan pemisah titik tengah (`A · B · C`) yang berulang di semua tempat
- Radius sudut seragam di semua elemen tanpa alasan
- Warna tombol semantik acak (hijau/kuning/biru/hitam/teal berdampingan tanpa sistem)
- Eyebrow label tracked-out di atas tiap section
- Emoji atau ikon sebagai pengganti kata di badge status

## 5. Ciri khas visual aplikasi ini

- Serif *Fraunces* untuk judul dan nama entitas — kesan dokumen institusional/akademik
- Aksen tunggal oranye bata (`#C4551C`), dipakai hemat, bukan teal/biru korporat generik
- Struktur daftar/tabel bertingkat sebagai default, bukan grid kartu
- Penanda status berbentuk ikon kecil + kata, bukan pil warna
- Garis tipis sebagai satu-satunya pemisah antar-blok konten, minim shadow

---

## 6. Contoh penerapan: halaman Agenda Perkuliahan

Ini contoh bagaimana prinsip di atas diterapkan pada satu halaman (Riwayat Agenda Perkuliahan), sebagai referensi saat membuat halaman lain.

```
┌─────────────────────────────────────────────────┐
│ Riwayat Agenda Perkuliahan          [Anggra T.] │  ← header tipis, tanpa gradient
├───────────┬─────────────────────────────────────┤
│           │  Cari & filter — toolbar tipis        │
│  Sidebar  │  menyatu dengan konten                │
│  teks +   ├─────────────────────────────────────┤
│  ikon     │  Praktikum Dasar Bahasa Pemrograman  │  ← judul serif besar,
│  garis    │  Kelas A · Semester 1                 │     bukan card
│  tipis    │  ─────────────────────────────────── │
│           │  01  12 Sep 2026   ● Selesai          │  ← baris, bukan card bulat
│           │      12:39–14:00 · Lab 209 · 0 hadir  │
│           │  ─────────────────────────────────── │
│           │  02  03 Oct 2026   ▲ Bentrok ruangan  │  ← bentuk beda utk status kritis
│           │      08:00–11:00 · Lab 209             │
└───────────┴─────────────────────────────────────┘
```

Nomor sesi (01, 02) di sini valid karena memang urutan pertemuan kuliah asli — beda dengan pola dekoratif 01/02/03 yang generik tanpa makna sequence.

Halaman lain (Ketersediaan Lab, Pengaturan Akun, dsb.) mengikuti token dan komponen yang sama di atas — hanya konten dan layout spesifik yang menyesuaikan kebutuhan halaman tersebut.