## Fase 9 — Hardening & Deploy

### Tujuan
Merapikan proyek sebelum dipakai sungguhan oleh KPMI Pekalongan, dan menyiapkan deploy ke Shared Hosting & VPS Linuxid.

### Tugas

**Data & Kualitas Kode**
- [ ] Lengkapi Factory & Seeder untuk semua tabel (data dummy realistis, cukup untuk demo ke Pengurus)
- [ ] Review index database (pastikan kolom yang sering difilter/di-JOIN sudah ber-index — lihat `docs/ARCHITECTURE.md` bagian Daftar Migration)
- [ ] Review ulang seluruh Screen Orchid: pastikan Screen admin-only benar-benar dipasangi `->permission()`, dan Screen self-service benar-benar di-scope `Auth::id()` (audit keamanan data lintas anggota)
- [ ] Review Policy (`app/Policies/*`) untuk operasi yang butuh otorisasi tambahan di luar Orchid permission (mis. update/delete oleh pemilik data)

**Persiapan Deploy**
- [ ] Siapkan `.env.production` (DB, APP_URL, APP_DEBUG=false, dll.)
- [ ] `php artisan storage:link` untuk Orchid Attachment (pastikan foto & lampiran bisa diakses publik)
- [ ] **Shared Hosting**: dokumentasikan langkah deploy (upload lewat SSH/cPanel, arahkan document root ke `public/`, jalankan migration lewat SSH atau tool bawaan hosting)
- [ ] **VPS Linuxid**: dokumentasikan setup web server (Nginx/Apache), PHP-FPM versi sesuai requirement Laravel 13, queue worker (kalau ada job async, mis. scheduled command dari Fase 5), cron untuk `schedule:run`
- [ ] Checklist backup database berkala

### Definition of Done
- Aplikasi bisa diakses dari domain produksi, seluruh modul berfungsi seperti di lokal
- Ada dokumen deploy (`docs/DEPLOYMENT.md`) yang bisa diikuti orang lain tanpa perlu bertanya langkah demi langkah

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
