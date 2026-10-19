<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'nama_lengkap' => 'Aditya Pratama',
                'nomor_wa' => '6281210000001',
                'email' => 'aditya.pratama@example.com',
                'kota' => 'Jakarta',
                'bio' => 'Pengembang web yang berfokus pada aplikasi bisnis.',
                'linkedin' => 'https://www.linkedin.com/in/aditya-pratama',
                'website' => 'https://adityapratama.example.com',
                'instagram' => '@aditya.pratama',
                'status_aktif' => true,
            ],
            [
                'nama_lengkap' => 'Nadia Putri Lestari',
                'nomor_wa' => '6281210000002',
                'email' => 'nadia.lestari@example.com',
                'kota' => 'Bandung',
                'bio' => 'Desainer grafis dan ilustrator.',
                'linkedin' => 'https://www.linkedin.com/in/nadia-lestari',
                'website' => 'https://nadialestari.example.com',
                'instagram' => '@nadia.lestari',
                'status_aktif' => true,
            ],
            [
                'nama_lengkap' => 'Rizky Ramadhan',
                'nomor_wa' => '6281210000003',
                'email' => 'rizky.ramadhan@example.com',
                'kota' => 'Surabaya',
                'bio' => 'Konsultan pemasaran digital untuk UMKM.',
                'linkedin' => 'https://www.linkedin.com/in/rizky-ramadhan',
                'website' => null,
                'instagram' => '@rizky.ramadhan',
                'status_aktif' => true,
            ],
            [
                'nama_lengkap' => 'Siti Rahmawati',
                'nomor_wa' => '6281210000004',
                'email' => 'siti.rahmawati@example.com',
                'kota' => 'Yogyakarta',
                'bio' => 'Akuntan dengan pengalaman di bidang keuangan.',
                'linkedin' => 'https://www.linkedin.com/in/siti-rahmawati',
                'website' => null,
                'instagram' => '@siti.rahmawati',
                'status_aktif' => true,
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'nomor_wa' => '6281210000005',
                'email' => 'budi.santoso@example.com',
                'kota' => 'Semarang',
                'bio' => 'Fotografer produk dan dokumentasi acara.',
                'linkedin' => null,
                'website' => 'https://budisantoso.example.com',
                'instagram' => '@budi.santoso',
                'status_aktif' => true,
            ],
            [
                'nama_lengkap' => 'Citra Maharani',
                'nomor_wa' => '6281210000006',
                'email' => 'citra.maharani@example.com',
                'kota' => 'Denpasar',
                'bio' => 'Pengelola proyek dan pengembangan komunitas.',
                'linkedin' => 'https://www.linkedin.com/in/citra-maharani',
                'website' => null,
                'instagram' => '@citra.maharani',
                'status_aktif' => true,
            ],
            [
                'nama_lengkap' => 'Fajar Nugroho',
                'nomor_wa' => '6281210000007',
                'email' => 'fajar.nugroho@example.com',
                'kota' => 'Malang',
                'bio' => 'Pengembang aplikasi mobile dan web.',
                'linkedin' => 'https://www.linkedin.com/in/fajar-nugroho',
                'website' => 'https://fajarnugroho.example.com',
                'instagram' => '@fajar.nugroho',
                'status_aktif' => false,
            ],
            [
                'nama_lengkap' => 'Dewi Anggraini',
                'nomor_wa' => '6281210000008',
                'email' => 'dewi.anggraini@example.com',
                'kota' => 'Makassar',
                'bio' => 'Konsultan hukum untuk bisnis dan organisasi.',
                'linkedin' => 'https://www.linkedin.com/in/dewi-anggraini',
                'website' => null,
                'instagram' => '@dewi.anggraini',
                'status_aktif' => true,
            ],
            [
                'nama_lengkap' => 'Yoga Saputra',
                'nomor_wa' => '6281210000009',
                'email' => 'yoga.saputra@example.com',
                'kota' => 'Medan',
                'bio' => 'Spesialis jaringan dan infrastruktur teknologi.',
                'linkedin' => 'https://www.linkedin.com/in/yoga-saputra',
                'website' => null,
                'instagram' => '@yoga.saputra',
                'status_aktif' => true,
            ],
            [
                'nama_lengkap' => 'Intan Permata Sari',
                'nomor_wa' => '6281210000010',
                'email' => 'intan.permata@example.com',
                'kota' => 'Bogor',
                'bio' => 'Penulis konten dan pengelola media sosial.',
                'linkedin' => 'https://www.linkedin.com/in/intan-permata-sari',
                'website' => 'https://intanpermata.example.com',
                'instagram' => '@intan.permata',
                'status_aktif' => true,
            ],
        ];

        foreach ($members as $member) {
            Member::updateOrCreate(
                ['email' => $member['email']],
                $member,
            );
        }
    }
}
