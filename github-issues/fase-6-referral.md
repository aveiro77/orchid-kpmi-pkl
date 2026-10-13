## Fase 6 — Referral (Modul 6)

### Tujuan
Mencatat referral bisnis antar anggota (siapa mereferensikan siapa, ke klien/proyek apa) — **modul ini di dalam Panel Orchid, tidak ada versi publik**.

### Tugas

**Migration & Model**
- [ ] Migration `referrals` (id, pemberi_referral_id FK→users, penerima_referral_id FK→users, client_name, project_name, nilai_estimasi decimal(15,2), status enum(introduced,follow_up,negotiation,won,lost), catatan, soft delete)
- [ ] Model `Referral` — `pemberi(): BelongsTo(User::class,'pemberi_referral_id')`, `penerima(): BelongsTo(User::class,'penerima_referral_id')`

**Panel Orchid**
- [ ] Screen anggota `Referral/MyReferralScreen.php` — hanya tampilkan referral di mana `Auth::id()` adalah pemberi ATAU penerima; anggota boleh buat referral baru (pilih penerima dari anggota lain), update status
- [ ] Screen admin `Referral/ReferralListScreen.php` — lihat semua referral (untuk laporan/statistik komunitas), `->permission()`

### Perhatian privasi
`nilai_estimasi` dan `catatan` berpotensi sensitif — pastikan Screen anggota benar-benar di-scope, jangan sampai anggota lain bisa lihat referral yang tidak melibatkan dirinya.

### Definition of Done
- Anggota bisa mencatat referral yang mereka berikan, penerima referral bisa update status & lihat catatan
- Anggota tidak bisa mengakses referral yang tidak melibatkan dirinya
- Admin bisa lihat seluruh data referral untuk pelaporan

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
