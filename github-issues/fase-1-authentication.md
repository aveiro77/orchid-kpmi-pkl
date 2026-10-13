## Fase 1 — Authentication ✅ (sudah dikerjakan, issue ini untuk tracking/commit)

### Tujuan
Registrasi anggota baru (publik) + login/logout terpadu lewat Panel Orchid, dengan pembatasan akun nonaktif.

### Yang sudah dibuat (perlu di-commit ke repo & dibuka PR-nya)
- [x] Migration kolom profil di `users` + soft delete
- [x] `RoleSeeder` (Administrator, Pengurus, Anggota) + `AdminUserSeeder` (dev only)
- [x] `App\Http\Middleware\EnsureMemberIsActive` (didaftarkan di `config/platform.php`)
- [x] `App\Http\Requests\Auth\RegisterRequest`
- [x] `App\Http\Controllers\Auth\RegisteredUserController` (assign Role "Anggota" otomatis saat daftar, lalu auto-login langsung ke Panel)
- [x] View `resources/views/auth/register.blade.php` + `resources/views/layouts/app.blade.php` (Bootstrap 5)
- [x] Route registrasi publik di `routes/web.php`

### Sisa pekerjaan
- [ ] Commit seluruh file di atas ke repo, buka PR, review, merge
- [ ] Uji end-to-end: daftar → auto-login → masuk Panel; login sbg Administrator vs Anggota → bandingkan menu sidebar; nonaktifkan `status_aktif` seorang user → pastikan otomatis ter-logout

### Definition of Done
PR merged, checklist di atas semua tercentang, alur register/login/logout jalan di environment staging.

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
