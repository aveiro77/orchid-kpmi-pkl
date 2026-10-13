## Fase 5 — Opportunities Board (Modul 5)

### Tujuan
Papan peluang bisnis (Need/Offer/Collaborate) — **modul ini murni di dalam Panel Orchid, tidak ada versi publik** (lihat daftar halaman Public di konvensi di bawah).

### Tugas

**Migration & Model**
- [ ] Migration `opportunities` (id, user_id FK, tipe enum(need,offer,collaborate), judul, deskripsi, lokasi, tanggal_expired, status enum(draft,published,closed), soft delete)
- [ ] Model `Opportunity` (`user(): BelongsTo`)

**Panel Orchid**
- [ ] Screen anggota `Opportunity/MyOpportunityScreen.php` — CRUD peluang milik sendiri ("Peluang Saya"), scope `Auth::id()`
- [ ] Screen admin/pengurus `Opportunity/OpportunityListScreen.php` — lihat & moderasi semua peluang, `->permission()` khusus Pengurus+Administrator (sesuai dokumen: Pengurus boleh "posting peluang" dan kelola data terkait)
- [ ] Filter di kedua Screen: tipe (Need/Offer/Collaborate), status

### Nice to have (opsional, boleh issue terpisah)
- [ ] Scheduled command harian yang otomatis mengubah status jadi `closed` untuk opportunity yang `tanggal_expired`-nya sudah lewat

### Definition of Done
- Anggota bisa buat/ubah/hapus peluang miliknya, ganti status draft→published→closed
- Pengurus/Administrator bisa melihat & memoderasi semua peluang lewat Screen terpisah

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
