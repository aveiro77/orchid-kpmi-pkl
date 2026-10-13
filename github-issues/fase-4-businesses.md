## Fase 4 — Businesses (Modul 4)

### Tujuan
Anggota bisa mendata usaha miliknya (bisa lebih dari satu), riwayat usaha tetap tersimpan walau non-aktif, dan publik bisa menelusuri direktori usaha.

### Tugas

**Migration & Model**
- [ ] Migration `business_categories` (id, nama, slug) — master data kategori usaha
- [ ] Migration `businesses` (id, user_id FK, business_category_id FK, nama_usaha, deskripsi, alamat, website, status enum(aktif,non_aktif), soft delete)
- [ ] Model `BusinessCategory` (`businesses(): HasMany`), `Business` (`user(): BelongsTo`, `category(): BelongsTo`)

**Seeder**
- [ ] Seed `business_categories`: Kuliner, Fashion Muslim, Perdagangan/Retail, Jasa & Konsultasi, Teknologi & Digital, Pendidikan & Pelatihan, Kesehatan & Kecantikan, Keuangan Syariah, Pertanian & Perikanan, Konstruksi & Properti, Otomotif (sesuaikan dengan masukan Pengurus KPMI Pekalongan)

**Panel Orchid**
- [ ] Screen anggota `Business/MyBusinessScreen.php` — CRUD usaha milik sendiri, scope `Auth::id()`, tanpa permission
- [ ] Screen admin `Business/BusinessListScreen.php` — lihat semua usaha, `->permission()`
- [ ] Screen admin `BusinessCategory/BusinessCategoryListScreen.php` — CRUD master kategori, `->permission()`

**Public Area**
- [ ] `Controllers/Public/BusinessDirectoryController.php` + view index/show — direktori usaha (status `aktif` saja), filter kategori & status

### Definition of Done
- Anggota bisa tambah/edit usaha miliknya, nonaktifkan usaha (status → non_aktif) tanpa data hilang (soft delete hanya untuk hapus permanen, bukan nonaktifkan — pastikan tombol "nonaktifkan" ≠ tombol "hapus")
- Direktori usaha publik menampilkan usaha aktif, filter kategori & status berfungsi

---
### Konvensi proyek (wajib dibaca sebelum mulai)
- Stack: Laravel 13 + MariaDB + Orchid Platform (`orchid/platform` ^14.53+) + Eloquent.
- **Admin Area & Member Area = satu Panel Orchid** (Screens), dibedakan lewat Role & Permission.
  Screen admin-only wajib dipasangi `->permission('platform.xxx')`. Screen self-service (data
  milik anggota sendiri) TIDAK pakai permission, cukup di-scope query ke `Auth::id()`.
- **Public Area** (bisa diakses tanpa login) = Laravel MVC standar: Route Group, Resource
  Controller, Blade + Bootstrap 5. Sesuai UI Requirement, Public Area HANYA: Homepage,
  Direktori Anggota, Direktori Usaha, Event Publik, Detail Anggota, Detail Usaha (+ halaman
  Registrasi). Modul lain (Peluang, Referral) tidak ada versi publiknya.
- Login/logout HANYA lewat Orchid (`/{prefix}/login`, prefix diatur di `config/platform.php`).
  Jangan bikin route login/logout baru.
- Role sistem: Administrator, Pengurus, Anggota (`Orchid\Platform\Models\Role`, di-seed lewat
  `database/seeders/RoleSeeder.php`).
- Nama tabel/kolom pakai Bahasa Indonesia sesuai dokumen kebutuhan asli (mis. `nama_lengkap`,
  `status_aktif`, `tanggal_expired`, `nilai_estimasi`).
- Repository Pattern HANYA dipakai untuk Dashboard & Search/Filter lintas modul. Modul CRUD
  sederhana lainnya cukup Service Layer + Eloquent langsung (hindari over-engineering).
- Soft Delete wajib di: `users`, `businesses`, `opportunities`, `referrals`, `events`.
- Upload file (foto profil, dll.) pakai **Orchid Attachment** bawaan, jangan bikin disk/upload
  custom.
- Dokumen acuan lengkap (ERD, struktur folder, daftar migration, daftar model & relasi):
  [`docs/ARCHITECTURE.md`](../../blob/main/docs/ARCHITECTURE.md) di repo ini — baca dulu sebelum
  membuat migration/model baru supaya penamaan & relasi konsisten.
- Kalau kamu AI coding agent: buka PR terpisah per issue, jangan gabung beberapa fase dalam satu
  PR, dan jalankan `php artisan migrate` + tes manual alur yang relevan sebelum minta review.
