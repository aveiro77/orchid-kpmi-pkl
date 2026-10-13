## Fase 7 — Event & Pendaftaran Event (Modul 7 & 8)

### Tujuan
Pengurus/Admin kelola event komunitas; anggota daftar & check-in; publik bisa melihat event yang sudah published.

### Tugas

**Migration & Model**
- [ ] Migration `events` (id, judul, deskripsi, lokasi, tanggal_mulai, tanggal_selesai, kuota, status enum(draft,published,finished), soft delete)
- [ ] Migration `event_registrations` (id, event_id FK, user_id FK, checkin_at, **unique(event_id, user_id)** — satu anggota hanya boleh daftar sekali per event)
- [ ] Model `Event` (`registrations(): HasMany`, `participants(): BelongsToMany(User::class,'event_registrations')->withPivot('checkin_at')`), `EventRegistration` (`event(): BelongsTo`, `user(): BelongsTo`)

**Panel Orchid**
- [ ] Screen admin/pengurus `Event/EventListScreen.php` + `EventEditScreen.php` — CRUD event, ubah status draft→published→finished, `->permission()`
- [ ] Screen anggota `Event/MyEventScreen.php` ("Event Saya") — daftar ke event published (cek kuota, cek belum pernah daftar), lihat status pendaftaran

**Public Area**
- [ ] `Controllers/Public/EventController.php` + view index/show — daftar event published & detail event
- [ ] Tombol "Daftar" di halaman publik mengarah ke Panel Orchid (karena harus login dulu untuk mendaftar)

### Definition of Done
- Anggota tidak bisa daftar dua kali ke event yang sama (constraint unique teruji)
- Pendaftaran otomatis ditolak kalau kuota penuh
- Event publik hanya menampilkan yang berstatus `published`

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
