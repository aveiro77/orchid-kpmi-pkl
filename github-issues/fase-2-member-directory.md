## Fase 2 — Member Directory (Modul 1)

### Tujuan
Anggota bisa mengelola profil sendiri lewat Panel Orchid; publik bisa menelusuri direktori anggota tanpa login.

### Tugas

**Panel Orchid (Member Area)**
- [ ] Screen `Profile/ProfileScreen.php` — edit profil sendiri (nama_lengkap, foto via **Orchid Attachment**, nomor_wa, kota, bio, linkedin, website, instagram). Scope ke `Auth::id()`, tanpa `->permission()`.

**Public Area (Laravel MVC)**
- [ ] `Controllers/Public/MemberDirectoryController.php` — list anggota `status_aktif = true` (pagination), + halaman detail per anggota (route model binding)
- [ ] View `resources/views/public/members/index.blade.php` (grid/list card, Bootstrap 5) & `show.blade.php`
- [ ] Filter dasar di halaman direktori: kota, nama (query string, `?kota=...&nama=...`) — filter skill & peran menyusul setelah Fase 3 selesai

### Service Layer
- [ ] `App\Services\MemberDirectoryService` untuk query listing + filter (dipindah ke Repository Pattern nanti kalau kompleksitas naik di Fase 8, tidak wajib sekarang)

### Definition of Done
- Anggota bisa login, edit profil termasuk upload foto, perubahan tersimpan
- Halaman `/anggota` (nama route bebas, sesuaikan) menampilkan anggota aktif, bisa difilter kota & nama, dan halaman detail menampilkan profil lengkap anggota
- Anggota dengan `status_aktif = false` tidak muncul di direktori publik

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
