## Fase 3 — Roles Profesi & Skill (Modul 2 & 3)

### Tujuan
Master data Peran Profesi & Skill, plus kemampuan anggota memilih banyak peran/skill sekaligus (many-to-many).

### Tugas

**Migration & Model**
- [ ] Migration `professional_roles` (id, nama) + pivot `professional_role_user`
- [ ] Migration `skills` (id, nama) + pivot `skill_user`
- [ ] Model `ProfessionalRole` (`users(): BelongsToMany`), `Skill` (`users(): BelongsToMany`)
- [ ] Tambahkan relasi `professionalRoles()` & `skills()` di `App\Models\User`

**Seeder**
- [ ] Seed `professional_roles`: Pengusaha, Freelancer, Konsultan, Mentor, Investor, Reseller, Programmer, Designer, Marketing
- [ ] Seed `skills`: Web Development, Graphic Design, Accounting, Digital Marketing, Photography, Legal Consultant (tambah sesuai kebutuhan komunitas)

**Panel Orchid**
- [ ] Screen admin `ProfessionalRole/ProfessionalRoleListScreen.php` — CRUD master data, `->permission()`
- [ ] Screen admin `Skill/SkillListScreen.php` — CRUD master data, `->permission()`
- [ ] Update `Profile/ProfileScreen.php` (dari Fase 2) — tambahkan field multi-select Peran Profesi & Skill

### Definition of Done
- Admin bisa CRUD master data Peran Profesi & Skill dari Panel
- Anggota bisa pilih >1 peran profesi & >1 skill di halaman profil sendiri, tersimpan dengan benar di tabel pivot

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
