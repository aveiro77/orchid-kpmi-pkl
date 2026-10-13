## Fase 0 — Setup & Konfigurasi Awal

### Tujuan
Menyiapkan fondasi sebelum modul lain dikerjakan: Role sistem, konfigurasi Panel Orchid, dan migration dasar ke tabel `users`.

### Tugas
- [ ] Pastikan `orchid/platform` >= ^14.53 (`composer show orchid/platform`; update kalau perlu)
- [ ] (Opsional, disarankan) Ganti `prefix` di `config/platform.php` dari `admin` ke sesuatu yang netral (mis. `app`), karena panel dipakai juga oleh Anggota biasa, bukan cuma staff
- [ ] Tambahkan middleware `EnsureMemberIsActive` ke `config/platform.php` > `middleware.private`, dan daftarkan alias-nya di `bootstrap/app.php`
- [ ] Jalankan migration penambah kolom profil (`foto`, `nomor_wa`, `kota`, `bio`, `linkedin`, `website`, `instagram`, `status_aktif`) + soft delete ke tabel `users`
- [ ] Jalankan `RoleSeeder` (membuat Role: Administrator, Pengurus, Anggota)
- [ ] (Dev only) Jalankan `AdminUserSeeder` untuk akun admin percobaan, lalu segera ganti passwordnya

### Definition of Done
- `php artisan migrate --seed` jalan tanpa error di environment lokal
- 3 Role (Administrator, Pengurus, Anggota) muncul di Panel > Roles
- Login ke Panel sebagai admin berhasil

### Catatan
Fase ini sebagian sudah dikerjakan bersamaan dengan Fase 1 (Authentication) — cek dulu apakah sudah ada sebelum mengerjakan ulang.

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
