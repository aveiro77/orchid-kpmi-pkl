## Fase 8 — Dashboard & Search/Filter Terpadu (Modul 9 + Fitur Pencarian)

### Tujuan
Satu Dashboard Screen dengan tampilan berbeda per role, plus melengkapi/menyatukan fitur pencarian & filter di semua modul.

### Tugas

**Dashboard (Panel Orchid)**
- [ ] `Orchid/Screens/Dashboard/DashboardScreen.php` (Orchid sudah sediakan file dasarnya sejak `orchid:install` — modifikasi, jangan bikin baru)
- [ ] Widget Administrator: total anggota, anggota aktif, total usaha aktif, total peluang aktif, total referral, total event, event terdekat, peluang terbaru
- [ ] Widget Anggota: profil singkat, skill, usaha aktif, peluang yang dibuat, event yang diikuti
- [ ] Bedakan widget berdasarkan `Auth::user()->inRole(...)` atau permission

**Search & Filter (lengkapi yang belum ada dari fase-fase sebelumnya)**
- [ ] Direktori Anggota (publik): filter kota, skill, peran profesi, nama — filter skill/peran menyusul dari Fase 3
- [ ] Direktori Usaha (publik): filter kategori, status
- [ ] Screen Peluang (Panel): filter tipe (need/offer/collaborate), status

**Repository Pattern (sesuai keputusan desain — dipakai khusus di sini)**
- [ ] `App\Repositories\Eloquent\DashboardRepository` (implements `DashboardRepositoryInterface`) untuk semua query agregasi dashboard
- [ ] `App\Repositories\Eloquent\MemberRepository` (implements `MemberRepositoryInterface`) untuk query search/filter direktori anggota

### Definition of Done
- Dashboard menampilkan data berbeda sesuai role yang login, angka-angkanya akurat
- Semua filter di atas berfungsi dan bisa dikombinasikan (mis. kota + skill sekaligus)

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
